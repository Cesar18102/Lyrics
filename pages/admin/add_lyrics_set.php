<html>
	<head>
		<title></title>
		<link rel = "stylesheet" href = "../../styles/main.css"/>
	</head>
	<body>
		<table border = "0px" cellspacing = "0px" cellpadding = "0px"> 
			<tr> 
				<td colspan = "3">
					<div class = "header">
						
						<?php 
							
							$auth = isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true";
							
							if($auth)
								echo '<div class = "head_button" id = "new_add">Новина</div>
									  <div class = "head_button" id = "lyrics_set_add">Збірник</div>
									  <div class = "head_button" id = "lyrics_add">Вірш</div>
									  <div class = "head_button" id = "picture_add">Картина</div>
									  <div class = "head_button" id = "film_add">Фільм/Кліп</div>
									  <div class = "head_button" id = "pic_add">Завантажити картинку</div>
									  <form action = "out.php" method = "POST" id = "out_form">
										<input name = "redirect" value = "admin.php" hidden></input>
										<div class = "head_button" id = "admin_out" onclick = "document.getElementById(\'out_form\').submit();">X</div>
									  </form>';
							else 
								Header("Location: admin.php");
						?>
						
					</div>
				</td>
			</tr>
			
			<tr>
				<td style = "vertical-align : top;"><div class = "left_side"></div></td>
				<td>
					<div class = "content">
					
						<?php
						
							if($auth) {
								
								echo "<center>
										<form id = 'new_add_form' action = 'query.php' method = 'POST'>
											<table>
												<tr>
													<td><input name = 'table' value = 'LYRICS_SET' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><input name = 'redirect' value = 'add_lyrics_set.php' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><input name = 'id' value = '0' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Назва збірника та назва розділу: </label></td>
													<td><input class = 'admin_input' name = 'name' id = 'title_input' maxlength = '100' placeholder = 'Назва збірника - назва розділу' required oninput = \"textFormatPreview('title_input', 'preview_title', 'Назва збірника - назва розділу');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Опис розділу: </label></td>
													<td><textarea class = 'admin_textarea' name = 'description' id = 'text_input' oninput = \"textFormatPreview('text_input', 'preview_text', 'Опис розділу');\"></textarea></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Дата дата видання збірника: </label></td>
													<td><input class = 'admin_input' name = 'write_date' type = 'date' id = 'date_input' value = '".date('Y-m-j')."' required oninput = \"document.getElementById('preview_date').innerHTML = document.getElementById('date_input').value;\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Ілюстрація до розділу: </label></td>
													<td>
														<select class = 'admin_input' name = 'src' id = 'pic_src' onchange = \"document.getElementById('preview_picture_wrapper').innerHTML = '<div class = \'new_picture\' style = \'background-image : url(../../' + document.getElementById('pic_src').value + ');\'></div>';\">
															<option value = 'NULL'>NULL</option>";
													
														$pictures = array();
														$files = scandir("../../");
														
														for( ; count($files) != 0; ) {
															
															if(preg_match("/(\.jpg)|(\.png)$/i", $files[0]))
																array_push($pictures, $files[0]);
															
															if(preg_match("/^[^\.]+$/", $files[0])){
																
																$dirs = scandir("../../".$files[0]);
																
																foreach($dirs as $key => $dir)
																	$dirs[$key] = $files[0]."/".$dirs[$key];
																
																$files = array_merge($files, $dirs);
															}
															
															array_shift($files);
														}
														
														echo "<option>".implode("</option>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>", $pictures)."</option>";
													
												echo   "</select>
													</td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Піктограма для перечислення віршів розділу: </label></td>
													<td>
														<select class = 'admin_input' name = 'list_item_pict_src' id = 'list_item_src_input' onchange = \"let lis = document.getElementsByClassName('list_item'); let src = 'url(../../' + document.getElementById('list_item_src_input').value + ');'; for(let i of lis) i.style = 'margin-left : 3vw; list-style-image : ' + src;\">
															<option value = 'NULL'>NULL</option>";
													
														foreach($pictures as $picture) {
															
															list($width, $height, $type, $attr) = getimagesize("../../".$picture);
															if($width <= 32 && $height <= 32)
																echo "<option>".$picture."</option>";
														}
													
												echo "</select>
													</td>
												</tr>
												<tr>
													<td colspan = '2'>
														<center><button class = 'admin_submit_button' type = 'submit'>Додати розділ</button></center>
													</td>
												</tr>
											</table>
										  </form>
									  </center>";
							}
						?>					
						
						
						<div class = 'set'>
							<div class = 'set_header'>
								<div class = 'set_title' id = 'preview_title'>Назва збірника - назва розділу</div>
								<div class = 'set_date' id = 'preview_date'><?php echo date('Y-m-j'); ?></div>
							</div>
							<div class = 'set_description' id = 'preview_text'>Опис розділу</div>
							<div class = 'set_content'>
								<center>
									<table width = '100%'>
										<tr>
									
								<?php
									$Total = rand(5, 10);
									$Height = ceil($Total / 3);
													
									for($i = 0; $i < 3; $i++) {
												
										echo "<td><ul class = 'list'>";
														
										for($j = 0; $j < $Height && $i * $Height + $j < $Total; $j++)
											echo "<li class = 'list_item' style = 'margin-left : 3vw;'><div class = 'lyrics_item'><a class = 'lyrics_link'>Вірш №".($i * $Height + $j + 1)."</a></div></li>";
												
									echo 	"</ul>
										</td>";
									}
								?>
											
										</tr>
									</table>
								</center>
							</div>
							<center id = 'preview_picture_wrapper'></center>
						</div>
					</div>
				</td>
				<td style = "vertical-align : top;"><div class = "right_side"></div></td>
			</tr>
			
			<tr>
				<td colspan = "3"><div class = "footer"></div></td>
			</tr>
		</table>
		<script src = "../../scripts/js/page_switcher_admin.js"></script>
		<script src = "../../scripts/js/input_format_admin.js"></script>
	</body>
</html>