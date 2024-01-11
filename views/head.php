<?php

declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/autoload.php';

// use GuzzleHttp\Client;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@300;500;600&display=swap" rel="stylesheet">
    <?php if (isset($_GET['room-type'])) : ?>
        <link rel="stylesheet" type="text/css" href="../assets/styles/calendar.css">
        <link rel="stylesheet" type="text/css" href="../assets/styles/carousel.css">
        <link rel="stylesheet" type="text/css" href="../assets/styles/room.css">

        <?php
        switch ($_GET['room-type']):
            case 1: ?>
                <link rel="stylesheet" href="../assets/styles/budget.css">
            <?php break;
            case 2: ?>
                <link rel="stylesheet" href="../assets/styles/standard.css">
            <?php break;
            case 3: ?>
                <link rel="stylesheet" href="../assets/styles/luxury.css">
        <?php endswitch;
    endif;

    if (isInViews()) : ?>
        <link rel="stylesheet" type="text/css" href="assets/styles/index.css">
    <?php endif;
    if (stripos($link, 'booking-complete')) : ?>
        <link rel="stylesheet" type="text/css" href="../assets/styles/booking-response.css">
    <?php endif;
    // if (!isset($_GET['room-type']) || !stripos($link, 'booking-complete') || !stripos($link, 'about') || !stripos($link, 'admin') || !stripos($link, 'login')) :
    if (stripos($link, 'room') || stripos($link, 'booking-complete')) : ?>
        <!-- <link rel="stylesheet" type="text/css" href="../assets/styles/app.css"> -->
        <link rel="stylesheet" type="text/css" href="../assets/styles/global.css">
    <?php else : ?>
        <!-- <link rel="stylesheet" href="assets/styles/app.css"> -->
        <link rel="stylesheet" href="assets/styles/global.css">
    <?php endif; ?>

    <title>Cat's Cradle</title>
</head>

<body>