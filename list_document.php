<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');

	function content_select()
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id, cipher_group FROM group_1');
		while ($arr = $result->fetch_assoc())
		{
			echo'<option value='.$arr["id"].'>'.$arr["cipher_group"].'</option>';
		}
	}
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Подготовить документы</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>

	<script type="text/javascript">

		$(function(){
			$("#slc").on('change',function(){
				$("#student").remove();
				$("#document").remove();
				var mode_other = 1;
				var select = $("#slc").val();
				$.ajax({
					type: 'POST',
					url: 'handler_document.php',
					data: {mode_other, select},
					async: false,
					success: function(response)
					{
						alert(response);
						var obj = JSON.parse(response);
						$('#slc').after('<div class="form-group"><label for="student">Студент:</label><select id="student" class="new_student form-control"><option value="" disabled selected></option></select></div>');
						$(obj).each(function(index, item) {
							$('#student').append('<option value='+item.arr_1+'>'+item.number_record_book+' '+item.last_name+' '+item.first_name+'</option>');
						});
			        }
			    });
			});
		});

		$(function(){
			$("body").on('change','.new_student',function(){
				$("#document").remove();
				var mode_other = 2;
				var arr_1 = $("#student").val();
				$('#arr_1_student').val(arr_1);
				$.ajax({
					type: 'POST',
					url: 'handler_document.php',
					data: {mode_other, arr_1},
					async: false,
					success: function(response)
					{
						var obj = JSON.parse(response);
						$('#student').after('<div class="form-group"><label for="document">Документ:</label><select id="document" class="form-control new_doc" ><option value="" disabled selected></option></select></div>');
						/*for(var i in obj)
						{*/
						if(obj['reference'] == 1)
						{
							$('#document').append('<option value='+obj.reference+'>справка</option>');
						}
						if(obj['conclusion'] == 2)
						{
							$('#document').append('<option value='+obj.conclusion+'>заключение</option>');
						}
						if(obj['protocol_se'] == 3)
						{
							$('#document').append('<option value='+obj.protocol_se+'>протокол ГЭ</option>');
						}
						if(obj['protocol_diploma'] == 4)
						{
							$('#document').append('<option value='+obj.protocol_diploma+'>протокол ВКР</option>');
						}
						if(obj['protocol_certification'] == 5)
						{
							$('#document').append('<option value='+obj.protocol_certification+'>протокол аттестации</option>');
						}
						if(obj['private_file'] == 6)
						{
							$('#document').append('<option value='+obj.private_file+'>личное дело</option>');
						}
						$('#document').after('<br/><button type="submit" class="btn btn-primary">Сформировать</button>');

			        }
				});
			});
		});

		$(function(){
			$("body").on('change','.new_doc',function(){
				$("#doc").val( $("#document").val());
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
				<form action="handler_document.php" method="POST">
					<legend>Сформировать документ</legend>
					<div class="form-group">
						<select class="form-control" id="slc" name="slc">
							<option value="" disabled selected></option>
							<?php
								content_select();
							?>
						</select>
					<input type="hidden" name="doc" id="doc">
					<input type="hidden" name="arr_1_student" id="arr_1_student">
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>