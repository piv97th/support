<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');

	function slc_commision()
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id, order_1 FROM commission');
		while($arr_commission = $result->fetch_assoc())
		{
			echo '<option value='.$arr_commission["id"].'>'.$arr_commission["order_1"].'</option>';
		}
	}

?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Назначить заседание группе</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(function(){
			$("form").on('submit',function(){
				var commission = $("#commission").val();
				var mode_1 = 2;
				$.ajax({
					type: 'GET',
					url: 'handler_add_meeting_group.php',
					data: {commission, mode_1},
					async: false,
					success: function(response)
					{
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
						if(arr['arr_1_commission'] == 0)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
						if(arr['arr_1_commission'] == 2)
						{
							toastr.error('Что-то не так','Ошибка!');
							flag = false;
						}
						if(arr['del'] == 0)
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
					<select name="commission" id="commission">
						<option value="" selected disabled></option>
						<?php
							slc_commision();
						?>
					</select>
				</div> 
				<form method="POST" action="#">
					<button type="submit" class="btn btn-primary">Выбрать</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>