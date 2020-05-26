<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');

	function content_select()
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id, cipher_group FROM group_1');
		// WHERE id IN (SELECT id_group_fk FROM student WHERE id_diploma_fk IN (SELECT id FROM diploma WHERE id_mark_fk IS NOT NULL) AND id_se_fk IN (SELECT id FROM se WHERE id_mark_fk IS NOT NULL))
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

		function a_dell()
		{
			$(".nolink").on("click", function(e){
				var mode_1 = 3;
				var link = e.target;
				link = String(link);
				var arr_1 = link.substr(50,8);
				$.ajax({
					type: 'POST',
					url: 'handler_student.php',
					data: {arr_1, mode_1},
					async: false,
					success: function(response)
					{
		        		var result = JSON.parse(response);
		        		outToast(result);
		        		$("#btn_choice").trigger("click");
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
			$("#slc").on('change',function(){
				//$("#slc").children().remove();
				var mode_other = 1;
				var select = $("#slc").val();
				$.ajax({
					type: 'POST',
					url: 'handler_document.php',
					data: {mode_other, select},
					async: false,
					success: function(response)
					{
						var obj = JSON.parse(response);
						$('#slc').after('<div id="change_block"><select id="student"><option value="" disabled selected></option></select></div>');
						$(obj).each(function(index, item) {
							$('#student').append('<option value='+item.arr_1+'>'+item.number_record_book+' '+item.last_name+' '+item.first_name+'</option>');
						});
			        }
			    });
			});
		});

		$(function(){
			$("#btn_student").on('click',function(){
				var mode_other = 2;
				var arr_1 = $("#student").val();
				alert(arr_1);
				$.ajax({
					type: 'POST',
					url: 'handler_document.php',
					data: {mode_other, arr_1},
					async: false,
					success: function(response)
					{
						alert(response);
						var obj = JSON.parse(response);
						$('#student').after('<select id="document"><option value="" disabled selected></option></select>');
						/*for(var i in obj)
						{*/
							if(obj['reference'] == 1)
							{
								$('#document').append('<option value='+obj.reference+'>справка</option>');
							}
							if(obj['conclusion'] == 2)
							{
								$('#document').append('<option value='+obj.conclusion+'>Заключение</option>');
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
			        }
				});
			});
		});

		$(function(){
			$("#btn_document").on('click',function(){
				//$("#slc").children().remove();
				var mode_1 = 1;
				var select = $("#document").val();
				$.ajax({
					type: 'POST',
					url: 'handler_document.php',
					data: {mode_other, select},
					async: false,
					success: function(response)
					{
						alert(response);
						/*var obj = JSON.parse(response);
						$('#slc').after('<div id="change_block"><select id="student"><option value="" disabled selected></option></select></div>');
						$(obj).each(function(index, item) {
							$('#student').append('<option value='+item.arr_1+'>'+item.number_record_book+' '+item.last_name+' '+item.first_name+'</option>');
						});*/
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
					Выбор группы
					<select id="slc" name="slc">
						<option value="" disabled selected></option>
						<?php
							content_select();
						?>
					</select>
					<button class="btn btn-primary" id="btn_student">Выбрать студента</button>
					<button class="btn btn-primary" id="btn_document">Выбрать документ</button>
					<!-- <form name="heh">
						<div id="content">
							<ul class="add_content">
							</ul>
						</div>
					</form> -->
				</div>
			</div>
		</div>
	</div>

	<?php require_once('blocks/footer.php'); ?>

</body>
</html>