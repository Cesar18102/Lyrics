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
						
						$lyrics_sets = Request($db_link, "SELECT * FROM LYRICS_SET ORDER BY write_date DESC");
						
						while($set = mysqli_fetch_array($lyrics_sets, MYSQLI_ASSOC)) {
							
							$lyrics_in_set = Request($db_link, "SELECT id, name FROM LYRICS WHERE set_id = ".$set["id"]);
							
							echo 	"<div class = 'set'>
										<div class = 'set_header'>
											<div class = 'set_title'>".
												"Збірник \"".$set["name"]."\"".
											"</div>
											<div class = 'set_date'>".
												$set["write_date"];
											
											if(isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true")
												echo "<form id = 'new_add_form' action = 'admin/query_delete.php' method = 'POST'>
														<table>
															<input name = 'table' value = 'LYRICS_SET' hidden></input>
															<input name = 'redirect' value = '../lyrics_sets.php' hidden></input>
															<input name = 'id' value = '".$set['id']."' hidden></input>
															<button class = 'admin_delete_button' type = 'submit'>X</button>
														</table>
													  </form>";
													  
										echo "</div>
										</div>
										<div class = 'set_description'>".
											$set["description"].
										"</div>
										<div class = 'set_content'>
											<center><table width = '100%'><tr>";
										
											$Total = mysqli_num_rows($lyrics_in_set);
											$Height = ceil($Total / 3);
													
											for($i = 0; $i < 3; $i++) {
												
												echo "<td><ul class = 'list'>";
														
												for($j = 0; $j < $Height && $i * $Height + $j < $Total; $j++) {
													
													$lyrics = mysqli_fetch_array($lyrics_in_set, MYSQLI_ASSOC);
													echo "<li class = 'list_item' style = 'margin-left : 3vw; list-style-image : url(../".$set["list_item_pict_src"].");'><div class = 'lyrics_item'><a class = 'lyrics_link' href = 'lyrics.php?id=".$lyrics["id"]."'>".$lyrics["name"]."</a></div></li>";
												}
												
												echo 	"</ul>
													  </td>";
											}
											
							echo 			"</tr></table></center>
										</div>";
										
										if(isset($set["src"]) && $set["src"] != "NULL")
											echo "<center><div class = 'set_picture' style = 'background-image : url(../".$set["src"].");'></div></center>";
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
		<script src = "../scripts/js/page_switcher_creative.js"></script>
	</body>
</html>