foreach ($_POST as $key => $value) {
if ($key < 40) { $_SESSION['features'][]=[ 'id'=> $key,
    'cost' => $value
    ];
    }
    }



    Add cats:
    <?php foreach ($features as $cats => $cat) : ?>
        <input type=" checkbox" id="<?= $cat['id']; ?>" name="feature<?= $cat['id'] ?>"><?= $cat['feature_name']; ?></input>
    <?php endforeach; ?>
    <button type="submit" name="submit" method="POST" id="submit">Submit</button>
    </form>

    <script>
        // let arrival = null;
        // let departure = null;

        // days.forEach(function (day) {
        //   day.addEventListener('click', function () {
        //     if (arrival === null) {
        //       arrival = this.id;
        //       this.classList.add('selected');
        //       document.getElementById('arrival').value = arrival;
        //       document.getElementById('calendar-form').submit();
        //     } else if (arrival !== null && departure === null) {
        //       departure = this.id;
        //       this.classList.add('selected');
        //       document.getElementById('departure').value = departure;
        //       document.getElementById('calendar-form').submit();
        //     }

        //   let arrivalIndex = days.indexOf(arrival);
        //   let departureIndex = days.indexOf(departure);
        //   while (arrivalIndex < departureIndex) {
        //     arrivalIndex++;
        //     days[arrivalIndex].classList.add('selected');
        //   }
        //   days[departureIndex].classList.add('selected');
        // } else {
        //   arrival = null;
        //   departure = null;
        //   document.querySelectorAll('.date').forEach((day) => {
        //     day.classList.remove('selected');
        //   });
        // });
    </script>

    <?php

    declare(strict_types=1);

    use benhall14\phpCalendar\Calendar as Calendar;

    $calendar = new Calendar;
    $calendar->useMondayStartingDate();

    if (isset($_POST['arrival'], $_POST['departure'])) :
        $_SESSION['arrival'] = $_POST['arrival'];
        $_SESSION['departure'] = $_POST['departure'];
    endif;
    if (isset($_POST['room-type'])) :
        $_SESSION['room-type'] = $_POST['room-type'];
    endif;
    if (isset($_POST['transfer-code'], $_POST['guest-name'])) :
        $_SESSION['transfer-code'] = $_POST['transfer-code'];
        $_SESSION['guest-name'] = $_POST['guest-name'];
    endif;
    if (isset($_GET['check-availability'], $_GET['room-type'])) {
        addCalendarEvent($calendar, (int)$_GET['room-type']);
        $calendar->draw(date('2024-01-01'));
    }

    ?>

    <!-- old main -->

    <main>MAIN!
        <div class="availability">
            <div class="calendar-wrapper">
                <?php
                echo $calendar->draw(date('2024-01-01')); ?>
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
        <button class="accordion">Choose your dates!</button>
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
                    <button class="button" type="submit" name="booking-step-1" id="booking-step-1">Book your stay</button>
                </form>
            </div>
        </div>
        <button class="accordion">Add features!</button>
        <div class="panel">
            <?php if (isset($_SESSION['room-type'])) :
                $features = fetchFeatures($_SESSION['room-type']); ?>
                <p><?= count($features); ?> features available for your chosen room type. Hint: other types may have more... or less...</p>
            <?php endif; ?>
            <form action="" method="post" name="set-features" id="set-features">
                <?php foreach ($features as $cats => $cat) : ?>
                    <input type="checkbox" id="<?= $cat['id']; ?>" name="<?= $cat['id'] ?>"><?= $cat['feature_name']; ?></input>
                <?php endforeach; ?>
                <button class="button" type="submit" name="booking-step-2" method="post" id="booking-step-2">Add features</button>
            </form>
        </div>
        <button class="accordion">Get your quote!</button>
        <div class="panel">
            <p>So cheap! Your total comes to:</p>
            <?= getQuote(); ?>
        </div>
        <button class="accordion">Book your stay!</button>
        <div class="panel">
            <p>Please enter your name and your transfer code to finalize your booking!</p>
            <form action="validateTransferCode.php" method="post" name="booking" id="booking">
                <input type="text" id="guest-name" name="guest-name" placeholder="Themperor of Catville" required><br>
                <input type="text" id="transfer-code" name="transfer-code" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" required>
                <button class="button" type="submit" name="booking-step-3" method="post" id="booking-step-3">Book!</button>
            </form>
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

        if (isset($_POST['booking-step-1'], $_SESSION['room-type'], $_SESSION['arrival'], $_SESSION['departure'])) :
            $availableRooms = checkAvailability($_SESSION['arrival'], $_SESSION['departure'], (int)$_SESSION['room-type']);
            $dates = fetchDates($availableRooms);
            $_SESSION['totalDays'] = count($dates);
            reserveRoom($dates, (int)$_SESSION['room-type'], $_SESSION['userId']);
        endif; ?>
        <br>
        <br>

        <?php echo '<pre> SESSION <br>';
        var_dump($_SESSION);
        echo 'POST <br>';
        var_dump($_POST);
        echo 'GET <br>';
        var_dump($_GET);
        echo 'FEATURES' . '<br>';
        echo countFeatureCosts($_SESSION);
        echo '<br>';
        echo 'ROOM COST' . '<br>';
        echo countStayCost() . '<br';
        $data = validateTransferCode('c8c33dbe-e0c9-4321-8ac6-f82d893790e1', $_SESSION['totalCost']);
        var_dump($data);

        ?>
    </main>


    // const accordion = document.getElementsByClassName('accordion');

    // for (let i = 0; i < accordion.length; i++) { // accordion[i].addEventListener('click', function () { // this.classList.toggle('active'); // const panel=this.nextElementSibling; // if (panel.style.display==='block' ) { // panel.style.display='none' ; // } else { // panel.style.display='block' ; // } // if (panel.style.maxHeight) { // panel.style.maxHeight=null; // } else { // panel.style.maxHeight=panel.scrollHeight + 'px' ; // } // // Close all other accordions // for (let j=0; j < accordion.length; j++) { // if (i !==j && accordion[j].classList.contains('active')) { // accordion[j].classList.remove('active'); // const otherPanel=accordion[j].nextElementSibling; // otherPanel.style.display='none' ; // otherPanel.style.maxHeight=null; // } // } // }); // }