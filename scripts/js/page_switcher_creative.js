let lyrics_button = document.getElementById('lyrics_button');
let pictures_button = document.getElementById('pictures_button');
let videos_button = document.getElementById('videos_button');
let main_button = document.getElementById('main_button');

lyrics_button.onclick = function() { document.location = "/Lyrics/pages/lyrics_sets.php" };
pictures_button.onclick = function() { document.location = "/Lyrics/pages/pictures.php" };
videos_button.onclick = function() { document.location = "/Lyrics/pages/videos.php" };
main_button.onclick = function() { document.location = "/Lyrics" };
