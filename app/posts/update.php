<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$database = databaseConnect('/database/hotel.db');

// Updates room price
if (isset($_POST['update-room-price'])) {
    $roomId = $_POST['room'];
    $newPrice = (int)$_POST['new-price'];

    $statement = $database->prepare('UPDATE rooms SET room_price = :newPrice WHERE id = :roomId');
    $statement->bindParam(':newPrice', $newPrice, PDO::PARAM_INT);
    $statement->bindParam('roomId', $roomId, PDO::PARAM_INT);
    $statement->execute();
}

// Updates feature prices (inreases or decreases all feature prices in a specific room by input amount)
if (isset($_POST['update-feature-price'])) {
    $roomId = $_POST['room'];
    $priceModifier = (int)$_POST['price-modifier'];

    $statement = $database->prepare('SELECT feature_id, feature_price FROM room_feature WHERE room_id = :roomId');
    $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $statement->execute();
    $currentPrices = $statement->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['increase'])) {
    foreach ($currentPrices as $index => $price) {
        $newPrice = ($price['feature_price'] + $priceModifier);
        $featureId = $price['feature_id'];
        $statement = $database->prepare('UPDATE room_feature SET feature_price = :newPrice WHERE room_id = :roomId AND feature_id = :featureId');
        $statement->bindParam(':newPrice', $newPrice, PDO::PARAM_INT);
        $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $statement->bindParam(':featureId', $price['feature_id'], PDO::PARAM_INT);
        $statement->execute();
    }
} else if (isset($_POST['decrease'])) {
    foreach ($currentPrices as $index => $price) {
        $newPrice = ($price['feature_price'] - $priceModifier);
        $featureId = $price['feature_id'];
        $statement = $database->prepare('UPDATE room_feature SET feature_price = :newPrice WHERE room_id = :roomId AND feature_id = :featureId');
        $statement->bindParam(':newPrice', $newPrice, PDO::PARAM_INT);
        $statement->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $statement->bindParam(':featureId', $price['feature_id'], PDO::PARAM_INT);
        $statement->execute();
    }
}

// Updates hotel star count
if (isset($_POST['update-stars'])) {
    $newStars = $_POST['new-stars'];

    $statement = $database->prepare('UPDATE hotel SET stars = :stars WHERE id = 1');
    $statement->bindParam(':stars', $newStars, PDO::PARAM_INT);
    $statement->execute();
}

redirect('https://rogue-fun.se/cradle/admin.php');
