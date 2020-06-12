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
				$("#block_student").remove();
				$("#block_document").remove();
				$(".sub").remove();
				$("#block_honours").remove();
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
						$('#slc').after('<div class="form-group" id="block_student"><label for="student">Студент:</label><select id="student" class="new_student form-control"><option value="" disabled selected></option></select></div>');
						$(obj).each(function(index, item) {
							$('#student').append('<option value='+item.arr_1+'>'+item.number_record_book+' '+item.last_name+' '+item.first_name+'</option>');
						});
			        }
			    });
			});
		});

		$(function(){
			$("body").on('change','.new_student',function(){
				$("#block_document").remove();
				$("#block_honours").remove();
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
						$('#student').after('<div class="form-group" id="block_document"><label for="document">Документ:</label><select id="document" class="form-control new_doc" ><option value="" disabled selected></option></select></div>');
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
						$('#document').after('<br/><button type="submit" class="btn btn-primary sub">Сформировать</button>');

			        }
				});
			});
		});

		$(function(){
			$("body").on('change','.new_doc',function(){
				$("#doc").val( $("#document").val());
				if($("#doc").val() == 5)
				{
					$('.sub').before('<div class="form-group" id="block_honours"><label for="honours">С отличием:</label><input type="checkbox" class="form-control honours" name="honours" value=1></option></select></div>');
				}
			});
		});

		$(function(){
			$("form").on('submit',function(){
				if(1 <= $("#doc").val() && $("#doc").val() <= 6)
				{
					return true;
				}
				else
				{
					toastr.error('Выберете документ','Ошибка!');
					return false;
				}
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