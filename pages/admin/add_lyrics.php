<html>
	<head>
		<title></title>
		<link rel = "stylesheet" href = "../../styles/main.css"/>
		<script src = "../../scripts/js/libs/glm-ajax.js"></script>
		<script src = "../../scripts/js/libs/jquery-3.3.1.js"></script>
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
								
								include "../../scripts/php/DB_Request.php";
								
								if(isset($_POST['edit']) && $_POST['edit'] == '1') {
									
									$db_link = Connect();
									
									global $lyr;
									$lyr = mysqli_fetch_array(Request($db_link, "SELECT * FROM LYRICS WHERE id = ".$_POST['id']), MYSQLI_ASSOC);
									
									global $text;
									$text = $lyr['content'];
									
									$text = str_replace($lyr['LINE_WRAPPER'], "", $text);
									$text = str_replace($lyr['LINE_WRAPPER_END'], "\n", $text);
									$text = str_replace($lyr['LINE_WRAPPER_TABBED'], "", $text);
									$text = str_replace($lyr['LINE_WRAPPER_TABBED_END'], "", $text);
									$text = str_replace($lyr['STROPHE_DELIM'], "", $text);
									
									global $pics;
									$pics = Request($db_link, "SELECT * FROM LYRICS_PICTURES WHERE lyrics_id = ".$lyr['id']);
									
									global $pcs;
									$pcs = array();
									
									global $vid;
									$vid = Request($db_link, "SELECT * FROM LYRICS_VIDEOS WHERE lyrics_id = ".$lyr['id']);
									
									global $v;
									$v = array();
								}
								
								echo "<script> 
										let icons = [{'iconFilePath':'', 'iconValue':'1'}];";
										
								include "get_imgs.php";
								$pictures = GetImgs();
															
								foreach($pictures as $picture)
									if(!strpos($picture, "iconselect"))
										echo "icons.push({'iconFilePath':'../../".$picture."'});\n";
								
								echo "</script>
									   <center>
										<form id = 'new_add_form' onsubmit = 'query()'>
											<table>
												<tr> 
													<td><label class = 'admin_input_label'>Збірник та розділ: </label></td>
													<td><select class = 'admin_input' name = 'set_id' id = 'set_id'>";
												
													$db_link = Connect();
													$lyrics_sets = Request($db_link, "SELECT id, name FROM LYRICS_SET");
												
													while($lyrics_set = mysqli_fetch_array($lyrics_sets, MYSQLI_ASSOC))
														echo "<option value = '".$lyrics_set['id']."' ".(isset($lyr) && $lyr['set_id'] == $lyrics_set['id'] ? "selected" : "").">Збірник \"".$lyrics_set['name']."\"</option>";
												
												echo "</select></td>
											    </tr>
												<tr>
													<td><label class = 'admin_input_label'>Назва вірша: </label></td>
													<td><input class = 'admin_input' name = 'name' value = '".(isset($lyr)? $lyr['name'] : "")."' id = 'title_input' maxlength = '100' placeholder = 'Назва вірша' required oninput = \"textFormatPreview('title_input', 'preview_title', 'Назва вірша');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Текст вірша: </label></td>
													<td><textarea class = 'admin_textarea' name = 'content' value = '".(isset($lyr)? $text : "")."' id = 'content_input' required oninput = \"textFormatPreview('content_input', 'preview_content', 'Текст вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\">".(isset($lyr)? $text : "")."</textarea></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Дата написання вірша: </label></td>
													<td><input class = 'admin_input' name = 'write_date' type = 'date' id = 'date_input' value = '".(isset($lyr)? $lyr['write_date'] : date('Y-m-j'))."' required></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Опис вірша: </label></td>
													<td><textarea class = 'admin_textarea' name = 'description' value = '".(isset($lyr)? $lyr['description'] : "")."' id = 'descr_input' oninput = \"textFormatPreview('descr_input', 'preview_descr', 'Опис вірша');\">".(isset($lyr)? $lyr['description'] : "")."</textarea></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Авторський коментар: </label></td>
													<td><textarea class = 'admin_textarea' name = 'author_comment' value = '".(isset($lyr)? $lyr['author_comment'] : "")."' id = 'comment_input' oninput = \"textFormatPreview('comment_input', 'preview_comment', 'Авторський коментар');\">".(isset($lyr)? $lyr['author_comment'] : "")."</textarea></td>
												</tr>
												<tr>
													<td><input name = 'lyrics_type' value = 'Лірика' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Ступінчастий вигляд строф: </label></td>
													<td><input class = 'admin_input auto_format' name = 'TABBED' ".(isset($lyr) && $lyr['TABBED'] == 1? "checked" : "")." id = 'tabbed' type = 'checkbox' hidden onchange = \"textFormatPreview('content_input', 'preview_content', 'Текст вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Додатковыий перенос рядка в кінці строфи: </label></td>
													<td><input class = 'admin_input auto_format' name = 'BRS' ".(isset($lyr) && $lyr['BRS'] == 1? "checked" : "")." id = 'brs' type = 'checkbox' hidden onchange = \"textFormatPreview('content_input', 'preview_content', 'Текст вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Кількість рядків у строфі: </label></td>
													<td><input class = 'admin_input auto_format' name = 'STROPHE_LENGTH' value = '".(isset($lyr)? $lyr['STROPHE_LENGTH'] : "4")."' type = 'number' id = 'strophe_height' min = '1' hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Розмежувач строф: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'STROPHE_DELIM' value = '".(isset($lyr)? $lyr['STROPHE_DELIM'] : "<br/>")."' id = 'str_delimeter' hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Початок розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER' id = 'line_wrapper' value = \"".(isset($lyr)? $lyr['LINE_WRAPPER'] : "<div class = 'tab'>")."\" hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Кінець розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER_END' id = 'line_wrapper_end' value = '".(isset($lyr)? $lyr['LINE_WRAPPER_END'] : "</div>")."' hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Початок подвійного розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER_TABBED' id = 'line_double_wrapper' value = \"".(isset($lyr)? $lyr['LINE_WRAPPER_TABBED'] : "<div class = 'double_tab'>")."\" hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Кінець подвійного розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER_TABBED_END' id = 'line_double_wrapper_end' value = '".(isset($lyr)? $lyr['LINE_WRAPPER_TABBED_END'] : "</div>")."' hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label' >Автоматичне форматування: </label></td>
													<td><input class = 'admin_input' name = 'auto_format' ".(isset($lyr) && $lyr['auto_format'] == 0? "" : "checked")." id = 'auto_format_id' type = 'checkbox' onchange = \"let auto_format_items = document.getElementsByClassName('auto_format'); for(let item of auto_format_items) item.hidden = !this.checked; textFormatPreview('content_input', 'preview_content', 'Текст вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label' >Кількість ілюстрацій: </label></td>
													<td><input class = 'admin_input' id = 'pictures_count_id' type = 'number' value = '".(isset($lyr)? mysqli_num_rows($pics) : "1")."' min = '0' max = '5' oninput = \"showPictureChoosers(document.getElementById('pictures_count_id').value, 'picture_choosers');\"></input></td>
												</tr>
												<tr>
													<td colspan = '2' id = 'picture_choosers' style = 'padding-top : 2vh;'></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label' >Кількість відео: </label></td>
													<td><input class = 'admin_input' id = 'video_count_id' type = 'number' value = '".(isset($lyr)? mysqli_num_rows($vid) : "1")."' min = '0' max = '10' oninput = \"showVideoChoosers(document.getElementById('video_count_id').value, 'video_choosers');\"></input></td>
												</tr>
												<tr>
													<td colspan = '2' id = 'video_choosers' style = 'padding-top : 2vh;'></td>
												</tr>
												<tr>
													<td colspan = '2'>
														<center><button class = 'admin_submit_button' type = 'submit'>Додати вірш</button></center>
													</td>
												</tr>
											</table>
										  </form>
									  </center>";
							}
						?>	
						
						<div class = 'lyrics'>
							<center>
								<div class = 'lyrics_title' id = 'preview_title'>Назва вірша</div>
							</center>
							<div class = 'lyrics_description' id = 'preview_descr'>Опис вірша</div>
							<center>
								<div class = 'lyrics_content' id = 'preview_content'>Текст вірша</div>
							</center>
							<div class = 'lyrics_comment' id = 'preview_comment'>Авторский коментар</div>
							<div id = 'pictures_wrapper'></div>
							<div id = 'video_wrapper'></div>
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
		
			function lyricsFormat(inputId, previewId, auto_format_checker_id, 
								  tabbed_checker_id, brs_checker_id, strophe_height_id, 
								  strophe_delimeter_id, line_wrapper_id, line_wrapper_end_id, 
								  line_double_wrapper_id, line_double_wrapper_end_id) {
									  
				let initLineDelim = '\n';
				
				let content = document.getElementById(inputId).value;
				let preview = document.getElementById(previewId);
				
				let strp_delim = document.getElementById(strophe_delimeter_id).value;
				let strp_height = parseInt(document.getElementById(strophe_height_id).value);
				
				let tabbed = document.getElementById(tabbed_checker_id).checked;
				let brs = document.getElementById(brs_checker_id).checked;
				
				let line_wrapper = document.getElementById(line_wrapper_id).value;
				let line_wrapper_end = document.getElementById(line_wrapper_end_id).value;
				
				let line_double_wrapper = document.getElementById(line_double_wrapper_id).value;
				let line_double_wrapper_end = document.getElementById(line_double_wrapper_end_id).value;
				
				if(document.getElementById(auto_format_checker_id).checked) {
						
					let lines = content.split(initLineDelim);
					content = "";
						
					for(let i = 0; i < lines.length; i += strp_height) {
							
						for(let j = 0; j < strp_height && i + j < lines.length; j++)
							if(tabbed && parseInt((i + j) / strp_height) % 2 == 1)
								content += line_double_wrapper + lines[i + j] + line_double_wrapper_end;
							else
								content +=  line_wrapper + lines[i + j] + line_wrapper_end;
								
						if(brs)
							content += strp_delim;
					}
				}
				
				preview.innerHTML = content;
				return content;
			}
			
			function query() {
				
				<?php echo isset($lyr)? 
					"let id = ".$lyr['id'].";
					 let xhr_delete = new XMLHttpRequest();
					 xhr_delete.open('POST', 'query_delete.php', false);
					 let data_delete = { redirect : '../lyrics.php', table : 'LYRICS', id : id };
					 let body_delete = fillXMLHttpRequest(data_delete, xhr_delete);
					 xhr_delete.onreadystatechange = function() {
					
						 if(xhr_delete.readyState === XMLHttpRequest.DONE && xhr_delete.status === 200) {
									
							query2(id);
						 };
					 }
					 xhr_delete.send(body_delete);" :
					 
					 "let xhr_get_id = new XMLHttpRequest();
					  xhr_get_id.open('POST', 'query_select.php', false);
					  let data = { query : \"SELECT AUTO_INCREMENT as id FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'vivakir' AND TABLE_NAME = 'LYRICS'\" };
					  let body_get_id = fillXMLHttpRequest(data, xhr_get_id)
					  xhr_get_id.onreadystatechange = function() {
						 if(xhr_get_id.readyState === XMLHttpRequest.DONE && xhr_get_id.status === 200) {
								
							query2(JSON.parse(xhr_get_id.responseText)['id']);
						 };
					  }
					xhr_get_id.send(body_get_id);"; ?>
			}
			
			function query2(id) {
						
				let set_id = document.getElementById('set_id').value;
				let name = document.getElementById('title_input').value;
				let content = lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 
										   'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');
										   
				let date = document.getElementById('date_input').value;
				let descr = document.getElementById('descr_input').value;
				let comment = document.getElementById('comment_input').value;
				let tabbed = document.getElementById('tabbed').checked ? 1 : 0;
				let brs = document.getElementById('brs').checked ? 1 : 0;
				let strp_height = document.getElementById('strophe_height').value;
				let strp_delim = document.getElementById('str_delimeter').value;
				let line_wrapper = document.getElementById('line_wrapper').value;
				let line_wrapper_end = document.getElementById('line_wrapper_end').value;
				let line_double_wrapper = document.getElementById('line_double_wrapper').value;
				let line_double_wrapper_end = document.getElementById('line_double_wrapper_end').value;
				let auto_format = document.getElementById('auto_format_id').checked ? 1 : 0;
						
				let QUERY_Object = { table : "LYRICS", id : id, set_id : set_id, name : name,
									 content : content, write_date : date, author : "В. В. Кириченко",
									 description : descr, author_comment : comment, lyrics_type : "Лірика",
									 TABBED : tabbed, BRS : brs, STROPHE_LENGTH : strp_height,
									 STROPHE_DELIM : strp_delim, LINE_WRAPPER : line_wrapper,
									 LINE_WRAPPER_END : line_wrapper_end, LINE_WRAPPER_TABBED : line_double_wrapper,
									 LINE_WRAPPER_TABBED_END : line_double_wrapper_end, auto_format : auto_format 
				};
									
				let xhr_add_lyrics = new XMLHttpRequest();
				xhr_add_lyrics.open('POST', 'query.php', false);
						
				let body_add_lyrics = fillXMLHttpRequest(QUERY_Object, xhr_add_lyrics);
						
				xhr_add_lyrics.onreadystatechange = function() {
							
					if(xhr_add_lyrics.readyState === XMLHttpRequest.DONE && xhr_add_lyrics.status === 200) {
							
						let count = document.getElementById('pictures_count_id').value;
									
						for(let i = 0; i < count; i++) {
									
							let pic_input = document.getElementById('pic_src_' + i);
									
							if(pic_input == null || pic_input.value == "")
								continue;
									
							let add_img_object = { table : "LYRICS_PICTURES", lyrics_id : id, src : pic_input.value };
									
							let xhr_add_img = new XMLHttpRequest();
							xhr_add_img.open('POST', 'query.php', false);
									
							let body_add_img = fillXMLHttpRequest(add_img_object, xhr_add_img);
							xhr_add_img.send(body_add_img);
						}
								
						let count_videos = document.getElementById('video_count_id').value;
								
						for(let i = 0; i < count_videos; i++) {
									
							let add_video_object = { table : "LYRICS_VIDEOS", lyrics_id : id, video_src : document.getElementById('video_src_input_' + i).value };
									
							let xhr_add_video = new XMLHttpRequest();
							xhr_add_video.open('POST', 'query.php', false);
									
							let body_add_video = fillXMLHttpRequest(add_video_object, xhr_add_video);
							xhr_add_video.send(body_add_video);
						}
					}
				}
						
				xhr_add_lyrics.send(body_add_lyrics);
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
			
			function showPictureChoosers(count, wrapper_id) {
				
				let wrapper = document.getElementById(wrapper_id);
				
				let cache = [];
				
				for(let i = 0; i < count; i++) {
					
					let input = document.getElementById('pic_src_' + i);
					cache.push(input == null? "" : input.value);
				}
				
				let inner = "";
				
				for(let i = 0; i < count; i++) 
					inner += "<input class = 'admin_input' hidden name = 'src' id = 'pic_src_" + i + "'></input>" +
							 "<div id = 'my-icon-select" + i + "' style = 'margin-left : 20vw; z-index : -100;'></div>";
				
				wrapper.innerHTML = inner;
				
				for(let i = 0; i < count; i++) {
										 
					let input = document.getElementById('pic_src_' + i);
					let icon_view = document.getElementById('my-icon-select' + i);
					let icon_input = new IconSelect('my-icon-select' + i,
													{'selectedIconWidth':160,
													 'selectedIconHeight':106,
													 'selectedBoxPadding':1,
													 'iconsWidth':160,
													 'iconsHeight':106,
													 'boxIconSpace':1,
													 'vectoralIconNumber': 1,
													 'horizontalIconNumber': 4});
													 
					SetBlockers('my-icon-select' + i);
					SetBlockers('my-icon-select' + i + '-box-scroll');
					
					icon_view.addEventListener('changed', function(e){
																
						let path = icon_input.getSelectedFilePath().substring(6);
						input.value = path;
						loadPreviewPictures();
					});
					
					icon_input.refresh(icons);
					document.getElementById('pic_src_' + i).value = cache[i];
				}
			}
			
			function showVideoChoosers(count, wrapper_id) {
				
				let wrapper = document.getElementById(wrapper_id);
				
				let cache = [];
				
				for(let i = 0; i < count; i++) {
					
					let input = document.getElementById('video_src_input_' + i);
					cache.push(input == null? "" : input.value);
				}
				
				wrapper.innerHTML = "";
				
				for(let i = 0; i < count; i++)
					wrapper.innerHTML += "<center style = 'margin-bottom : 1vh;'><label class = 'admin_input_label' >Відео №" + (i + 1) + ": </label>" + 
										 "<input class = 'admin_input' name = 'video_src' id = 'video_src_input_" + i + "' maxlength = '200' type = 'url' placeholder = 'https://www.youtube.com/embed/cwyoYeRfpSM' oninput = 'loadPreviewVideos();'></input>";
										 
				for(let i = 0; i < count; i++)
					document.getElementById('video_src_input_' + i).value = cache[i];
			}
			
			function loadPreviewPictures(load) {
				
				let count = document.getElementById('pictures_count_id').value;
				let picturesWrapper = document.getElementById('pictures_wrapper');
				
				picturesWrapper.innerHTML = "";
				
				for(let i = 0; i < count; i++) {
					
					let input = document.getElementById('pic_src_' + i);
					
					if(input != null && load)
						input.value = "<?php if(isset($lyr)) { $t = mysqli_fetch_array($pics, MYSQLI_ASSOC); array_push($pcs, $t); echo $t['src']; } ?>";
						
					if(input != null && input.value != "NULL" && input.value != "")
						picturesWrapper.innerHTML += "<center><div class = 'lyrics_picture' style = 'background-image : url(../../" + input.value + ");'></div></center>";
				}
			}
			
			function loadPreviewVideos(load) {
				
				let count = document.getElementById('video_count_id').value;
				let videoWrapper = document.getElementById('video_wrapper');
				
				videoWrapper.innerHTML = "";
				
				for(let i = 0; i < count; i++) {
					
					let input = document.getElementById('video_src_input_' + i);
					
					if(input != null && load)
						input.value = "<?php if(isset($lyr)) { $t = mysqli_fetch_array($vid, MYSQLI_ASSOC); array_push($v, $t); echo $t['video_src']; } ?>";
					
					if(input != null && input.value != "") {
						
						input.value = input.value.replace('watch', 'embed').replace('?v=', '/');
						let amp_ind = input.value.indexOf('&');
						
						if(amp_ind != -1)
							input.value = input.value.substring(0, input.value.indexOf('&'));
						
						videoWrapper.innerHTML += "<div class = 'video_new_wrapper'><iframe class = 'video_new' frameborder = '1' allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen src = '" + input.value + "'></iframe></div>";
					}
				}
			}
			
			textFormatPreview('title_input', 'preview_title', 'Назва вірша');
			textFormatPreview('descr_input', 'preview_descr', 'Опис вірша');
			textFormatPreview('content_input', 'preview_content', 'Текст вірша'); 
			lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 
							 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');
							 
			let auto_format_items = document.getElementsByClassName('auto_format'); 
			for(let item of auto_format_items) 
				item.hidden = !this.checked;
				
			showPictureChoosers(document.getElementById('pictures_count_id').value, 'picture_choosers');
			loadPreviewPictures(true);
			
			showVideoChoosers(document.getElementById('video_count_id').value, 'video_choosers');
			loadPreviewVideos(true);
			
		</script>
		<script src = "../../scripts/js/scroll_adder.js"></script>
		<script>SetScrolls();</script>
	</body>
</html>