<?php require('check_login.php'); ?>
<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Добавить направление</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>
	<script type="text/javascript" src="scripts/check_data.js"></script>


	<script type="text/javascript">

		function checks()
		{
			var cipher_direction = $("#cipher_direction").val();
			alert(cipher_direction);
			cipher_direction = checkDirection(cipher_direction);
			alert(2222);
			if(cipher_direction != 1)
			{
				if(cipher_direction == 0)
				{
					toastr.error('Введите шифр направления','Ошибка!');
					return false;
				}
				else if(cipher_direction == 2)
				{
					toastr.error('Некорректный шифр направления','Ошибка!');
					return false;
				}
			}

			alert(333);
		    var name_cipher = $("#name_cipher").val();
		    name_cipher = checkText(name_cipher);
		    if(name_cipher != 1)
		    {
		    	if(name_cipher == 0)
				{
					alert(2);
					toastr.error('Введите наименование шифра','Ошибка!');
					return false;
				}
				else if(name_cipher == 2)
				{
					toastr.error('Некорректное наименование шифра направления','Ошибка!');
					return false;
				}
		    }
		}

		$(function(){
			$("form").on('submit',function(){
				/*if(checks() == false)
				{
					return false;
				}*/
				var mode_1 = 1;
		        var cipher_direction = $("#cipher_direction").val();
		        var name_cipher = $("#name_cipher").val();
		        var qualification = $("#qualification").val();
		        $.ajax({
		        	type: 'POST',
		        	url: 'handler_structure.php',
		        	data: {cipher_direction, name_cipher, qualification, mode_1},
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
						if(arr['cipher_direction'] == 0)
						{
							toastr.error('Введите шифр направления','Ошибка!');
							flag = false;
						}
						if(arr['cipher_direction'] == 2)
						{
							toastr.error('Некорректный шифр направления','Ошибка!');
							flag = false;
						}
						if(arr['cipher_direction'] == 3)
						{
							toastr.error('Такой шифр направления уже существует','Ошибка!');
							flag = false;
						}
						if(arr['direction'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['name_cipher'] == 0)
						{
							toastr.error('Введите наименование шифра','Ошибка!');
							flag = false;
						}
						if(arr['name_cipher'] == 2)
						{
							toastr.error('Некорректное наименование шифра направления','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['qualification'] == 0)
						{
							toastr.error('Выберете квалификацию','Ошибка!');
							flag = false;
						}
						if(arr['qualification'] == 2)
						{
							toastr.error('Некорректная квалификация','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Направление добавлено');
    			$("#cipher_direction").val("");
    			$("#name_cipher").val("");
    			$.removeCookie('cipher_direction');
    			$.removeCookie('name_cipher');
    			$.removeCookie('qualification');
    		}
		}

		window.onbeforeunload = function() {
			$.cookie('cipher_direction', $("#cipher_direction").val(), { expires: 1 });
			$.cookie('name_cipher', $("#name_cipher").val(), { expires: 1 });
			$.cookie('qualification', $("#qualification").val(), { expires: 1 });
		};

		$(window).ready(function() {
			if($.cookie('cipher_direction') != null)
			{
				$("#cipher_direction").val($.cookie("cipher_direction"));
			}
			if($.cookie('name_cipher') != null)
			{
				$("#name_cipher").val($.cookie("name_cipher"));
			}
			if($.cookie('qualification') != null)
			{
				$("#qualification").val($.cookie("qualification"));
			}
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
				<form method="POST" action="#">
					<legend>О направлении</legend>
					<div class="form-group">
						<label for="cipher_direction">Шифр:</label>
						<input type="text" class="form-control" id="cipher_direction" name="cipher_direction" >
					</div>
					<div class="form-group">
						<label for="name_cipher">Полное название:</label>
						<textarea class="form-control" id="name_cipher" name="name_cipher" ></textarea>
					</div>
					<div class="form-group">
						<label for="qualification">Квалификация:</label>
						<select class="form-control" id="qualification" name="qualification" >
							<option value="" disabled selected></option>
							<option value="1">Бакалавр</option>
							<option value="2">Магистр</option>
							<option value="3">Специалист</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Добавить</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>