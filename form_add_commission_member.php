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
			$("form").on('submit',function(){
				var mode_1 = 1;
				var chairman = $('#chairman').val();
				var secretary = $('#secretary').val();
				var login = $('#login').val();
				var password = $('#password').val();
		        //var arr_1 = <?php echo $arr_diploma['id']; ?>;
		        var members_ssk = [];
		        //var roles = [];
		        //cMember = $(this).find('input[name="date_meeting"]').length;
		        //alert(90);
		        var cMember = $(this).find('.member_ssk').length;
		        if(cMember < 1)
		        {
		        	toastr.error('Добавьте членов комиссии','Ошибка!');
		        	return false;
		        }
		        alert(chairman);
		        for(var i = 0; i < cMember; i++)
		        {
		        	members_ssk[i] = $('select[name="member_ssk"]:eq('+i+')').val();
		        	//roles[i] = $('select[name="role"]:eq('+i+')').val();
		        	//alert(members_ssk[i]);
		    	}
		    	//alert(arr_1);
		        //var members_ssk = $(".member_ssk").serialize();
		        //var questions = $("form").serialize();
		        var commission = $("#commission").val();
		        //alert(members_ssk);
		        $.ajax({
		        	type: 'POST',
		        	url: 'handler_commission_member.php',
		        	data: {chairman, secretary, password, login, members_ssk, commission, mode_1},
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
				alert($('.member_ssk').length);
				if($('member_ssk').length < 8)
				{
					var mode_other = 1;
					$.ajax({
			        	type: 'POST',
			        	url: 'handler_commission_member.php',
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
							//$('.slc_mbr:last').after('<div class="form-group slc_role"><label>Роль:</label><select class="form-control role" name="role"><option value="1">Председатель</option><option value="2">Член</option><option value="3">Секретарь</option></select><div>');
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
				if($('.slc_mbr').length > 0)
				{
					$('.slc_mbr:last').remove();
					//$('.slc_role:last').remove();
				}
		    });
		});

		$(window).ready(function() {
			var mode_other = 1;
					$.ajax({
			        	type: 'POST',
			        	url: 'handler_commission_member.php',
			        	data: {mode_other},
			        	async: false,
			        	success: function(response)
			        	{
			        		alert(response);
			        		var result = JSON.parse(response);
			        		$('#div_chairman').after('<div class="form-group"><label>Секретарь:</label><select class="form-control" id="secretary"><option value="" disabled selected></option></select></div>');
			        		//$('.appear_content:last').append('<label>Член комиссии:</label><select class="form-control member_ssk" name="member_ssk"><option value="" disabled selected></option></select>');
			        		$(result).each(function(index, item) {
								$('#secretary').append('<option value='+item.arr_1+'>'+item.last_name+' '+item.first_name+' '+item.patronymic+' '+item.post+'</option>');
							});
							//$('.slc_mbr:last').after('<div class="form-group slc_role"><label>Роль:</label><select class="form-control role" name="role"><option value="1">Председатель</option><option value="2">Член</option><option value="3">Секретарь</option></select><div>');
			        	},
			        	error: function(jqxhr, status, errorMsg)
			        	{
			        		toastr.error(errorMsg, status);
			        	}
		    		});
		});


		/*function pretrain(arrs_1_meeting, arrs_date)
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
		}*/

		/*$(function(){
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
					url: 'handler_commission_member.php',
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
		});*/

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
						if(arr['chairman'] == 0)
						{
							toastr.error('Не выбран председатель','Ошибка!');
							flag = false;
						}
						if(arr['chairman'] == 2)
						{
							toastr.error('Ошибка формата председателя','Ошибка!');
							flag = false;
						}
						if(arr['add'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
						if(arr['user'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['secretary'] == 0)
						{
							toastr.error('Не выбран секретарь','Ошибка!');
							flag = false;
						}
						if(arr['secretary'] == 2)
						{
							toastr.error('Ошибка формата секретаря','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['arr_member_ssk'] == 0)
						{
							toastr.error('Не выбран член ГЭК','Ошибка!');
							flag = false;
						}
						if(arr['arr_member_ssk'] == 2)
						{
							toastr.error('Ошибка формата члена ГЭК','Ошибка!');
							flag = false;
						}
					}
					if(c == 3)
					{
						if(arr['arr_1_commission'] == 0)
						{
							toastr.error('Выберете коммисию','Ошибка!');
							flag = false;
						}
						if(arr['arr_1_commission'] == 2)
						{
							toastr.error('Неправильный формат комиссии','Ошибка!');
							flag = false;
						}
					}
					if(c == 4)
					{
						if(arr['login'] == 0)
						{
							toastr.error('Введите логин','Ошибка!');
							flag = false;
						}
						if(arr['login'] == 2)
						{
							toastr.error('Неправильный формат логина','Ошибка!');
							flag = false;
						}
						if(arr['login'] == 3)
						{
							toastr.error('Такой логин уже есть','Ошибка!');
							flag = false;
						}
					}
					if(c == 5)
					{
						if(arr['password'] == 0)
						{
							toastr.error('Введите пароль','Ошибка!');
							flag = false;
						}
						if(arr['password'] == 1)
						{
							toastr.error('Неправильный формат пароля','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Добавлено');
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
					<legend>О комиссии:</legend>
					<div class="form-group" id="div_chairman">
						<label>Председатель:</label>
						<select class="form-control" id="chairman">
							<option value="" disabled selected></option>
							<?php
							while($arr_member_ssk = $result_member_ssk->fetch_assoc())
							{
								echo '<option value='.$arr_member_ssk["id"].'>'.$arr_member_ssk["last_name"].' '.$arr_member_ssk["first_name"].' '.$arr_member_ssk["patronymic"].' '.$arr_member_ssk["post"].'</option>';
							}
							?>
						</select>
					</div>
					<!-- <div class="form-group slc_role">
						<label>Роль:</label>
						<select class="form-control role" name="role">
							<option value="1">Председатель</option>
							<option value="2">Член</option>
							<option value="3">Секретарь</option>
						</select>
					</div> -->
					<!-- <div class="form-group">
						<label>Секретарь:</label>
						<select class="form-control" id="secretary">
							<option value="" disabled selected></option>
							<?php
							while($arr_member_ssk_2 = $result_member_ssk->fetch_assoc())
							{
								echo '<option value='.$arr_member_ssk_2["id"].'>'.$arr_member_ssk_2["last_name"].' '.$arr_member_ssk_2["first_name"].' '.$arr_member_ssk_2["patronymic"].' '.$arr_member_ssk_2["post"].'</option>';
							}
							foreach($arr_member_ssk as $valmember)
							{
								echo '<option value='.$valmember["id"].'>'.$valmember["last_name"].' '.$valmember["first_name"].' '.$valmember["patronymic"].' '.$valmember["post"].'</option>';
							}
							?>
						</select>
					</div> -->
					<div class="form-group">
						<label for="login">Логин:</label>
						<input type="text" class="form-control" id="login" name="login" >
					</div>
					<div class="form-group">
						<label for="login">Пароль:</label>
						<input type="password" class="form-control" id="password" name="password" >
					</div>
					<!-- <div class="form-group slc_role">
						<label>Роль:</label>
						<select class="form-control role" name="role">
							<option value="1">Председатель</option>
							<option value="2">Член</option>
							<option value="3">Секретарь</option>
						</select>
					</div> -->
					<button type="button" id="btn_minus" class="btn btn-primary">-</button>
						<button type="button" id="btn_plus" class="btn btn-primary">+</button>
					<div class="form-group">
						<select class="form-control" name="commission" id="commission">
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