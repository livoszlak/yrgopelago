<?php require __DIR__ . '/views/head.php';
require __DIR__ . '/views/header.php';
require __DIR__ . '/views/navigation.php'; ?>

<article>
    <h1>Admin login</h1>

    <form action="app/users/login.php" method="post">
        <div class="mb-3">
            <label for="admin" class="form-label">Username</label>
            <input class="form-control" type="text" name="admin" id="admin" placeholder="Thempress of Catville" required>
            <small class="form-text">Please provide admin username.</small>
        </div>

        <div class="mb-3">
            <label for="key" class="form-label">Key</label>
            <input class="form-control" type="password" name="adminKey" id="key" required>
            <small class="form-text">Please provide key.</small>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</article>

<?php
require __DIR__ . '/views/footer.php'; ?>