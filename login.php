<?php require __DIR__ . '/views/head.php';
require __DIR__ . '/views/header.php';
require __DIR__ . '/views/navigation.php'; ?>

<main>
    <article>
        <div class="headline">Admin login</div>
        <div class="update login">
            <form action="app/users/login.php" method="post">
                <div class="mb-3">
                    <label for="admin" class="form-label">Username</label><br>
                    <input class="form-control" type="text" name="admin" id="admin" placeholder="Thempress of Catville" required>
                </div>

                <div class="mb-3">
                    <label for="key" class="form-label">Key</label><br>
                    <input class="form-control" type="password" name="adminKey" id="key" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </article>
    <br>
</main>
<?php
require __DIR__ . '/views/footer.php'; ?>