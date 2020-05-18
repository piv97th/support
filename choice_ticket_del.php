<?php require('check_login.php'); ?>
<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Выбор билета</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/toastr.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>

	<script type="text/javascript">

		$(function(){
			refresh();
		});

		function refresh()
		{
			$("#content").children().remove();
			var mode_other = 1;
			var mode_1 = 45;
			$.ajax({
				type: 'POST',
				url: 'handler_ticket.php',
				data: {mode_other, mode_1},
				async: false,
				success: function(response)
				{
					var obj = JSON.parse(response);
					$('#content').append('<ul class="add_content"></ul>');
					$(obj).each(function(index, item) {
					$('.add_content').append('<li><a class="nolink" href=handler_ticket.php?arr_1='+item.arr_1+'>'+(index+1)+' '+item.fq+' '+item.sq+' '+item.tq+'</a></li>');
					});
					aDellTicket();
		        }
		    });
		}

		function aDellTicket()
		{
			$(".nolink").on("click", function(e){
				var mode_1 = 3;
				var link = e.target;
				link = String(link);
				var arr_1 = link.substr(49,8);
				$.ajax({
					type: 'POST',
					url: 'handler_ticket.php',
					data: {arr_1, mode_1},
					async: false,
					success: function(response)
					{
		        		var result = JSON.parse(response);
		        		outToast(result);
		        		refresh();
					},
					error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
				});
				return false;
			});
		}

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
							toastr.error('Что-то не дошло','Ошибка!');
							flag = false;
						}
						if(arr['arr_1'] == 2)
						{
							toastr.error('Что-то не дошло','Ошибка!');
							flag = false;
						}
						if(arr['ticket'] == 0)
						{
							toastr.error('Возможно этот билет кому-то уже задан','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Удалено');
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
				<div>
					<form name="cform">
						<div id="content">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>