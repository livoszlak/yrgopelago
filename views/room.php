<?php

declare(strict_types=1);
require __DIR__ . '/head.php';
require __DIR__ . '/navigation.php';
require __DIR__ . '/header.php';
require __DIR__ . '/../app/arrays.php';

use benhall14\phpCalendar\Calendar as Calendar;

$calendar = new Calendar;
$calendar->useMondayStartingDate();
$_SESSION['room-type'] = htmlspecialchars($_GET['room-type'], ENT_QUOTES);
$roomInfo = getRoomInfo();
if (!empty($_SESSION['features'])) {
    foreach ($roomInfo as $info => $feature) {
        if (!in_array((int)$feature['feature_id'], $_SESSION['features'])) {
            continue;
        } else {
            $_SESSION['feature-data'][] = ['name' => $feature['feature_name'], 'cost' => $feature['feature_price'], 'id' => $feature['feature_id']];
        }
    }
}
?>

<main>
    <div class="discounts">
        <div class="discount-headline">PAW-TASTIC DISCOUNTS AVAILABLE!</div>
        <div class="discount-specs">Book more than 2 days with us for 25% off your stay -<br>
            and add 4 or more features to your 2+ days long stay for 40% off!</div>
    </div>
    <div class="calendar-info-wrapper">
        <div class="room-info-wrapper">
            <div class="calendar-wrapper">
                <?php addCalendarEvent($calendar, (int)$_GET['room-type']);
                echo $calendar->draw(date('2024-01-01')); ?>
            </div>
            <div class="info-wrapper">
                <span class="room-name">
                    <?php switch ($_GET['room-type']):
                        case 1:
                            echo $roomDescriptions['budget']['name'];
                            break;
                        case 2:
                            echo $roomDescriptions['standard']['name'];
                            break;
                        case 3:
                            echo $roomDescriptions['luxury']['name'];
                            break;
                    endswitch; ?>
                </span>
                <div class="booking-info">
                    <p>
                        <?php switch ($_GET['room-type']):
                            case 1:
                                echo $roomDescriptions['budget']['description'];
                                break;
                            case 2:
                                echo $roomDescriptions['standard']['description'];
                                break;
                            case 3:
                                echo $roomDescriptions['luxury']['description'];
                                break;
                        endswitch; ?>
                    </p>
                    <p>
                        <?php switch ($_GET['room-type']):
                            case 1:
                                echo $roomDescriptions['budget']['lore'];
                                break;
                            case 2:
                                echo $roomDescriptions['standard']['lore'];
                                break;
                            case 3:
                                echo $roomDescriptions['luxury']['lore'];
                                break;
                        endswitch; ?>

                    </p>
                </div>
            </div>
        </div>
        <div class="info-instructions-wrapper">
            <div class="room-info">
                <ul>
                    <li><b>Room cost per night:</b> <?= $roomInfo[0]['room_price']; ?><sup>cc</sup></li><br>
                    <li><b># of cats available:</b> <?= count($roomInfo); ?></li>
                </ul>
            </div>
            <div class="instructions">
                Check the calendar for available dates. Select your desired arrival and departure dates, then add which cats you want for company during your stay. Click the "get your quote" button for your total. Submit your name and transfer code. Welcome!</li>
            </div>
        </div>
    </div>

    <form action="" method="post" name="booking" id="booking">
        <div class="booking">
            <div class="date-picker-wrapper">
                <div class="arrival">
                    <label for="arrival">Arrival date:</label>
                    <input type="date" id="arrival" name="arrival" value="<?php echo isset($_POST['arrival']) ? htmlspecialchars($_POST['arrival'], ENT_QUOTES) : '2024-01-01'; ?>" min="2024-01-01" max="2024-01-31" required />
                </div>
                <div class="departure">
                    <label for="departure">Departure date:</label>
                    <input type="date" id="departure" name="departure" value="<?php echo isset($_POST['departure']) ? htmlspecialchars($_POST['departure'], ENT_QUOTES) : '2024-01-01'; ?>" min="2024-01-01" max="2024-01-31" required />
                </div>
            </div>

            <div class="features-wrapper">
                <div class="headline">ADD FURRY FRIENDS TO YOUR STAY!</div>
                <div class="feature-choices-wrapper">
                    <?php foreach ($roomInfo as $info => $feature) : ?>
                        <div class="feature" style="background-image: url('../<?= $feature['feature_url']; ?>')">
                            <div class="feature-price-bubble">
                                <p><?= $feature['feature_price']; ?><sup>cc</sup></p>
                            </div>
                            <div class="input-wrapper">
                                <input type="checkbox" class="checkbox" id="<?= $feature['feature_id']; ?>" name="<?= $feature['feature_id'] ?>">
                                <div class="feature-name-wrapper"><a class="feature-name"><?= $feature['feature_name']; ?></a></div></input>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="button-quote-wrapper">
                <button class="button" type="submit" name="booking-step-1" id="booking-step-1">Get your quote!</button>
                <div class="quote-wrapper">
                    <?= 'Your total is <span class="quote">' . (!isset($_SESSION['totalCost']) ? '0' : $_SESSION['totalCost']) . '<sup>cc</sup></span>' ?>
                </div>
    </form>

    <?php if (isset($_POST['booking-step-1'])) : ?>
        <div class="issues">
            <ul>
                <?php if ($_SESSION['totalDays'] == 0) : ?>
                    <li>Hissss, you selected unavailable dates. Please double check our availability calendar!</li>
                <?php endif;
                if (count($_SESSION['features']) == 0) : ?>
                    <li>No cats? Seriously? That hurts... right here in my meow-meow...</li>
                <?php endif;
                if ($_POST['arrival'] > $_POST['departure']) : ?>
                    <li>Your arrival date is set after your departure. Unless you are a time traveller (in which case, we have parking space for your TARDIS!), please reselect your dates!</li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="error-container">
        <ul>
            <?php if (!empty($_SESSION['errors'])) :
                foreach ($_SESSION['errors'] as $error) : ?>
                    <li><?= $error; ?></li>
                <?php endforeach;
                $_SESSION['errors'] = []; ?>
            <?php endif; ?>
        </ul>
    </div>
    <div class="booking-carousel-wrapper">
        <div class="room-carousel">
            <div class="mySlides fade">
                <img id="sliderImage" src="../assets/images/carousel/CAROUSEL-nine-koepfer-lpgAlv8I7V8-unsplash (1).jpg">
            </div>
        </div>

        <form class="booking-form" action="../app/posts/booking.php" method="post" name="booking" id="booking">
            <div class="booking-wrapper">
                <div class="booking-heading-wrapper">
                    Book your stay
                </div>
                <div class="form-payment">
                    <label for="guest-name">
                        Meow, what is your name?
                    </label><br>
                    <input type="text" id="guest-name" name="guest-name" placeholder="Themperor of Catville" required><br>
                    <label for="transfer-code">
                        Meow-meow, enter your transfer code!
                    </label><br>
                    <input type="text" id="transfer-code" name="transfer-code" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" required><br>
                    <button class="button" type="submit" name="booking-step-2" method="post" id="booking-step-2">Book!</button>
                </div>
        </form>
    </div>
    </div>

</main>
<?php require __DIR__ . '/footer.php'; ?>