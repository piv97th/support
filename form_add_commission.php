<?php
	require('blocks/connect.php');

?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Добавить комиссию</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">
		$(function(){
			$("form").on('submit',function(){
				var mode_1 = 7;
		        var order_1 = $("#order_1").val();
		        var year = $("#year").val();
		        $.ajax({
		        	type: 'POST',
		        	url: 'handler_structure.php',
		        	data: { order_1, year, mode_1},
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
						if(arr['commission'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
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
    			toastr.success('Успешно! Комиссия добавлена');
/*		        $("#nrb").val("");
    			$("#last_name").val("");*/
    		}
		}

		window.onbeforeunload = function() {
			$.cookie('order_1', $("#order_1").val(), { expires: 1 });
			$.cookie('year', $("#year").val(), { expires: 1 });
		};

		$(window).ready(function() {
			if($.cookie('order_1') != null)
			{
				$("#order_1").val($.cookie("order_1"));
			}
			if($.cookie('year') != null)
			{
				$("#year").val($.cookie("year"));
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
					<legend>О комиссии</legend>
					<div class="form-group">
						<label for="order_1">Приказ:</label>
						<textarea class="form-control" id="order_1" name="order_1" ></textarea>
					</div>
					<div class="form-group">
						<label for="year">Год:</label>
						<select class="form-control" id="year" name="year" >
							<option value="" disabled selected></option>
							<?php
							for($y = 0; $y < 3; $y++)
							{
								$current_date = date(Y)-1+$y;
								echo '<option value='.$current_date.'>'.$current_date.'</option>';
							}
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