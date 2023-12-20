<?php

declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/autoload.php';

use GuzzleHttp\Client;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (!key_exists('userId', $_SESSION)) {
    $_SESSION['userId'] = guidv4();
    $_SESSION['dates'] = array();
    $_SESSION['features'] = array();
    foreach ($_POST as $key => $value) {
        if ($value == 'on') {
            $_SESSION['features'][] = $key;
        }
    }
}
if (isset($_POST['arrival'], $_POST['departure'])) :
    $_SESSION['arrival'] = $_POST['arrival'];
    $_SESSION['departure'] = $_POST['departure'];
endif;
if (isset($_POST['transfer-code'], $_POST['guest-name'])) :
    $_SESSION['transfer-code'] = $_POST['transfer-code'];
    $_SESSION['guest-name'] = $_POST['guest-name'];
endif;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/app.css">
    <link rel="stylesheet" type="text/css" href="../assets/styles/calendar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Grandiflora+One&family=Raleway&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>