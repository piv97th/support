<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	if($_POST['mode_1'] == 1)
	{

		require_once('user_classes/class_curation_events.php');
		$add = new e_commission_member();

		$result = array('arr_member_ssk' => $add->check_arr_member($_POST['members_ssk']), 'arr_role' => $add->check_arr_role($_POST['roles']), 'arr_1_commission' => $add->check_arr_1_com($_POST['commission']));
		check_result($result);

		$result_add = $add->add_commission_member();
		$result = array('add' => $result_add);
		check_result($result);

		echo json_encode($result);
        exit;
	}

	if($_GET['mode_1'] == 3)
	{

		require_once('user_classes/class_curation_events.php');
		$del = new e_commission_member();

		$result = array('arr_1_commission' => $del->check_arr_1_com($_GET['commission']));
		check_result($result);

		$result_del = $del->del_commission_member();
		$result = array('del' => $result_del);
		check_result($result);

		echo json_encode($result);
        exit;
	}

	if($_POST['mode_other'] == 1)
	{
		$result_member = $conn->query('SELECT id, last_name, first_name, patronymic, post FROM member_ssk');
		while($arr_member = $result_member->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr_member['id'], 'last_name' => $arr_member['last_name'], 'first_name' => $arr_member['first_name'], 'patronymic' => $arr_member['patronymic'], 'post' => $arr_member['post']);
		}

		echo json_encode($arr_new);
		exit();
	}
?>