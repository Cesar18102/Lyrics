<html>
	<head>
		<title></title>
		<link rel = "stylesheet" href = "../styles/main.css"/>
	</head>
	<body>
		<table border = "0px" cellspacing = "0px" cellpadding = "0px"> 
			<tr> 
				<td colspan = "3">
					<div class = "header">
						<div class = "head_button" id = "lyrics_button">Вірші</div>
						<div class = "head_button" id = "pictures_button">Картини</div>
						<div class = "head_button" id = "videos_button">Фільми та пісні</div>
						<div class = "head_button" id = "main_button">Головна</div>
					</div>
				</td>
			</tr>
			
			<tr>
				<td style = "vertical-align : top;"><div class = "left_side"></div></td>
				<td><div class = "content">
					
					<?php
				
						include "../scripts/php/DB_Request.php";
						$db_link = Connect();
					
						$pictures = Request($db_link, "SELECT * FROM PICTURES");
						
						while($picture = mysqli_fetch_array($pictures, MYSQLI_ASSOC)) {
								
							echo 	"<div class = 'pictures'>
										<ul class = 'list'>
											<li class = 'list_item' style = 'list-style-image : url(../pic/list_item_image.png);'><div class = 'lyrics_item'><a class = 'lyrics_link' href = 'picture.php?id=".$picture["id"]."'>".$picture["name"]." — ".$picture["description"]."</a></div></li>";
							echo 	   "</ul>
									</div>";
						}
					?>

				</div></td>
				<td style = "vertical-align : top;"><div class = "right_side"></div></td>
			</tr>
			
			<tr>
				<td colspan = "3"><div class = "footer"></div></td>
			</tr>
		</table>
		<script src = "../scripts/js/page_switcher_creative.js"></script>
	</body>
</html>