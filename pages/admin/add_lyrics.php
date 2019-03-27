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
													<td><input name = 'table' value = 'LYRICS' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><input name = 'redirect' value = 'add_lyrics.php' hidden></input></td>
													<td></td>
												</tr>
												<tr>
													<td><input name = 'id' value = '0' hidden></input></td>
													<td></td>
												</tr>
												<tr> 
													<td><label class = 'admin_input_label'>Збірник та розділ: </label></td>
													<td><select class = 'admin_input' name = 'set_id'>";
												
													include "../../scripts/php/DB_Request.php";
													$db_link = Connect();
													$lyrics_sets = Request($db_link, "SELECT id, name FROM LYRICS_SET");
												
													while($lyrics_set = mysqli_fetch_array($lyrics_sets, MYSQLI_ASSOC))
														echo "<option value = ".$lyrics_set['id'].">".$lyrics_set['name']."</option>";
												
												echo "</select></td>
											    </tr>
												<tr>
													<td><label class = 'admin_input_label'>Назва вірша: </label></td>
													<td><input class = 'admin_input' name = 'name' id = 'title_input' maxlength = '100' placeholder = 'Назва вірша' required oninput = \"textFormatPreview('title_input', 'preview_title', 'Назва вірша');\"></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Текст вірша: </label></td>
													<td><textarea class = 'admin_textarea' name = 'content' id = 'content_input' required oninput = \"lyricsFormat(textFormatPreview('content_input', 'preview_content', 'Тест вірша'));\"></textarea></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label'>Дата написання вірша: </label></td>
													<td><input class = 'admin_input' name = 'write_date' type = 'date' id = 'date_input' value = '".date('Y-m-j')."' required oninput = \"document.getElementById('preview_date').innerHTML = document.getElementById('date_input').value;\"></input></td>
												</tr>
												<tr>
													<td><input name = 'author' value = 'В. В. Кириченко' hidden></input></td>
													<td></td>
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
													<td><input class = 'admin_input auto_format' name = 'TABBED' type = 'checkbox' hidden></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Додатковыий перенос рядка в кінці строфи: </label></td>
													<td><input class = 'admin_input auto_format' name = 'BRS' type = 'checkbox' hidden></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Кількість рядків у строфі: </label></td>
													<td><input class = 'admin_input auto_format' name = 'STROPHE_LENGTH' type = 'number' value = '4' min = '1' hidden></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Розмежувач строф: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'STROPHE_DELIM' value = '<br/>' hidden></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Початок розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER' value = \"<div class = 'tab'>\" hidden></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Кінець розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER_END' value = \"</div>\" hidden></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Початок подвійного розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER_TABBED' value = \"<div class = 'double_tab'>\" hidden></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label auto_format' hidden>Кінець подвійного розмежувача рядків: </label></td>
													<td><input class = 'admin_input auto_format' maxlength = '255' name = 'LINE_WRAPPER_TABBED_END' value = \"</div>\" hidden></input></td>
												</tr>
												<tr>
													<td><label class = 'admin_input_label' >Автоматичне форматування: </label></td>
													<td><input class = 'admin_input' name = 'auto_format' type = 'checkbox' onchange = \"let auto_format_items = document.getElementsByClassName('auto_format'); for(let item of auto_format_items) item.hidden = !this.checked;\"></input></td>
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
								<div class = 'lyrics_title'></div>
							</center>
							<div class = 'lyrics_description'></div>
							<center>
								<div class = 'lyrics_content'></div>
							</center>
							<div class = 'lyrics_conmment'></div>							
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