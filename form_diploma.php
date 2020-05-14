<?php
	require('blocks/connect.php');

	require_once('blocks/check_data.php');

	$arr_1 = $_GET['arr_1'];
	check_get($arr_1);

	$result_student = $conn->query('SELECT id, number_record_book, last_name, first_name, patronymic, id_diploma_fk FROM student WHERE id = '.$arr_1);
	$arr_student = $result_student->fetch_assoc();

	$result_diploma = $conn->query('SELECT * FROM diploma WHERE id = '.$arr_student['id_diploma_fk']);
	$arr_diploma = $result_diploma->fetch_assoc();
	//$result_member_ssk = $conn->query('SELECT * FROM member_ssk WHERE ');
	$result_member_ssk = $conn->query('SELECT member_ssk.id as id, member_ssk.last_name as last_name, member_ssk.first_name as first_name, member_ssk.patronymic as patronymic FROM curation_event JOIN commission ON commission.id=curation_event.id_commission_fk JOIN member_ssk ON member_ssk.id=curation_event.id_member_ssk_fk WHERE curation_event.id_commission_fk = (SELECT id_commission_fk FROM timetable_meeting WHERE id = '.$arr_diploma['id_meeting_fk'].')');
	while($arr_member_ssk = $result_member_ssk->fetch_assoc())
	{
		$arr_member[] = $arr_member_ssk;
	}

	//$result_member_ssk = $conn->query('SELECT curation_event.id, commission.id, commission.order_1, member_ssk.id, member_ssk.last_name, member_ssk.first_name, member_ssk.patronymic FROM curation_event JOIN commission ON commission.id=curation_event.id_commission_fk JOIN member_ssk ON member_ssk.id=curation_event.id_member_ssk_fk WHERE curation_event.id_commission_fk = (SELECT id_commission_fk FROM timetable_meeting WHERE id = '.$arr_diploma['id_meeting_fk'].')');

/*	select t1.value1, t1.value2, t2.valuea, t3.valuexx, t3.valueyy
from table1 as t1
join table2 as t2 on t2.id1 = t1.id1
join table3 as t3 on t3.id1 = t1.id1*/

?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>ВКР</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">
		$(function(){
			$("form").on('submit',function(){
				var mode_1 = 4;
		        var cipher_group = $("#cipher_group").val();
		        var qualification = $("#qualification").val();
		        var cathedra = $("#cathedra").val();
		        var direction = $("#direction").val();
		        var form_studying = $("#form_studying").val();
		        $.ajax({
		        	type: 'POST',
		        	url: 'handler_structure.php',
		        	data: {cipher_group, qualification, cathedra, direction, form_studying, mode_1},
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

		function outMember(arr)
		{
			alert(arr[3]);
			/*for(var i in arr)
			{
				alert(arr.get('id'));
			}*/
		}

		$(function(){
			$("#btn_plus").on('click',function(){
				/*var countMeeting = $('#number_meeting').val();
				countMeeting++;*/
				alert($('.member_ssk').length);
				if($('.member_ssk').length < 20)
				{
					var json_1 = <?php echo json_encode($arr_member); ?>;
					//alert(json);
					//var student = {name: 'John', age: 30};
					//json_1 = JSON.stringify(student);
					var result = JSON.stringify(json_1);
					outMember(result);
					//alert(outMember(result));
					//$('#number_meeting').val(countMeeting); json_encode($arr_member_ssk);
					//$('.form-group:eq(-2)').after('<div class="form-group"><label>Член комиссии:</label><select class="form-control member_ssk" name="member_ssk[]"><option value="" disabled selected></option><option value='+<?php echo $arr_member_ssk["id"]; ?>+'>'+<?php echo $arr_member_ssk["id"]; ?>+'</option></select></div>');
					//$('.form-group:eq(-2)').after('<div class="form-group"><label for="mark">Оценка:</label><select class="form-control" id="mark" name="mark" ><option value="" disabled selected></option><option value="1">неудовлетворительно</option><option value="2">удовлетворительно</option><option value="3">хорошо</option><option value="4">отлично</option></select></div>');
				}
		    });
		});

		$(function(){
			$("#btn_minus").on('click',function(){
				/*var countMeeting = $('#number_meeting').val();
				countMeeting--;*/
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
						if(arr['cipher_group'] == 0)
						{
							toastr.error('Введите шифр группы','Ошибка!');
							flag = false;
						}
						if(arr['cipher_group'] == 2)
						{
							toastr.error('Некорректный шифр группы','Ошибка!');
							flag = false;
						}
						if(arr['cipher_group'] == 3)
						{
							toastr.error('Такой шифр группы уже существует','Ошибка!');
							flag = false;
						}
						if(arr['group'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['qualification'] == 0)
						{
							toastr.error('Выберете квалификацию','Ошибка!');
							flag = false;
						}
						if(arr['qualification'] == 2)
						{
							toastr.error('Некорректное значение квалификации','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['cathedra'] == 0)
						{
							toastr.error('Введите квалификацию','Ошибка!');
							flag = false;
						}
						if(arr['cathedra'] == 2)
						{
							toastr.error('Введите квалификацию','Ошибка!');
							flag = false;
						}
					}
					if(c == 3)
					{
						if(arr['direction'] == 0)
						{
							toastr.error('Выберете направление','Ошибка!');
							flag = false;
						}
						if(arr['direction'] == 2)
						{
							toastr.error('Некорректное направление','Ошибка!');
							flag = false;
						}
					}
					if(c == 4)
					{
						if(arr['form_studying'] == 0)
						{
							toastr.error('Выберете форму обучения','Ошибка!');
							flag = false;
						}
						if(arr['form_studying'] == 2)
						{
							toastr.error('Некорректная форма обучения','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Направление добавлено');
/*		        $("#nrb").val("");
    			$("#last_name").val("");*/
    		}
		}

		window.onbeforeunload = function() {
			$.cookie('cipher_group', $("#cipher_group").val(), { expires: 1 });
			$.cookie('qualification', $("#qualification").val(), { expires: 1 });
			$.cookie('cathedra', $("#cathedra").val(), { expires: 1 });
			$.cookie('direction', $("#direction").val(), { expires: 1 });
			$.cookie('form_studying', $("#form_studying").val(), { expires: 1 });
		};

		$(window).ready(function() {
			if($.cookie('cipher_group') != null)
			{
				$("#cipher_group").val($.cookie("cipher_group"));
			}
			if($.cookie('qualification') != null)
			{
				$("#qualification").val($.cookie("qualification"));
			}
			if($.cookie('cathedra') != null)
			{
				$("#cathedra").val($.cookie("cathedra"));
			}
			if($.cookie('direction') != null)
			{
				$("#direction").val($.cookie("direction"));
			}
			if($.cookie('form_studying') != null)
			{
				$("#form_studying").val($.cookie("form_studying"));
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
					<legend>ВКР:</legend>
					<div id="info_student"><h3><?php echo $arr_student["number_record_book"].' '.$arr_student["last_name"].' '.$arr_student["first_name"].' '.$arr_student["patronymic"]; ?></h3></div>
					<legend>Вопросы:</legend>
					<div class="form-group">
						<label>Член комиссии:</label>
						<select class="form-control member_ssk" name="member_ssk[]" >
							<option value="" disabled selected></option>
							<?php
							foreach($arr_member as $valmbr)
							{
								echo '<option value='.$valmbr["id"].'>'.$valmbr["last_name"].' '.$valmbr["first_name"].' '.$valmbr["patronymic"].'</option>';
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Вопрос:</label>
						<textarea class="form-control" name="rank[]" ></textarea>
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