<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// databaseConnect('hotel.db');
// $statement = $database->prepare('UPDATE * FROM room_availability WHERE is_available = 1 AND room_id = :roomId AND date BETWEEN :arrival AND :departure');

// $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
// $statement->bindParam(':arrival', $arrival, PDO::PARAM_STR);
// $statement->bindParam(':departure', $departure, PDO::PARAM_STR);

// $statement->execute();

redirect('/');
