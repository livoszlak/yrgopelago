<?php

declare(strict_types=1);

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

    // Prepare SQL statement
    $statement = $database->prepare('SELECT * FROM room_availability WHERE is_available = 1 AND room_id = :roomId AND date BETWEEN :arrival AND :departure');

    // Bind the parameters
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $statement->bindParam(':arrival', $arrival, PDO::PARAM_STR);
    $statement->bindParam(':departure', $departure, PDO::PARAM_STR);

    // Execute the statement
    $statement->execute();

    // Fetch all the results
    $availableRooms = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $availableRooms;
}

function addCalendarEvent($calendar, $roomId)
{

    $database = databaseConnect('/database/hotel.db');
    $statement = $database->prepare('SELECT date FROM room_availability WHERE is_available = 0 AND room_id = :roomId');
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $statement->execute();
    $dates = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($dates as $date) {
        $calendar->addEvent(
            $date['date'],
            $date['date'],
            "",
            true,
            ['booked']
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
