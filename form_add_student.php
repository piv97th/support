<!DOCTYPE html>


<head>

	<?php require_once("blocks/head.php"); ?>

	<title>Добавить студента</title>

	<script src="scripts/disabled_link.js" type="text/javascript"></script>
	
</head>


<body>
	
	<?php
	require_once("blocks/header.php");
	require_once("blocks/navbar.php");
	?>
	
	<div class="container" id="content">    
		<div class="row content">
			<div class="col-sm text-left"> 
				<form action="/action_page.php">
					<div class="form-group">
						<label for="text">НЗК:</label>
						<input type="text" class="form-control" id="nrb" name="nrb">
					</div>
					<div class="form-group">
						<label for="pwd">Фамилия:</label>
						<input type="password" class="form-control" id="pwd" name="pswd">
					</div>
					<div class="form-group">
						<label for="pwd">Фамилия:</label>
						<input type="password" class="form-control" id="pwd" name="pswd">
					</div>
					<div class="form-group">
						<label for="pwd">Фамилия:</label>
						<input type="password" class="form-control" id="pwd" name="pswd">
					</div>
					<div class="form-group">
						<label for="pwd">Фамилия:</label>
						<input type="password" class="form-control" id="pwd" name="pswd">
					</div>
					<div class="form-group form-check">
						<label class="form-check-label">
							<input class="form-check-input" type="checkbox" name="remember"> Remember me
						</label>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once("blocks/footer.php"); ?>
	
</body>
</html>