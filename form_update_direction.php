<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	$arr_1 = $_GET['arr_1'];
	check_get($arr_1);

	$qs_direction = $conn->query('SELECT * FROM direction WHERE id = '.$arr_1);
	$arr_direction = $qs_direction->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Обновить данные направления</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(function(){
			$("form").on('submit',function(){
				var arr_1 = <?php echo $arr_direction['id']; ?>;
				var mode_1 = 2;
				var cipher_direction = $("#cipher_direction").val();
		        var name_cipher = $("#name_cipher").val();
		    	$.ajax({
		        	type: 'POST',
		        	url: 'handler_structure.php',
		        	data: {cipher_direction, name_cipher, arr_1, mode_1},
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
							toastr.error('Значение пусто','Ошибка!');
							flag = false;
						}
						if(arr['arr_1'] == 2)
						{
							toastr.error('Некорректное значение','Ошибка!');
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
					}
					if(c == 2)
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
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Информация отредактирована');
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
					<legend>О направлении</legend>
					<div class="form-group">
						<label for="cipher_direction">Шифр:</label>
						<input type="text" class="form-control" id="cipher_direction" name="cipher_direction" value="<?php echo $arr_direction['cipher_direction']; ?>">
					</div>
					<div class="form-group">
						<label for="name_cipher">Полное название:</label>
						<textarea class="form-control" id="name_cipher" name="name_cipher" ><?php echo $arr_direction['name']; ?></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>