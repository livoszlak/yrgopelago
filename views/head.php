<?php

declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

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

    if (isInIndex()) : ?>
        <link rel="stylesheet" type="text/css" href="assets/styles/index.css">
    <?php endif;
    if (stripos($link, 'booking-complete')) : ?>
        <link rel="stylesheet" type="text/css" href="../assets/styles/booking-response.css">
    <?php endif;
    if (stripos($link, 'room') || stripos($link, 'booking-complete')) : ?>
        <link rel="stylesheet" type="text/css" href="../assets/styles/global.css">
    <?php else : ?>
        <link rel="stylesheet" href="assets/styles/global.css">
    <?php endif; ?>

    <title>Cat's Cradle</title>
</head>

<body>