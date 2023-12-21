<?php

declare(strict_types=1);
require __DIR__ . '/navigation.php';
require __DIR__ . '/head.php';
require __DIR__ . '/header.php';

use benhall14\phpCalendar\Calendar as Calendar;

$calendar = new Calendar;
$calendar->useMondayStartingDate();
$_SESSION['room-type'] = $_GET['room-type'];
$roomInfo = getRoomInfo();

?>

<main>
    <div class="room-info">
        <p>Room cost per night: <?= $roomInfo[0]['room_price']; ?><sup>cc</sup></p><br>
    </div>
    <form action="" method="post" name="booking" id="booking">
        <div class="booking">
            <div class="calendar-dates-wrapper">
                <div class="calendar-wrapper">
                    <?php addCalendarEvent($calendar, (int)$_GET['room-type']);
                    echo $calendar->draw(date('2024-01-01')); ?>
                </div>
                <div class="date-picker-info-wrapper">
                    <div class="booking-info">
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste quaerat consequatur alias vel sit sequi, adipisci ullam dignissimos? Hic unde pariatur totam incidunt at maxime, corporis adipisci labore vel enim! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Odio unde, quas alias adipisci voluptas aperiam natus enim reprehenderit eum, dolor nam esse incidunt ad tempora dolorum? Voluptas neque cum provident. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque consequatur voluptatem quas. Quod veniam fuga earum, laudantium recusandae magni amet. Enim praesentium quae tempore repellat, modi facilis aliquam dolorum sint!</p>
                    </div>
                    <div class="date-picker-wrapper">
                        <div class="arrival">
                            <label for="arrival">Arrival date:</label>
                            <input type="date" id="arrival" name="arrival" value="2024-01-01" min="2024-01-01" max="2024-01-31" required />
                        </div>
                        <div class="departure">
                            <label for="departure">Departure date:</label>
                            <input type="date" id="departure" name="departure" value="2024-01-01" min="2024-01-01" max="2024-01-31" required />
                        </div>
                    </div>
                </div>
            </div>

            <div class="features-wrapper">
                <?php foreach ($roomInfo as $info => $feature) : ?>
                    <div class="feature" style="background-image: url('/<?= $feature['feature_url']; ?>')">
                        <div class="feature-price-bubble">
                            <p><?= $feature['feature_price']; ?><sup>cc</sup></p>
                        </div>
                        <div class="input-wrapper">
                            <input type="checkbox" id="<?= $feature['feature_id']; ?>" name="<?= $feature['feature_id'] ?>">
                            <div class="feature-name-wrapper"><a class="feature-name"><?= $feature['feature_name']; ?></a></div></input>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="button" type="submit" name="booking-step-1" id="booking-step-1">Get your quote!</button>
    </form>
    <div class="booking-payment-wrapper">
        <div class="booking-carousel-wrapper">
            <div class="room-carousel">

                <div class="mySlides fade">
                    <img src="/assets/images/FEATURE-ABYSSINIAN-pexels-lindsey-garrett-13986951.png" style="width:100%; height: 100%">
                    <div class="text">Caption Text</div>
                </div>

                <div class="mySlides fade">
                    <img src="/assets/images/FEATURE-BALINESE-pexels-leah-kelley-341522.png" style="width:100%; height: 100%">
                    <div class="text">Caption Two</div>
                </div>

                <div class="mySlides fade">
                    <img src="/assets/images/FEATURE-BENGAL-pexels-nika-benedictova-15802496.png" style="width:100%; height: 100%">
                    <div class="text">Caption Three</div>
                </div>
                <div class="dots" style="text-align:center">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
            <form class="booking-form" action="/app/posts/booking.php" method="post" name="booking" id="booking">
                <div class="booking-heading-wrapper">
                    <?php if (isset($_POST['booking-step-1'])) : ?>
                        <?= "Your total is " . $_SESSION['totalCost'] . " for " . $_SESSION['totalDays'] . " days and " . count($_SESSION['features']) . " cats."; ?>
                    <?php endif; ?>
                    Book your stay
                    <div class="error-container"></div>
                </div>
                <label for="guest-name">
                    Meow, what is your name?
                </label><br>
                <input type="text" id="guest-name" name="guest-name" placeholder="Themperor of Catville" required><br>
                <label for="transfer-code">
                    Meow-meow, enter your transfer code!
                </label><br>
                <input type="text" id="transfer-code" name="transfer-code" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" required><br>
                <button class="button" type="submit" name="booking-step-2" method="post" id="booking-step-2">Book!</button>
            </form>
        </div>
    </div>


    </div>
    <div>
        <?php echo '<pre>';
        var_dump(getRoomInfo()); ?>
        <br>
        <?php var_dump($_SESSION); ?>
    </div>

</main>
<?php require __DIR__ . '/footer.php'; ?>