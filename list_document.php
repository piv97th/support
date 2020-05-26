<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');

	function content_select()
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id, cipher_group FROM group_1 WHERE id IN (SELECT id_group_fk FROM student WHERE id_diploma_fk IN (SELECT id FROM diploma WHERE id_mark_fk IS NOT NULL) AND id_se_fk IN (SELECT id FROM se WHERE id_mark_fk IS NOT NULL))');
		while ($arr = $result->fetch_assoc())
		{
			echo'<option value='.$arr["id"].'>'.$arr["cipher_group"].'</option>';
		}
	}
	/*$mode = $_GET['mode'];
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

	<title>Подготовить документы</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>

	<script type="text/javascript">

		/*function data(mode, index)
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
		}*/

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
		        		var result = JSON.parse(response);
		        		outToast(result);
		        		$("#btn_choice").trigger("click");
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
				//$("#slc").children().remove();
				var mode_other = 1;
				var select = $("#slc").val();
				$.ajax({
					type: 'POST',
					url: 'handler_document.php',
					data: {mode_other, select},
					async: false,
					success: function(response)
					{
						alert(response);
						var obj = JSON.parse(response);
						$('#slc').after('<div id="change_block"><select id="student"><option value="" disabled selected></option></select></div>');
						$(obj).each(function(index, item) {
							$('#student').append('<option value='+item.arr_1+'>'+item.number_record_book+' '+item.last_name+' '+item.first_name+'</option>');
						});
						$('#student').after('<select id="document"><option value="" disabled selected></option><option value=1>Личное дело</option><option value=2>Справка</option><option value=3>Заключение</option><option value=4>Протокол ГЭ</option><option value=5>Протокол ВКР</option><option value=6>Протокол аттестации</option></select>');
						/*if(mode == 2)
						{
							a_dell();
						}*/
			        }
			    });
			});
		});

		function outToast(arr)
		{
			var flag = true;
			var c = 0;
			for(var i in arr)
			{
				if(arr[i] != 1)
				{
					if(c == 0)
					{
						if(arr['arr_1'] == 0)
						{
							toastr.error('Ошибка','Ошибка!');
							flag = false;
						}
						if(arr['arr_1'] == 2)
						{
							toastr.error('Ошибка','Ошибка!');
							flag = false;
						}
						if(arr['student'] == 0)
						{
							toastr.error('При удалении','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Удалено');
    		}
		}

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
					Выбор группы
					<select id="slc" name="slc">
						<option value="" disabled selected></option>
						<?php
							content_select();
						?>
					</select>
					<button class="btn btn-primary" id="btn_choice">Выбрать</button>
					<!-- <form name="heh">
						<div id="content">
							<ul class="add_content">
							</ul>
						</div>
					</form> -->
				</div>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>