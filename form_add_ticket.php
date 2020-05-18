<?php require('check_login.php'); ?>
<?php

	function out_number_ticket()
	{
		require('blocks/connect.php');
		$query = $conn->query('SELECT COUNT(id) as `count` FROM ticket');
		$number_ticket = $query->fetch_assoc();

		if($number_ticket['count'] == 0)
		{
			return 1;
		}
		else
		{
			return $number_ticket['count'] + 1;
		}
	}

?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Добавить билет</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(window).ready(function() {
			if($.cookie('fq') != null)
			{
				$("#fq").val($.cookie("fq"));
			}
			if($.cookie('sq') != null)
			{
				$("#sq").val($.cookie("sq"));
			}
			if($.cookie('tq') != null)
			{
				$("#tq").val($.cookie("tq"));
			}
		});

		window.onbeforeunload = function() {
			$.cookie('fq', $("#fq").val(), { expires: 1 });
			$.cookie('sq', $("#sq").val(), { expires: 1 });
			$.cookie('tq', $("#tq").val(), { expires: 1 });
		};

		$(function(){
			$("form").on('submit',function(){
				var fq = $("#fq").val();
				var sq = $("#sq").val();
				var tq = $("#tq").val();
		        var mode_1 = 1;
		    	$.ajax({
		        	type: 'POST',
		        	url: 'handler_ticket.php',
		        	data: {fq, sq, tq, mode_1},
		        	async: false,
		        	success: function(response)
		        	{
		        		var result = JSON.parse(response);
						outToast(result);
						var nq = $('#nq').text();
						nq++;
						alert(nq);
						$('#nq').text(nq);
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
						if(arr['ticket'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
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
					if(c == 2)
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
					<legend>Билет <span id="nq"><?php echo out_number_ticket(); ?></span></legend>
					<div class="form-group">
						<label for="fq">Вопрос 1:</label>
						<textarea class="form-control" id="fq" name="fq" ></textarea>
					</div>
					<div class="form-group">
						<label for="sq">Вопрос 2:</label>
						<textarea class="form-control" id="sq" name="sq" ></textarea>
					</div>
					<div class="form-group">
						<label for="tq">Вопрос 3:</label>
						<textarea class="form-control" id="tq" name="tq" ></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>