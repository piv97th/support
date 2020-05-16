<?php
	require('blocks/connect.php');

	require_once('blocks/check_data.php');

	function slc_meeting()
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id, number_meeting, date FROM timetable_meeting');
		echo '<option value="" disabled selected></option>';
		while($arr_meeting = $result->fetch_assoc())
		{
			echo '<option value='.$arr_meeting["id"].'>'.$arr_meeting["number_meeting"].' '.$arr_meeting["date"].'</option>';
		}
	}

	function slc_ticket()
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id FROM ticket');
		$c = 1;
		echo '<option value="" disabled selected></option>';
		while($arr_ticket = $result->fetch_assoc())
		{
			echo '<option value='.$arr_ticket["id"].'>'.$c.'</option>';
			$c++;
		}
	}

	$arr_1 = $_GET['arr_1'];
	check_get($arr_1);

	$result_student = $conn->query('SELECT id, number_record_book, last_name, first_name, patronymic, id_diploma_fk FROM student WHERE id = '.$arr_1);
	
	$arr_student = $result_student->fetch_assoc();

	//$result_diploma = $conn->query('SELECT * FROM diploma WHERE id = '.$arr_student['id_diploma_fk']);
	//$arr_diploma = $result_diploma->fetch_assoc();
	$result_member_ssk = $conn->query('SELECT * FROM member_ssk');
	//$result_member_ssk = $conn->query('SELECT member_ssk.id as id, member_ssk.last_name as last_name, member_ssk.first_name as first_name, member_ssk.patronymic as patronymic, member_ssk.post as post FROM curation_event JOIN commission ON commission.id=curation_event.id_commission_fk JOIN member_ssk ON member_ssk.id=curation_event.id_member_ssk_fk WHERE curation_event.id_commission_fk = (SELECT id_commission_fk FROM timetable_meeting WHERE id = '.$arr_diploma['id_meeting_fk'].')');
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Госэкзамен</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">
		$(function(){
			$("form").on('submit',function(){
				var mode_1 = 1;
				var arr_1_student = <?php echo $arr_student["id"]; ?>;
				var arr_1_meeting = $('#meeting').val();
				var ticket = $('#ticket').val();
		        var members_ssk = [];
		        var questions = [];
		        var cMember = $(this).find('.member_ssk').length;
		        alert(cMember);
		        for(var i = 0; i < cMember; i++)
		        {
		        	members_ssk[i] = $('select[name="member_ssk"]:eq('+i+')').val();
		        	questions[i] = $('textarea:eq('+i+')').val();
		        	//alert(members_ssk[i]);
		    	}
		    	//alert(arr_1);
		        var mark = $("#mark").val();
		        //alert(members_ssk);
		        $.ajax({
		        	type: 'POST',
		        	url: 'handler_se.php',
		        	data: {arr_1_student, arr_1_meeting, ticket, members_ssk, questions, mark, mode_1},
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
			$("#meeting").on('change',function(){
				alert(111);
				var arr_1_meeting = $('#meeting').val();
				var mode_other = 1;
				alert(arr_1_meeting);
				$.ajax({
		        	type: 'POST',
		        	url: 'handler_se.php',
		        	data: {mode_other, arr_1_meeting},
		        	async: false,
		        	success: function(response)
		        	{
		        		alert(response);
		        		var result = JSON.parse(response);
		        		$('.member_ssk').find('option').remove();
		        		$(result).each(function(index, item) {
							$('.member_ssk').append('<option value='+item.arr_1+'>'+item.last_name+' '+item.first_name+' '+item.patronymic+' '+item.post+'</option>');
						});
		        	},
		        	error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
	    		});

			});
		});

		$(function(){
			$("#btn_plus").on('click',function(){
				alert($('.slc_spr').length);
				if($('.slc_spr').length < 20)
				{
					var mode_other = 2;
					var arr_1_meeting = $('#meeting').val();//$('#arr_1_meeting').val();
					$.ajax({
			        	type: 'POST',
			        	url: 'handler_se.php',
			        	data: {mode_other, arr_1_meeting},
			        	async: false,
			        	success: function(response)
			        	{
			        		alert(response);
			        		var result = JSON.parse(response);
			        		$('#btn_minus').before('<div class="form-group appear_content slc_spr"></div>');
			        		$('.appear_content:last').append('<label>Член комиссии:</label><select class="form-control member_ssk" name="member_ssk"><option value="" disabled selected></option></select>');
			        		$(result).each(function(index, item) {
								$('.member_ssk:last').append('<option value='+item.arr_1+'>'+item.last_name+' '+item.first_name+' '+item.patronymic+' '+item.post+'</option>');
							});
							$('.slc_spr:last').after('<div class="form-group txtr_qstn"><label>Вопрос:</label><textarea class="form-control" name="question"></textarea><div>');
			        	},
			        	error: function(jqxhr, status, errorMsg)
			        	{
			        		toastr.error(errorMsg, status);
			        	}
		    		});
				}
				else
				{
					alert("Слишком много вопросов");
				}
		    });
		});

		$(function(){
			$("#btn_minus").on('click',function(){
				if($('.slc_spr').length > 1)
				{
					$('.slc_spr:last').remove();
					$('.txtr_qstn:last').remove();
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
						if(arr['arr_1_meeting'] == 0)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
						if(arr['arr_1_meeting'] == 2)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
						if(arr['se'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
						if(arr['student'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
						if(arr['questions'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['ticket'] == 0)
						{
							toastr.error('Введите номер билета','Ошибка!');
							flag = false;
						}
						if(arr['ticket'] == 2)
						{
							toastr.error('Некорректное значение номера билета','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['mark'] == 0)
						{
							toastr.error('Введите оценку','Ошибка!');
							flag = false;
						}
						if(arr['mark'] == 2)
						{
							toastr.error('Некорректное значение оценки','Ошибка!');
							flag = false;
						}
					}
					if(c == 3)
					{
						if(arr['member_ssk'] == 0)
						{
							toastr.error('Выберете преподавателя','Ошибка!');
							flag = false;
						}
						if(arr['member_ssk'] == 2)
						{
							toastr.error('Некорректный преподаватель','Ошибка!');
							flag = false;
						}
					}
					if(c == 4)
					{
						if(arr['questions'] == 0)
						{
							toastr.error('Заполните поле вопроса','Ошибка!');
							flag = false;
						}
						if(arr['questions'] == 2)
						{
							toastr.error('Некорректые данные в поле вопроса','Ошибка!');
							flag = false;
						}
					}
					if(c == 4)
					{
						if(arr['arr_1_student'] == 0)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
						if(arr['arr_1_student'] == 2)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Данные сохранены');
/*		        $("#nrb").val("");
    			$("#last_name").val("");*/
    		}
		}

		/*window.onbeforeunload = function (evt) {
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
					<legend>ВКР:</legend>
					<div id="info_student"><h3><?php echo $arr_student["number_record_book"].' '.$arr_student["last_name"].' '.$arr_student["first_name"].' '.$arr_student["patronymic"]; ?></h3><input type="hidden" name="arr_1_meeting" id="arr_1_meeting" value=<?php echo $arr_diploma["id_meeting_fk"] ?>></div>
					<div class="form-group">
						<label>Заседание:</label>
						<select name="meeting" id="meeting">
							<!-- <option value="" selected disabled></option> -->
							<?php
								slc_meeting();
							?>
						</select>
					</div> 
					<div class="form-group slc_spr">
						<label>Билет:</label>
						<select class="form-control ticket" id="ticket">
							<?php
								slc_ticket();
							?>
						</select>
					</div>
					<legend>Вопросы:</legend>
					<div class="form-group slc_spr">
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
					<div class="form-group txtr_qstn">
						<label>Вопрос:</label>
						<textarea class="form-control" name="question"></textarea>
					</div>
					<button type="button" id="btn_minus" class="btn btn-primary">-</button>
					<button type="button" id="btn_plus" class="btn btn-primary">+</button>
					<div class="form-group">
						<label for="mark">Оценка:</label>
						<select class="form-control" id="mark" name="mark" >
							<option value="" disabled selected></option>
							<option value="1">неудовлетворительно</option>
							<option value="2">удовлетворительно</option>
							<option value="3">хорошо</option>
							<option value="4">отлично</option>
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