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
							
							if(isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true")
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
					
						<center>
							<form onsubmit = 'addFilm();'>
								<table>
									<tr>
										<td><label class = 'admin_input_label'>Назва відео: </label></td>
										<td><input class = 'admin_input' name = 'name' id = 'name_input' required oninput = "textFormatPreview('name_input', 'preview_name', 'Назва відео');"></input></td>
									</tr>
									<tr>
										<td><label class = 'admin_input_label'>Опис відео: </label></td>
										<td><textarea class = 'admin_textarea' name = 'description' id = 'text_input' oninput = "textFormatPreview('text_input', 'preview_text', 'Опис відео');"></textarea></td>
									</tr>
									<tr>
										<td><label class = 'admin_input_label'>Відео: </label></td>
										<td><input class = 'admin_input' name = 'video_src' id = 'video_src_input' maxlength = '200' required type = 'url' placeholder = 'https://www.youtube.com/embed/cwyoYeRfpSM' oninput = "VideoFormat('video_src_input', 'preview_video_wrapper');"></input></td>
									</tr>
									<tr>
										<td colspan = '2'>
											<center><button class = 'admin_submit_button' type = 'submit'>Додати фільм</button></center>
										</td>
									</tr>
								</table>
							</form>
							
						</center>
						
						<div class = 'video_container' style = 'margin-top : 2vh;'>
							<div class = 'video_header'>
								<center>
									<div class = 'video_title' id = 'preview_name'>Назва відео</div>
								</center>
							</div>
							<div class = 'video_description' id = 'preview_text'>Опис відео</div>
							<div id = 'preview_video_wrapper' style = "margin-bottom : -2vh;"></div>
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
		
			function addFilm() {
				
				let name = document.getElementById('name_input').value;
				let descr = document.getElementById('text_input').value;
				let video_src = document.getElementById('video_src_input').value;
				
				let film_data_object = { table : "FILMS", id : 0, title : name, description : descr, video_src : video_src };
				
				let xhr_add_film = new XMLHttpRequest();
				xhr_add_film.open('POST', 'query.php', false);
								
				let body_add_film = fillXMLHttpRequest(film_data_object, xhr_add_film);
				xhr_add_film.send(body_add_film);
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
	</body>
</html>