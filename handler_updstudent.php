<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	if(isset($_POST['se']))
	{
		$id = $_POST['arr_1_se'];
		$res_se = $conn->query('SELECT id, number_protocol, id_meeting_fk FROM se WHERE id ='.$id);
		$arr_se = $res_se->fetch_assoc();

		$json_1 = array('np_se' => $arr_se['number_protocol'], 'arr_1_meeting' => $arr_se['id_meeting_fk']);
		//$json_2 = array();

/*		$res_m = $conn->query('SELECT id, number_meeting FROM timetable_meeting');
		while($arr_m = $res_m->fetch_assoc())
		{
			$json_2[] = array('arr_1_meeting' => $arr_m['id'], 'nm' => $arr_m['number_meeting']);
			//echo 1;
		}*/

		//$json_1 = array('se_1' => array('np_se' => $arr_se['number_protocol'], 'arr_1_meeting' => $arr_se['id_meeting_fk']), 'm_se' => array('arr_1_meeting' => $arr_m['id'], 'nm' => $arr_m['number_meeting']));
		//$json_1 += $json2;
		echo json_encode($json_1);
		//echo json_encode($json_2);
	}

	if(isset($_POST['meeting_se']))
	{
		$json_2 = array();

		$res_m = $conn->query('SELECT id, number_meeting, date FROM timetable_meeting');
		while($arr_m = $res_m->fetch_assoc())
		{
			$json_2[] = array('arr_1_meeting' => $arr_m['id'], 'nm' => $arr_m['number_meeting'], 'date_se' => $arr_m['date']);
			//echo 1;
		}
		echo json_encode($json_2);
	}

	if(isset($_POST['ticket_se']))
	{
		$json_3 = array();

		$res_t = $conn->query('SELECT id, first_question FROM ticket');
		while($arr_t = $res_t->fetch_assoc())
		{
			$json_3[] = array('arr_1_ticket' => $arr_t['id'], 'fq' => $arr_t['first_question']);
			//echo 1;
		}
		echo json_encode($json_3);
	}

	if(isset($_POST['mark_se']))
	{
		$json_4 = array();

		$res_mk = $conn->query('SELECT id, mark FROM mark');
		while($arr_mk = $res_mk->fetch_assoc())
		{
			$json_4[] = array('arr_1_mark' => $arr_mk['id'], 'mark' => $arr_mk['mark']);
			//echo 1;
		}
		echo json_encode($json_4);
	}

	if(isset($_POST['meeting_diploma']))
	{
		$json_5 = array();

		$res_m = $conn->query('SELECT id, number_meeting, date FROM timetable_meeting');
		while($arr_m = $res_m->fetch_assoc())
		{
			$json_5[] = array('arr_1_meeting' => $arr_m['id'], 'nm' => $arr_m['number_meeting'], 'date_diploma' => $arr_m['date']);
			//echo 1;
		}
		echo json_encode($json_5);
	}

	if(isset($_POST['mark_diploma']))
	{
		$json_6 = array();

		$res_mk = $conn->query('SELECT id, mark FROM mark');
		while($arr_mk = $res_mk->fetch_assoc())
		{
			$json_6[] = array('arr_1_mark' => $arr_mk['id'], 'mark' => $arr_mk['mark']);
			//echo 1;
		}
		echo json_encode($json_6);
	}
?>