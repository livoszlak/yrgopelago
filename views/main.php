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
    <article>
        <div class="calendar-wrapper">
            <?= $calendar->draw(date('2024-01-01')); ?>
        </div>
        <form action="" method="POST">
            <select type="select" id="room-select" name="room-select">
                <option type="select" id="budget" name="budget" value="1">Budget</option>
                <option type="select" id="standard" name="standard" value="2">Standard</option>
                <option type="select" id="luxury" name="luxury" value="3">Luxury</option>
            </select>
            <label for="arrival">Arrival date:</label>
            <input type="date" id="arrival" name="arrival" value="2024-01-01" min="2024-01-01" max="2024-01-31" />
            <label for="departure">Departure date:</label>
            <input type="date" id="departure" name="departure" value="2024-01-01" min="2024-01-01" max="2024-01-31" />
            <br>
            <button type="submit" name="check-availability" id="check-availability">Check availability</button>
            <?php if (isset($_POST['room-type'], $_POST['arrival'], $_POST['departure'])) :
                $availableRooms = checkAvailability($_POST['arrival'], $_POST['departure'], $_POST['room-type']);
                var_dump($availableRooms);
            endif; ?>

            <br>
            <br>

            Add cats:
            <?php foreach ($features as $cats => $cat) : ?>
                <input type="checkbox" id="<?= $cat['id']; ?>" name="feature<?= $cat['id'] ?>"><?= $cat['feature_name']; ?></input>
            <?php endforeach; ?>
            <button type="submit" name="submit" method="POST" id="submit">Submit</button>
        </form>
        <?= '<pre>';
        var_dump($_POST); ?>
    </article>
</main>
<script>

</script>