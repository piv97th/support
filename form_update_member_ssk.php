<?php require('check_login.php'); ?>
<?php

	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	$arr_1 = $_GET['arr_1'];
	check_get($arr_1);

	$qs_member_ssk = $conn->query('SELECT * FROM member_ssk WHERE id = '.$arr_1);
	$arr_member_ssk = $qs_member_ssk->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Обновить данные члена ГЭК</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(window).ready(function() {
			$("#degree option[value=<?php echo $arr_member_ssk['degree']; ?>]").attr("selected", "selected");
		});

		$(function(){
			$("form").on('submit',function(){
				var arr_1 = <?php echo $arr_member_ssk['id']; ?>;
				var last_name = $("#last_name").val();
		        var first_name = $("#first_name").val();
		        var patronymic = $("#patronymic").val();
		        var degree = $("#degree").val();
		        var rank = $("#rank").val();
		        var post = $("#post").val();
		        var mode_1 = 2;
		    	$.ajax({
		        	type: 'POST',
		        	url: 'handler_member_ssk.php',
		        	data: {arr_1, last_name, first_name, patronymic, degree, rank, post, mode_1},
		        	async: false,
		        	success: function(response)
		        	{
		        		var result = JSON.parse(response);
						outToast(result);
		        	},
		        	error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
		    	});
		    	return false;
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
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
						if(arr['arr_1'] == 2)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
						if(arr['member_ssk'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['last_name'] == 0)
						{
							toastr.error('Введите Фамилию','Ошибка!');
							flag = false;
						}
						if(arr['last_name'] == 2)
						{
							toastr.error('Некорректная фамилия','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['first_name'] == 0)
						{
							toastr.error('Введите Имя','Ошибка!');
							flag = false;
						}
						if(arr['first_name'] == 2)
						{
							toastr.error('Некорректное имя','Ошибка!');
							flag = false;
						}
					}
					if(c == 3)
					{
						if(arr['patronymic'] == 0)
						{
							toastr.error('Введите отчество','Ошибка!');
							flag = false;
						}
						if(arr['patronymic'] == 2)
						{
							toastr.error('Некорректное отчество','Ошибка!');
							flag = false;
						}
					}
					if(c == 4)
					{
						if(arr['degree'] == 0)
						{
							toastr.error('Выберете степень','Ошибка!');
							flag = false;
						}
						if(arr['degree'] == 2)
						{
							toastr.error('Некорректная степень','Ошибка!');
							flag = false;
						}
					}
					if(c == 5)
					{
						if(arr['rank'] == 0)
						{
							toastr.error('Выберете звание','Ошибка!');
							flag = false;
						}
						if(arr['rank'] == 2)
						{
							toastr.error('Некорректное звание','Ошибка!');
							flag = false;
						}
					}
					if(c == 6)
					{
						if(arr['post'] == 0)
						{
							toastr.error('Выберете должность','Ошибка!');
							flag = false;
						}
						if(arr['post'] == 2)
						{
							toastr.error('Некорректное должность','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Информация добавлена');
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
				<form method="POST" action="#">
					<legend>О научном руководителе</legend>
					<div class="form-group">
						<label for="last_name">Фамилия:</label>
						<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $arr_member_ssk['last_name']; ?>">
					</div>
					<div class="form-group">
						<label for="first_name">Имя:</label>
						<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $arr_member_ssk['first_name']; ?>">
					</div>
					<div class="form-group">
						<label for="patronymic">Отчество:</label>
						<input type="text" class="form-control" id="patronymic" name="patronymic" value="<?php echo $arr_member_ssk['patronymic']; ?>">
					</div>
					<div class="form-group">
						<label for="degree">Степень:</label>
						<select class="form-control" id="degree" name="degree" >
							<option value="1">Кандидат наук</option>
							<option value="2">Доктор наук</option>
						</select>
					</div>
					<div class="form-group">
						<label for="rank">Звание:</label>
						<textarea class="form-control" id="rank" name="rank" ><?php echo $arr_member_ssk['rank']; ?></textarea>
					</div>
					<div class="form-group">
						<label for="post">Должность:</label>
						<textarea class="form-control" id="post" name="post" ><?php echo $arr_member_ssk['post']; ?></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>