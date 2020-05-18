<?php require('check_login_general.php'); ?>
<?php
	require('blocks/connect.php');

	function content_select($arr_1)
	{
		require('blocks/connect.php');

			$result = $conn->query('SELECT id, number_meeting, date FROM timetable_meeting WHERE id_commission_fk = (SELECT id FROM commission WHERE id IN (SELECT id_commission_fk FROM curation_event WHERE role = 3 AND id = (SELECT id_curevent_fk FROM user WHERE id = '.$arr_1.')))');
			while ($arr = $result->fetch_assoc())
			{
				echo'<option value='.$arr["id"].'>'.$arr["number_meeting"].' '.$arr["date"].'</option>';
			}
	}
?>

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