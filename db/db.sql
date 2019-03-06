CREATE TABLE LYRICS_SET (

	id INTEGER PRIMARY KEY AUTO_INCREMENT, 
	name CHAR(100),
	description TEXT,
	write_date DATE,
	src char(100),
	list_item_pict_src char(100)
);

CREATE TABLE LYRICS (

	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	set_id INTEGER,
	name CHAR(100),
	content TEXT NOT NULL,
	write_date DATE,
	author CHAR(200) NOT NULL,
	description TEXT,
	author_comment TEXT,
	lyrics_type CHAR(100),
	FOREIGN KEY(set_id) REFERENCES LYRICS_SET(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE PICTURES (

	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name CHAR(100),
	write_date DATE NOT NULL,
	author CHAR(200) NOT NULL,
	description TEXT,
	author_comment TEXT,
	src char(100) NOT NULL
);

CREATE TABLE LYRICS_PICTURES (

	lyrics_id INTEGER NOT NULL,
	src char(100) NOT NULL,
	FOREIGN KEY(lyrics_id) REFERENCES LYRICS(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE NEWS (

	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	title TEXT NOT NULL,
	description TEXT,
	news_date DATE NOT NULL,
	src char(100)
);