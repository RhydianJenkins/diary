<?php

// get the date today
$date = new DateTime;
$time = $date->format('H:i:s');

if (!empty($_POST['year'])) {
    $year = $_POST['year'];
} else {
    $year = date('Y');
}
if (!empty($_POST['month'])) {
    $month = strtolower($_POST['month']);
} else {
    $month = strtolower(date('F'));
}
if (!empty($_POST['day'])) {
    $day = $_POST['day'];
} else {
    $day = date('j');
}

if ($_POST['text']) {
    try {
        file_put_contents("../saves/{$year}/{$month}/{$day}.txt", $_POST['text']);
    } catch (Exception $e) {
        echo 'Failed to save to "../saves/{$year}/{$month}/{$day}.txt"';
        return;
    }
}

// output the save time
echo 'Saved ' . $time;
return 'Saved ' . $time;
