<footer>
    <?php echo '<pre>';
    var_dump($_SESSION); ?>
</footer>
<?php if (stripos($link, 'room.php')) : ?>
    <script src="../assets/scripts/app.js"></script>
<?php else : ?>
    <script src="assets/scripts/app.js"></script>
<?php endif; ?>
</body>

</html>