<nav class="navbar">
    <div class="container">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/index.php">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/about.php">About</a>
            </li>

            <li class="nav-item">
                <?php if (isset($_SESSION['user'])) : ?>
                    <a class="nav-link" href="/app/users/logout.php">Logout</a>
                <?php else : ?>
                    <a class="nav-link" href="/login.php">Login</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>