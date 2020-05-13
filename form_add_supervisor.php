<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Добавить научного руководителя</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(window).ready(function() {
			if($.cookie('cipher') != null)
			{
				$("#cipher").val($.cookie("cipher"));
			}
			if($.cookie('last_name') != null)
			{
				$("#last_name").val($.cookie("last_name"));
			}
			if($.cookie('first_name') != null)
			{
				$("#first_name").val($.cookie("first_name"));
			}
			if($.cookie('patronymic') != null)
			{
				$("#patronymic").val($.cookie("patronymic"));
			}
			if($.cookie('degree') != null)
			{
				$("#degree").val($.cookie("degree"));
			}
			if($.cookie('rank') != null)
			{
				$("#rank").val($.cookie("rank"));
			}
			if($.cookie('post') != null)
			{
				$("#post").val($.cookie("post"));
			}
		});

		window.onbeforeunload = function() {
			$.cookie('cipher', $("#cipher").val(), { expires: 1 });
			$.cookie('last_name', $("#last_name").val(), { expires: 1 });
			$.cookie('first_name', $("#first_name").val(), { expires: 1 });
			$.cookie('patronymic', $("#patronymic").val(), { expires: 1 });
			$.cookie('degree', $("#degree").val(), { expires: 1 });
			$.cookie('rank', $("#rank").val(), { expires: 1 });
			$.cookie('post', $("#post").val(), { expires: 1 });
		};

		$(function(){
			$("form").on('submit',function(){
				var cipher = $("#cipher").val();
				var last_name = $("#last_name").val();
		        var first_name = $("#first_name").val();
		        var patronymic = $("#patronymic").val();
		        var degree = $("#degree").val();
		        var rank = $("#rank").val();
		        alert(cipher);
		        var post = $("#post").val();
		        var mode_1 = 1;
		    	$.ajax({
		        	type: 'POST',
		        	url: 'handler_supervisor.php',
		        	data: {cipher, last_name, first_name, patronymic, degree, rank, post, mode_1},
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
						if(arr['cipher'] == 0)
						{
							toastr.error('Введите шифр','Ошибка!');
							flag = false;
						}
						if(arr['cipher'] == 2)
						{
							toastr.error('Проверьте правильность шифра','Ошибка!');
							flag = false;
						}
						if(arr['cipher'] == 3)
						{
							toastr.error('Такой шифр существует','Ошибка!');
							flag = false;
						}
						if(arr['supervisor'] == 0)
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

/*		window.onbeforeunload = function (evt) {
			var message = "Измененные данные не отправлены";
			if (typeof evt == "undefined") {
				evt = window.event;
			}
			if (evt) {
				evt.returnValue = message;
			}
			return message;
		}*/

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
						<label for="cipher">Шифр:</label>
						<input type="text" class="form-control" id="cipher" name="cipher" >
					</div>
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
						<label for="degree">Степень:</label>
						<select class="form-control" id="degree" name="degree" >
							<option value="1">Кандидат наук</option>
							<option value="2">Доктор наук</option>
						</select>
					</div>
					<div class="form-group">
						<label for="rank">Звание:</label>
						<textarea class="form-control" id="rank" name="rank" ></textarea>
					</div>
					<div class="form-group">
						<label for="post">Должность:</label>
						<textarea class="form-control" id="post" name="post" ></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>