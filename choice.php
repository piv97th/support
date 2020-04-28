<?php
	require('blocks/connect.php');

	function content_select($mode)
	{
		require('blocks/connect.php');
		if($mode == 1)
		{
			$result = $conn->query('SELECT id, cipher_group FROM group_1');
			while ($arr = $result->fetch_assoc())
			{
				echo'<option value='.$arr["id"].'>'.$arr["cipher_group"].'</option>';
			}

		}
	}
	//require_once('classes/class_site.php')
	$mode = $_GET['mode'];
	if($mode == 1)
	{
		$title = 'Выбор группы';
		$name_choice = 'Группа';
		//$sql_choice = 'SELECT cipher_group FROM group_1';
	}

	//content_select($mode, $sql_choice);

	//$qs_group = $conn->query('SELECT id, cipher_group FROM group_1');
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title><?php echo $title; ?></title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		function data(mode, index)
		{
			if(mode == 1)
			{
				return '(\'<li><a href=form_update_student.php?arr_1=\'+item.arr_1+\'>\'+(index+1)+\' \'+item.last_name +\' \'+item.first_name+\' \'+item.number_record_book+\'</li></a>\')';
			}
		}

		$(function(){
			$("#btn_choice").on('click',function(){
				$(".add_content").children().remove();
				var mode = <?php echo $mode; ?>;
				var select = $("#slc").val();
				$.ajax({
					type: 'GET',
					url: 'handler_choice.php',
					data: {mode, select},
					async: false,
					success: function(response)
					{
						var obj = JSON.parse(response);
						$(obj).each(function(index, item) {
							$('.add_content').append(eval(data(mode, index)));
						});
			        }
			    });
			});
		});
	</script>

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
					<?php echo $name_choice; ?>
					<select id="slc" name="slc">
						<option value="" disabled selected></option>
						<?php
							content_select($mode);
						?>
					</select>
					<button class="btn btn-primary" id="btn_choice">Выбрать</button>
					<div id="content">
						<ul class="add_content">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>