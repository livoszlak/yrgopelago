<footer>
    <div class="osz-logo"></div>
    <div class="contact">
        <span class="contact-headline">The Cat's Cradle Hotel</span><br>
        <span class="contact-details">42 Sir Meowington Memorial Lane</span><br>
        <span class="contact-details">421 53 Whisker Bay, The Isle of Cats</span><br>
        <span class="contact-details">Yrgopelago</span><br>
        <span class="contact-details">+46 22702-881127</span><br>
        <span class="contact-details"><a href="https://github.com/livoszlak" target="_blank">the-cradle@hotel.com</a></span>
    </div>
</footer>
<?php if (stripos($link, 'room.php')) : ?>
    <script src="../assets/scripts/room.js"></script>
<?php elseif (stripos($link, 'booking-complete.php')) : ?>
    <script src="../assets/scripts/booking-complete.js"></script>
<?php elseif (!stripos($link, 'admin.php' || !stripos($link, 'login.php') || !stripos($link, 'about.php') || !stripos($link, 'booking-complete.php'))) : ?>
    <script src="assets/scripts/index.js"></script>
<?php endif; ?>
</body>

</html>