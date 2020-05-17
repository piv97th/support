<?php
	require('check_login.php');
	require('blocks/connect.php');

	function content_select($arr_1)
	{
		require('blocks/connect.php');

			$result = $conn->query('SELECT id, number_meeting, date FROM timetable_meeting WHERE id_commission_fk = (SELECT id FROM commission WHERE id IN (SELECT id_commission_fk FROM curation_event WHERE role = 3 AND id = (SELECT id_curevent_fk FROM user WHERE id = '.$arr_1.')))');
			//SELECT id FROM user WHERE id_curevent_fk = (SELECT id FROM curation_event WHERE id_commission_fk = 2 AND role = 3)
			while ($arr = $result->fetch_assoc())
			{
				echo'<option value='.$arr["id"].'>'.$arr["number_meeting"].' '.$arr["date"].'</option>';
			}
	}
	//$mode = $_GET['mode'];
	/*if($mode == 1)
	{
		$title = 'Выбор группы';
		$name_choice = 'Группа';
	}
	elseif($mode == 2)
	{
		$title = 'Выбор группы';
		$name_choice = 'Группа';
	}
	elseif($mode == 3)
	{
		$title = 'Выбор группы';
		$name_choice = 'Группа';
	}
	elseif($mode == 4)
	{
		$title = 'Выбор группы';
		$name_choice = 'Группа';
	}*/
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Выбор</title>

	<script type="text/javascript" src="scripts/disabled_link.js"></script>

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
			else if(mode == 3)
			{
				return '(\'<li><a class="nolink" href=form_se.php?arr_1=\'+item.arr_1+\'>\'+(index+1)+\' \'+item.last_name +\' \'+item.first_name+\' \'+item.number_record_book+\'</li></a>\')';
			}
			else if(mode == 4)
			{
				return '(\'<li><a href=form_diploma.php?arr_1=\'+item.arr_1+\'>\'+(index+1)+\' \'+item.last_name +\' \'+item.first_name+\' \'+item.number_record_book+\'</li></a>\')';
			}
		}

		/*$(function(){
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

		});*/

		$(function(){
			$("#btn_choice").on('click',function(){
				$(".add_content").children().remove();
				var mode_other = 1;
				var select = $("#slc").val();
				$.ajax({
					type: 'GET',
					url: 'handler_operator.php',
					data: {mode_other, select},
					async: false,
					success: function(response)
					{
						alert(response);
						var obj = JSON.parse(response);
						$(obj).each(function(index, item) {
							$('.add_content').append('<li><a href=form_diploma.php?arr_1='+item.arr_1+'>'+(index+1)+' '+item.last_name +' '+item.first_name+' '+item.number_record_book+'</li></a>');
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
							content_select($row_uid["id"]);
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