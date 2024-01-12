<main>
    <div class="headline">
        <a>Welcome to the Cat's Cradle</a>
    </div>
    <div class="index-info">
        <div class="hotel-info">
            <div class="info headline">THE ISLE OF CATS</div>
            <p>Our idyllic island hosts a harmony of domestic cats amid lush landscapes and sunny vistas. Wander pathways adorned by playful felines amidst blooming gardens, and listen to the serene symphony of contented purrs. Encounter a variety of breeds relaxing by clear streams or perched with regal grace. Your heart will surely be stolen by their charming antics.</p>
        </div>
        <div class="hotel-info">
            <div class="info headline">A MEOWGICAL PLACE</div>
            <p>Indulge in a stay tailored to cat lovers' dreams! Choose from budget, standard, or luxury rooms, each offering modern comforts and equipped with cat toys. Personalize your stay by welcoming adorable feline companions into your room. Picture yourself unwinding amidst cozy spaces, cuddling with furry friends, and creating memories that purr-sist forever.</p>
        </div>
    </div>
    <div class="rooms-wrapper">
        <a href="views/room.php?room-type=1">
            <div class="room-card budget">
                <div class="room-text">
                    <div class="room-heading">SAM'S SUITE</div>
                    <span class="remaining">Only <?= countRemaining(1); ?> dates left!</span><br>
                    <span class="feature-count"><?= count(fetchFeatures(1)); ?> companion cats available!</span>
                </div>
                <div class="room-image"><img src="assets/images/ROOM-pexels-anete-lusina-5240576.png"></div>
            </div>
        </a>
        <a href="views/room.php?room-type=2">
            <div class="room-card standard">
                <div class="room-text">
                    <div class="room-heading">FINDUS' FLAT</div>
                    <span class="remaining">Only <?= countRemaining(2); ?> dates left!</span><br>
                    <span class="feature-count"><?= count(fetchFeatures(2)); ?> companion cats available!</span>
                </div>
                <div class="room-image"><img src="assets/images/ROOM-pexels-ekaterina-bolovtsova-7445017.png"></div>
            </div>
        </a>
        <a href="views/room.php?room-type=3">
            <div class="room-card luxury">
                <div class="room-text">
                    <div class="room-heading">CHESHIRE'S CHAMBER</div>
                    <span class="remaining">Only <?= countRemaining(3); ?> dates left!</span><br>
                    <span class="feature-count"><?= count(fetchFeatures(3)); ?> companion cats available! </span>
                </div>
                <div class="room-image"><img src="assets/images/ROOM-pexels-max-rahubovskiy-6580369.png"></div>
            </div>
        </a>
        <div class="cat-fact"></div>
    </div>
</main>