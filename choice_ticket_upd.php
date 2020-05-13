<?php
	require('blocks/connect.php');

	function content_select()
	{
		require('blocks/connect.php');
		$result_ticket = $conn->query('SELECT * FROM ticket');
		echo '<ul class="add_content">';
		$c = 1;
		while ($arr_ticket = $result_ticket->fetch_assoc())
		{
			printf('<li><a href=form_update_ticket.php?arr_1=%s>%s %s %s %s</a></li>', $arr_ticket['id'], $c, $arr_ticket['first_question'], $arr_ticket['second_question'], $arr_ticket['third_question']);
			$c++;
		}
		echo '</ul>';
	}
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Выбор билета</title>

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
								content_select();
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