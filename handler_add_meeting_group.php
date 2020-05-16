<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	if($_POST['mode_1'] == 1)
	{
		echo "again ajax";
		//UPDATE diploma SET id_meeting_fk = 45 WHERE id IN (SELECT id_diploma_fk FROM student WHERE id_group_fk = 10)

		require_once('user_classes/class_curation_events.php');
		$add = new e_add_meeting_group();

		$result = array('arrs_1_meeting' => $add->check_arr_meeting($_POST['arrs_1_meeting']), 'arrs_date' => $add->check_arr_date($_POST['arrs_date']), 'arr_group' => $add->check_arr_group($_POST['arr_group']));
		check_result($result);

		$result_add = $add->add_meeting_group();
		$result = array('add' => $result_add);
		check_result($result);

		echo json_encode($result);
        exit;
	}

	if($_GET['mode_other'] == 1)
	{

		$commission = $_GET['commission'];
		check_get($commission);

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
		echo json_encode($arr_new);
		exit();
	}
?>