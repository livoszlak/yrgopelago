<?php

declare(strict_types=1);

use benhall14\phpCalendar\Calendar as Calendar;

$calendar = new Calendar;
$calendar->useMondayStartingDate();

$database = databaseConnect('/database/hotel.db');
$statement = $database->prepare('SELECT * FROM features');
$statement->execute();
$features = $statement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['arrival'], $_POST['departure'])) :
    $_SESSION['arrival'] = $_POST['arrival'];
    $_SESSION['departure'] = $_POST['departure'];
endif;
if (isset($_POST['room-type'])) :
    $_SESSION['room-type'] = $_POST['room-type'];
endif;
?>

<main>MAIN!
    <div class="availability">
        <div class="calendar-wrapper">
            <?php
            if (isset($_POST['check-availability'], $_SESSION['room-type'])) {
                addCalendarEvent($calendar, (int)$_SESSION['room-type']);
            } ?>
            <?= $calendar->draw(date('2024-01-01')); ?>
        </div>
        <div class="update-availability">
            <form action="" method="get" name="update-availability" id="update-availability">
                <label for="room-type">Select room type:</label>
                <select type="select" id="room-type" name="room-type">
                    <option type="select" id="budget" name="budget" value="1">Budget</option>
                    <option type="select" id="standard" name="standard" value="2">Standard</option>
                    <option type="select" id="luxury" name="luxury" value="3">Luxury</option>
                </select>
                <button type="submit" name="check-availability" id="check-availability">Check availability</button>
            </form>
        </div>
    </div>
    <button class="accordion">Book your stay!</button>
    <div class="panel">
        <div class="date-form" id="date-form">
            <form action="" method="post" name="set-dates" id="set-dates">
                <label for="room-type">Room type:</label>
                <select type="select" id="room-type" name="room-type">
                    <option type="select" id="budget" name="budget" value="1">Budget</option>
                    <option type="select" id="standard" name="standard" value="2">Standard</option>
                    <option type="select" id="luxury" name="luxury" value="3">Luxury</option>
                </select>
                <label for="arrival">Arrival date:</label>
                <input type="date" id="arrival" name="arrival" value="2024-01-01" min="2024-01-01" max="2024-01-31" />
                <label for="departure">Departure date:</label>
                <input type="date" id="departure" name="departure" value="2024-01-01" min="2024-01-01" max="2024-01-31" />
                <button type="submit" name="booking-step-1" id="booking-step-1">Book your stay</button>
            </form>
        </div>
    </div>

    <button class="accordion">Add features!</button>
    <div class="panel">
        <p>So many to choose from!</p>
        <form action="" method="post" name="set-features" id="set-features">
            <?php foreach ($features as $cats => $cat) : ?>
                <input type="checkbox" id="<?= $cat['id']; ?>" name="<?= $cat['feature_name'] ?>"><?= $cat['feature_name']; ?></input>
            <?php endforeach; ?>
            <button type="submit" name="booking-step-2" method="post" id="booking-step-2">Add features</button>
        </form>
    </div>

    </div>
    <?php if (!isset($_SESSION['features'])) {
        $_SESSION['features'] = array();
    } else if (isset($_POST['booking-step-2']))
        $_SESSION['features'] = array();
    foreach ($_POST as $key => $value) {
        if ($value == 'on') {
            $_SESSION['features'][] = $key;
        }
    }

    // if (isset($_POST['booking-step-1'])) {

    //     if ($_SESSION['arrival'] > $_SESSION['departure']) {
    //     }
    // }

    if (isset($_POST['booking-step-1'], $_SESSION['room-type'], $_SESSION['arrival'], $_SESSION['departure'])) :
        $availableRooms = checkAvailability($_SESSION['arrival'], $_SESSION['departure'], (int)$_SESSION['room-type']);
        var_dump($availableRooms);
        $dates = fetchDates($availableRooms);
        var_dump($dates);
    // if ($_SESSION['arrival'] > $_SESSION['departure']) 
    endif; ?>
    <br>
    <br>


    <?php echo '<pre>';
    var_dump($_POST);
    var_dump($_SESSION); ?>

</main>