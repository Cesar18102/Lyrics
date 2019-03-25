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
								echo '<div class = "head_button" id = "new_add">Додати новину</div>
									  <div class = "head_button" id = "lyrics_add">Додати вірш</div>
									  <div class = "head_button" id = "picture_add">Додати картину</div>
									  <div class = "head_button" id = "film_add">Додати відео</div>
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
													<td><input name = 'table' value = 'NEWS' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><input name = 'redirect' value = 'add_new.php' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><input name = 'id' value = '0' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Заголовок новини: </label></td>
													<td><input class = 'admin_input' name = 'title' id = 'title_input' maxlength = '255' required oninput = \"document.getElementById('preview_title').innerHTML = document.getElementById('title_input').value;\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Текст новини: </label></td>
													<td><textarea class = 'admin_textarea' name = 'description' id = 'text_input' oninput = \"document.getElementById('preview_text').innerHTML = document.getElementById('text_input').value;\"></textarea></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Дата новини: </label></td>
													<td><input class = 'admin_input' name = 'news_date' type = 'date' id = 'date_input' value = '".date('Y-m-j')."' required oninput = \"document.getElementById('preview_date').innerHTML = document.getElementById('date_input').value;\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Ілюстрація до новини: </label></td>
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
													<td><label class = 'admin_input_label'>Відео до новини: </label></td>
													<td><input class = 'admin_input' name = 'video_src' id = 'video_src_input' maxlength = '200' type = 'url' placeholder = 'https://www.youtube.com/embed/cwyoYeRfpSM' oninput = \"let video_src_input = document.getElementById('video_src_input'); video_src_input.value = video_src_input.value.replace('watch', 'embed').replace('?v=', '/').replace(/&t=\d+s/, ''); document.getElementById('preview_video_new_wrapper').innerHTML = '<div class = \'video_new_wrapper\'><iframe class = \'video_new\' frameborder = \'1\' allow = \'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\' allowfullscreen src = \'' + video_src_input.value + '\'></iframe></div>';\"></input></td>
												</tr>
												<tr>
													<td colspan = '2'>
														<center><button class = 'admin_submit_button' type = 'submit'>Додати нивину</button></center>
													</td>
												</tr>
											</table>
										  </form>
									  </center>";
							}
						?>					
						
						<div class = 'new'>
							<div class = 'new_header'>
								<div class = 'new_title' id = 'preview_title'>Заголовок новини</div>
								<div class = 'new_date' id = 'preview_date'><?php echo date('Y-m-j'); ?></div>
							</div>
							<div class = 'new_content' id = 'preview_text'>Текст новини</div>
							<center id = 'preview_picture_wrapper'></center>
							<div id = 'preview_video_new_wrapper'></div>
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
	</body>
</html>