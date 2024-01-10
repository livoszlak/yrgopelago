<nav class="navbar">
    <div class="container">
        <div class="logo"><a href="https://rogue-fun.se/cradle/index.php">Cat's Cradle</a>
            <div class="stars">
                <?php for ($i = 0; $i < $_SESSION['stars']; $i++) : ?>
                    <?php if (stripos($link, 'room.php') || stripos($link, 'booking-complete.php')) : ?>
                        <img src="../assets/images/icons/star.svg">
                    <?php else : ?>
                        <img src="assets/images/icons/star.svg">
                <?php endif;
                endfor; ?>
            </div>
        </div>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="https://rogue-fun.se/cradle/index.php">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="https://rogue-fun.se/cradle/about.php">About</a>
            </li>

            <li class="nav-item">
                <?php if (isset($_SESSION['admin'])) : ?>
                    <a class="nav-link" href="https://rogue-fun.se/cradle/admin.php">Admin</a>
            </li>
            <a class="nav-link" href="../app/users/logout.php">Logout admin</a>
        <?php else : ?>
            <a class="nav-link" href="https://rogue-fun.se/cradle/login.php">Login admin</a>
        <?php endif; ?>
        </li>
        </ul>
    </div>
</nav>