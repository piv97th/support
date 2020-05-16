<?php
	require('blocks/connect.php');

	function slc_commision()
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id, order_1 FROM commission');
		while($arr_commission = $result->fetch_assoc())
		{
			echo '<option value='.$arr_commission["id"].'>'.$arr_commission["order_1"].'</option>';
		}
	}

	$result_member_ssk = $conn->query('SELECT id, last_name, first_name, patronymic, post FROM member_ssk');

?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Назначить комиссии членов ГЭК</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(function(){
			$("#btn_plus").on('click',function(){
				alert($('.member_ssk').length);
				if($('member_ssk').length < 8)
				{
					var mode_other = 1;
					//var arr_1_meeting = $('#arr_1_meeting').val();
					$.ajax({
			        	type: 'POST',
			        	url: 'handler_commission_group.php',
			        	data: {mode_other},
			        	async: false,
			        	success: function(response)
			        	{
			        		alert(response);
			        		var result = JSON.parse(response);
			        		$('#btn_minus').before('<div class="form-group slc_mbr"><label>Член комиссии:</label><select class="form-control member_ssk" name="member_ssk"><option value="" disabled selected></option></select></div>');
			        		//$('.appear_content:last').append('<label>Член комиссии:</label><select class="form-control member_ssk" name="member_ssk"><option value="" disabled selected></option></select>');
			        		$(result).each(function(index, item) {
								$('.member_ssk:last').append('<option value='+item.arr_1+'>'+item.last_name+' '+item.first_name+' '+item.patronymic+' '+item.post+'</option>');
							});
							$('.slc_mbr:last').after('<div class="form-group slc_role"><label>Роль:</label><select class="form-control role" name="role"><option value="1">Председатель</option><option value="2">Член</option><option value="3">Секретарь</option></select><div>');
			        	},
			        	error: function(jqxhr, status, errorMsg)
			        	{
			        		toastr.error(errorMsg, status);
			        	}
		    		});
				}
				else
				{
					alert("Слишком членов ГЭК");
				}
		    });
		});

		$(function(){
			$("#btn_minus").on('click',function(){
				if($('.slc_mbr').length > 1)
				{
					$('.slc_mbr:last').remove();
					$('.slc_role:last').remove();
				}
		    });
		});

		function pretrain(arrs_1_meeting, arrs_date)
		{
			$("form").on('submit',function(){
				alert("again 1");
				var arr_group = [];
				var cGroup = $(this).find('.groups').length;
				for(var i = 0; i < cGroup; i++)
		        {
		        	arr_group[i] = $('select[name="groups"]:eq('+i+')').val();
		    	}
		    	alert("again 2");
		    	var mode_1 = 1;
		    	$.ajax({
		        	type: 'POST',
		        	url: 'handler_add_meeting_group.php',
		        	data: {arrs_1_meeting, arrs_date, arr_group, mode_1},
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
		}

		$(function(){
			$("#commission").on('change',function(){
				var alerte = $('.main_content').length;
				if($('.main_content').length > 0)
				{
					$(".main_content").remove();
				}
				var commission = $("#commission").val();
				var mode_other = 1;
				alert(commission);
				$.ajax({
					type: 'GET',
					url: 'handler_add_meeting_group.php',
					data: {commission, mode_other},
					async: false,
					success: function(response)
					{
						alert(response);
						var obj = JSON.parse(response);
						var arrs_1_meeting = [];
		        		var arrs_date = [];
						$(obj).each(function(index, item) {
							$('form').append('<div class="form-group main_content"><input type hidden class="hidden" value='+item.arr_1+'>'+item.number_meeting+' <input type="date" class="date" value='+item.date+'></div>');
							$('.date:last').after('<select class="groups" name="groups"><option value="" disabled selected></option></select>');
							$(item.arr_group).each(function(index, itm) {
								$('.groups').append('<option value='+itm.arr_1+'>'+itm.cipher_group+'</option>');
							});
							arrs_1_meeting[index] = item.arr_1;
							arrs_date[index] = item.date;
						});
						pretrain(arrs_1_meeting, arrs_date);
			        }
			    });
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
						if(arr['arrs_1_meeting'] == 0)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
						if(arr['arrs_1_meeting'] == 2)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
						if(arr['add'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['arrs_date'] == 0)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
						if(arr['arrs_date'] == 2)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['arr_group'] == 0)
						{
							toastr.error('Выберете группу','Ошибка!');
							flag = false;
						}
						if(arr['arr_group'] == 2)
						{
							toastr.error('Неправильный формат группы','Ошибка!');
							flag = false;
						}
						if(arr['arr_group'] == 3)
						{
							toastr.error('Группы повторяются','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Событие добавлено');
/*		        $("#nrb").val("");
    			$("#last_name").val("");*/
    		}
		}

		/*window.onbeforeunload = function() {
			$.cookie('order_1', $("#order_1").val(), { expires: 1 });
			//$.cookie('year', $("#year").val(), { expires: 1 });
		};

		$(window).ready(function() {
			if($.cookie('order_1') != null)
			{
				$("#order_1").val($.cookie("order_1"));
			}
			$('#number_meeting').val(0);
/*			if($.cookie('year') != null)
			{
				$("#year").val($.cookie("year"));
			}*/
		//});
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
					<legend>Форма:</legend>
					<div class="form-group slc_mbr">
						<label>Член комиссии:</label>
						<select class="form-control member_ssk" name="member_ssk">
							<option value="" disabled selected></option>
							<?php
							while($arr_member_ssk = $result_member_ssk->fetch_assoc())
							{
								echo '<option value='.$arr_member_ssk["id"].'>'.$arr_member_ssk["last_name"].' '.$arr_member_ssk["first_name"].' '.$arr_member_ssk["patronymic"].' '.$arr_member_ssk["post"].'</option>';
							}
							?>
						</select>
					</div>
					<div class="form-group slc_role">
						<label>Роль:</label>
						<select class="form-control role" name="role">
							<option value="1">Председатель</option>
							<option value="2">Член</option>
							<option value="3">Секретарь</option>
						</select>
					</div>
					<button type="button" id="btn_minus" class="btn btn-primary">-</button>
						<button type="button" id="btn_plus" class="btn btn-primary">+</button>
					<div class="form-group">
						<select name="commission" id="commission">
							<option value="" selected disabled></option>
							<?php
								slc_commision();
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