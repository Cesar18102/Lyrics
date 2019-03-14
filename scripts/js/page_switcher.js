let creative_button = document.getElementById('creative_button');
let news_button = document.getElementById('news_button');
let author_button = document.getElementById('author_button');
let science_button = document.getElementById('science_button');

creative_button.onclick = function() { document.location = "/Lyrics/pages/creativity.php" };
author_button.onclick = function() { document.location = "/Lyrics/pages/author.php" };
science_button.onclick = function() { document.location = "/Lyrics/pages/science.php" };
news_button.onclick = function() { document.location = "/Lyrics" };
