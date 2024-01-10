<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// Remove the user session variable and redirect the user back to index
unset($_SESSION['admin']);

redirect('https://rogue-fun.se/cradle/index.php');
