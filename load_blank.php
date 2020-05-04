<?php
	require('blocks/connect.php');
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Загрузка бланка</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">
		$(function(){
			$("form").on('submit',function(){
		        $.ajax({
		        	type: 'POST',
		        	url: 'handler_excel_add.php',
		        	success: function(response)
		        	{
		        		var flag = true;
		        		var result = JSON.parse(response);
		        		for(var i in result)
		        		{
		        			if(result[i] != 1)
		        			{
		        				if(result['first'] == 3)
		        				{
		        					toastr.error('Такой номер зачетной книжки существует','Ошибка!');
		        					flag = false;
		        					break;
		        				}
		        				toastr.error('Проверьте правильность введенных данных','Ошибка!');
		        				flag = false;
		        				break;
		        			}
		        		}
		        		if(flag == true)
		        		{
		        			toastr.success('Успешно! Студент добавлен');
/*		        			$("#nrb").val("");
		        			$("#last_name").val("");
		        			$("#first_name").val("");
		        			$("#patronymic").val("");
		        			$("#group_1").val("");
		        			$("#topic").val("");
		        			$("#type_work").val("");
		        			$("#anti_plagiarism").val("");
		        			$("#supervisor").val("");*/
		        		}
		        	},
		        	error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
		    	});
		    	return false;
		    });
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
					<input type="file" id="file_blank" name="file_blank" accept='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel'>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>