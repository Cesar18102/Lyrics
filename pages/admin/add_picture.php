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
							
							if(isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true") {
								
								if(isset($_POST['edit']) && $_POST['edit'] == '1') {
								
									include "../../scripts/php/DB_Request.php";
									$db_link = Connect();
									global $pic;
									$pic = mysqli_fetch_array(Request($db_link, "SELECT * FROM PICTURES WHERE id = ".$_POST['id']), MYSQLI_ASSOC);
								}
								
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
							}
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
					
						<center>
						
							<form onsubmit = 'addPicture();'>
								<table>
									<tr>
										<td><label class = 'admin_input_label'>Назва картини: </label></td>
										<td><input class = 'admin_input' name = 'name' value = '<?php echo isset($pic) ? $pic['name'] : ""; ?>' id = 'name_input' required oninput = "textFormatPreview('name_input', 'preview_name', 'Назва картини');"></input></td>
									</tr>
									<tr>
										<td><label class = 'admin_input_label'>Опис картини: </label></td>
										<td><textarea class = 'admin_textarea' name = 'description' value = '<?php echo isset($pic) ? $pic['description'] : ""; ?>' id = 'text_input' oninput = "textFormatPreview('text_input', 'preview_text', 'Опис картини');"><?php isset($pic) ? $pic['description'] : ""; ?></textarea></td>
									</tr>
									<tr>
										<td><label class = 'admin_input_label'>Дата написання картини: </label></td>
										<td><input class = 'admin_input' name = 'write_date' type = 'date' id = 'date_input' value = '<?php echo isset($pic) ? $pic['write_date'] : date('Y-m-j'); ?>' required oninput = "document.getElementById('preview_date').innerHTML = document.getElementById('date_input').value;"></input></td>
									</tr>
									<tr>
										<td><label class = 'admin_input_label'>Авторський коментар: </label></td>
										<td><input class = 'admin_input' name = 'author_comment' id = 'author_comment_input' value = '<?php echo isset($pic) ? $pic['author_comment'] : ""; ?>' oninput = "textFormatPreview('author_comment_input', 'preview_comment', 'Авторський коментар');"></input></td>
									</tr>
									<tr>
										<td><label class = 'admin_input_label'>Картина: </label></td>
										<td>
											<?php 
												if(!isset($pic)) 
													echo "<input class = 'admin_input' type = 'file' id = 'file_input' onchange = 'showPreviewPicture();' required></input>"; 
												else {
													
													echo "<input class = 'admin_input' hidden name = 'src' value = '".$pic['src']."' id = 'pic_src'></input>
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
																document.getElementById('picture_wrapper').innerHTML = path == ''? '' : '<div class = \'new_picture\' style = \'background-image : url(../../' + pic_input.value + ');\'></div>';
															});
																
															icon_input.refresh(icons);
															
														</script>";
												}
											?>
											
										</td>
									</tr>
									<tr>
										<td colspan = '2'>
											<center><button class = 'admin_submit_button' type = 'submit'>Додати картину</button></center>
										</td>
									</tr>
								</table>
							</form>
							
						</center>
						
						<div class = 'picture' style = 'margin-top : 2vh'>
							<div class = 'picture_header'>
								<div class = 'picture_title' id = 'preview_name'>Назва картини</div>
								<div class = 'picture_date' id = 'preview_date'><?php echo date('Y-m-j'); ?></div>
							</div>
							<div class = 'picture_description' id = 'preview_text'>Опис картини</div>
							<center id = 'picture_wrapper'></center>
							<div class = 'picture_comment' id = 'preview_comment'>Авторський коментар</div>
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
		<script>
		
			function showPreviewPicture() {
				
				let file = document.getElementById('file_input').files[0];
				let path = (window.URL || window.webkitURL).createObjectURL(file);
				
				document.getElementById('picture_wrapper').innerHTML = "<div class = 'picture_picture' style = 'background-image : url(" + path + ");'></div>";
			}
		
			function uploadPicture() {
				
				let formdata = new FormData();
				formdata.append('dir', '../../pictures/draw_pictures');
							
				file = document.getElementById('file_input').files[0];
				formdata.append('file', file, document.getElementById('name_input').value + '.jpg');
				
				let xhr_upload_pic = new XMLHttpRequest();
				xhr_upload_pic.open('POST', 'upload_file.php', false);
				xhr_upload_pic.send(formdata);
			}
			
			function addPicture() {
				
				<?php echo !isset($pic)? "uploadPicture();" : 
				
					"let xhr_delete = new XMLHttpRequest();
					 xhr_delete.open('POST', 'query_delete.php', false);
					 let data_delete = { redirect : '../pictures.php', table : 'PICTURES', id : ".$pic['id']." };
					 let body_delete = fillXMLHttpRequest(data_delete, xhr_delete);
					 xhr_delete.send(body_delete);"; ?>
				
				let name = document.getElementById('name_input').value;
				let date = document.getElementById('date_input').value;
				let descr = document.getElementById('text_input').value;
				let comment = document.getElementById('author_comment_input').value;
				let pic_src = <?php echo !isset($pic)? "'pictures/draw_pictures/' + name + '.jpg'" : "document.getElementById('pic_src').value" ?>
				
				let pic_data_object = { table : "PICTURES", id : <?php echo isset($pic)? $pic['id'] : 0; ?>, name : name, write_date : date, author : "В. В. Кириченко", description : descr, author_comment : comment, src : pic_src };
				
				let xhr_add_pic = new XMLHttpRequest();
				xhr_add_pic.open('POST', 'query.php', false);
								
				let body_add_pic = fillXMLHttpRequest(pic_data_object, xhr_add_pic);
				xhr_add_pic.send(body_add_pic);
			}
			
			function fillXMLHttpRequest(dataObject, xhr) {
				
				let boundary = String(Math.random()).slice(2);
				let boundaryMiddle = '--' + boundary + '\r\n';
				let boundaryLast = '--' + boundary + '--\r\n'

				let body = ['\r\n'];
				for (let key in dataObject) { body.push('Content-Disposition: form-data; name="' + key + '"\r\n\r\n' + dataObject[key] + '\r\n'); }

				body = body.join(boundaryMiddle) + boundaryLast;

				xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
				return body;
			}
			
		</script>
		<script>
		
			<?php echo isset($pic) ? 
					"let path = '".$pic['src']."';
				     document.getElementById('picture_wrapper').innerHTML = '<div class = \"picture_picture\" style = \"background-image : url(../../' + path + ');\"></div>';
					 document.getElementById('pic_src').value = path;" : ""; ?>
					 
			textFormatPreview('name_input', 'preview_name', 'Назва картини');
			textFormatPreview('text_input', 'preview_text', 'Опис картини');
			document.getElementById('preview_date').innerHTML = document.getElementById('date_input').value;
			textFormatPreview('author_comment_input', 'preview_comment', 'Авторський коментар');
			
		</script>
	</body>
</html>