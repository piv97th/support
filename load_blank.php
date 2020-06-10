<?php require('check_login.php'); ?>
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
			$("form").on('submit',function(e){
				e.stopPropagation();
				e.preventDefault(); 
				var file_blank = new FormData(this);
		        $.ajax({
		        	type: 'POST',
					processData: false,
					contentType: false,
					cache:false,
		        	url: 'handler_excel_add.php',
					data: file_blank,
		        	success: function(response)
		        	{
		        		//alert(response);
		        		var result = JSON.parse(response);
		        		out_toast(result);
		        	},
		        	error: function(jqxhr, status, errorMsg)
		        	{
		        		toastr.error(errorMsg, status);
		        	}
		    	});
		    	return false;
		    });
		});

		function out_toast(arr)
		{
			//alert(2);
			var flag = true;
			var c = 0;
			for(var i in arr)
			{
				if(arr[i] != 1)
				{
					if(c == 0)
					{
						if(arr['file'] == 0)
						{
							toastr.error('Файл не загружен','Ошибка!');
							flag = false;
						}
						if(arr['file'] == 2)
						{
							toastr.error('Слишком большой размер файла','Ошибка!');
							flag = false;
						}
						if(arr['file'] == 4)
						{
							toastr.error('Тип файла не подходит','Ошибка!');
							flag = false;
						}
						if(arr['file'] == 5)
						{
							toastr.error('Ошибка','Ошибка!');
							flag = false;
						}
						if(arr['last_use_row'] == 0)
						{
							toastr.error('Строка','Ошибка!');
							flag = false;
						}
						if(arr['сell'] == 0)
						{
							toastr.error('Одна из ячеек пуста','Ошибка!');
							flag = false;
						}
						if(arr['сell0'] == 2)
						{
							toastr.error('Проверьте столбец НЗК','Ошибка!');
							flag = false;
						}
						if(arr['сell0'] == 3)
						{
							toastr.error('Такой НЗК существует','Ошибка!');
							flag = false;
						}
						if(arr['сellname'] == 2)
						{
							toastr.error('Проверьте столбец c ФИО','Ошибка!');
							flag = false;
						}
						if(arr['сelltopic'] == 2)
						{
							toastr.error('Проверьте столбец c темой','Ошибка!');
							flag = false;
						}
						if(arr['сell5'] == 2)
						{
							toastr.error('Проверьте столбец с типом работы','Ошибка!');
							flag = false;
						}
						if(arr['supervisor'] == 6)
						{
							toastr.error('Не найден руководитель','Ошибка!');
							flag = false;
						}
						if(arr['diploma'] == 0)
						{
							toastr.error('При записи в БД','Ошибка!');
							flag = false;
						}
						if(arr['student'] == 0)
						{
							toastr.error('При записи в БД','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
					{
						if(arr['last_use_column'] == 0)
						{
							toastr.error('Столбец','Ошибка!');
							flag = false;
						}
					}
					if(c == 2)
					{
						if(arr['last_use_column_index'] == 0)
						{
							toastr.error('Индекс столбца','Ошибка!');
							flag = false;
						}
					}
					if(c == 3)
					{
						if(arr['group_1'] == 0)
						{
							toastr.error('Введите группу','Ошибка!');
							flag = false;
						}
						if(arr['group_1'] == 2)
						{
							toastr.error('Группа не соответствует шаблону','Ошибка!');
							flag = false;
						}
						if(arr['group_1'] == 3)
						{
							toastr.error('Нет такой группы','Ошибка!');
							flag = false;
						}
					}
		        }
		        c = c+1;
		    }
    		if(flag == true)
    		{
    			toastr.success('Успешно! Студенты добавлен');
    		}
    		/*else
    		{
    			toastr.error('Проверьте данные','Ошибка!');
    		}*/
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
					<legend>Загрузить бланк для добавления</legend>
					<input type="file" id="file_blank" name="file_blank" accept='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel'>
					<button type="submit" class="btn btn-primary">Загрузить</button>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>