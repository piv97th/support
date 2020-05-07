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
		elseif($mode == 2)
		{
			$result = $conn->query('SELECT id, cipher_group FROM group_1');
			while ($arr = $result->fetch_assoc())
			{
				echo'<option value='.$arr["id"].'>'.$arr["cipher_group"].'</option>';
			}
		}
	}
	$mode = $_GET['mode'];
	if($mode == 1)
	{
		$title = 'Выбор группы';
		$name_choice = 'Группа';
	}
	elseif($mode == 2)
	{
		$title = 'Выбор группы';
		$name_choice = 'Группа';
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


	<script type="text/javascript">

		function data(mode, index)
		{
			if(mode == 1)
			{
				return '(\'<li><a href=form_update_student.php?arr_1=\'+item.arr_1+\'>\'+(index+1)+\' \'+item.last_name +\' \'+item.first_name+\' \'+item.number_record_book+\'</li></a>\')';
			}
			else if(mode == 2)
			{
				return '(\'<li><a class="nolink" href=handler_student.php?arr_1=\'+item.arr_1+\'>\'+(index+1)+\' \'+item.last_name +\' \'+item.first_name+\' \'+item.number_record_book+\'</li></a>\')';
			}
		}

		function a_dell()
		{
			$(".nolink").on("click", function(e){
				var mode_1 = 3;
				var link = e.target;
				link = String(link);
				var arr_1 = link.substr(50,8);
				$.ajax({
					type: 'POST',
					url: 'handler_student.php',
					data: {arr_1, mode_1},
					async: false,
					success: function(response)
					{
						var flag = true;
		        		var result = JSON.parse(response);
		        		for(var i in result)
		        		{
		        			if(result[i] != 1)
		        			{
		        				toastr.error('Ошибка при удалении','Ошибка!');
		        				flag = false;
		        				break;
		        			}
		        		}
		        		if(flag == true)
		        		{
		        			toastr.success('Успешно! Студент удален');
		        			$("#btn_choice").trigger("click");
		        		}
					},
					error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
				});
				return false;
			});

		}

		$(function(){
			$("#btn_choice").on('click',function(){
				$(".add_content").children().remove();
				var mode = <?php echo $mode; ?>;
				var select = $("#slc").val();
				$.ajax({
					type: 'GET',
					url: 'handler_choice_select.php',
					data: {mode, select},
					async: false,
					success: function(response)
					{
						var obj = JSON.parse(response);
						$(obj).each(function(index, item) {
							$('.add_content').append(eval(data(mode, index)));
						});
						if(mode == 2)
						{
							a_dell();
						}
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
					<form name="heh">
						<div id="content">
							<ul class="add_content">
							</ul>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>