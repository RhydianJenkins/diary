<?php

/**
 * Appends the ordinal to a number
 * E.G: 19 -> 19th, 1 -> 1st etc...
 */
function ordinal($number) {
    if ((int) $number == 0) {
        return $number;
    }
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13)) {
        return $number. 'th';
    } else {
        return $number. $ends[$number % 10];
    }
}

/**
 * http://stackoverflow.com/questions/13646690/how-to-get-real-ip-from-visitor
 * Retrieves the visiting IP address
 */
function getUserIP() {
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}
