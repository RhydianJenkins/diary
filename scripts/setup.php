<?php

// generate the links for yesterday, today, and tomorrow
$yesterdayLink = '?month=' . strtolower(date('F', strtotime('yesterday')));
$yesterdayLink .= '&day=' . date('j', strtotime('yesterday'));
$todayLink = '?month=' . strtolower(date('F', strtotime('now')));
$todayLink .= '&day=' . date('j', strtotime('now'));
$tommorrowLink = '?month=' . strtolower(date('F', strtotime('tomorrow')));
$tommorrowLink .= '&day=' . date('j', strtotime('tomorrow'));

// get the current date that we are looking at. Assume today if not available from GET
// Year
if (!empty($_GET['year'])) { $currentYear = $_GET['year']; }
else { $currentYear = date('Y', strtotime('today')); }
// Month
if (!empty($_GET['month'])) { $currentMonth = ucwords($_GET['month']); }
else { $currentMonth = ucwords(date('F', strtotime('today'))); }
// Day
if (!empty($_GET['day'])) { $currentDay = ucwords($_GET['day']); }
else { $currentDay = date('j', strtotime('today')); }
// Weekday
$currentWeekday = strftime('%A', strtotime($currentYear.'-'.date('m', strtotime($currentMonth)).'-'.$currentDay));

// remove everything that isn't a visible directory
$months = array_filter(scandir("./saves/{$currentYear}"), function($month) {
    return $month[0] !== '.';
});

// initialise the empty array to keep month order
$directoryTree = array(
    'december' => array(), 'november' => array(), 'october' => array(), 'september' => array(),
    'august' => array(), 'july' => array(), 'june' => array(), 'may' => array(),
    'april' => array(), 'march' => array(), 'febuary' => array(), 'january' => array(),
);

// populate the directoryTree with the months and dates
foreach($months as $month) {
    $numericMonth = date('m', strtotime($month));
    foreach(array_slice(scandir("./saves/{$currentYear}/{$month}"), 2) as $day) {
        $numericDate = str_replace(".txt", "", $day);
        $weekday = strftime('%A', strtotime($currentYear.'-'.$numericMonth.'-'.$numericDate));

        // add day to the tree if not a weekend
        if (($weekday != 'Saturday') && ($weekday != 'Sunday')) {
            $directoryTree[$month][$numericDate] = array(
                'date' => $numericDate,
                'day' => $weekday
            );
        }
    }
    //reverse array to give most recent date at the top
    ksort($directoryTree[$month]);
    $directoryTree[$month] = array_reverse($directoryTree[$month]);
}

// remove empty months
foreach($directoryTree as $month => $days) {
    if (empty($directoryTree[$month])) {
        unset($directoryTree[$month]);
    }
}
