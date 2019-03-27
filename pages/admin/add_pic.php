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