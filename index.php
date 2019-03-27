<html>
	<head>
		<title></title>
		<link rel = "stylesheet" href = "styles/main.css"/>
	</head>
	<body>
		<table border = "0px" cellspacing = "0px" cellpadding = "0px"> 
			<tr> 
				<td colspan = "3">
					<div class = "header">
						<div class = "head_button" id = "science_button">Наукова діяльність</div>
						<div class = "head_button" id = "creative_button">Творчість</div>
						<div class = "head_button" id = "news_button">Новини</div>
						<div class = "head_button" id = "author_button">Про автора</div>
					</div>
				</td>
			</tr>
			
			<tr>
				<td style = "vertical-align : top;"><div class = "left_side"></div></td>
				<td><div class = "content">
					
					<?php
						
						include "scripts/php/DB_Request.php";
						$db_link = Connect();
						$news = Request($db_link, "SELECT * FROM NEWS ORDER BY news_date DESC");
						
						while($new = mysqli_fetch_array($news, MYSQLI_ASSOC)) {
							
							echo 	"<div class = 'new'>
										<div class = 'new_header'>
											<div class = 'new_title'>".
												$new["title"].
											"</div>
											<div class = 'new_date'>".
												$new["news_date"];
											
											$auth = isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true";
											
											if($auth)
												echo "<form id = 'new_add_form' action = 'pages/admin/query_delete.php' method = 'POST'>
														<table>
															<input name = 'table' value = 'NEWS' hidden></input>
															<input name = 'redirect' value = '../../index.php' hidden></input>
															<input name = 'id' value = '".$new['id']."' hidden></input>
															<button class = 'admin_delete_button' type = 'submit'>X</button>
														</table>
													  </form>";
								echo   "</div>
										</div>
										<div class = 'new_content'>".
											$new["description"].
										"</div>";
										
							if(isset($new["src"]) && $new["src"] != "NULL")
								echo "<center>
										<div class = 'new_picture' style = 'background-image : url(".$new["src"].");'></div>
									  </center>";
							
							if(isset($new["video_src"]) && $new["video_src"] != "NULL")
								echo "<div class = 'video_new_wrapper'>
										<iframe class = 'video_new' src='".$new["video_src"]."' frameborder='1' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
									 </div>";
							echo "</div>";
						}
					?>

				</div></td>
				<td style = "vertical-align : top;"><div class = "right_side"></div></td>
			</tr>
			
			<tr>
				<td colspan = "3"><div class = "footer"></div></td>
			</tr>
		</table>
		<script src = "scripts/js/page_switcher.js"></script>
	</body>
</html>