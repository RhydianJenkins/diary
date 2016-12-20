<?php

// get the dates we are working with from GET, assume current if empty
$date = getDate();
if (empty($_GET['year'])) {
    $year = $date['year'];
} else {
    $year = $_GET['year'];
}
if (empty($_GET['month'])) {
    $month = strtolower($date['month']);
} else {
    $month = $_GET['month'];
}
if (empty($_GET['day'])) {
    $day = $date['mday'];
} else {
    $day = $_GET['day'];
}

// create files if needed
if (!is_dir("./saves/{$year}")) {
    mkdir("./saves/{$year}");
}
if (!is_dir("./saves/{$year}/{$month}")) {
    mkdir("./saves/{$year}/{$month}");
}
if (!file_exists("./saves/{$year}/{$month}/{$day}.txt")) {
    file_put_contents("./saves/{$year}/{$month}/{$day}.txt", "");
}

// try to get the contents, dump any errors in the textarea
try {
    return file_get_contents("./saves/{$year}/{$month}/{$day}.txt");
} catch(Exception $e) {
    var_dump($e);
}
