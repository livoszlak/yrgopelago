<?php
// reserveRoom($_SESSION['arrival'], $_SESSION['departure'], $_SESSION['room-type']);

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../app/autoload.php';

use GuzzleHttp\Client;

if (!isAvailable($_SESSION['arrival'], $_SESSION['departure'], $_SESSION['room-type'])) {
    $_SESSION['errors'][] = 'Meouch, too slow! Someone else booked your desired date(s). Please refresh page to see updated availability calendar.';
    redirect('/views/room.php?room-type=' . $_SESSION['room-type']);
} else {

    if (!isValidUuid($_POST['transfer-code'])) {
        // $_SESSION['errors'] = array();
        $_SESSION['errors'][] = 'Meow-ow, there was an issue with your transfer code! Please try again!';
        redirect('/views/room.php?room-type=' . $_SESSION['room-type']);
    } else {
        unset($_SESSION['errors']);
        $transferCodeResponse = validateTransferCode($_POST['transfer-code'], $_SESSION['totalCost']);
    }

    if (property_exists($transferCodeResponse, 'transferCode')) {
        deposit($_POST['transfer-code']);
    }

    unset($_SESSION['errors']);
    reserveRoom($_SESSION['arrival'], $_SESSION['departure'], (int)$_SESSION['room-type']);
    bookStay();
    echo "Booked";
}



// reserve room on booked dates

// redirect('/views/room.php?room-type=' . $_SESSION['room-type']);
