<?php require('check_login.php'); ?>
<!DOCTYPE html>
<html>	
	
	<head>

		<?php require_once("blocks/head.php"); ?>

		<title>Стартовая страница</title>

		<script type="text/javascript">
			
			function deleteCookie(name) {
				var date = new Date(); // Берём текущую дату
				date.setTime(date.getTime() - 1); // Возвращаемся в "прошлое"
				document.cookie = name += "=; expires=" + date.toGMTString(); // Устанавливаем cookie пустое значение и срок действия до прошедшего уже времени
			}

			$(function(){
				$("#logout").on('click',function(){
					//alert(1);
					deleteCookie("uid");
					deleteCookie("hash");
					location.reload();
					//alert(document.cookie);
					//setCookie("uid", "", {'max-age': -1});
					//setCookie("hash", "", {'max-age': -1});
					/*var cookie_date = new Date ( );  // Текущая дата и время
					cookie_date.setTime ( cookie_date.getTime() - 1 );
					document.cookie = "uid" += "=; expires=" + cookie_date.toGMTString();
					document.cookie = "hash" += "=; expires=" + cookie_date.toGMTString();
					alert(2);*/
					//location.reload();
				});
			});

		</script>
		
	</head>
	
	
	<body>
		
		<?php
			require_once("blocks/header.php");
			require_once("blocks/navbar.php");
		?>
		
		<div class="container-fluid text-center" id="content">    
			<div class="row content">
				<div class="col-sm text-left"> 
					<h1>Welcome</h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					<hr>
					<h3>Test</h3>
					<p>Lorem ipsum...</p>
				</div>
			</div>
		</div>

		<?php require_once("blocks/footer.php"); ?>
		
	</body>
</html>