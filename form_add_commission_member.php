<?php require('check_login.php'); ?>
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
		        var members_ssk = [];
		        var cMember = $(this).find('.member_ssk').length;
		        if(cMember < 1)
		        {
		        	toastr.error('Добавьте членов комиссии','Ошибка!');
		        	return false;
		        }
		        for(var i = 0; i < cMember; i++)
		        {
		        	members_ssk[i] = $('select[name="member_ssk"]:eq('+i+')').val();
		    	}
		        var commission = $("#commission").val();
		        $.ajax({
		        	type: 'POST',
		        	url: 'handler_commission_member.php',
		        	data: {chairman, secretary, password, login, members_ssk, commission, mode_1},
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
			        		var result = JSON.parse(response);
			        		$('#btn_minus').before('<div class="form-group slc_mbr"><label>Член комиссии:</label><select class="form-control member_ssk" name="member_ssk"><option value="" disabled selected></option></select></div>');
			        		$(result).each(function(index, item) {
								$('.member_ssk:last').append('<option value='+item.arr_1+'>'+item.last_name+' '+item.first_name+' '+item.patronymic+' '+item.post+'</option>');
							});
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
			        		var result = JSON.parse(response);
			        		$('#div_chairman').after('<div class="form-group"><label>Секретарь:</label><select class="form-control" id="secretary"><option value="" disabled selected></option></select></div>');
			        		$(result).each(function(index, item) {
								$('#secretary').append('<option value='+item.arr_1+'>'+item.last_name+' '+item.first_name+' '+item.patronymic+' '+item.post+'</option>');
							});
			        	},
			        	error: function(jqxhr, status, errorMsg)
			        	{
			        		toastr.error(errorMsg, status);
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
					<div class="form-group">
						<label for="login">Логин:</label>
						<input type="text" class="form-control" id="login" name="login" >
					</div>
					<div class="form-group">
						<label for="login">Пароль:</label>
						<input type="password" class="form-control" id="password" name="password" >
					</div>
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