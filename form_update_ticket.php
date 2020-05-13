<?php

	require_once('blocks/check_data.php');

	$arr_1 = $_GET['arr_1'];
	check_get($arr_1);

	function out_number_ticket($arr_1)
	{
		require('blocks/connect.php');
		$query = $conn->query('SELECT COUNT(id) as `count` FROM ticket WHERE (id >= (SELECT id FROM ticket ORDER BY id LIMIT 1) AND id <= '.$arr_1.')');
		$number_ticket = $query->fetch_assoc();

		return $number_ticket['count'];
	}

	require('blocks/connect.php');
	$qs_ticket = $conn->query('SELECT *  FROM ticket WHERE id ='.$arr_1);
	$arr_ticket = $qs_ticket->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Обновить билет</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(function(){
			$("form").on('submit',function(){
				var arr_1 = <?php echo $arr_1; ?>;
				var fq = $("#fq").val();
				var sq = $("#sq").val();
				var tq = $("#tq").val();
		        var mode_1 = 2;
		    	$.ajax({
		        	type: 'POST',
		        	url: 'handler_ticket.php',
		        	data: {arr_1, fq, sq, tq, mode_1},
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
						if(arr['ticket'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['fq'] == 0)
						{
							toastr.error('Введите первый вопрос','Ошибка!');
							flag = false;
						}
						if(arr['fq'] == 2)
						{
							toastr.error('Проверьте правильность первого вопроса','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['sq'] == 0)
						{
							toastr.error('Введите второй вопрос','Ошибка!');
							flag = false;
						}
						if(arr['sq'] == 2)
						{
							toastr.error('Проверьте правильность второго вопроса','Ошибка!');
							flag = false;
						}
					}
					if(c == 3)
					{
						if(arr['tq'] == 0)
						{
							toastr.error('Введите третий вопрос','Ошибка!');
							flag = false;
						}
						if(arr['tq'] == 2)
						{
							toastr.error('Проверьте правильность третьего вопроса','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Информация добавлена');
    		}
		}

/*		window.onbeforeunload = function (evt) {
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
					<legend>Билет <span id="nq"><?php echo out_number_ticket($arr_1); ?></span></legend>
					<div class="form-group">
						<label for="fq">Вопрос 1:</label>
						<textarea class="form-control" id="fq" name="fq" ><?php echo $arr_ticket['first_question']; ?></textarea>
					</div>
					<div class="form-group">
						<label for="sq">Вопрос 2:</label>
						<textarea class="form-control" id="sq" name="sq" ><?php echo $arr_ticket['second_question']; ?></textarea>
					</div>
					<div class="form-group">
						<label for="tq">Вопрос 3:</label>
						<textarea class="form-control" id="tq" name="tq" ><?php echo $arr_ticket['third_question']; ?></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>