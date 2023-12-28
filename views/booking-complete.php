<?php

declare(strict_types=1);
require __DIR__ . '/navigation.php';
require __DIR__ . '/head.php';
require __DIR__ . '/header.php'; ?>

<main>
    <div class="thank-you">
        <div class="info-headline">Booking complete</div>
        <div class="json">
            <a href="/views/booking-response.php">Click here to see your booking in JSON format!</a>
        </div>
    </div>
</main>

<?php require __DIR__ . '/footer.php'; ?>