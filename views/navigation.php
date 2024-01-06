<nav class="navbar">
    <div class="container">
        <div class="logo"><a href="/index.php">Cat's Cradle</a>
            <div class="stars">

            </div>
        </div>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/index.php">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/about.php">About</a>
            </li>

            <li class="nav-item">
                <?php if (isset($_SESSION['admin'])) : ?>
                    <a class="nav-link" href="/admin.php">Admin</a>
            </li>
            <a class="nav-link" href="/app/users/logout.php">Logout admin</a>
        <?php else : ?>
            <a class="nav-link" href="/login.php">Login admin</a>
        <?php endif; ?>
        </li>
        </ul>
    </div>
</nav>