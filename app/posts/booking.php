<?php

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

    reserveRoom($_SESSION['arrival'], $_SESSION['departure'], (int)$_SESSION['room-type']);
    $bookingId = bookStay();

    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare("SELECT 
    hotel.island,
    hotel.hotel,
    bookings.arrival_date,
    bookings.departure_date,
    bookings.total_cost,
    hotel.stars,
    features.feature_name AS features,
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

    $statement->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // $booking = [];
    // foreach ($results as $row) {
    //     $booking['island'] = $row['island'];
    //     $booking['hotel'] = $row['hotel'];
    //     $booking['arrival_date'] = $row['arrival_date'];
    //     $booking['departure_date'] = $row['departure_date'];
    //     $booking['total_cost'] = $row['total_cost'];
    //     $booking['stars'] = $row['stars'];
    //     $booking['features'][] = $row['features'];
    //     $booking['additional_info'] = ['greeting' => $row['greeting']];
    // }

    header('Content-type: JSON');
    echo json_encode($results, JSON_PRETTY_PRINT);
    // $_SESSION['booking'] = json_encode($booking, JSON_PRETTY_PRINT);
}
// redirect('/../views/booking-response.php');
