<?php
	include('blocks/connect.php');

	$qs_group = $conn->query('SELECT id, cipher_group FROM group_1');
	$qs_supervisor = $conn->query('SELECT * FROM teacher');
?>

<!DOCTYPE html>


<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Добавить студента</title>

	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script src="scripts/disabled_link.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(function(){
			$(":submit").on('click',function(){
				$(".alert").addClass("hide_alert");
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
		        	success: function(answer)
		        	{
		        		//alert(answer);
		        		var flag = true;
		        		var result = JSON.parse(answer);
		        		//alert(result);
		        		for(var i in result)
		        		{
		        			if(result[i] != 1)
		        			{
		        				$(".alert-danger").removeClass("hide_alert");
		        				flag = false;
		        				break;
		        			}
		        		}
		        		if(flag == true)
		        		{
		        			$(".alert-success").removeClass("hide_alert");
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
/*		        		if (result['status'] == 1) {
		        			$(".alert-success").removeClass("hide_alert");
		        		} else {
		        			$(".alert-danger").removeClass("hide_alert");
		        		}*/
		        	},
		        	error: function(answer)
		        	{
		        		$(".alert-danger").removeClass("hide_alert");
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
			$("#nrb").val($.cookie("nrb"));
			$("#last_name").val($.cookie("last_name"));
			$("#first_name").val($.cookie("first_name"));
			$("#patronymic").val($.cookie("patronymic"));
			$("#group_1").val($.cookie("group_1"));
			$("#topic").val($.cookie("topic"));
			$("#type_work").val($.cookie("type_work"));
			$("#anti_plagiarism").val($.cookie("anti_plagiarism"));
			$("#supervisor").val($.cookie("supervisor"));
		});
	</script>

</head>


<body>

	<?php
	require_once('blocks/header.php');
	require_once('blocks/navbar.php');
	?>

	<div class="alert alert-success fixed-top hide_alert">
		<strong>Успешно!</strong> Студент был добавлен
	</div>

	<div class="alert alert-danger fixed-top hide_alert">
		<strong>Ошибка!</strong> Проверьте данные
	</div>

	<div class="container" id="content">    
		<div class="row content">
			<div class="col-sm text-left"> 
				<form method="POST" action="#">
					<div class="form-group">
						<label for="nrb">НЗК:</label>
						<input type="text" class="form-control" id="nrb" name="nrb">
					</div>
					<div class="form-group">
						<label for="last_name">Фамилия:</label>
						<input type="text" class="form-control" id="last_name" name="last_name">
					</div>
					<div class="form-group">
						<label for="first_name">Имя:</label>
						<input type="text" class="form-control" id="first_name" name="first_name">
					</div>
					<div class="form-group">
						<label for="patronymic">Отчество:</label>
						<input type="text" class="form-control" id="patronymic" name="patronymic">
					</div>
					<div class="form-group">
						<label for="group_1">Группа:</label>
						<select class="form-control" id="group_1" name="group_1">
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
						<label for="patronymic">Тема:</label>
						<textarea class="form-control" id="topic" name="topic"></textarea>
					</div>
					<div class="form-group">
						<label for="type_work">Тип работы</label>
						<select class="form-control" id="type_work" name="type_work">
							<option value="" disabled selected></option>
							<option value="1">Простая</option>
							<option value="2">Заказная</option>
							<option value="3">Университетская</option>
						</select>
					</div>
					<div class="form-group">
						<label for="anti_plagiarism">Антиплагиат:</label>
						<input type="text" class="form-control" id="anti_plagiarism" name="anti_plagiarism">
					</div>
					<div class="form-group">
						<label for="supervisor">Преподватель:</label>
						<select class="form-control" id="supervisor" name="supervisor">
							<option value="" disabled selected></option>
							<?php
							while($arr_supervisor = $qs_supervisor->fetch_assoc())
							{
								echo '<option value='.$arr_supervisor["id"].'>'.$arr_supervisor["last_name"].' '.$arr_supervisor["first_name"].' '.$arr_supervisor["patronymic"].'</option>';
							}
							?>
						</select>
					</div>
<!-- 					<div class="form-group form-check">
	<label class="form-check-label">
		<input class="form-check-input" type="checkbox" name="remember"> Remember me
	</label>
</div> -->
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>