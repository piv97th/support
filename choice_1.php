<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	function content_select($mode)
	{
		require('blocks/connect.php');
		if($mode == 1)
		{
			$result_direction = $conn->query('SELECT * FROM direction');
			echo '<ul class="add_content">';
			while ($arr_direction = $result_direction->fetch_assoc())
			{
				printf('<li><a href=form_update_direction.php?arr_1=%s>%s %s</a></li>', $arr_direction['id'], $arr_direction['name'], $arr_direction['cipher_direction']);
			}
			echo '</ul>';
		}
	}
	$mode = $_GET['mode'];
	check_get($mode);
	if($mode == 1)
	{
		$title = 'Выбор направления';
		$name_choice = 'Направление';
	}
	elseif($mode == 2)
	{
		$title = 'Выбор направления';
		$name_choice = 'Направление';
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
			var mode_other = 3;
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
					$(obj).each(function(index, item) {
						$('.add_content').append('<li><a class="nolink" href=handler_structure.php?arr_1='+item.arr_1+'>'+item.name+''+item.cipher_direction+'</a></li>');
					});
					a_dell();
		        }
		    });
		}

		function a_dell()
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
						if(arr['cipher_direction'] == 2)
						{
							toastr.error('Что-то не дошло','Ошибка!');
							flag = false;
						}
						if(arr['direction'] == 0)
						{
							toastr.error('Возможно у этого направления есть группы','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Направление удалено');
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
							<?php
								content_select($mode);
							?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>