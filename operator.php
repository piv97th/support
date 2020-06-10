<?php require('check_login_general.php'); ?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Выбор</title>

	<style>
	html, body {
    	height: 100%;
  	}
		.left{
			float: left;
			height: 100%;
			width: 50%;
			text-align: center;
			padding: 400px 0;

		}
		.right{
			float: right;
			height: 100%;
			width: 50%;
			text-align: center;
			padding: 400px 0;

		}
	</style>

</head>


<body>

	<div class="left"><a href="choice_diploma.php">ВКР</a></div>
	<div class="right"><a href="choice_se.php">Госэкзамен</a></div>	

</body>
</html>