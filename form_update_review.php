<?php require('check_login.php');?>

<?php
	require('blocks/check_data.php');
	check_get($_GET['arr_1']);

	require('blocks/connect.php');
	$arr_1_student = $_GET['arr_1'];
	$qs_group = $conn->query('SELECT * FROM review WHERE id = (SELECT id_review_fk FROM diploma WHERE id = (SELECT id_diploma_fk FROM student WHERE id = '.$arr_1_student.'))');
	$arr_review = $qs_group->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Обновить данные о рецензии</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(function(){
			$("form").on('submit',function(){
				var student = <?php echo $arr_1_student; ?>;
				var last_name = $("#last_name").val();
		        var first_name = $("#first_name").val();
		        var patronymic = $("#patronymic").val();
		        var post = $("#post").val();
		        var place_work = $("#place_work").val();
		        var mode_1 = 2;
		    	$.ajax({
		        	type: 'POST',
		        	url: 'handler_review.php',
		        	data: {student, last_name, first_name, patronymic, post, place_work, mode_1},
		        	async: false,
		        	success: function(response)
		        	{
		        		alert(response);
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
						if(arr['review'] == 0)
						{
							toastr.error('При обновлении','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
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
					if(c == 2)
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
					if(c == 3)
					{
						if(arr['post'] == 0)
						{
							toastr.error('Введите должность','Ошибка!');
							flag = false;
						}
						if(arr['post'] == 2)
						{
							toastr.error('Некорректная должность','Ошибка!');
							flag = false;
						}
					}
					if(c == 4)
					{
						if(arr['place_work'] == 0)
						{
							toastr.error('Введите место работы','Ошибка!');
							flag = false;
						}
						if(arr['place_work'] == 2)
						{
							toastr.error('Некорректное место работы','Ошибка!');
							flag = false;
						}
					}
					if(c == 5)
					{
						if(arr['student'] == 0)
						{
							toastr.error('Выберете студента','Ошибка!');
							flag = false;
						}
						if(arr['student'] == 2)
						{
							toastr.error('Некорректный студент','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Информация обновлена');
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
					<legend>О рецензенте</legend>
					<div class="form-group">
						<label for="last_name">Фамилия:</label>
						<input type="text" class="form-control" id="last_name" name="last_name" value=<?php echo $arr_review['last_name']; ?> >
					</div>
					<div class="form-group">
						<label for="first_name">Имя:</label>
						<input type="text" class="form-control" id="first_name" name="first_name" value=<?php echo $arr_review['first_name']; ?> >
					</div>
					<div class="form-group">
						<label for="patronymic">Отчество:</label>
						<input type="text" class="form-control" id="patronymic" name="patronymic" value=<?php echo $arr_review['patronymic']; ?> >
					</div>
					<div class="form-group">
						<label for="post">Должность:</label>
						<textarea class="form-control" id="post" name="post" ><?php echo $arr_review['post']; ?></textarea>
					</div>
					<div class="form-group">
						<label for="place_work">Место работы:</label>
						<textarea class="form-control" id="place_work" name="place_work" ><?php echo $arr_review['place_work']; ?></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Обновить</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>