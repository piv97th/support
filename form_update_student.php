<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');

	function check_var($var)
	{
		if(!isset($var))
		{
			return 0;
		}
		else
		{
			return $var;
		}
	}

	$arr_1 = $_GET['arr_1'];
	if(empty($arr_1))
	{
		if(0 > $arr_1 || $arr_1 > 100000000)
		{
			exit;
		}
		exit;
	}

	$qs_student = $conn->query('SELECT * FROM student WHERE id = '.$arr_1);
	$arr_student = $qs_student->fetch_assoc();

	if($arr_student[id_se_fk] != NULL)
	{
		$qs_se = $conn->query('SELECT * FROM se WHERE id = '.$arr_student['id_se_fk']);
		$arr_se = $qs_se->fetch_assoc();
	}

	$qs_diploma = $conn->query('SELECT * FROM diploma WHERE id = '.$arr_student['id_diploma_fk']);
	$arr_diploma = $qs_diploma->fetch_assoc();

	$qs_group = $conn->query('SELECT id, cipher_group FROM group_1');
	$qs_supervisor = $conn->query('SELECT * FROM teacher');
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Обновить данные студента</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		function get_ticket_se()
		{
			var ticket_se = 1;
			$.ajax({
	        	type: 'POST',
	        	url: 'handler_updstudent.php',
	        	data: {ticket_se},
	        	async: false,
	        	success: function(response)
	        	{
	        		var obj = JSON.parse(response);
					$(obj).each(function(index, item) {
						$('#ticket_se').append("<option value="+item.arr_1_ticket+">"+item.arr_1_ticket+" "+item.fq+"</option>");
					});
	        	},
	        	error: function(jqxhr, status, errorMsg)
	        	{
	        		toastr.error(errorMsg, status);
	        	}
		    });
		}

		function get_mark_se()
		{
			var mark_se = 1;
			$.ajax({
	        	type: 'POST',
	        	url: 'handler_updstudent.php',
	        	data: {mark_se},
	        	async: false,
	        	success: function(response)
	        	{
	        		var obj = JSON.parse(response);
					$(obj).each(function(index, item) {
						$('#mark_se').append("<option value="+item.arr_1_mark+">"+item.mark+"</option>");
					});
	        	},
	        	error: function(jqxhr, status, errorMsg)
	        	{
	        		toastr.error(errorMsg, status);
	        	}
		    });
		}

		function get_mark_diploma()
		{
			var mark_diploma = 1;
			alert(100);
			$.ajax({
	        	type: 'POST',
	        	url: 'handler_updstudent.php',
	        	data: {mark_diploma},
	        	async: false,
	        	success: function(response)
	        	{
	        		alert(response);
	        		var obj = JSON.parse(response);
					$(obj).each(function(index, item) {
						$('#mark_diploma').append("<option value="+item.arr_1_mark+">"+item.mark+"</option>");
					});
	        	},
	        	error: function(jqxhr, status, errorMsg)
	        	{
	        		toastr.error(errorMsg, status);
	        	}
		    });
		}

		function diploma()
		{
			var exsist_np = <?php echo check_var($arr_diploma['number_protocol']); ?>;
			if(exsist_np != 0)
			{
				$('#np_diploma').val(<?php echo $arr_diploma['number_protocol']; ?>);
				
				var diploma_mark = <?php echo check_var($arr_diploma['id_mark_fk']); ?>;
				if(diploma_mark != 0)
				{
					get_mark_diploma();
					$('#mark_diploma option[value=<?php echo $arr_diploma["id_mark_fk"]; ?>]').attr('selected', 'selected');
				}
				else
				{
					$('#diploma_second').remove();
				}
			}
			else
			{
				$('#diploma_first').remove();
				$('#diploma_second').remove();

			}
		}

		function se()
		{
			var arr_1_se = <?php echo check_var($arr_student['id_se_fk']); ?>;
			if(arr_1_se != 0)
			{
				var se = 1;
				$.ajax({
		        	type: 'POST',
		        	url: 'handler_updstudent.php',
		        	data: {se, arr_1_se},
		        	async: false,
		        	success: function(response)
		        	{
		        		var obj = JSON.parse(response);
						$("#np_se").val(obj.np_se);
						var se_ticket = <?php echo check_var($arr_se['id_ticket_fk']); ?>;
						if(se_ticket != 0)
						{
							get_ticket_se();
							$('#ticket_se option[value=<?php echo $arr_se["id_ticket_fk"]; ?>]').attr('selected', 'selected');
						}
						else
						{
							$('#se_second').remove();
						}

						var se_mark = <?php echo check_var($arr_se['id_mark_fk']); ?>;
						if(se_mark != 0)
						{
							get_mark_se();
							$('#mark_se option[value=<?php echo $arr_se["id_mark_fk"]; ?>]').attr('selected', 'selected');
						}
						else
						{
							$('#se_third').remove();
						}
						$('#m_se option[value='+obj.arr_1_meeting+']').attr('selected', 'selected');
		        	},
		        	error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
			    });
			}
			else
			{
				$('#se_first').remove();
				$('#se_second').remove();
				$('#se_third').remove();

			}
		}

		$(function(){
			$("form").on('submit',function(){
				var arr_1 = <?php echo $arr_1; ?>;
				var mode_1 = 2;
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

		        var protocol_se = $("#np_se").val();
		        //var meeting_se = $("#m_se").val();

		        var ticket_se = $("#ticket_se").val();

		        var mark_se = $("#mark_se").val();

		        var protocol_diploma = $("#np_diploma").val();
		        //var meeting_diploma = $("#m_diploma").val();

		        var mark_diploma = $("#mark_diploma").val();
		    	$.ajax({
		        	type: 'POST',
		        	url: 'handler_student.php',
		        	data: {nrb, last_name, first_name, patronymic, group_1, topic, type_work, anti_plagiarism, supervisor, mode_1, arr_1, protocol_se, ticket_se, mark_se, protocol_diploma, mark_diploma},
		        	async: false,
		        	success: function(response)
		        	{
		        		alert(response);
		        		var result = JSON.parse(response);
						out_toast(result);
		        	},
		        	error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
		    	});
		    	return false;
		    });
		});

		function out_toast(arr)
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
							toastr.error('Ошибка','Ошибка!');
							flag = false;
						}
						if(arr['arr_1'] == 2)
						{
							toastr.error('Ошибка','Ошибка!');
							flag = false;
						}
						if(arr['se'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['nrb'] == 0)
						{
							toastr.error('Введите Номер зачетной книжки','Ошибка!');
							flag = false;
						}
						if(arr['nrb'] == 2)
						{
							toastr.error('Некорректный номер зачетной книжки','Ошибка!');
							flag = false;
						}
						if(arr['nrb'] == 3)
						{
							toastr.error('Такой номер зачетной книжки существует','Ошибка!');
							flag = false;
						}
						if(arr['diploma'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['last_name'] == 0)
						{
							toastr.error('Введите фамилию','Ошибка!');
							flag = false;
						}
						if(arr['last_name'] == 2)
						{
							toastr.error('Некорректая фамилия','Ошибка!');
							flag = false;
						}
						if(arr['student'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 3)
					{
						if(arr['first_name'] == 0)
						{
							toastr.error('Введите имя','Ошибка!');
							flag = false;
						}
						if(arr['first_name'] == 2)
						{
							toastr.error('Некорректное имя','Ошибка!');
							flag = false;
						}
					}
					if(c == 4)
					{
						if(arr['patronymic'] == 0)
						{
							toastr.error('Введите отчество','Ошибка!');
							flag = false;
						}
						if(arr['patronymic'] == 2)
						{
							toastr.error('Некорректное отчество','Ошибка!');
							flag = false;
						}
					}
					if(c == 5)
					{
						if(arr['group_1'] == 0)
						{
							toastr.error('Выберете группу','Ошибка!');
							flag = false;
						}
						if(arr['group_1'] == 2)
						{
							toastr.error('Некорректная группа','Ошибка!');
							flag = false;
						}
					}
					if(c == 6)
					{
						if(arr['topic'] == 0)
						{
							toastr.error('Введите тему','Ошибка!');
							flag = false;
						}
						if(result['topic'] == 2)
						{
							toastr.error('Некорректная тема','Ошибка!');
							flag = false;
						}
					}
					if(c == 7)
					{
						if(arr['type_work'] == 0)
						{
							toastr.error('Выберете тип работы','Ошибка!');
							flag = false;
						}
						if(arr['type_work'] == 2)
						{
							toastr.error('Некорректный тип работы','Ошибка!');
							flag = false;
						}
					}
					if(c == 8)
					{
						if(arr['anti_plagiarism'] == 2)
						{
							toastr.error('Некорректное значение антиплагиата','Ошибка!');
							flag = false;
						}
					}
					if(c == 9)
					{
						if(arr['supervisor'] == 0)
						{
							toastr.error('Выберете научного руководителя','Ошибка!');
							flag = false;
						}
						if(arr['supervisor'] == 2)
						{
							toastr.error('Некорректное значение научного руководителя','Ошибка!');
							flag = false;
						}
					}
					if(c == 10)
					{
						if(arr['protocol_diploma'] == 0)
						{
							toastr.error('Введите номер протокола ВКР','Ошибка!');
							flag = false;
						}
						if(arr['protocol_diploma'] == 2)
						{
							toastr.error('Некорректный номер протокола ВКР','Ошибка!');
							flag = false;
						}
						if(arr['protocol_diploma'] == 3)
						{
							toastr.error('Такой номер протокола ВКР есть','Ошибка!');
							flag = false;
						}
					}
					if(c == 11)
					{
						if(arr['mark_diploma'] == 0)
						{
							toastr.error('Выберете оценку ВКР','Ошибка!');
							flag = false;
						}
						if(arr['mark_diploma'] == 2)
						{
							toastr.error('Некорректная оценка ВКР','Ошибка!');
							flag = false;
						}
					}
					if(c == 12)
					{
						if(arr['protocol_se'] == 0)
						{
							toastr.error('Введите номер протокола госэкзамена','Ошибка!');
							flag = false;
						}
						if(arr['protocol_se'] == 2)
						{
							toastr.error('Некорректный номер протокола госэкзамена','Ошибка!');
							flag = false;
						}
						if(arr['protocol_se'] == 3)
						{
							toastr.error('Такой номер протокола госэкзамена есть','Ошибка!');
							flag = false;
						}
					}
					if(c == 13)
					{
						if(arr['ticket_se'] == 0)
						{
							toastr.error('Выберете номер билета','Ошибка!');
							flag = false;
						}
						if(arr['ticket_se'] == 2)
						{
							toastr.error('Некорректные номер билета','Ошибка!');
							flag = false;
						}
					}
					if(c == 14)
					{
						if(arr['mark_se'] == 0)
						{
							toastr.error('Выберете оценку госэкзамена','Ошибка!');
							flag = false;
						}
						if(arr['mark_se'] == 2)
						{
							toastr.error('Некорректная оценка госэкзамена','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Информация обновлена');
    		}
		}

		$(window).ready(function() {
			if($("#anti_plagiarism").val() == 0)
			{
				$("#anti_plagiarism").val("");
			}
			$("#group_1 option[value=<?php echo $arr_student['id_group_fk']; ?>]").attr("selected", "selected");
			$("#type_work option[value=<?php echo $arr_diploma['id_type_work_fk']; ?>]").attr("selected", "selected");
			$("#supervisor option[value=<?php echo $arr_diploma['id_teacher_fk']; ?>]").attr("selected", "selected");
			se();
			diploma();
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
						<input type="text" class="form-control" id="nrb" name="nrb" pattern="[0-9]{2}[Б,М,С][0-9]{4}" required title="Пожалуйста, введите номер зачетной книжки студента в формате 16Б0000" value="<?php echo $arr_student['number_record_book']; ?>">
					</div>
					<div class="form-group">
						<label for="last_name">Фамилия:</label>
						<input type="text" class="form-control" id="last_name" name="last_name" pattern="[А-ЯЁ][а-яё]{1,254}" required  title="Пожалуйста, введите фамилию" value="<?php echo $arr_student['last_name']; ?>">
					</div>
					<div class="form-group">
						<label for="first_name">Имя:</label>
						<input type="text" class="form-control" id="first_name" name="first_name" pattern="[А-ЯЁ][а-яё]{1,254}" required title="Пожалуйста, введите имя" value="<?php echo $arr_student['first_name']; ?>">
					</div>
					<div class="form-group">
						<label for="patronymic">Отчество:</label>
						<input type="text" class="form-control" id="patronymic" name="patronymic" pattern="[А-ЯЁ][а-яё]{1,254}" required title="Пожалуйста, введите отчество" value="<?php echo $arr_student['patronymic']; ?>">
					</div>
					<div class="form-group">
						<label for="group_1">Группа:</label>
						<select class="form-control" id="group_1" name="group_1" required>
							<option value="" selected></option>
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
						<textarea class="form-control" id="topic" name="topic" required><?php echo $arr_diploma['topic']; ?></textarea>
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
						<input type="text" class="form-control" id="anti_plagiarism" name="anti_plagiarism" pattern="[0].[0-9]{0,6}[1-9]" title="пожалуйста, введите антиплагиат в формате дроби" value="<?php echo $arr_diploma['anti_plagiarism']; ?>">
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
					<div id="se_first">
						<div class="form-group">
							<label for="np_se">Номер протокола ГЭ:</label>
							<input type="text" class="form-control" id="np_se" name="np_se" >
						</div>
					</div>
					<div id="se_second">
							<div class="form-group">
							<label for="ticket_se">Номер билета:</label>
							<select class="form-control" name="ticket_se" id="ticket_se">
							</select>
						</div>
					</div>
					<div id="se_third">
							<div class="form-group">
							<label for="mark_se">Оценка ГЭ:</label>
							<select class="form-control" name="mark_se" id="mark_se">
							</select>
						</div>
					</div>
					<div id="diploma_first">
						<div class="form-group">
							<label for="np_diploma">Номер протокола ВКР:</label>
							<input class="form-control" type="text" class="form-control" id="np_diploma" name="np_diploma" >
						</div>
					</div>
					<div id="diploma_second">
							<div class="form-group">
							<label for="mark_diploma">Оценка ВКР:</label>
							<select class="form-control" name="mark_diploma" id="mark_diploma">
							</select>
						</div>
					</div>
					<button type="submit" class="btn btn-primary">Редактировать</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>