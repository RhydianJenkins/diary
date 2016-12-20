<?php
    // load functions
    require('./scripts/functions.php');

    // execute setup script
    require('./scripts/setup.php');

    // load the saved text from file
    $loadedText = require('./scripts/load.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Rhydian Jenkins">

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

<title>Diary</title>

<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
    crossorigin="anonymous">

<!-- custom css -->
<link rel="stylesheet" href="./css/main.css">

<!-- simple sidebar css -->
<link rel="stylesheet" href="./css/simple-sidebar.css">

</head>
<body class="secondary-color-bg">

    <div id="wrapper" class="secondary-color-bg">

        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="primary-color-bg">
            <ul class="sidebar-nav">
                <li class="sidebar"><a class="secondary-color" href="<?= $yesterdayLink; ?>"><strong>Yesterday</strong></a></li>
                <li class="sidebar"><a class="secondary-color" href="<?= $todayLink; ?>"><strong>Today</strong></a></li>
                <li class="sidebar"><a class="secondary-color" href="<?= $tommorrowLink; ?>"><strong>Tomorrow</strong></a></li>
                <hr id="separator" />
                <?php foreach($directoryTree as $month => $days) : ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle secondary-color" data-toggle="dropdown">
                            <strong><?= ucwords($month); ?></strong> <span class="tertiary-color caret" />
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <?php foreach($days as $day) : ?>
                                <li>
                                    <a class="primary-color-bg secondary-color" href="?month=<?= $month; ?>&day=<?= $day['date']; ?>">
                                        <strong><?= $day['day'] . ', ' . ordinal($day['date']); ?></strong>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Header -->
        <div class="container-fluid">
            <div class="row">
                <h1 class="col-xs-6 tertiary-color" id="header">Diary - <?= $currentWeekday . ', ' . $currentMonth . ' ' . ordinal($currentDay); ?></h1>
                <h1 class="col-xs-6 tertiary-color" id="savedInfo"></h1>
            </div>
        </div>

        <!-- Textarea -->
        <div class="container-fluid">
            <textarea id="textBoxMain" type="textarea" name="textBoxMain" class="primary-color-bg secondary-color"><?= $loadedText; ?></textarea>
        </div>

    </div>

    <!-- jQuery Version 1.12.4 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

    <!-- Ajax save -->
    <script>
        $('#textBoxMain').blur(function(){
            $.ajax({
                url: './scripts/save.php',
                method: 'POST',
                data: {
                    'text': $('#textBoxMain').val(),
                    'month': '<?= $_GET['month']; ?>',
                    'day': '<?= $_GET['day']; ?>',
                    'ajax': true
                },
                success: function(data) {
                    $('#savedInfo').text(data);
                }
            });
        });
    </script>

    <!-- Allow tabs in textarea -->
    <script>
        $(document).delegate('#textBoxMain', 'keydown', function(e) {
            var keyCode = e.keyCode || e.which;

            if (keyCode == 9) {
                e.preventDefault();
                var start = $(this).get(0).selectionStart;
                var end = $(this).get(0).selectionEnd;

                // set textarea value to: text before caret + tab + text after caret
                $(this).val($(this).val().substring(0, start)
                            + "\t"
                            + $(this).val().substring(end));

                // put caret at right position again
                $(this).get(0).selectionStart =
                $(this).get(0).selectionEnd = start + 1;
            }
        });
    </script>

    <!-- Move caret to end of textarea on page focus and load -->
    <script>
        $(window).focus(function(){
            val = $("#textBoxMain").val();
            $("#textBoxMain").focus().val("").val(val);
        });
        $(function(){
            val = $("#textBoxMain").val();
            $("#textBoxMain").focus().val("").val(val);
        });
    </script>

</body>
</html>
