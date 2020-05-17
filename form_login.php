<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Вход</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">
		$(function(){
			$("form").on('submit',function(){
				var login = $('#login').val();
				var password = $('#password').val();
				alert(login);
				alert(password);
		        $.ajax({
		        	type: 'POST',
		        	url: 'handler_login.php',
		        	data: {login, password},
		        	async: false,
		        	success: function(response)
		        	{
		        		alert(response);
		        		var result = JSON.parse(response);
		        		out_toast(result);
		        		if(result['user'] == 1)
		        		{
		        			alert(222);
		        			$('form').attr('action', 'index.php');
		        			return true;
		        		}
		        		else if(result['user'] == 4)
		        		{
		        			$('form').attr('action', 'operator.php');
		        			return true;
		        		}
		        	},
		        	error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
		    	});
		    	//return false;
		    });
		});

		function out_toast(arr)
		{
			var flag = true;
			var c = 0;
			for(var i in arr)
			{
				if(arr[i] != 1)
				{
					if(c == 0)
					{
						if(arr['login'] == 0)
						{
							toastr.error('Введите логин','Ошибка!');
							flag = false;
						}
						if(arr['login'] == 2)
						{
							toastr.error('Некорректный логин','Ошибка!');
							flag = false;
						}
						if(arr['user'] == 0)
						{
							toastr.error('Пользователь не найден','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['password'] == 0)
						{
							toastr.error('Введите пароль','Ошибка!');
							flag = false;
						}
						if(arr['password'] == 2)
						{
							toastr.error('Некорректный пароль','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно!');
    		}
		}
	</script>

</head>


<body>

	<div class="container" id="content">    
		<div class="row content">
			<div class="col-sm text-left">
				<h1>Вход</h1>
				<form method="POST" action="#">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Логин</span>
						</div>
						<input type="text" class="form-control" id="login">
					</div>
					<div class="input-group mb-3">
						<div class="input-group-append">
							<span class="input-group-text">Пароль</span>
						</div>
						<input type="password" class="form-control" id="password">
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

</body>
</html>