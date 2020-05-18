<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	$arr_1 = $_GET['arr_1'];
	check_get($arr_1);
	$qs_commission = $conn->query('SELECT * FROM commission WHERE id = '.$arr_1);
	$arr_commission = $qs_commission->fetch_assoc();

	$qs_meeting = $conn->query('SELECT * FROM timetable_meeting WHERE id_commission_fk = '.$arr_commission['id']);
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
				var arr_1_commission = <?php echo $arr_commission['id'];?>;
				var mode_1 = 8;
		        var order_1 = $("#order_1").val();
		        var arr_date = [];
		        cDate = $(this).find('input[name="date_meeting"]').length;
		        for(var i = 0; i < cDate; i++)
		        {
		        	arr_date[i] = $('input[name="date_meeting"]:eq('+i+')').val();
		    	}
		        $.ajax({
		        	type: 'POST',
		        	url: 'handler_structure.php',
		        	data: {arr_1_commission, order_1, arr_date, mode_1},
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

		$(function(){
			$("#btn_plus").on('click',function(){
				var countMeeting = $('#number_meeting').val();
				countMeeting++;
				if(countMeeting < 10)
				{
					$('#number_meeting').val(countMeeting);
					$('.form-group:last').after('<div class="form-group date"><label>Дата:</label><input type="date" class="form-control" name="date_meeting" ></div>');
				}
		    });
		});

		$(function(){
			$("#btn_minus").on('click',function(){
				var countMeeting = $('#number_meeting').val();
				countMeeting--;
				if(0 <= countMeeting)
				{
					$('#number_meeting').val(countMeeting);
					$('.date:last').remove();
				}
				else
				{
					$('#number_meeting').val(0);
				}
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
						if(arr['meeting'] == 0)
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
						if(arr['commission'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['date'] == 0)
						{
							toastr.error('Выберете год','Ошибка!');
							flag = false;
						}
						if(arr['date'] == 2)
						{
							toastr.error('Неправильно набран год','Ошибка!');
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

		$(window).ready(function() {
			$('#number_meeting').val($(".date").length);
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
						<textarea class="form-control" id="order_1" name="order_1" required><?php echo $arr_commission['order_1']; ?></textarea>
					</div>
					<div class="form-group">
						<label for="number_meeting">Количество заседаний:</label>
						<input type="text" id="number_meeting" value="0" disabled>
						<button type="button" id="btn_minus" class="btn btn-primary">-</button>
						<button type="button" id="btn_plus" class="btn btn-primary">+</button>
					</div>
					<?php
					while($arr_meeting = $qs_meeting->fetch_assoc())
					{
						echo '<div class="form-group date"><label>Дата:</label><input type="date" class="form-control" name="date_meeting" value='.$arr_meeting["date"].'></div>';
					}
					?>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>