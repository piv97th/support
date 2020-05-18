<?php require('check_login_general.php'); ?>
<?php
	require('blocks/connect.php');

	function content_select($arr_1)
	{
		require('blocks/connect.php');

			$result = $conn->query('SELECT id, number_meeting, date FROM timetable_meeting WHERE id_commission_fk = (SELECT id FROM commission WHERE id IN (SELECT id_commission_fk FROM curation_event WHERE role = 3 AND id = (SELECT id_curevent_fk FROM user WHERE id = '.$arr_1.')))');
			while ($arr = $result->fetch_assoc())
			{
				echo'<option value='.$arr["id"].'>'.$arr["number_meeting"].' '.$arr["date"].'</option>';
			}
	}
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Выбор</title>

	<script type="text/javascript" src="scripts/disabled_link.js"></script>

	<script type="text/javascript">

		$(function(){
			$("#btn_choice").on('click',function(){
				$(".add_content").children().remove();
				var mode_other = 1;
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
							$('.add_content').append('<li><a href=form_diploma.php?arr_1='+item.arr_1+'>'+(index+1)+' '+item.last_name +' '+item.first_name+' '+item.number_record_book+'</li></a>');
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
	require_once('blocks/navbar.php');
	?>

	<div class="container" id="content">    
		<div class="row content">
			<div class="col-sm text-left"> 
				<div>
					<?php echo $name_choice; ?>
					<select id="slc" name="slc">
						<option value="" disabled selected></option>
						<?php
							content_select($row_uid["id"]);
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