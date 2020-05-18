<?php require('check_login_general.php'); ?>
<?php
	require('blocks/connect.php');

	$mode_other = $_GET['mode_other'];
	$select = $_GET['select'];
	if($mode_other == 1 && (0 < $select && $select < 1000))
	{
		$result = $conn->query('SELECT id, number_record_book, last_name, first_name FROM student WHERE id_diploma_fk IN (SELECT id FROM diploma WHERE id_meeting_fk = '.$select.' AND id_mark_fk IS NULL)') or die($conn->error);
		while($arr = $result->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'number_record_book' => $arr['number_record_book'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name']);
		}
	}

	if($mode_other == 2 && (0 < $select && $select < 1000))
	{
		$result = $conn->query('SELECT id, number_record_book, last_name, first_name FROM student WHERE id_se_fk IS NULL AND id_group_fk = '.$select) or die($conn->error);
		while($arr = $result->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'number_record_book' => $arr['number_record_book'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name']);
		}
	}

	echo json_encode($arr_new);
?>