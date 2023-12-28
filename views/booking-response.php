<?php

declare(strict_types=1);
require '../vendor/autoload.php';
require __DIR__ . '/../app/autoload.php';

header('Content-type: application/json');

echo json_encode($_SESSION['booking'], JSON_PRETTY_PRINT);
