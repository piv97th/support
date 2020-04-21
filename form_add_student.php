<!DOCTYPE html>
	
	
	<head>

		<?php require_once("blocks/block_head.php"); ?>

		<title>Добавить студента</title>

		<script type="text/javascript">
			$(function() {
				$("#disabled_link").css({"background-color":"#DDDDDD", "color":"#FFFFFF"});
				$("#disabled_link").on("click", function() {
					return false;
				});
			});
		</script>
		
	</head>
	
	
	<body>
		
		<?php require_once("blocks/block_header.php"); ?>
		
		<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
			<a class="navbar-brand" href="index.php">Главная</a>

			<ul class="navbar-nav">

				<li class="nav-item dropdown active">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						Студенты
					</a>
					<div class="dropdown-menu">
						
						<div class="dropdown-header">На сайте</div>
						<a class="dropdown-item" id="disabled_link" href="#">Добавить</a>
						<a class="dropdown-item" href="#">Редактировать</a>
						<a class="dropdown-item" href="#">Удалить</a>
						<div class="dropdown-header">Через файл</div>
						<a class="dropdown-item" href="#">Скачать файл</a>
						<a class="dropdown-item" href="#">Загрузить бланк</a>
					</div>
				</li>
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						Пользователи
					</a>
					<div class="dropdown-menu">
						
						<!--<div class="dropdown-header">На сайте</div>-->
						<a class="dropdown-item" href="#">Добавить</a>
						<a class="dropdown-item" href="#">Редактировать</a>
						<a class="dropdown-item" href="#">Удалить</a>
					</div>
				</li>
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						Комиссии
					</a>
					<div class="dropdown-menu">
						
						<!--<div class="dropdown-header">На сайте</div>-->
						<a class="dropdown-item" href="#">Добавить</a>
						<a class="dropdown-item" href="#">Редактировать</a>
						<a class="dropdown-item" href="#">Удалить</a>
					</div>
				</li>
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						Госэкзамен
					</a>
					<div class="dropdown-menu">
						
						<!--<div class="dropdown-header">На сайте</div>-->
						<a class="dropdown-item" href="#">Добавить</a>
						<a class="dropdown-item" href="#">Редактировать</a>
						<a class="dropdown-item" href="#">Удалить</a>
					</div>
				</li>
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						ВКР
					</a>
					<div class="dropdown-menu">
						
						<!--<div class="dropdown-header">На сайте</div>-->
						<a class="dropdown-item" href="#">Добавить</a>
						<a class="dropdown-item" href="#">Редактировать</a>
						<a class="dropdown-item" href="#">Удалить</a>
					</div>
				</li>
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						Структура вуза
					</a>
					<div class="dropdown-menu">
						
						<!--<div class="dropdown-header">На сайте</div>-->
						<a class="dropdown-item" href="#">Добавить</a>
						<a class="dropdown-item" href="#">Редактировать</a>
						<a class="dropdown-item" href="#">Удалить</a>
					</div>
				</li>
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						Члены ГЭК
					</a>
					<div class="dropdown-menu">
						
						<!--<div class="dropdown-header">На сайте</div>-->
						<a class="dropdown-item" href="#">Добавить</a>
						<a class="dropdown-item" href="#">Редактировать</a>
						<a class="dropdown-item" href="#">Удалить</a>
					</div>
				</li>
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
						Рецензия
					</a>
					<div class="dropdown-menu">
						
						<!--<div class="dropdown-header">На сайте</div>-->
						<a class="dropdown-item" href="#">Добавить</a>
						<a class="dropdown-item" href="#">Редактировать</a>
						<a class="dropdown-item" href="#">Удалить</a>
					</div>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" href="#">Инфо</a>
				</li>
			</ul>
		</nav>
		
		<div class="container-fluid text-center">    
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

		<?php require_once("blocks/block_footer.php"); ?>
		
	</body>
</html>