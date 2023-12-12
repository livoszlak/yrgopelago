<?php
header('Content-type: JSON');

$roomId = $_POST['room-type'];
$arrival = $_POST['arrival'];
$departure = $_POST['departure'];

// Connect to database
$database = databaseConnect('/database/hotel.db');

// Query the database for room availability
$statement = $database->prepare('SELECT * FROM room_availability WHERE is_available = 1 AND room_id = :roomId AND date BETWEEN :arrival AND :departure');
$statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
$statement->bindParam(':arrival', $arrival, PDO::PARAM_STR);
$statement->bindParam(':departure', $departure, PDO::PARAM_STR);
$statement->execute();
$availability = $statement->fetchAll(PDO::FETCH_ASSOC);

// Return the data in JSON format
echo json_encode($availability);
