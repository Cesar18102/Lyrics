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
								
								if(isset($_POST['edit']) && $_POST['edit'] == '1') {
								
									include "../../scripts/php/DB_Request.php";
									$db_link = Connect();
									global $new;
									$new = mysqli_fetch_array(Request($db_link, "SELECT * FROM NEWS WHERE id = ".$_POST['id']), MYSQLI_ASSOC);
								}
								
								echo "<center>
										<form id = 'new_add_form' action = '".(isset($new)? "query_update.php" : "query.php")."' method = 'POST'>
											<table>
												<tr>
													<td><input name = 'table' value = 'NEWS' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><input name = 'redirect' value = '".(isset($new)? "../../index.php" : "add_new.php")."' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><input name = 'id' value = '".(isset($new)? $new['id'] : 0)."' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Заголовок новини: </label></td>
													<td><input class = 'admin_input' name = 'title' value = '".(isset($new)? $new['title'] : "")."' id = 'title_input' required oninput = \"textFormatPreview('title_input', 'preview_title', 'Заголовок новини');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Текст новини: </label></td>
													<td><textarea class = 'admin_textarea' name = 'description' value = '".(isset($new)? $new['description'] : "")."' id = 'text_input' oninput = \"textFormatPreview('text_input', 'preview_text', 'Текст новини');\">".(isset($new)? $new['description'] : "")."</textarea></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Дата новини: </label></td>
													<td><input class = 'admin_input' name = 'news_date' type = 'date' value = '".(isset($new)? $new['news_date'] : date('Y-m-j'))."' id = 'date_input' required oninput = \"document.getElementById('preview_date').innerHTML = document.getElementById('date_input').value;\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Ілюстрація до новини: </label></td>
													<td>
														<input class = 'admin_input' hidden name = 'src' value = '".(isset($new)? $new['src'] : "")."' id = 'pic_src'></input>
														<div id = 'my-icon-select'></div>
														<script>
														
															let icons = [{'iconFilePath':'', 'iconValue':'1'}];";
													
															include "get_imgs.php";
															$pictures = GetImgs();
															
															foreach($pictures as $picture)
																if(!strpos($picture, "iconselect"))
																	echo "icons.push({'iconFilePath':'../../".$picture."'});";
															
													echo   "
															let pic_input = document.getElementById('pic_src');
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
													<td><label class = 'admin_input_label'>Відео до новини: </label></td>
													<td><input class = 'admin_input' name = 'video_src' id = 'video_src_input' value = '".(isset($new)? $new['video_src'] : "")."' maxlength = '200' type = 'url' placeholder = 'https://www.youtube.com/embed/cwyoYeRfpSM' oninput = \"VideoFormat('video_src_input', 'preview_video_new_wrapper')\"></input></td>
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
		<script src = "../../scripts/js/input_format_admin.js"></script>
		<script src = "../../scripts/js/scroll_adder.js"></script>
		<script>SetScrolls();</script>
		<script>
			
			textFormatPreview('title_input', 'preview_title', 'Заголовок новини');
			textFormatPreview('text_input', 'preview_text', 'Текст новини');
			document.getElementById('preview_date').innerHTML = document.getElementById('date_input').value;
			
			let p = "<?php echo $new['src']; ?>";
			document.getElementById('preview_picture_wrapper').innerHTML = p == '' || p == 'NULL'? '' : '<div class = \'new_picture\' style = \'background-image : url(../../' + p + ');\'></div>';
			document.getElementById('pic_src').value = p;
			
			VideoFormat('video_src_input', 'preview_video_new_wrapper');
			
		</script>
	</body>
</html>