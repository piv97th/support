<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	$result = $conn->query('SELECT id, cipher_group FROM group_1 WHERE id NOT IN (SELECT id_group_fk FROM student)');
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Выбор группы</title>

	<script type="text/javascript" src="scripts/disabled_link.js"></script>

</head>


<body>

	<?php
	require_once('blocks/header.php');
	require_once('blocks/navbar.php');
	?>

	<div class="container" id="content">    
		<div class="row content">
			<div class="col-sm text-left"> 
				<form method="POST" action="download_blank.php">
					<legend>Скачать бланк для добавления</legend>
					<div class="form-group">
						<label for="slc">Выбор группы:</label>
						<select id="slc" class="form-control" name="cipher_group" required>
							<option value="" disabled selected></option>
							<?php
								while ($arr = $result->fetch_assoc())
								{
									echo'<option value='.$arr["cipher_group"].'>'.$arr["cipher_group"].'</option>';
								}
							?>
						</select>
					</div>
					<button class="btn btn-primary" id="btn_choice">Выбрать</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>