<?php

declare(strict_types=1);
require __DIR__ . '/navigation.php';
require __DIR__ . '/head.php';
require __DIR__ . '/header.php'; ?>

<main>
    <div class="thank-you">
        <div class="headline">Booking complete</div>
        <div class="booking-html">
            You're spending <?= $_SESSION['totalDays']; ?> meowgical day/-s on The <?= $_SESSION['booking']['island']; ?><br>
            The <?= $_SESSION['booking']['stars'] ?> star hotel <?= $_SESSION['booking']['hotel']; ?> welcomes you with happy paws!<br>
            Arrival date: <?= $_SESSION['booking']['arrival_date']; ?><br>
            Departure date: <?= $_SESSION['booking']['departure_date']; ?><br>
            Total cost: <?= $_SESSION['booking']['total_cost']; ?><br>
            Cats chosen for company during your stay: <?php
                                                        for ($i = 0; $i < count($_SESSION['booking']['features']); $i++) :
                                                            if (isset($_SESSION['booking']['features'][$i]['name'])) :
                                                                echo $_SESSION['booking']['features'][$i]['name'] . '! ';
                                                            else : echo $_SESSION['booking']['features'][$i];
                                                            endif;
                                                        endfor; ?>
        </div>
        <div class="json">
            <a href="/views/booking-response.php">Click here to see your booking in JSON format!</a>
        </div>
    </div>
</main>

<?php
echo '<pre>';
var_dump($_SESSION['booking']);

require __DIR__ . '/footer.php'; ?>