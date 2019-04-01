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
						
						$picture = Request($db_link, "SELECT * FROM PICTURES");
							
						while($pic = mysqli_fetch_array($picture, MYSQLI_ASSOC)) {
									
							echo 	"<div class = 'picture'>
										<div class = 'picture_header'>
											<div class = 'picture_title'>".
												$pic["name"].
											"</div>
											<div class = 'picture_date'>".
												$pic["write_date"];
												
											if(isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true")
												echo "<form id = 'new_add_form' action = 'admin/query_delete.php' method = 'POST'>
														<table>
															<input name = 'table' value = 'PICTURES' hidden></input>
															<input name = 'redirect' value = '../pictures.php' hidden></input>
															<input name = 'id' value = '".$pic['id']."' hidden></input>
															<button class = 'admin_delete_button' type = 'submit'>X</button>
														</table>
													  </form>";
													  
							echo 			"</div>
										</div>
										<div class = 'picture_description'>".
												$pic["description"].
										"</div>
										<center><div class = 'picture_picture'  style = '".($pic['author_comment'] == "" ? "margin-bottom : -2vh;" : "")."background-image : url(../".$pic["src"].");'></div></center>
										<div class = 'picture_comment'>".
											$pic["author_comment"].
										"</div>
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