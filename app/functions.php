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

function validateTransferCode(string $transferCode, int $totalCost)
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
        echo "An error occurred: " . $e->getMessage();
    }

    if ($response->getBody()) {
        $data = json_decode($response->getBody()->getContents());
    }
    return $data;
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

    // Open the database file and catch the exception if it fails.
    try {
        $database = new PDO($db);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to connect to the database";
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

// function reserveRoom(string $arrival, string $departure, int $roomId)
// {
//     $database = databaseConnect('/database/hotel.db');

//     $statement = $database->prepare('UPDATE room_availability SET is_available = 0 WHERE date BETWEEN :arrival AND :departure AND room_id = :roomId');

//     $statement->bindParam(':arrival', $arrival, PDO::PARAM_STR);
//     $statement->bindParam(':departure', $departure, PDO::PARAM_STR);
//     $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);

//     $statement->execute();
// }

function reserveRoom(array $dates, int $roomId, string $guestId)
{
    $database = databaseConnect('/database/hotel.db');
    $time = time();
    foreach ($dates as $date) {
        $statement = $database->prepare('INSERT INTO reservations (guest_id, room_id, date, time) VALUES (:guestId, :roomId, :date, :time)');
        $statement->bindParam(':guestId', $guestId, PDO::PARAM_STR);
        $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $statement->bindParam(':date', $date, PDO::PARAM_STR);
        $statement->bindParam(':time', $time, PDO::PARAM_STR);
        $statement->execute();
    }
}

function fetchFeatures($roomId)
{
    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('SELECT features.feature_name, features.id, room_feature.feature_price FROM features INNER JOIN room_feature ON features.id = room_feature.feature_id WHERE room_feature.room_id = :roomId');
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


    // $calendar->addEvent(
    //     $arrival,   # start date in either Y-m-d or Y-m-d H:i if you want to add a time.
    //     $departure,   # end date in either Y-m-d or Y-m-d H:i if you want to add a time.
    //     // 'My Birthday',  # event name text
    //     true,           # should the date be masked - boolean default true
    //     ['booked']   # (optional) additional classes in either string or array format to be included on the event days
    // );

    # or for multiple events

    // $events = array();

    // $events[] = array(
    // 	'start' => '2022-01-14',
    // 	'end' => '2022-01-14',
    // 	'summary' => 'My Birthday',
    // 	'mask' => true,
    // 	'classes' => ['myclass', 'abc']
    // );

    // $events[] = array(
    // 	'start' => '2022-12-25',
    // 	'end' => '2022-12-25',
    // 	'summary' => 'Christmas',
    // 	'mask' => true
    // );

    // $calendar->addEvents($events);
    // return $calendar->addEvents($events);
}

function getQuote(): int
{
    $featureTotal = countFeatureCosts();
    $roomTotal = countStayCost();
    $_SESSION['totalCost'] = $featureTotal + $roomTotal;
    return $featureTotal + $roomTotal;
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

    $prices = array_map(function ($element) {
        return array_column($element, 'feature_price')[0];
    }, $bookedFeatures);

    for ($i = 0; $i < count($prices); $i++) {
        $featureTotal += $prices[$i];
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

function booking()
{
    $guestName = trim(htmlspecialchars($_SESSION['guest-name'], ENT_QUOTES));
    $transferCode = trim(htmlspecialchars($_SESSION['transfer-code'], ENT_QUOTES));
    $totalCost = $_SESSION['totalCost'];
    if (!isValidUuid($transferCode)) {
        echo "Sorry, your transfer code is invalid. Please try again.";
    } else {
        validateTransferCode($transferCode, $totalCost);
    }
}
