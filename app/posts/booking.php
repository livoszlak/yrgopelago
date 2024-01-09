<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../app/autoload.php';

// use GuzzleHttp\Client;

if (!isAvailable($_SESSION['arrival'], $_SESSION['departure'], $_SESSION['room-type'])) {
    $_SESSION['errors'][] = 'Meouch, too slow! Someone else booked your desired date(s). Please refresh page to see updated availability calendar.';
    redirect('/views/room.php?room-type=' . $_SESSION['room-type']);
} else {

    if (!isValidUuid($_POST['transfer-code'])) {
        $_SESSION['errors'][] = 'Meow-ow, there was an issue with your transfer code! Please try again!';
        redirect('/views/room.php?room-type=' . $_SESSION['room-type']);
    } else {
        unset($_SESSION['errors']);
        $transferCodeResponse = validateTransferCode($_POST['transfer-code'], $_SESSION['totalCost']);
        $transferCodeAmount = $transferCodeResponse->amount;
    }

    if (property_exists($transferCodeResponse, 'transferCode') && $transferCodeAmount >= $_SESSION['totalCost']) {
        deposit($_POST['transfer-code']);
    } else {
        $_SESSION['errors'][] = "By my whiskers, your transfer code was worth less than the cost of your stay. Please try again!";
        redirect('/views/room.php?room-type=' . $_SESSION['room-type']);
    }

    reserveRoom($_SESSION['arrival'], $_SESSION['departure'], (int)$_SESSION['room-type']);
    $bookingId = bookStay();

    $database = databaseConnect('/database/hotel.db');
    if (!empty($_SESSION['features'])) {
        $statement = $database->prepare("SELECT 
    hotel.island,
    hotel.hotel,
    bookings.arrival_date,
    bookings.departure_date,
    bookings.total_cost,
    hotel.stars,
    features.feature_name AS feature_name,
    booking_feature.feature_price AS feature_price,
    bookings.greeting
 FROM 
    bookings
 JOIN 
    hotel ON bookings.hotel_id = hotel.id
 JOIN 
    booking_feature ON bookings.id = booking_feature.booking_id
 JOIN 
    features ON booking_feature.feature_id = features.id
 WHERE 
    bookings.id = :bookingId");
    } else {
        $statement = $database->prepare("SELECT 
    hotel.island,
    hotel.hotel,
    bookings.arrival_date,
    bookings.departure_date,
    bookings.total_cost,
    hotel.stars,
    bookings.greeting
 FROM 
    bookings
 JOIN 
    hotel ON bookings.hotel_id = hotel.id
 WHERE 
    bookings.id = :bookingId");
    }

    $statement->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $catFact = getCatFact();

    $booking = [];
    foreach ($results as $row) {
        $booking['island'] = $row['island'];
        $booking['hotel'] = $row['hotel'];
        $booking['arrival_date'] = $row['arrival_date'];
        $booking['departure_date'] = $row['departure_date'];
        $booking['total_cost'] = $row['total_cost'];
        $booking['stars'] = $row['stars'];
        !empty($_SESSION['features']) ? $booking['features'][] = ['name' => $row['feature_name'], 'cost' => $row['feature_price']] : $booking['features'][] = 'none';
        $booking['additional_info'] = ['greeting' => $row['greeting'], 'cat_fact' => $catFact];
    }

    $_SESSION['booking'] = array();
    $_SESSION['booking'] = $booking;
    redirect('/../views/booking-complete.php');
}
