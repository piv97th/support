<?php
	include('blocks/connect.php');

	$qs_group = $conn->query('SELECT id, cipher_group FROM group_1');
	$qs_supervisor = $conn->query('SELECT * FROM teacher');
?>

<!DOCTYPE html>


<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Добавить студента</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">
		$(function(){
			$("form").on('submit',function(){
		        var nrb = $("#nrb").val();
		        var last_name = $("#last_name").val();
		        var first_name = $("#first_name").val();
		        var patronymic = $("#patronymic").val();
		        var group_1 = $("#group_1").val();
		        var cipher_group = $("#cipher_group").val();
		        var topic = $("#topic").val();
		        var type_work = $("#type_work").val();
		        var anti_plagiarism = $("#anti_plagiarism").val();
		        var supervisor = $("#supervisor").val();
		        $.ajax({
		        	type: 'POST',
		        	url: 'add_student.php',
		        	data: {nrb, last_name, first_name, patronymic, group_1, topic, type_work, anti_plagiarism, supervisor},
		        	async: false,
		        	success: function(response)
		        	{
		        		var flag = true;
		        		var result = JSON.parse(response);
		        		for(var i in result)
		        		{
		        			if(result[i] != 1)
		        			{
		        				if(result['first'] == 3)
		        				{
		        					toastr.error('Такой номер зачетной книжки существует','Ошибка!');
		        					flag = false;
		        					break;
		        				}
		        				toastr.error('Проверьте правильность введенных данных','Ошибка!');
		        				flag = false;
		        				break;
		        			}
		        		}
		        		if(flag == true)
		        		{
		        			toastr.success('Успешно! Студент добавлен');
		        			$("#nrb").val("");
		        			$("#last_name").val("");
		        			$("#first_name").val("");
		        			$("#patronymic").val("");
		        			$("#group_1").val("");
		        			$("#topic").val("");
		        			$("#type_work").val("");
		        			$("#anti_plagiarism").val("");
		        			$("#supervisor").val("");
		        		}
		        	},
		        	error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
		    	});
		    	return false;
		    });
		});

		window.onbeforeunload = function() {
			$.cookie('nrb', $("#nrb").val(), { expires: 1 });
			$.cookie('last_name', $("#last_name").val(), { expires: 1 });
			$.cookie('first_name', $("#first_name").val(), { expires: 1 });
			$.cookie('patronymic', $("#patronymic").val(), { expires: 1 });
			$.cookie('group_1', $("#group_1").val(), { expires: 1 });
			$.cookie('topic', $("#topic").val(), { expires: 1 });
			$.cookie('type_work', $("#type_work").val(), { expires: 1 });
			$.cookie('anti_plagiarism', $("#anti_plagiarism").val(), { expires: 1 });
			$.cookie('supervisor', $("#supervisor").val(), { expires: 1 });
		};

		$(window).ready(function() {
			if($.cookie('nrb') != null)
			{
				$("#nrb").val($.cookie("nrb"));
			}
			if($.cookie('last_name') != null)
			{
				$("#last_name").val($.cookie("last_name"));
			}
			if($.cookie('first_name') != null)
			{
				$("#first_name").val($.cookie("first_name"));
			}
			if($.cookie('patronymic') != null)
			{
				$("#patronymic").val($.cookie("patronymic"));
			}
			if($.cookie('group_1') != null)
			{
				$("#group_1").val($.cookie("group_1"));
			}
			if($.cookie('topic') != null)
			{
				$("#topic").val($.cookie("topic"));
			}
			if($.cookie('type_work') != null)
			{
				$("#type_work").val($.cookie("type_work"));
			}
			if($.cookie('anti_plagiarism') != null)
			{
				$("#anti_plagiarism").val($.cookie("anti_plagiarism"));
			}
			if($.cookie('supervisor') != null)
			{
				$("#supervisor").val($.cookie("supervisor"));
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
					<legend>О студенте</legend>
					<div class="form-group">
						<label for="nrb">НЗК:</label>
						<input type="text" class="form-control" id="nrb" name="nrb" pattern="[0-9]{2}[Б,М,С][0-9]{4}" required title="Пожалуйста, введите номер зачетной книжки студента в формате 16Б0000">
					</div>
					<div class="form-group">
						<label for="last_name">Фамилия:</label>
						<input type="text" class="form-control" id="last_name" name="last_name" pattern="[А-ЯЁ][а-яё]{1,254}" required  title="Пожалуйста, введите фамилию">
					</div>
					<div class="form-group">
						<label for="first_name">Имя:</label>
						<input type="text" class="form-control" id="first_name" name="first_name" pattern="[А-ЯЁ][а-яё]{1,254}" required title="Пожалуйста, введите имя">
					</div>
					<div class="form-group">
						<label for="patronymic">Отчество:</label>
						<input type="text" class="form-control" id="patronymic" name="patronymic" pattern="[А-ЯЁ][а-яё]{1,254}" required title="Пожалуйста, введите отчество">
					</div>
					<div class="form-group">
						<label for="group_1">Группа:</label>
						<select class="form-control" id="group_1" name="group_1" required>
							<option value="" disabled selected></option>
							<?php
							while($arr_group = $qs_group->fetch_assoc())
							{
								echo '<option value='.$arr_group["id"].'>'.$arr_group["cipher_group"].'</option>';
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="topic">Тема:</label>
						<textarea class="form-control" id="topic" name="topic" required></textarea>
					</div>
					<div class="form-group">
						<label for="type_work">Тип работы</label>
						<select class="form-control" id="type_work" name="type_work" required>
							<option value="" disabled selected></option>
							<option value="1">Простая</option>
							<option value="2">Заказная</option>
							<option value="3">Университетская</option>
						</select>
					</div>
					<div class="form-group">
						<label for="anti_plagiarism">Антиплагиат:</label>
						<input type="text" class="form-control" id="anti_plagiarism" name="anti_plagiarism" pattern="[0].[0-9]{0,6}[1-9]" title="пожалуйста, введите антиплагиат в формате дроби">
					</div>
					<div class="form-group">
						<label for="supervisor">Преподаватель:</label>
						<select class="form-control" id="supervisor" name="supervisor" required>
							<option value="" disabled selected></option>
							<?php
							while($arr_supervisor = $qs_supervisor->fetch_assoc())
							{
								echo '<option value='.$arr_supervisor["id"].'>'.$arr_supervisor["last_name"].' '.$arr_supervisor["first_name"].' '.$arr_supervisor["patronymic"].'</option>';
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