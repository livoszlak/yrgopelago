// api.php
<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/autoload.php';

$totalCost = getQuote();

echo json_encode(['totalCost' => $totalCost]);
?>