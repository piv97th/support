<?php require('check_login_general.php'); ?>
<?php
	require('blocks/connect.php');

	function content_select($mode)
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

	<title>Выбор студента</title>

	<link href="scripts/toastr.css" rel="stylesheet">
	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/toastr.js"></script>

	<script type="text/javascript">

		$(function(){
			$("#btn_choice").on('click',function(){
				$(".add_content").children().remove();
				var mode_other = 2;
				var select = $("#slc").val();
				$.ajax({
					type: 'GET',
					url: 'handler_operator.php',
					data: {mode_other, select},
					async: false,
					success: function(response)
					{
						var obj = JSON.parse(response);
						$(obj).each(function(index, item) {
							$('.add_content').append('<li><a href=form_se.php?arr_1='+item.arr_1+'>'+(index+1)+' '+item.last_name +' '+item.first_name+' '+item.number_record_book+'</li></a>');
						});
			        }
			    });
			});
		});

	</script>

</head>


<body>

	<?php
	require_once('blocks/header.php');
	?>

	<div class="container" id="content">    
		<div class="row content">
			<div class="col-sm text-left"> 
				<div>
					Группа
					<select id="slc" name="slc">
						<option value="" disabled selected></option>
						<?php
							content_select($mode);
						?>
					</select>
					<button class="btn btn-primary" id="btn_choice">Выбрать</button>
					<form name="heh">
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