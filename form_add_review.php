<?php require('check_login.php'); ?>

<?php

	function out_group()
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id, cipher_group FROM group_1 WHERE id_qualification_fk = 2 OR id_qualification_fk = 3');
		while ($arr = $result->fetch_assoc())
		{
			echo'<option value='.$arr["id"].'>'.$arr["cipher_group"].'</option>';
		}

	}
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Добавить рецензента</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(window).ready(function() {
			if($.cookie('last_name_reviewer') != null)
			{
				$("#last_name").val($.cookie("last_name_reviewer"));
			}
			if($.cookie('first_name_reviewer') != null)
			{
				$("#first_name").val($.cookie("first_name_reviewer"));
			}
			if($.cookie('patronymic_reviewer') != null)
			{
				$("#patronymic").val($.cookie("patronymic_reviewer"));
			}
			if($.cookie('post_reviewer') != null)
			{
				$("#post").val($.cookie("post_reviewer"));
			}
			if($.cookie('place_work_reviewer') != null)
			{
				$("#place_work").val($.cookie("place_work_reviewer"));
			}
		});

		window.onbeforeunload = function() {
			$.cookie('last_name_reviewer', $("#last_name").val(), { expires: 1});
			$.cookie('first_name_reviewer', $("#first_name").val(), { expires: 1});
			$.cookie('patronymic_reviewer', $("#patronymic").val(), { expires: 1});
			$.cookie('post_reviewer', $("#post").val(), { expires: 1});
			$.cookie('place_work_reviewer', $("#place_work").val(), { expires: 1});
		};

		$(function(){
			$("#group").on('change',function(){
				$("#block_student").remove();
				//$("#document").remove();
				var mode_other = 1;
				var group = $("#group").val();
				$.ajax({
					type: 'POST',
					url: 'handler_review.php',
					data: {mode_other, group},
					async: false,
					success: function(response)
					{
						var obj = JSON.parse(response);
						$('#group').after('<div class="form-group" id="block_student"><label for="student">Студент:</label><select id="student" class="new_student form-control"><option value="" disabled selected></option></select></div>');
						$(obj).each(function(index, item) {
							$('#student').append('<option value='+item.arr_1+'>'+item.number_record_book+' '+item.last_name+' '+item.first_name+'</option>');
						});
			        }
			    });
			});
		});

		$(function(){
			$("form").on('submit',function(){
				//var group = $("#last_group").val();
				var student = $("#student").val();
				var last_name = $("#last_name").val();
		        var first_name = $("#first_name").val();
		        var patronymic = $("#patronymic").val();
		        var post = $("#post").val();
		        var place_work = $("#place_work").val();
		        var mode_1 = 1;
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
							toastr.error('При записи','Ошибка!');
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
    			toastr.success('Успешно! Информация добавлена');
    			$("#block_student").remove();
    			$("#group").val("");
    			$("#student").val("");
    			$("#last_name").val("");
    			$("#first_name").val("");
    			$("#patronymic").val("");
    			$("#post").val("");
    			$("#place_work").val("");
    			$.removeCookie('last_name_reviewer');
    			$.removeCookie('first_name_reviewer');
    			$.removeCookie('patronymic_reviewer');
    			$.removeCookie('post_reviewer');
    			$.removeCookie('place_work_reviewer');
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
					<legend>Выбор студента</legend>
					<div class="form-group">
						<label for="group">Группа:</label>
						<select class="form-control" id="group" name="group">
							<option value="" disabled selected></option>
							<?php
								out_group();
							?>
						</select>
					</div>
					<legend>О рецензенте</legend>
					<div class="form-group">
						<label for="last_name">Фамилия:</label>
						<input type="text" class="form-control" id="last_name" name="last_name" >
					</div>
					<div class="form-group">
						<label for="first_name">Имя:</label>
						<input type="text" class="form-control" id="first_name" name="first_name" >
					</div>
					<div class="form-group">
						<label for="patronymic">Отчество:</label>
						<input type="text" class="form-control" id="patronymic" name="patronymic" >
					</div>
					<div class="form-group">
						<label for="post">Должность:</label>
						<textarea class="form-control" id="post" name="post" ></textarea>
					</div>
					<div class="form-group">
						<label for="place_work">Место работы:</label>
						<textarea class="form-control" id="place_work" name="place_work" ></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Добавить</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>