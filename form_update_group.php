<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	$arr_1 = $_GET['arr_1'];
	check_get($arr_1);

	$qs_group = $conn->query('SELECT * FROM group_1 WHERE id = '.$arr_1);
	$arr_group = $qs_group->fetch_assoc();

	$result_cathedra = $conn->query('SELECT * FROM cathedra');
	$result_direction = $conn->query('SELECT * FROM direction');
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Обновить данные группы</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/jquery_cookies.js"></script>
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>


	<script type="text/javascript">

		$(window).ready(function() {
			$("#qualification option[value=<?php echo $arr_group['id_qualification_fk']; ?>]").attr("selected", "selected");
			$("#cathedra option[value=<?php echo $arr_group['id_cathedra_fk']; ?>]").attr("selected", "selected");
			$("#direction option[value=<?php echo $arr_group['id_direction_fk']; ?>]").attr("selected", "selected");
			$("#form_studying option[value=<?php echo $arr_group['id_form_studying_fk']; ?>]").attr("selected", "selected");
		});

		$(function(){
			$("form").on('submit',function(){
				var arr_1 = <?php echo $arr_group['id']; ?>;
				var mode_1 = 5;
				var cipher_group = $("#cipher_group").val();
		        var qualification = $("#qualification").val();
		        var cathedra = $("#cathedra").val();
		        var direction = $("#direction").val();
		        var form_studying = $("#form_studying").val();
		    	$.ajax({
		        	type: 'POST',
		        	url: 'handler_structure.php',
		        	data: {cipher_group, qualification, cathedra, direction, form_studying, arr_1, mode_1},
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
						if(arr['group'] == 0)
						{
							toastr.error('При записи','Ошибка!');
							flag = false;
						}
					}
					if(c == 1)
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
					if(c == 2)
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
					if(c == 3)
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
					if(c == 4)
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
					if(c == 5)
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
    			toastr.success('Успешно! Информация отредактирована');
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
					<legend>О группе</legend>
					<div class="form-group">
						<label for="cipher_group">Шифр:</label>
						<input type="text" class="form-control" id="cipher_group" name="cipher_group" value="<?php echo $arr_group['cipher_group']; ?>">
					</div>
					<div class="form-group">
						<label for="qualification">Квалификация:</label>
						<select class="form-control" id="qualification" name="qualification" >
							<option value="1">Бакалавр</option>
							<option value="2">Магистр</option>
							<option value="3">Специалист</option>
						</select>
					</div>
					<div class="form-group">
						<label for="cathedra">Кафедра:</label>
						<select class="form-control" id="cathedra" name="cathedra" >
							<?php
							while($arr_cathedra = $result_cathedra->fetch_assoc())
							{
								echo '<option value='.$arr_cathedra["id"].'>'.$arr_cathedra["abbreviation"].'</option>';
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="direction">Направление:</label>
						<select class="form-control" id="direction" name="direction" >
							<option value="" disabled selected></option>
							<?php
							while($arr_direction = $result_direction->fetch_assoc())
							{
								echo '<option value='.$arr_direction["id"].'>'.$arr_direction["cipher_direction"].' '.$arr_direction['name'].'</option>';
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="form_studying">Форма обучения:</label>
						<select class="form-control" id="form_studying" name="form_studying" >
							<option value="" disabled selected></option>
							<option value="1">очная</option>
							<option value="2">очно-заочная</option>
							<option value="3">заочная</option>
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