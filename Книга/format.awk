BEGIN {

	STR = 0;
	C = 0;
	QUERY = "";
	TOPIC = "";
}

/\w+/ {
	
	if(substr($0, 1, 1) == "<") {
	
		STR = 0;
	
		if(QUERY != "") {
			
			QUERY = QUERY "\", \"2019-03-17\", \"В.В. Кириченко\", \"\", \"\", \"\");";
			print QUERY > "QUERY1.txt";
			QUERY = "";
		}
		
		NAME = "";
		
		if(C == 0)
			TOPIC = "'Радість життя\" розділ \"Природа і ми'";
		if(C == 41)
			TOPIC = "'Радість життя\" розділ \"Радість життя'";
		if(C == 61)
			TOPIC = "'Радість життя\" розділ \"Мій рідний край'";
		if(C == 69)
			TOPIC = "'Радість життя\" розділ \"Любовна лірика'";
		if(C == 97)
			TOPIC = "'Радість життя\" розділ \"Дороги, що ми обираємо'";
		if(C == 119)
			TOPIC = "'Радість життя\" розділ \"Уроки історії'";
		if(C == 133)
			TOPIC = "'Радість життя\" розділ \"Жарти і байки'";
			
		if(C == 0 || C == 41 || C == 61 || C == 69 || C == 97 || C == 119 || C == 133)
			QUERY = QUERY "INSERT INTO LYRICS_SET VALUES(0," TOPIC ", '', '2016-05-05', 'pictures/news_pictures/1.png', 'pic/list_item_image.png');";
		
		NAME = substr($0, 2, index($0, " - ") - 2);
			
		gsub("\"", "\\\"", NAME);
		
		IND = index(NAME, "(");
		if(IND != 0)
			NAME = substr(NAME, 1, IND - 1);
		
		QUERY = QUERY "INSERT INTO LYRICS VALUES(0, (SELECT id FROM LYRICS_SET WHERE name = " TOPIC "), \"" NAME "\", \"";

		C++;		
	}
}

/\w+/ {
	
	if(substr($0, 1, 1) != "<") {
	
		gsub("\"", "\\\"", $0);
		QUERY = QUERY "<div class = 'tab'>" substr($0, 0, length($0) - 1) "</div>";
		
		STR++;
		if(STR == 4) {
				
			STR = 0;
			QUERY = QUERY "<br/>";
		}
	}
}

