<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	$mode = $_GET['mode'];
	check_get($mode);
	if($mode == 1)
	{
		$title = 'Выбор направления';
	}
	elseif($mode == 2)
	{
		$title = 'Выбор группы';
	}
	elseif($mode == 3)
	{
		$title = 'Выбор комиссии';
	}
	elseif($mode == 4)
	{
		$title = 'Выбор нучного руководителя';
	}
	elseif($mode == 5)
	{
		$title = 'Выбор члена ГЭК';
	}

?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title><?php echo $title; ?></title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/toastr.js"></script>
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>

	<script type="text/javascript">

		$(function(){
			refresh();
		});

		function refresh()
		{
			$("#content").children().remove();
			var mode = <?php echo $mode; ?>;
			if(mode == 1)
			{
				var mode_other = 1;
			}
			else if(mode == 2)
			{
				var mode_other = 2;
			}
			else if(mode == 3)
			{
				var mode_other = 3;
			}
			else if(mode == 4)
			{
				var mode_other = 4;
			}
			else if(mode == 5)
			{
				var mode_other = 5;
			}
			$.ajax({
				type: 'POST',
				url: 'handler_structure.php',
				data: {mode_other},
				async: false,
				success: function(response)
				{
					alert(response);
					var obj = JSON.parse(response);
					$('#content').append('<ul class="add_content"></ul>');
					if(mode == 1)
					{
						$(obj).each(function(index, item) {
						$('.add_content').append('<li><a class="nolink" href=handler_structure.php?arr_1='+item.arr_1+'>'+item.name+' '+item.cipher_direction+'</a></li>');
						});
						aDellDirection();
					}
					if(mode == 2)
					{
						$(obj).each(function(index, item) {
						$('.add_content').append('<li><a class="nolink" href=handler_structure.php?arr_1='+item.arr_1+'>'+item.cipher_group+'</a></li>');
						});
						aDellGroup();
					}
					if(mode == 3)
					{
						$(obj).each(function(index, item) {
						$('.add_content').append('<li><a class="nolink" href=handler_structure.php?arr_1='+item.arr_1+'>'+item.order_1+'</a></li>');
						});
						aDellCommission();
					}
					if(mode == 4)
					{
						$(obj).each(function(index, item) {
						$('.add_content').append('<li><a class="nolink" href=handler_supervisor.php?arr_1='+item.arr_1+'>'+item.cipher_supervisor+' '+item.last_name+' '+item.first_name+'</a></li>');
						});
						aDellSupervisor();
					}
					if(mode == 5)
					{
						$(obj).each(function(index, item) {
						$('.add_content').append('<li><a class="nolink" href=handler_member_ssk.php?arr_1='+item.arr_1+'>'+item.last_name+' '+item.first_name+' '+item.post+'</a></li>');
						});
						aDellMemberSSK();
					}
		        }
		    });
		}

		function aDellDirection()
		{
			$(".nolink").on("click", function(e){
				alert(1000);
				var mode_1 = 3;
				var link = e.target;
				link = String(link);
				var arr_1 = link.substr(52,8);
				alert(arr_1);
				$.ajax({
					type: 'POST',
					url: 'handler_structure.php',
					data: {arr_1, mode_1},
					async: false,
					success: function(response)
					{
						alert(response);
						var flag = true;
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

		function aDellGroup()
		{
			$(".nolink").on("click", function(e){
				alert(1000);
				var mode_1 = 6;
				var link = e.target;
				link = String(link);
				var arr_1 = link.substr(52,8);
				alert(arr_1);
				$.ajax({
					type: 'POST',
					url: 'handler_structure.php',
					data: {arr_1, mode_1},
					async: false,
					success: function(response)
					{
						alert(response);
						var flag = true;
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

		function aDellCommission()
		{
			$(".nolink").on("click", function(e){
				var mode_1 = 9;
				var link = e.target;
				link = String(link);
				var arr_1 = link.substr(52,8);
				alert(arr_1);
				$.ajax({
					type: 'POST',
					url: 'handler_structure.php',
					data: {arr_1, mode_1},
					async: false,
					success: function(response)
					{
						alert(response);
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

		function aDellSupervisor()
		{
			$(".nolink").on("click", function(e){
				var mode_1 = 3;
				var link = e.target;
				link = String(link);
				var arr_1 = link.substr(53,8);
				alert(arr_1);
				$.ajax({
					type: 'POST',
					url: 'handler_supervisor.php',
					data: {arr_1, mode_1},
					async: false,
					success: function(response)
					{
						alert(response);
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

		function aDellMemberSSK()
		{
			$(".nolink").on("click", function(e){
				var mode_1 = 3;
				var link = e.target;
				link = String(link);
				var arr_1 = link.substr(53,8);
				alert(arr_1);
				$.ajax({
					type: 'POST',
					url: 'handler_member_ssk.php',
					data: {arr_1, mode_1},
					async: false,
					success: function(response)
					{
						alert(response);
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
						if(arr['direction'] == 0)
						{
							toastr.error('Возможно у этого направления есть группы','Ошибка!');
							flag = false;
						}
						if(arr['group'] == 0)
						{
							toastr.error('Возможно у этой группы есть студенты','Ошибка!');
							flag = false;
						}
						if(arr['meeting'] == 0)
						{
							toastr.error('Возможно у этой комиссии есть связанные данные','Ошибка!');
							flag = false;
						}
						if(arr['commission'] == 0)
						{
							toastr.error('Возможно у этой комиссии есть связанные данные','Ошибка!');
							flag = false;
						}
						if(arr['supervisor'] == 0)
						{
							toastr.error('Возможно у этого преподавателя есть студенты','Ошибка!');
							flag = false;
						}
						if(arr['member_ssk'] == 0)
						{
							toastr.error('Возможно у этого преподавателя есть студенты','Ошибка!');
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