![](https://github.com/livoszlak/yrgopelago/blob/master/assets/images/HEADER-gaelle-marcel-YnbJwNXy0YQ-unsplash.png)

# Isle of Cats

(pronounciation: [aɪl ɒv kæts], _"Ilovecats"_)

Welcome to **The Cat's Cradle**, a haven nestled in the heart of the **Yrgopelago**, where our story begins with the enchanting discovery of the **Isle of Cats**. This idyllic island, adorned with lush landscapes and sun-kissed vistas, revealed a paradise inhabited by a harmonious community of domestic cats.
The island's extraordinary charm captured the hearts of explorers who envisioned a safe place for these charming creatures. The Cat's Cradle emerged as not just a hotel, but a sanctuary for the many homeless cats that call the Isle of Cats their home. We believe in creating an environment where guests can indulge in the delights of a stay tailored to cat lovers' dreams.

# The Cat's Cradle

Our accommodation options range from budget to standard to luxury rooms, each thoughtfully designed to offer modern comforts. Equipped with an array of cat toys, our rooms provide the perfect setting for guests to unwind amidst cozy spaces while creating lasting memories with their feline companions. Picture yourself in a room where the line between guest and furry friend blurs, and every stay becomes a unique adventure filled with charming antics and companionship.

At The Cat's Cradle , we pride ourselves on more than just offering a delightful getaway. Profits generated from your stay contribute to the welfare of the Isle of Cats' feline population. We are committed to not only caring for the island's homeless cats, but also actively participating in preservation efforts to maintain their natural habitat. Your choice to stay with us helps ensure the continued well-being of these endearing creatures and the preservation of the unique charm that is the Isle of Cats.
Join us in celebrating the beauty of our feline friends, and let The Cat's Cradle be your gateway to an unforgettable experience where the love for cats and the preservation of their island paradise go hand in hand.

# Instructions

No installation needed, just come visit our lovely island! Booking currently restricted to tourists travelling from other islands in the Yrgopelago. Pack your sunniest disposition, plenty of catnip, and don't forget your transfer code!

# Code review

1. views/navigation.php:3 - A suggestion if you want to easily switch between local hosting and deployed site
   and have links like this one direct to the correct site, you could set a "base-url" in autoload.php
   or another file which is loaded everywhere. Then concatenate (like: `<?= $baseUrl ?> . "index.php"`)
   and change only one line of code when switching between local and deployed:
   `$baseUrl = "/"` when hosting locally and `$baseUrl = https://rogue-fun.se/cradle/` when deploying.
2. .editorconfig:12 - Set the indent size to 2 or 4, 20 is way to much!!
3. views/room.php:15 - A minor thing but maybe a double negation `if (!empty ... )` could be changed to `if (isset ...)`?
   I know the two don´t equate completely but something like that could improve readability.
4. views/room.php:129 - I think it's generally not recommended to have HTML tags inside PHP strings.
   On this line you could change it to exit PHP mode when you write HTML and enter PHP mode again thereafter.
5. views/room.php:162 - Also a minor thing but it's always a good idea to exclude spaces from file names, just in case.
6. calendar.php:23-53 - Even though it's not used, since you included the file I will comment on it :)
   The buttons could be printed with a loop instead of writing each one manually.
7. booking-complete.js:4 - Although `var` is completely valid code,
   I think it's generally recommended to use `let` and `const` instead in JavaScript.
8. app/users/arrays.php - This file is maybe a bit redundant? The content could be included in views/room.php.
9. app/users/config.php - Same a above. I think it's generally very good that you have such a clear file structure,
   but the content of this file could maybe be included in autoload.php instead?
10. global.css:6-7 - The color contrast between text and background could be increased (especially on luxury room styling)
    to increase readability and make the site more accessible.

All in all a nice looking and well structured project with well documented code. / Joar
