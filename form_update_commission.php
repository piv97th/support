<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	$arr_1 = $_GET['arr_1'];
	check_get($arr_1);

	$qs_commission = $conn->query('SELECT * FROM commission WHERE id = '.$arr_1);
	$arr_commission = $qs_commission->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Обновить данные комиссии</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(function(){
			$("form").on('submit',function(){
				var arr_1 = <?php echo $arr_commission['id']; ?>;
				var mode_1 = 8;
				var order_1 = $("#order_1").val();
		        var year = $("#year").val();
		    	$.ajax({
		        	type: 'POST',
		        	url: 'handler_structure.php',
		        	data: {order_1, year, arr_1, mode_1},
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
						if(arr['commission'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['order_1'] == 0)
						{
							toastr.error('Введите приказ','Ошибка!');
							flag = false;
						}
						if(arr['order_1'] == 2)
						{
							toastr.error('Слишком много символов','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['year'] == 0)
						{
							toastr.error('Выберете год','Ошибка!');
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
					<legend>О комиссии</legend>
					<div class="form-group">
						<label for="order_1">Приказ:</label>
						<textarea class="form-control" id="order_1" name="order_1" required><?php echo $arr_commission['order_1']; ?></textarea>
					</div>
					<div class="form-group">
						<label for="year">Год:</label>
						<select class="form-control" id="year" name="year" >
							<?php
							echo '<option value='.($arr_commission["year"] + 1).'>'.($arr_commission["year"] + 1).'</option>';
							echo '<option value='.$arr_commission["year"].' selected>'.$arr_commission["year"].'</option>';
							echo '<option value='.($arr_commission["year"] - 1).'>'.($arr_commission["year"] - 1).'</option>';
							echo $arr_commission['year'];
							?>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>