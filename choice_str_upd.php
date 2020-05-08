<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	function content_select($mode)
	{
		require('blocks/connect.php');
		if($mode == 1)
		{
			$result_direction = $conn->query('SELECT * FROM direction');
			echo '<ul class="add_content">';
			while ($arr_direction = $result_direction->fetch_assoc())
			{
				printf('<li><a href=form_update_direction.php?arr_1=%s>%s %s</a></li>', $arr_direction['id'], $arr_direction['name'], $arr_direction['cipher_direction']);
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
	}
	$mode = $_GET['mode'];
	check_get($mode);
	if($mode == 1)
	{
		$title = 'Выбор направления';
		//$name_choice = 'Направление';
	}
	elseif($mode == 2)
	{
		$title = 'Выбор группы';
		//$name_choice = 'Направление';
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