<?php require('check_login_general.php'); ?>
<?php
	require('blocks/connect.php');

	function content_select($arr_1)
	{
		require('blocks/connect.php');

			$result = $conn->query('SELECT timetable_meeting.*, group_1.id as `id_group`, group_1.cipher_group FROM timetable_meeting INNER JOIN group_1 ON timetable_meeting.id = group_1.id_meeting_diploma_fk WHERE timetable_meeting.id_commission_fk IN (SELECT id FROM commission WHERE id IN (SELECT id_commission_fk FROM curation_event WHERE id IN (SELECT id_curevent_fk FROM user WHERE id = '.$arr_1.')))');
			while ($arr = $result->fetch_assoc())
			{
				echo'<option value='.$arr["id"].'>Номер заседания: '.$arr["number_meeting"].' Дата: '.$arr["date"].' Группа: '.$arr["cipher_group"].'</option>';
			}
	}
?>

<!DOCTYPE html>
<html>

<head>

	<?php require_once('blocks/head.php'); ?>

	<title>Выбор</title>

	<style>
		footer
		{
		    bottom: 0;
			position: fixed;
		}
	</style>

	<script type="text/javascript" src="scripts/disabled_link.js"></script>
	<script type="text/javascript" src="scripts/logout.js"></script>

	<script type="text/javascript">

		$(function(){
			$("#slc").on('change',function(){
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
	require_once('blocks/navbar_operator.php');
	?>

	<div class="container" id="content">    
		<div class="row content">
			<div class="col-sm text-left"> 
				<div>
					<legend>Защита ВКР</legend>
					Заседание
					<select id="slc" name="slc">
						<option value="" disabled selected></option>
						<?php
							content_select($row_uid["id"]);
						?>
					</select>
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