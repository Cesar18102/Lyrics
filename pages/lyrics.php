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
				<td><div class = "content">
					
					<?php
				
						include "../scripts/php/DB_Request.php";
						$db_link = Connect();
						
						if(isset($_GET["id"])) {
					
							$id = $_GET["id"];
							$lyrics_set = Request($db_link, "SELECT * FROM LYRICS WHERE id = ".$id);
						
							while($lyrics = mysqli_fetch_array($lyrics_set, MYSQLI_ASSOC)) {
								
								$pictures = Request($db_link, "SELECT * FROM LYRICS_PICTURES WHERE lyrics_id = ".$id);
								$videos = Request($db_link, "SELECT * FROM LYRICS_VIDEOS WHERE lyrics_id = ".$id);
								
								echo 	"<div class = 'lyrics'>
											<center>
												<div class = 'lyrics_title'>".
													$lyrics["name"].
												"</div>";
											
												if(isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true")
													echo "<form id = 'new_add_form' action = 'admin/query_delete.php' method = 'POST' style = 'position : relative; margin-top : 0vh;'>
															<table>
																<input name = 'table' value = 'LYRICS' hidden></input>
																<input name = 'redirect' value = '../lyrics_sets.php' hidden></input>
																<input name = 'id' value = '".$lyrics['id']."' hidden></input>
																<button class = 'admin_delete_button' type = 'submit'>X</button>
															</table>
														  </form>
														  <form id = 'new_edit_form' action = 'admin/add_lyrics.php' method = 'POST' style = 'position : relative; margin-top : -3vh;'>
															<table>
																<input name = 'edit' value = '1' hidden></input>
																<input name = 'id' value = '".$lyrics['id']."' hidden></input>
																<button class = 'admin_edit_button' type = 'submit'>...</button>
															</table>
														  </form>";
														  
								echo 	   "</center>
											<div class = 'lyrics_description'>".
												$lyrics["description"].
											"</div>
											<center>
												<div class = 'lyrics_content'>";
												
								$content = $lyrics["content"];
												
								if($lyrics["auto_format"] == 1) {

									$content = str_replace($lyrics["STROPHE_DELIM"], "", $lyrics["content"]);
										
									if($lyrics["BRS"] != 0 || $lyrics["STROPHE_LENGTH"] != 4 || $lyrics["TABBED"] == 1) {
										
										$Lines = explode($lyrics["LINE_WRAPPER_END"], $content);
										$content = "";
										
										for($i = 0; $i < count($Lines); $i += $lyrics["STROPHE_LENGTH"]) {
										
											for($j = 0; $j < $lyrics["STROPHE_LENGTH"] && $i + $j < count($Lines); $j++)
												if($lyrics["TABBED"] == 1 && (($i + $j) / $lyrics["STROPHE_LENGTH"]) % 2 == 1)
													$content .= str_replace($lyrics["LINE_WRAPPER"], $lyrics["LINE_WRAPPER_TABBED"], $Lines[$i + $j]).$lyrics["LINE_WRAPPER_TABBED_END"];
												else
													$content .= $Lines[$i + $j].$lyrics["LINE_WRAPPER_END"];
												
											$content .= $lyrics["STROPHE_DELIM"];
										}
									}
								}
								
								echo				$content.
										"</center>
											<div class = 'lyrics_comment'>".
												$lyrics["author_comment"].
											"</div>";
									
								while($picture = mysqli_fetch_array($pictures, MYSQLI_ASSOC))
									if(file_exists("../".$picture["src"]))
										echo "<center><div class = 'lyrics_picture' style = 'background-image : url(../".$picture["src"].");'></div></center>";
								   
								while($video = mysqli_fetch_array($videos, MYSQLI_ASSOC))
									if($video["video_src"] != "" && $video["video_src"] != "NULL" && $video["video_src"] != "")
									   echo "<div class = 'video_new_wrapper'>
												<iframe class = 'video_new' src='".$video["video_src"]."' frameborder='1' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
											 </div>";
											
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
		<script src = "../scripts/js/page_switcher_creative.js"></script>
	</body>
</html>