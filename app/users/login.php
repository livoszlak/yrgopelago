<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';
require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

// Check if both username and key exist in the POST request, wash them a bit
if (isset($_POST['admin'], $_POST['adminKey'])) {
    $admin = htmlspecialchars($_POST['admin'], ENT_QUOTES);
    $adminKey = htmlspecialchars($_POST['adminKey'], ENT_QUOTES);

    $admin = validateAdmin($admin, $adminKey);

    // If not valid, redirect back to the login page
    if (!$admin) {
        redirect('../../login.php');
    } else {
        // Save admin in session, unset adminKey, redirect to admin page
        unset($_POST['adminKey']);
        $_SESSION['admin'] = $admin;
        redirect('../../admin.php');
    }
}

// Redirect
redirect('index.php');
