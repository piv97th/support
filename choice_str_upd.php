<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	function content_select($mode)
	{
		require('blocks/connect.php');
		if($mode == 1)
		{
			$result_direction = $conn->query('SELECT direction.*, qualification.name as `name_qualification` FROM direction INNER JOIN qualification ON direction.id_qualification_fk = qualification.id');
			echo '<ul class="add_content">';
			while ($arr_direction = $result_direction->fetch_assoc())
			{
				printf('<li><a href=form_update_direction.php?arr_1=%s>%s %s %s</a></li>', $arr_direction['id'], $arr_direction['name'], $arr_direction['cipher_direction'], $arr_direction['name_qualification']);
			}
			echo '</ul>';
		}
		if($mode == 2)
		{
			$result_group = $conn->query('SELECT * FROM group_1');
			echo '<ul class="add_content">';
			while ($arr_group = $result_group->fetch_assoc())
			{
				printf('<li><a href=form_update_group.php?arr_1=%s>%s</a></li>', $arr_group['id'], $arr_group['cipher_group']);
			}
			echo '</ul>';
		}
		if($mode == 3)
		{
			$result_commission = $conn->query('SELECT id, number FROM commission');
			echo '<ul class="add_content">';
			while ($arr_commission = $result_commission->fetch_assoc())
			{
				printf('<li>Комиссия: <a href=form_update_commission.php?arr_1=%s>%s</a></li>', $arr_commission['id'], $arr_commission['number']);
			}
			echo '</ul>';
		}
		if($mode == 4)
		{
			$result_supervisor = $conn->query('SELECT id, cipher_teacher, last_name, first_name FROM teacher');
			echo '<ul class="add_content">';
			while ($arr_supervisor = $result_supervisor->fetch_assoc())
			{
				printf('<li><a href=form_update_supervisor.php?arr_1=%s>%s %s %s</a></li>', $arr_supervisor['id'], $arr_supervisor['cipher_teacher'], $arr_supervisor['last_name'], $arr_supervisor['first_name']);
			}
			echo '</ul>';
		}
		if($mode == 5)
		{
			$result_member_ssk = $conn->query('SELECT id, last_name, first_name, post FROM member_ssk');
			echo '<ul class="add_content">';
			while ($arr_member_ssk = $result_member_ssk->fetch_assoc())
			{
				printf('<li><a href=form_update_member_ssk.php?arr_1=%s>%s %s %s</a></li>', $arr_member_ssk['id'], $arr_member_ssk['last_name'], $arr_member_ssk['first_name'], $arr_member_ssk['post']);
			}
			echo '</ul>';
		}
	}
	$mode = $_GET['mode'];
	check_get($mode);
	if($mode == 1)
	{
		$title = 'Выбор направления';
	}
	elseif($mode == 2)
	{
		$title = 'Выбор группы';
	}
	elseif($mode == 3)
	{
		$title = 'Выбор комиссии';
	}
	elseif($mode == 4)
	{
		$title = 'Выбор научного руководителя';
	}
	elseif($mode == 5)
	{
		$title = 'Выбор члена ГЭК';
	}
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title><?php echo $title; ?></title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/toastr.js"></script>
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>

</head>


<body>

	<?php
	require_once('blocks/header.php');
	require_once('blocks/navbar.php');
	?>

	<div class="container" id="content">    
		<div class="row content">
			<div class="col-sm text-left"> 
				<div>
					<form name="cform">
						<div id="content">
							<?php
								content_select($mode);
							?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>