<html>
	<head>
		<title></title>
		<link rel = "stylesheet" href = "../../styles/main.css"/>
		<script src = "../../scripts/js/libs/glm-ajax.js"></script>
		<script src = "../../scripts/js/libs/jquery-3.3.1.js"></script>
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
										<form id = 'new_add_form' onsubmit = 'query()'>
											<table>
												<tr> 
													<td><label class = 'admin_input_label'>Збірник та розділ: </label></td>
													<td><select class = 'admin_input' name = 'set_id' id = 'set_id'>";
												
													include "../../scripts/php/DB_Request.php";
													$db_link = Connect();
													$lyrics_sets = Request($db_link, "SELECT id, name FROM LYRICS_SET");
												
													while($lyrics_set = mysqli_fetch_array($lyrics_sets, MYSQLI_ASSOC))
														echo "<option value = ".$lyrics_set['id'].">Збірник \"".$lyrics_set['name']."\"</option>";
												
												echo "</select></td>
											    </tr>
												<tr>
													<td><label class = 'admin_input_label'>Назва вірша: </label></td>
													<td><input class = 'admin_input' name = 'name' id = 'title_input' maxlength = '100' placeholder = 'Назва вірша' required oninput = \"textFormatPreview('title_input', 'preview_title', 'Назва вірша');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Текст вірша: </label></td>
													<td><textarea class = 'admin_textarea' name = 'content' id = 'content_input' required oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></textarea></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Дата написання вірша: </label></td>
													<td><input class = 'admin_input' name = 'write_date' type = 'date' id = 'date_input' value = '".date('Y-m-j')."' required></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Опис вірша: </label></td>
													<td><textarea class = 'admin_textarea' name = 'description' id = 'descr_input' oninput = \"textFormatPreview('descr_input', 'preview_descr', 'Опис вірша');\"></textarea></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Авторський коментар: </label></td>
													<td><textarea class = 'admin_textarea' name = 'author_comment' id = 'comment_input' oninput = \"textFormatPreview('comment_input', 'preview_comment', 'Авторський коментар');\"></textarea></td>
												</tr>
												<tr>
													<td><input name = 'lyrics_type' value = 'Лірика' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Ступінчастий вигляд строф: </label></td>
													<td><input class = 'admin_input auto_format' name = 'TABBED' id = 'tabbed' type = 'checkbox' hidden onchange = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Додатковыий перенос рядка в кінці строфи: </label></td>
													<td><input class = 'admin_input auto_format' name = 'BRS' id = 'brs' type = 'checkbox' hidden onchange = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Кількість рядків у строфі: </label></td>
													<td><input class = 'admin_input auto_format' name = 'STROPHE_LENGTH' type = 'number' id = 'strophe_height' value = '4' min = '1' hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Розмежувач строф: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'STROPHE_DELIM' id = 'str_delimeter' value = '<br/>' hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Початок розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER' id = 'line_wrapper' value = \"<div class = 'tab'>\" hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Кінець розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER_END' id = 'line_wrapper_end' value = \"</div>\" hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Початок подвійного розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER_TABBED' id = 'line_double_wrapper' value = \"<div class = 'double_tab'>\" hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Кінець подвійного розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER_TABBED_END' id = 'line_double_wrapper_end' value = \"</div>\" hidden oninput = \"textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label' >Автоматичне форматування: </label></td>
													<td><input class = 'admin_input' name = 'auto_format' id = 'auto_format_id' type = 'checkbox' onchange = \"let auto_format_items = document.getElementsByClassName('auto_format'); for(let item of auto_format_items) item.hidden = !this.checked; textFormatPreview('content_input', 'preview_content', 'Тест вірша'); lyricsFormat('content_input', 'preview_content', 'auto_format_id', 'tabbed', 'brs', 'strophe_height', 'str_delimeter', 'line_wrapper', 'line_wrapper_end', 'line_double_wrapper', 'line_double_wrapper_end');\"></input></td>
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
				let line_wrapper_end = document.getElementById(line_double_wrapper_end_id).value;
				
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
				
				$.post("query_select.php", "query=SELECT MAX(id) AS id FROM LYRICS", function(json) {
					
					let resp = JSON.parse(json);
					let id = resp['id'] + 1;
					
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
					
					
					let QUERY = 'table=LYRICS&redirect=add_lyrics.php&id=' + id + '&set_id=' + set_id + '&name=' + name + 
								'&content=' + content + '&write_date=' + date + "&author=В. В. Кириченко" + 
								'&description=' + descr + '&author_comment=' + comment + '&lyrics_type=Лірика' + 
								'&TABBED=' + tabbed + '&BRS=' + brs + '&STROPHE_LENGTH=' + strp_height + 
								'&STROPHE_DELIM=' + strp_delim + '&LINE_WRAPPER=' + line_wrapper + 
								'&LINE_WRAPPER_END=' + line_wrapper_end + '&LINE_WRAPPER_TABBED=' + line_double_wrapper + 
								'&LINE_WRAPPER_TABBED_END=' + line_double_wrapper_end + '&auto_format=' + auto_format;
												
					$.post('query.php', QUERY);
				});
			}
		</script>
	</body>
</html>