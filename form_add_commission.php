<?php require('check_login.php'); ?>
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
				var number_commission = $("#number_commission").val();
		        var order_1 = $("#order_1").val();
		        var arr_mixed = [];
		        cDate = $(this).find('input[name="date_meeting"]').length;
		        for(var i = 0; i < cDate; i++)
		        {
		        	arr_mixed[i] = [];
	        		arr_mixed[i][0] = parseInt($('select[name="group"]:eq('+i+')').val());
	        		arr_mixed[i][1] = $('input[name="date_meeting"]:eq('+i+')').val();
	        		arr_mixed[i][2] = $('select[name="type_meeting"]:eq('+i+')').val();
		    	}
		        $.ajax({
		        	type: 'POST',
		        	url: 'handler_structure.php',
		        	data: {number_commission, order_1, arr_mixed, mode_1},
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

		$(function(){
			$("#btn_plus").on('click',function(){
				var mode_other = 6;
				var countMeeting = $('#number_meeting').val();
				$.ajax({
					type: 'POST',
					url: 'handler_structure.php',
					data: {mode_other},
					async: false,
					success: function(response)
					{
						var obj = JSON.parse(response);
						$('.form-group:last').after('<div class="form-group block_group"><label for="group">Группа:</label><select class="form-control group" name="group"><option value="" disabled selected></option></select></div>');
						$(obj).each(function(index, item) {
							$('.group:last').append('<option value='+item.arr_1+'>'+item.cipher_group+'</option>');
						});
						countMeeting++;
						if(countMeeting < 10)
						{
							$('#number_meeting').val(countMeeting);
							$('.form-group:last').after('<div class="form-group date"><label>Дата:</label><input type="date" class="form-control" name="date_meeting" ></div><div class="form-group block_type_meeting"><label>Тип ГИА:</label><select class="form-control type_meeting" name="type_meeting" ><option value="" disabled selected></option><option value=1>Госэкзамен</option><option value=2>Защита ВКР</option></select></div>');
						}
			        }
			    });
		    });
		});

		$(function(){
			$("#btn_minus").on('click',function(){
				var countMeeting = $('#number_meeting').val();
				countMeeting--;
				if(0 <= countMeeting)
				{
					$('#number_meeting').val(countMeeting);
					$('.block_group:last').remove();
					$('.date:last').remove();
					$('.block_type_meeting:last').remove();
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
						if(arr['number_commission'] == 0)
						{
							toastr.error('Введите номер комиссии','Ошибка!');
							flag = false;
						}
						if(arr['number_commission'] == 2)
						{
							toastr.error('Введите корректный номер','Ошибка!');
							flag = false;
						}
						if(arr['number_commission'] == 3)
						{
							toastr.error('Такой номер комиссии уже есть','Ошибка!');
							flag = false;
						}
						if(arr['group'] == 0)
						{
							toastr.error('Выберете группу','Ошибка!');
							flag = false;
						}
						if(arr['group'] == 2)
						{
							toastr.error('Некорректный номер группы','Ошибка!');
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
						if(arr['date'] == 0)
						{
							toastr.error('Выберете дату','Ошибка!');
							flag = false;
						}
						if(arr['date'] == 2)
						{
							toastr.error('Некорректная дата','Ошибка!');
							flag = false;
						}
						if(arr['meeting'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['type_meeting'] == 0)
						{
							toastr.error('Выберете тип ГИА','Ошибка!');
							flag = false;
						}
						if(arr['type_meeting'] == 2)
						{
							toastr.error('Некорректный тип ГИА','Ошибка!');
							flag = false;
						}
					}
					if(c == 3)
					{
						if(arr['repeat'] == 3)
						{
							toastr.error('Повтор события для группы','Ошибка!');
							flag = false;
						}
					}

		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Комиссия добавлена');
    			$("#number_commission").val("");
		        $("#order_1").val("");
		        $.removeCookie('number_commission');
		        $.removeCookie('order_1');
		        location.reload();
		    }
		}

		window.onbeforeunload = function() {
			$.cookie('number_commission', $("#number_commission").val(), { expires: 1 });
			$.cookie('order_1', $("#order_1").val(), { expires: 1 });
		};

		$(window).ready(function() {
			if($.cookie('number_commission') != null)
			{
				$("#number_commission").val($.cookie("number_commission"));
			}
			if($.cookie('order_1') != null)
			{
				$("#order_1").val($.cookie("order_1"));
			}
			$('#number_meeting').val(0);
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
						<label for="number_commission">Номер комиссии:</label>
						<input type="text" class="form-control" id="number_commission" name="number_commission" >
					</div>
					<div class="form-group">
						<label for="order_1">Приказ:</label>
						<textarea class="form-control" id="order_1" name="order_1" ></textarea>
					</div>
					<div class="form-group">
						<label for="number_meeting">Количество заседаний:</label>
						<input type="text" id="number_meeting" value="0" disabled>
						<button type="button" id="btn_minus" class="btn btn-primary">-</button>
						<button type="button" id="btn_plus" class="btn btn-primary">+</button>
					</div>
					<button type="submit" class="btn btn-primary">Добавить</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>