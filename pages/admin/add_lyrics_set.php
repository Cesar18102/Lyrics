<html>
	<head>
		<title></title>
		<link rel = "stylesheet" href = "../../styles/main.css"/>
		<link rel="stylesheet" type="text/css" href="../../scripts/js/libs/iconselect/css/lib/control/iconselect.css" >
        <script type="text/javascript" src="../../scripts/js/libs/iconselect/lib/control/iconselect.js"></script>
        <script type="text/javascript" src="../../scripts/js/libs/iconselect/lib/iscroll.js"></script>
		<script src = "../../scripts/js/scroll_blocker.js"></script>
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
														<input class = 'admin_input' hidden name = 'src' id = 'pic_src'></input>
														<div id = 'my-icon-select'></div>
														<script>
															let icons = [{'iconFilePath':'', 'iconValue':'1'}];";
															
															include "get_imgs.php";
															$pictures = GetImgs();
															
															foreach($pictures as $picture)
																if(!strpos($picture, "iconselect"))
																	echo "icons.push({'iconFilePath':'../../".$picture."'});";
														
													echo   "let pic_input = document.getElementById('pic_src');
															let icon_view = document.getElementById('my-icon-select');
															let icon_input = new IconSelect('my-icon-select',
																				{'selectedIconWidth':192,
																				 'selectedIconHeight':128,
																				 'selectedBoxPadding':1,
																				 'iconsWidth':192,
																				 'iconsHeight':128,
																				 'boxIconSpace':1,
																				 'vectoralIconNumber': Math.min(2, icons.length),
																				 'horizontalIconNumber': Math.min(2, Math.ceil(icons.length / 2))});
																				 
															SetBlockers('my-icon-select');
															SetBlockers('my-icon-select-box-scroll');
															
															icon_view.addEventListener('changed', function(e){
																
																let path = icon_input.getSelectedFilePath().substring(6);
																pic_input.value = path;
																document.getElementById('preview_picture_wrapper').innerHTML = path == ''? '' : '<div class = \'new_picture\' style = \'background-image : url(../../' + pic_input.value + ');\'></div>';
															});
															
															icon_input.refresh(icons);
															
														</script>
													</td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Піктограма для перечислення віршів розділу: </label></td>
													<td>
														<input class = 'admin_input' hidden name = 'list_item_pict_src' id = 'list_item_src_input'></input>
														<div id = 'my-picto-icon-select'></div>
														<script>
														
															let picto_input = document.getElementById('list_item_src_input');
															let picto_icon_view = document.getElementById('my-picto-icon-select');
															
															let picto_icons = [{'iconFilePath':'', 'iconValue':'1'}];";
															
															foreach($pictures as $picture) {
																
																list($width, $height, $type, $attr) = getimagesize("../../".$picture);
																if($width <= 32 && $height <= 32 && !strpos($picture, "iconselect"))
																	echo "picto_icons.push({'iconFilePath':'../../".$picture."'});";
															}
															
														echo "let picto_icon_input = new IconSelect('my-picto-icon-select',
																				{'selectedIconWidth':32,
																				 'selectedIconHeight':32,
																				 'selectedBoxPadding':1,
																				 'iconsWidth':32,
																				 'iconsHeight':32,
																				 'boxIconSpace':1,
																				 'vectoralIconNumber': Math.min(4, picto_icons.length),
																				 'horizontalIconNumber': Math.min(4, Math.ceil(picto_icons.length / 4))});
																				 
															SetBlockers('my-picto-icon-select');
															SetBlockers('my-picto-icon-select-box-scroll');
															
															picto_icon_view.addEventListener('changed', function(e){
																
																let path = picto_icon_input.getSelectedFilePath().substring(6);
																picto_input.value = path;
																
																let lis = document.getElementsByClassName('list_item'); 
																let src = 'url(../../' + document.getElementById('list_item_src_input').value + ');'; 
																
																for(let i of lis) 
																	i.style = 'margin-left : 3vw; list-style-image : ' + src;
															});
															
															picto_icon_input.refresh(picto_icons);
															
														</script>
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
		<script src = "../../scripts/js/scroll_adder.js"></script>
		<script>SetScrolls();</script>
	</body>
</html>