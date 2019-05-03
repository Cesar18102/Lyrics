<html>
	<head>
		<title>Офіційна особиста сторінка Віктора Васильовича Кириченка</title>
		<link rel = "stylesheet" href = "../styles/main.css"/>
		<link rel = "icon" href = "../pic/list_item_image.png"/>
		<meta name = "description" content = "Кириченко Віктор Васильович - офіційна особиста сторінка"/>
		<meta name = "keywords" content = "Кириченко, Віктор Васильович, вірші, стихи, стихотворения, пісні, песни, картини, акадамік НААН, творчість, новини"/>
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
				<td>
				<div class = "content">
					
					<?php
				
						include "../scripts/php/DB_Request.php";
						$db_link = Connect();
				
						$videos = Request($db_link, "SELECT * FROM FILMS ORDER BY id DESC");
						
						while($video = mysqli_fetch_array($videos, MYSQLI_ASSOC)) {
								
							echo 	"<div class = 'video_container'>
										<div class = 'video_header'>
											<center>
												<div class = 'video_title'>".
													$video["title"].
												"</div>
											</center>";
											
											if(isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true")
												echo "<form id = 'new_add_form' action = 'admin/query_delete.php' method = 'POST' style = 'position : relative; margin-top : 0vh;'>
														<table>
															<input name = 'table' value = 'FILMS' hidden></input>
															<input name = 'redirect' value = '../videos.php' hidden></input>
															<input name = 'id' value = '".$video['id']."' hidden></input>
															<button class = 'admin_delete_button' type = 'submit'>X</button>
														</table>
													  </form>
													  <form id = 'new_edit_form' action = 'admin/add_film.php' method = 'POST' style = 'position : relative; margin-top : -3vh;'>
														<table>
															<input name = 'edit' value = '1' hidden></input>
															<input name = 'id' value = '".$video['id']."' hidden></input>
															<button class = 'admin_edit_button' type = 'submit'>...</button>
														</table>
													  </form>";
							echo	   "</div>
										<div class = 'video_description'>".
											$video["description"].
										"</div>
										<div class = 'video_wrapper'>
											<iframe class = 'video' src='".$video["video_src"]."' frameborder='1' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
										</div>
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