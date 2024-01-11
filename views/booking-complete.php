<?php

declare(strict_types=1);
require __DIR__ . '/head.php';
require __DIR__ . '/navigation.php';
require __DIR__ . '/header.php'; ?>

<main>
    <div class="thank-you">
        <div class="headline">Booking complete!</div>
        <div class="booking-html">
            <div class="json">
                <a href="https://rogue-fun.se/cradle/views/booking-response.php">Click here to see your booking in JSON format!</a>
            </div>
            <div class="html-details">
                You're spending <span class="booking-data"><?= $_SESSION['totalDays']; ?></span> meowgical day/-s on <span class="booking-data">The <?= $_SESSION['booking']['island']; ?></span><br>
                The <span class="booking-data"><?= $_SESSION['booking']['stars'] ?></span> star hotel <span class="booking-data"><?= $_SESSION['booking']['hotel']; ?></span> welcomes you with happy paws!<br>
                <br>
                <span class="booking-data">Arrival date: </span><?= $_SESSION['booking']['arrival_date']; ?><br>
                <span class="booking-data">Departure date: </span><?= $_SESSION['booking']['departure_date']; ?><br>
                <span class="booking-data">Total cost: </span><?= $_SESSION['booking']['total_cost']; ?><sup>cc</sup><br>
                <span class="booking-data">Kitty companions: </span><?php
                                                                    for ($i = 0; $i < count($_SESSION['booking']['features']); $i++) :
                                                                        if (isset($_SESSION['booking']['features'][$i]['name'])) :
                                                                            echo $_SESSION['booking']['features'][$i]['name'] . '! ';
                                                                        else : echo $_SESSION['booking']['features'][$i];
                                                                        endif;
                                                                    endfor; ?>
            </div>
            <div class="random-fact">
                <span class="booking-data">Did you know?</span><br>
                <?= $_SESSION['booking']['additional_info']['cat_fact']; ?>
            </div>
        </div>
    </div>
    <div class="return">
        <div class="return-headline">WHY NOT BOOK ADDITIONAL DAYS WITH US?</div>
        <div class="buttons"><a href="https://rogue-fun.se/cradle/views/room.php?room-type=1"><button class="return-room">SAM'S SUITE</button></a>
            <a href="https://rogue-fun.se/cradle/views/room.php?room-type=2"><button class="return-room">FINDUS' FLAT</button></a>
            <a href="https://rogue-fun.se/cradle/views/room.php?room-type=3"><button class="return-room">CHESHIRE'S CHAMBER</button></a>
        </div>
    </div>
</main>
<?php require __DIR__ . '/footer.php'; ?>