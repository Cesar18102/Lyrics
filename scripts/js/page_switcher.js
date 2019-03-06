let lyrics_button = document.getElementById('lyrics_button');
let pictures_button = document.getElementById('pictures_button');
let news_button = document.getElementById('news_button');

lyrics_button.onclick = function() { document.location = "/Lyrics/pages/lyrics.php" };
pictures_button.onclick = function() { document.location = "/Lyrics/pages/pictures.php" };
news_button.onclick = function() { document.location = "/Lyrics" };
