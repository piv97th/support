<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	if(isset($_POST['se']))
	{
		$id = $_POST['arr_1_se'];
		$res_se = $conn->query('SELECT id, number_protocol FROM se WHERE id ='.$id);
		$arr_se = $res_se->fetch_assoc();

		$json_1 = array('np_se' => $arr_se['number_protocol']);

		echo json_encode($json_1);
	}

	if(isset($_POST['ticket_se']))
	{
		$json_3 = array();

		$res_t = $conn->query('SELECT id, first_question FROM ticket');
		while($arr_t = $res_t->fetch_assoc())
		{
			$json_3[] = array('arr_1_ticket' => $arr_t['id'], 'fq' => $arr_t['first_question']);
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
		}
		echo json_encode($json_4);
	}

	if(isset($_POST['mark_diploma']))
	{
		$json_6 = array();

		$res_mk = $conn->query('SELECT id, mark FROM mark');
		while($arr_mk = $res_mk->fetch_assoc())
		{
			$json_6[] = array('arr_1_mark' => $arr_mk['id'], 'mark' => $arr_mk['mark']);
		}
		echo json_encode($json_6);
	}
?>