<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	if($_GET['mode_other'] == 1)
	{
		/*$mode_other = $_POST['mode_other'];
		check_get($mode_other);*/
		//UPDATE diploma SET id_meeting_fk = 45 WHERE id IN (SELECT id_diploma_fk FROM student WHERE id_group_fk = 10)

		$commission = $_GET['commission'];
		check_get($commission);
		//echo $commission;

		$result_group = $conn->query('SELECT id, cipher_group FROM group_1') or die($conn->error);
		while($arr_group = $result_group->fetch_assoc())
		{
			$arr_new_group[] = array('arr_1' => $arr_group['id'], 'cipher_group' => $arr_group['cipher_group']);
		}

		$result_meeting = $conn->query('SELECT id, number_meeting, date FROM timetable_meeting WHERE id_commission_fk = '.$commission) or die($conn->error);
		while($arr_meeting = $result_meeting->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr_meeting['id'], 'number_meeting' => $arr_meeting['number_meeting'], 'date' => $arr_meeting['date'], 'arr_group' => $arr_new_group);
		}
		//echo "string";
		echo json_encode($arr_new);
		exit();
	}
?>