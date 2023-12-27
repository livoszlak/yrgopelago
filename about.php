<?php

declare(strict_types=1);
require __DIR__ . '/views/head.php';
require __DIR__ . '/views/navigation.php';
require __DIR__ . '/views/header.php'; ?>

<main>
    <div class="cat">
        <div class="cat-cal"><img src="assets/images/CALTOP-manja-vitolic-gKXKBY-C-Dk-unsplash.png"></div>
    </div>
    HERE'S THE ABOUT STUFF!
</main>
<style>
    .cat {
        width: 100%;
    }

    .cat-cal>img {
        width: 50%;
        z-index: 5;
    }

    .cat-cal {
        width: 100%;
    }
</style>

<?php require __DIR__ . '/views/footer.php';
?>