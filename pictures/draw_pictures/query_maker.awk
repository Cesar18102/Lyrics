/\w+\.(jpg|JPG)/ {

	print "INSERT INTO PICTURES VALUES(0, 'Картина " $0 "', '2019-01-10', 'В. В. Кириченко', 'Описание картины', 'Авторский комментарий', 'pictures/draw_pictures/" $0 "');" > "QUERY.txt";
}