<?php
require __DIR__ . '/views/head.php';
require __DIR__ . '/views/navigation.php';
require __DIR__ . '/views/header.php';

if (isset($_SESSION['admin'])) :
?>
    <main>
        <div class="headline">
            <p>Welcome, admin</p>
        </div>

        <div class="update">
            <p class="update-heading" class="update-heading">UPDATE ROOM PRICE</p>
            <form action="app/posts/update.php" method="post" name="update-room-price">
                Room type:<br>
                <select name="room">
                    <option name="room" value="1">Budget</option>
                    <option name="room" value="2">Standard</option>
                    <option name="room" value="3">Luxury</option>
                </select>
                <input type="text" name="new-price" placeholder="Enter new price">
                <br>
                <input type="submit" method="post" name="update-room-price" value="Update room price">
            </form>
        </div>

        <div class="update">
            <p class="update-heading">UPDATE FEATURE PRICE</p>
            <form action="app/posts/update.php" method="post" name="update-feature-price">
                Room type:<br>
                <select name="room">
                    <option name="room" value="1">Budget</option>
                    <option name="room" value="2">Standard</option>
                    <option name="room" value="3">Luxury</option>
                </select>
                <br>
                Increase price <input type="checkbox" name="increase"><br>
                Decrease price <input type="checkbox" name="decrease"><br>
                <input type="text" name="price-modifier" placeholder="Enter modifier">
                <br>
                <input type="submit" method="post" name="update-feature-price" value="Update feature price">
            </form>
        </div>

        <div class="update">
            <p class="update-heading">UPDATE STARS</p>
            <form action="app/posts/update.php" method="post" name="update-stars">
                <input type="text" name="new-stars" placeholder="Enter new star count">
                <br>
                <input type="submit" method="post" name="update-stars" value="Update star count">
            </form>
            <form action="" method="post">
            </form>
        </div>
    </main>
<?php else : ?>
    <main>
        <div class="headline">
            <p>Please log in using your API key to view this page.</p>
        </div>
    <?php endif; ?>
    <?php require __DIR__ . '/views/footer.php'; ?>