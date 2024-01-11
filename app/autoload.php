<?php

declare(strict_types=1);

// Start the session engines.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set the default timezone to Coordinated Universal Time.
date_default_timezone_set('UTC');

// Set the default character encoding to UTF-8.
mb_internal_encoding('UTF-8');

// Include the helper functions.
require __DIR__ . '/functions.php';

// Fetch the global configuration array.
$config = require __DIR__ . '/config.php';

// Setup the database connection.
// $database = connect('/database/hotel.db');

$_SESSION['stars'] = fetchStars();

if (!key_exists('userId', $_SESSION)) :
    $_SESSION['userId'] = guidv4();
    $_SESSION['dates'] = array();
    $_SESSION['features'] = array();
    $_SESSION['errors'] = array();

endif;
if (isset($_POST['arrival'], $_POST['departure'])) :
    $_SESSION['arrival'] = $_POST['arrival'];
    $_SESSION['departure'] = $_POST['departure'];
endif;
if (isset($_POST['transfer-code'], $_POST['guest-name'])) :
    $_POST['transfer-code'] = trim(htmlspecialchars($_POST['transfer-code'], ENT_QUOTES));
    $_POST['guest-name'] = trim(htmlspecialchars($_POST['guest-name'], ENT_QUOTES));
endif;

!isset($_SESSION['booking-step-1']) ? $_SESSION['totalCost'] = 0 : $_SESSION['totalCost'] = getQuote();

if (isset($_GET['room-type']) && isset($_POST['booking-step-1'])) :
    $availableRooms = checkAvailability($_SESSION['arrival'], $_SESSION['departure'], (int)$_SESSION['room-type']);
    $dates = fetchDates($availableRooms);
    $_SESSION['totalDays'] = count($dates);
    unset($_SESSION['feature-data']);
    $_SESSION['feature-data'] = array();
    $_SESSION['features'] = [];
    foreach ($_POST as $key => $value) {
        if ($value == 'on') {
            $_SESSION['features'][] = $key;
        }
    }
    getQuote();
endif;

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $link = "https";
    $link .= "://";
    $link .= $_SERVER['HTTP_HOST'];
    $link .= $_SERVER['REQUEST_URI'];
} else {
    $link = "http";
    $link .= "://";
    $link .= $_SERVER['HTTP_HOST'];
    $link .= $_SERVER['REQUEST_URI'];
}
