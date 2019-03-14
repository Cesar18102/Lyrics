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
					
						if(isset($_GET['id'])) {
							
							$id = $_GET['id'];
							
							include "../scripts/php/DB_Request.php";
							$db_link = Connect();
						
							$picture = Request($db_link, "SELECT * FROM PICTURES WHERE id = ".$id);
							
							while($pic = mysqli_fetch_array($picture, MYSQLI_ASSOC)) {
									
								echo 	"<div class = 'picture'>
											<div class = 'picture_header'>
												<div class = 'picture_title'>".
													$pic["name"].
												"</div>
												<div class = 'picture_date'>".
													$pic["write_date"].
												"</div>
											</div>
											<div class = 'picture_description'>".
													$pic["description"].
											"</div>
											<center><div class = 'picture_picture' style = 'background-image : url(../".$pic["src"].");'></div></center>
											<div class = 'picture_comment'>".
												$pic["author_comment"].
											"</div>
										</div>";
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
		<script src = "../scripts/js/page_switcher_creative.js"></script>
	</body>
</html>