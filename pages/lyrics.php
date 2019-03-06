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
						
						if(isset($_GET["id"])) {
					
							$id = $_GET["id"];
							$lyrics_set = Request($db_link, "SELECT * FROM LYRICS WHERE id = ".$id);
						
							while($lyrics = mysqli_fetch_array($lyrics_set, MYSQLI_ASSOC)) {
								
								$pictures = Request($db_link, "SELECT * FROM LYRICS_PICTURES WHERE lyrics_id = ".$id);
								
								echo 	"<div class = 'lyrics'>
											<div class = 'lyrics_header'>
												<div class = 'lyrics_title'>".
													$lyrics["name"].
												"</div>
												<div class = 'lyrics_date'>".
													$lyrics["write_date"].
												"</div>
											</div>
											<div class = 'lyrics_description'>".
													$lyrics["description"].
												"</div>
											<center>
											<div class = 'lyrics_content'>".
												$lyrics["content"].
											"</div>
											</center>
											<div class = 'lyrics_conmment'>".
												$lyrics["author_comment"].
											"</div>";
									
								while($picture = mysqli_fetch_array($pictures, MYSQLI_ASSOC))
									   echo "<center><div class = 'lyrics_picture' style = 'background-image : url(../".$picture["src"].");'></div></center>";
											
								echo 	"</div>";
							}
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