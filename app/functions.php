<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: {$path}");
    exit;
}

/* 
Here's something to start your career as a hotel manager.

One function to connect to the database you want (it will return a PDO object which you then can use.)
    For instance: $db = connect('hotel.db');
                  $db->prepare("SELECT * FROM bookings");
                  
one function to create a guid,
and one function to control if a guid is valid.
*/

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
