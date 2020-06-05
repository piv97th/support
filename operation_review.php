<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');

	function content_select()
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id, cipher_group FROM group_1 WHERE id_qualification_fk = 2 OR id_qualification_fk = 3');
		while ($arr = $result->fetch_assoc())
		{
			echo'<option value='.$arr["id"].'>'.$arr["cipher_group"].'</option>';
		}
	}

	$mode = $_GET['mode'];
	if($mode == 1)
	{
		$title = 'Выбор рецензии';
		$legend = 'Редактирование рецензии';
		$name_choice = 'Группа';
	}
	elseif($mode == 2)
	{
		$title = 'Выбор рецензии';
		$legend = 'Удаление рецензии';
		$name_choice = 'Группа';
	}
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title><?php echo $title; ?></title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>

	<script type="text/javascript">

		function a_dell()
		{
			$(".nolink").on("click", function(e){
				var mode_1 = 3;
				var link = e.target;
				link = String(link);
				var arr_1 = link.substr(48,8);
				alert(arr_1);
				$.ajax({
					type: 'POST',
					url: 'handler_review.php',
					data: {arr_1, mode_1},
					async: false,
					success: function(response)
					{
		        		var result = JSON.parse(response);
		        		outToast(result);
		        		location.reload();

					},
					error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
				});
				return false;
			});
		}

		$(function(){
			$("#group").on('change',function(){
				$(".add_content").children().remove();
				var mode_other = 2;
				var mode = <?php echo $mode; ?>;
				var select = $("#group").val();
				alert(select);
				$.ajax({
					type: 'GET',
					url: 'handler_review.php',
					data: {mode_other, select},
					async: false,
					success: function(response)
					{
						alert(response);
						var obj = JSON.parse(response);
						if(mode == 1)
						{
							$(obj).each(function(index, item) {
								$('.add_content').append('<li><a href=form_update_review.php?arr_1='+item.arr_1+'>'+(index+1)+' '+item.last_name +' '+item.first_name+' '+item.number_record_book+'</a></li>');
							});
						}
						if(mode == 2)
						{
							$(obj).each(function(index, item) {
								$('.add_content').append('<li><a class="nolink" href=delete_review.php?arr_1='+item.arr_1+'>'+(index+1)+' '+item.last_name +' '+item.first_name+' '+item.number_record_book+'</a></li>');
							});
							a_dell();
						}
			        }
			    });
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
							toastr.error('Ошибка','Ошибка!');
							flag = false;
						}
						if(arr['arr_1'] == 2)
						{
							toastr.error('Ошибка','Ошибка!');
							flag = false;
						}
						if(arr['student'] == 0)
						{
							toastr.error('При удалении','Ошибка!');
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
					<legend><?php echo $legend; ?></legend>
					<?php echo $name_choice; ?>
					<select id="group" name="group">
						<option value="" disabled selected></option>
						<?php
							content_select();
						?>
					</select>
					<!-- <button class="btn btn-primary" id="btn_choice">Выбрать</button> -->
					<form method="POST" action="#">
						<div id="content">
							<ul class="add_content">
							</ul>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>