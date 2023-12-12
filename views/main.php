<?php

declare(strict_types=1);

use benhall14\phpCalendar\Calendar as Calendar;

$calendar = new Calendar;
$calendar->useMondayStartingDate();

$database = databaseConnect('/database/hotel.db');
$statement = $database->prepare('SELECT * FROM features');
$statement->execute();
$features = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<main>MAIN!
    <div class="calendar-wrapper">
        <?php
        if (isset($_POST['check-availability'], $_POST['room-type'])) {
            addCalendarEvent($calendar, (int)$_POST['room-type']);
        } ?>
        <?= $calendar->draw(date('2024-01-01')); ?>
    </div>
    <div class="update-availability">
        <form action="" method="post" name="update-availability" id="update-availability">
            <label for="room-type">Select room type:</label>
            <select type="select" id="room-type" name="room-type">
                <option type="select" id="budget" name="budget" value="1">Budget</option>
                <option type="select" id="standard" name="standard" value="2">Standard</option>
                <option type="select" id="luxury" name="luxury" value="3">Luxury</option>
            </select>
            <button type="submit" name="check-availability" id="check-availability">Check availability</button>
        </form>
    </div>
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
            <button type=" submit" name="booking-step-1" id="booking-step-1">Book your stay</button>
        </form>
    </div>
    <div class="features-wrapper" id="features-wrapper"></div>

    <?php if (isset($_POST['room-type'], $_POST['arrival'], $_POST['departure'])) :
        $availableRooms = checkAvailability($_POST['arrival'], $_POST['departure'], (int)$_POST['room-type']);
    endif;

    if (isset($_POST['arrival'], $_POST['departure'])) :
        $arrival = $_POST['arrival'];
        $departure = $_POST['departure'];
    endif;
    ?>
    <br>
    <br>


    <?php echo '<pre>';
    var_dump($_POST); ?>

</main>