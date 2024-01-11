<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;


function redirect(string $path)
{
    header("Location: {$path}");
    exit;
}

function guidv4(string $data = null): string
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function isValidUuid(string $uuid): bool
{
    if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
        return false;
    }
    return true;
}

function validateTransferCode(string $transferCode, float $totalCost)
{
    $client = new Client();
    try {
        $response = $client->request('POST', 'https://www.yrgopelag.se/centralbank/transferCode', [
            'form_params' => [
                'transferCode' => $transferCode,
                'totalcost' => $totalCost
            ],
        ]);
    } catch (ClientException $e) {
        // echo "There was an issue validating your transfer code: " . $e->getMessage();
    }

    if ($response->getBody()) {
        $data = json_decode($response->getBody()->getContents());
    }
    return $data;
}

function getCatFact()
{
    $client = new Client();
    try {
        $response = $client->request('GET', 'https://catfact.ninja/fact', [
            'form_params' => [
                'max_length' => 60
            ],
        ]);
    } catch (ClientException $e) {
        // echo "There was an issue fetching cat fact: " . $e->getMessage();
    }

    if ($response->getBody()) {
        $factObject = json_decode($response->getBody()->getContents());
        return $factObject->fact;
    }
}


function deposit(string $transferCode)
{
    $client = new Client();
    try {
        $response = $client->request('POST', 'https://www.yrgopelag.se/centralbank/deposit', [
            'form_params' => [
                'user' => 'Liv',
                'transferCode' => $transferCode
            ],
        ]);
        $response = $response->getBody()->getContents();
        return true;
    } catch (ClientException $e) {
        // echo "There was an issue with depositing: " . $e->getMessage();
        return false;
    }
}

function validateAdmin(string $input_username, string $input_api_key): bool
{
    $username = $_ENV['USER_NAME'];
    $apiKey = $_ENV['API_KEY'];
    if ($input_username == $username && $input_api_key == $apiKey) {
        return true;
    } else {
        return false;
    }
}

function databaseConnect(string $dbName): object
{
    $dbPath = __DIR__ . '/' . $dbName;
    $db = "sqlite:$dbPath";

    try {
        $database = new PDO($db);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // echo "Failed to connect to the database";
        throw $e;
    }
    return $database;
}

function checkAvailability(string $arrival, string $departure, int $roomId): array
{
    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('SELECT * FROM room_availability WHERE is_available = 1 AND room_id = :roomId AND date BETWEEN :arrival AND :departure');
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $statement->bindParam(':arrival', $arrival, PDO::PARAM_STR);
    $statement->bindParam(':departure', $departure, PDO::PARAM_STR);
    $statement->execute();

    $availableRooms = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $availableRooms;
}

function countRemaining(int $roomId)
{
    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('SELECT date FROM room_availability WHERE is_available = 1 AND room_id = :roomId');
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $remainingDates = count($result);
    return $remainingDates;
}

function isAvailable(string $arrival, string $departure, int $roomId): bool
{
    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('SELECT * FROM room_availability WHERE is_available = 0 AND room_id = :roomId AND date BETWEEN :arrival AND :departure');
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $statement->bindParam(':arrival', $arrival, PDO::PARAM_STR);
    $statement->bindParam(':departure', $departure, PDO::PARAM_STR);
    $statement->execute();

    $bookedRooms = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($bookedRooms)) {
        return false;
    } else {
        return true;
    }
}

function reserveRoom(string $arrival, string $departure, int $roomId)
{
    $database = databaseConnect('/database/hotel.db');

    $statement = $database->prepare('UPDATE room_availability SET is_available = 0 WHERE date BETWEEN :arrival AND :departure AND room_id = :roomId');

    $statement->bindParam(':arrival', $arrival, PDO::PARAM_STR);
    $statement->bindParam(':departure', $departure, PDO::PARAM_STR);
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);

    $statement->execute();
}

/* Temporary reservation function that I have not had time to implement yet because of deployment issues */

// function reserveRoom(array $dates, int $roomId, string $guestId)
// {
//     $database = databaseConnect('/database/hotel.db');
//     $time = time();
//     foreach ($dates as $date) {
//         $statement = $database->prepare('INSERT INTO reservations (guest_id, room_id, date, time) VALUES (:guestId, :roomId, :date, :time)');
//         $statement->bindParam(':guestId', $guestId, PDO::PARAM_STR);
//         $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
//         $statement->bindParam(':date', $date, PDO::PARAM_STR);
//         $statement->bindParam(':time', $time, PDO::PARAM_STR);
//         $statement->execute();
//     }
// }

function fetchStars()
{
    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('SELECT stars FROM hotel');
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $stars = $result[0]['stars'];
    return $stars;
}

function fetchFeatures($roomId)
{
    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('SELECT feature_name, feature_id, feature_price FROM room_feature WHERE room_id = :roomId');
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $statement->execute();
    $features = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $features;
}

function fetchDates($availableRooms)
{
    $dates = array();
    foreach ($availableRooms as $choice) {
        $dates[] = $choice['date'];
    }
    return $dates;
}

function addCalendarEvent($calendar, $roomId)
{
    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('SELECT date FROM room_availability WHERE is_available = 0 AND room_id = :roomId');
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $statement->execute();
    $bookedDates = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $database->prepare('SELECT date FROM room_availability WHERE is_available = 1 AND room_id = :roomId');
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $statement->execute();
    $availableDates = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($bookedDates as $date) {
        $calendar->addEvent(
            $date['date'],
            $date['date'],
            "",
            true,
            ['booked']
        );
    }
    foreach ($availableDates as $date) {
        $calendar->addEvent(
            $date['date'],
            $date['date'],
            "",
            true,
            ['available']
        );
    }
}

function getRoomInfo()
{
    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('SELECT rooms.room_price, room_feature.feature_name, room_feature.feature_id, room_feature.feature_price, room_feature.feature_url FROM room_feature INNER JOIN rooms ON rooms.id = room_feature.room_id  WHERE room_feature.room_id = :roomId ORDER BY room_feature.feature_name');
    $statement->bindParam(':roomId', $_SESSION['room-type'], PDO::PARAM_INT);
    $statement->execute();
    $roomInfo = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $roomInfo;
}

function getQuote()
{
    $featureTotal = countFeatureCosts();
    $roomTotal = countStayCost();
    $discount = 1;
    $_SESSION['totalCost'] = $featureTotal + $roomTotal;

    if ($_SESSION['totalDays'] > 2) {
        $discount = 0.75;
    } else if ($_SESSION['totalDays'] > 2 && count($_SESSION['features']) > 3) {
        $discount = 0.6;
    }

    $totalCost = $_SESSION['totalCost'] * $discount;
    $_SESSION['totalCost'] = $totalCost;
    return $totalCost;
}

function countFeatureCosts(): int
{
    $database = databaseConnect('/database/hotel.db');
    $features = $_SESSION['features'];
    $featureTotal = 0;
    foreach ($features as $feature) {
        $statement = $database->prepare('SELECT feature_price FROM room_feature WHERE room_id = :roomId AND feature_id = :featureId');
        $statement->bindParam(':roomId', $_SESSION['room-type'], PDO::PARAM_INT);
        $statement->bindParam('featureId', $feature, PDO::PARAM_INT);
        $statement->execute();
        $bookedFeatures[] = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    if (!empty($bookedFeatures)) {
        $prices = array_map(function ($element) {
            return array_column($element, 'feature_price')[0];
        }, $bookedFeatures);

        for ($i = 0; $i < count($prices); $i++) {
            $featureTotal += $prices[$i];
        }
    }
    return $featureTotal;
}

function countStayCost()
{
    $roomId = (int)$_SESSION['room-type'];
    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('SELECT room_price FROM rooms WHERE id = :roomId');
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $statement->execute();
    $roomPrice = $statement->fetchAll(PDO::FETCH_DEFAULT);

    $roomTotal = $roomPrice[0]['room_price'] * $_SESSION['totalDays'];
    return $roomTotal;
}

function bookStay()
{
    $guestName = trim(htmlspecialchars($_POST['guest-name'], ENT_QUOTES));
    $totalCost = $_SESSION['totalCost'];
    $hotelId = 1;
    $guestId = $_SESSION['userId'];
    $roomId = $_SESSION['room-type'];
    $arrival = $_SESSION['arrival'];
    $departure = $_SESSION['departure'];
    // $discount = 1;
    $totalDays = $_SESSION['totalDays'];
    $totalCost = $_SESSION['totalCost'];
    $transferCode = trim(htmlspecialchars($_POST['transfer-code'], ENT_QUOTES));
    $greeting = "Thank you, " . $guestName . ", for staying with us for " . $totalDays . " days!";

    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('INSERT INTO bookings(hotel_id, guest_id, room_id, arrival_date, departure_date, total_cost, transfer_code, greeting) VALUES (:hotelId, :guestId, :roomId, :arrival, :departure, :totalCost, :transferCode, :greeting)');
    $statement->bindParam(':hotelId', $hotelId, PDO::PARAM_INT);
    $statement->bindParam(':guestId', $guestId, PDO::PARAM_STR);
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_STR);
    $statement->bindParam(':arrival', $arrival, PDO::PARAM_STR);
    $statement->bindParam(':departure', $departure, PDO::PARAM_STR);
    $statement->bindParam(':totalCost', $totalCost, PDO::PARAM_STR);
    $statement->bindParam(':transferCode', $transferCode, PDO::PARAM_STR);
    $statement->bindParam(':greeting', $greeting, PDO::PARAM_STR);
    $statement->execute();

    $bookingId = $database->lastInsertId();

    if (!empty($_SESSION['features'])) {
        foreach ($_SESSION['features'] as $feature) {
            $statement = $database->prepare('INSERT INTO booking_feature(feature_id, booking_id) VALUES(:featureId, :bookingId)');
            $statement->bindParam(':featureId', $feature, PDO::PARAM_INT);
            $statement->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
            $statement->execute();
        }
        foreach ($_SESSION['feature-data'] as $data) {
            $statement = $database->prepare('UPDATE booking_feature SET feature_price = :featurePrice WHERE booking_id = :bookingId AND feature_id = :featureId');
            $statement->bindParam(':featurePrice', $data['cost'], PDO::PARAM_INT);
            $statement->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
            $statement->bindParam(':featureId', $data['id'], PDO::PARAM_INT);
            $statement->execute();
        }
    }
    return $bookingId;
}

function isInViews(): bool
{
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

    if (!isset($_GET['room-type']) || !stripos($link, 'booking-complete') || !stripos($link, 'about') || !stripos($link, 'admin') || !stripos($link, 'login')) {
        return true;
    } else {
        return false;
    }
}

function isInIndex(): bool
{
    $currentPage = basename($_SERVER['PHP_SELF']);
    if ($currentPage == 'index.php') {
        return true;
    } else {
        return false;
    }
}
