<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';
require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

// Check if both username and key exist in the POST request, wash them a bit
if (isset($_POST['username'], $_POST['key'])) {
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $key = htmlspecialchars($_POST['key'], ENT_QUOTES);

    echo "Form data:\n";
    echo "Username: " . $username . "\n";
    echo "Key: " . $key . "\n";

    $user = validateAdmin($username, $key);

    // If not valid, redirect back to the login page
    if (!$user) {
        echo "Redirecting to login.php\n";
        redirect('/login.php');
    } else {
        // Save username in session, unset key, redirect to admin page
        unset($_POST['key']);
        $_SESSION['user'] = $username;
        echo "Redirecting to admin.php\n";
        redirect('/admin.php');
    }
}

// Redirect
redirect('/index.php');
