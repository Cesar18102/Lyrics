let new_add = document.getElementById('new_add');
let lyrics_set_add = document.getElementById('lyrics_set_add');
let lyrics_add = document.getElementById('lyrics_add');
let picture_add = document.getElementById('picture_add');
let film_add = document.getElementById('film_add');

new_add.onclick = function() { document.location = "/Lyrics/pages/admin/add_new.php" };
lyrics_set_add.onclick = function() { document.location = "/Lyrics/pages/admin/add_lyrics_set.php" };
lyrics_add.onclick = function() { document.location = "/Lyrics/pages/admin/add_lyrics.php" };
picture_add.onclick = function() { document.location = "/Lyrics/pages/admin/add_picture.php" };
film_add.onclick = function() { document.location = "/Lyrics/pages/admin/add_film.php" };
