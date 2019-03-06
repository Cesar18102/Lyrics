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
						<div class = "head_button" id = "lyrics_button">Стихи</div>
						<div class = "head_button" id = "pictures_button">Картины</div>
						<div class = "head_button" id = "news_button">Новости</div>
					</div>
				</td>
			</tr>
			
			<tr>
				<td style = "vertical-align : top;"><div class = "left_side"></div></td>
				<td><div class = "content">
					
					<?php
					
						include "../scripts/php/DB_Request.php";
						$db_link = Connect();
						
						$lyrics_sets = Request($db_link, "SELECT * FROM LYRICS_SET ORDER BY write_date DESC");
						
						while($set = mysqli_fetch_array($lyrics_sets, MYSQLI_ASSOC)) {
							
							$lyrics_in_set = Request($db_link, "SELECT id, name FROM LYRICS WHERE set_id = ".$set["id"]);
							
							echo 	"<div class = 'set'>
										<div class = 'set_header'>
											<div class = 'set_title'>".
												"Збірник \"".$set["name"]."\"".
											"</div>
											<div class = 'set_date'>".
												$set["write_date"].
											"</div>
										</div>
										<div class = 'set_description'>".
											$set["description"].
										"</div>
										<div class = 'set_content'>
											<ul class = 'list'>";
												while($lyrics = mysqli_fetch_array($lyrics_in_set, MYSQLI_ASSOC))
													echo "<li class = 'list_item' style = 'list-style-image : url(../".$set["list_item_pict_src"].");'><div class = 'lyrics_item'><a class = 'lyrics_link' href = 'lyrics.php?id=".$lyrics["id"]."'>".$lyrics["name"]."</a></div></li>";
							echo 			"</ul>
										</div>
										<center><div class = 'set_picture' style = 'background-image : url(../".$set["src"].");'></div></center>
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
		<script src = "../scripts/js/page_switcher.js"></script>
	</body>
</html>