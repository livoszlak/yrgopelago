<main>MAIN!
    <article>
        <p>This is the home page.</p>

        <?php if (isset($_SESSION['user'])) : ?>
            <p>Welcome, <?php echo $_SESSION['user']['name']; ?>!</p>
        <?php endif; ?>
    </article>
</main>