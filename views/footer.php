<footer>

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