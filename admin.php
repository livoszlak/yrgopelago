<?php require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';
require __DIR__ . '/views/navigation.php'; ?>
<article>
    <h1>Admin page</h1>
    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?php echo $_SESSION['user']; ?>!</p>
    <?php endif; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>