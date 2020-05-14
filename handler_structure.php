<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');
	$mode_1 = $_POST['mode_1'];
	if($mode_1 == 1)
	{
		require_once('user_classes/class_structure.php');
		$direction = new direction();

		$result = array('cipher_direction' => $direction->check_cipher($_POST['cipher_direction']), 'name_cipher' => $direction->check_name($_POST['name_cipher']));
		check_result($result);

		$result_direction = $direction->add_direction();
		$result = array('direction' => $result_direction);
		echo json_encode($result);
        exit;
	}

	if($mode_1 == 2)
	{
		require_once('user_classes/class_structure.php');
		$direction = new direction();

		$result = array('arr_1' => $direction->check_arr_1($_POST['arr_1']), 'cipher_direction' => $direction->check_cipher_u($_POST['cipher_direction']), 'name_cipher' => $direction->check_name($_POST['name_cipher']));
		check_result($result);

		$result_direction = $direction->update_direction();
		$result = array('direction' => $result_direction);
		echo json_encode($result);
        exit;
	}

	if($mode_1 == 3)
	{
		require_once('user_classes/class_structure.php');
		$direction = new direction();

		$result = array('arr_1' => $direction->check_arr_1($_POST['arr_1']));
		check_result($result);

		$result_direction = $direction->delete_direction();
		$result = array('direction' => $result_direction);
		echo json_encode($result);
        exit;
	}

	if($mode_1 == 4)
	{
		require_once('user_classes/class_structure.php');
		$group = new group();

		$result = array('cipher_group' => $group->check_cipher_group($_POST['cipher_group']), 'qualification' => $group->check_qualification($_POST['qualification']), 'cathedra' => $group->check_cathedra($_POST['cathedra']), 'direction' => $group->check_direction($_POST['direction']), 'form_studying' => $group->check_fs($_POST['form_studying']));
		check_result($result);

		$result_group = $group->add_group();
		$result = array('group' => $result_group);
		echo json_encode($result);
        exit;
	}

	if($mode_1 == 5)
	{
		require_once('user_classes/class_structure.php');
		$group = new group();

		$result = array('arr_1' => $group->check_arr_1($_POST['arr_1']), 'cipher_group' => $group->check_cipher_group_u($_POST['cipher_group']), 'qualification' => $group->check_qualification($_POST['qualification']), 'cathedra' => $group->check_cathedra($_POST['cathedra']), 'direction' => $group->check_direction($_POST['direction']), 'form_studying' => $group->check_fs($_POST['form_studying']));

		$result_group = $group->update_group();
		$result = array('group' => $result_group);
		echo json_encode($result);
        exit;
	}

	if($mode_1 == 6)
	{
		require_once('user_classes/class_structure.php');
		$group = new group();

		$result = array('arr_1' => $group->check_arr_1($_POST['arr_1']));
		check_result($result);

		$result_group = $group->delete_group();
		$result = array('group' => $result_group);
		echo json_encode($result);
        exit;
	}

	if($mode_1 == 7)
	{
		require_once('user_classes/class_structure.php');
		$commission = new commission();
		$meeting = new meeting();

		$result = array('order_1' => $commission->check_order_1($_POST['order_1']));

		$result += ['date' => $meeting->check_date($_POST['arr_date'])];
		check_result($result);

		$result_commission = $commission->add_commission();
		$result = array('commission' => $result_commission);
		check_result($result);

		$meeting->commission_fk = $commission->get_commission_fk();
		$result_meeting = $meeting->update_meeting();
		$result += ['meeting' => $result_meeting];

		echo json_encode($result);
        exit;
	}

	if($mode_1 == 8)
	{
		require_once('user_classes/class_structure.php');
		$commission = new commission();
		$meeting = new meeting();

		$result = array('arr_1' => $commission->check_arr_1($_POST['arr_1_commission']), 'order_1' => $commission->check_order_1($_POST['order_1']));

		$result += ['date' => $meeting->check_date($_POST['arr_date'])];
		check_result($result);

		$meeting->commission_fk = $commission->get_commission_fk();
		$result_meeting = $meeting->update_meeting();
		$result = array('meeting' => $result_meeting);
		check_result($result);

		$result_commission = $commission->update_commission();
		$result += ['commission' => $result_commission];

		echo json_encode($result);
        exit;
	}

	if($mode_1 == 9)
	{
		require_once('user_classes/class_structure.php');
		$commission = new commission();
		$meeting = new meeting();

		$result = array('arr_1' => $commission->check_arr_1($_POST['arr_1']));
		check_result($result);
		$meeting->commission_fk = $commission->get_commission_fk();
		if($meeting->is_commission() == 1)
		{
			$result_meeting = $meeting->delete_meeting();
			$result = array('meeting' => $result_meeting);
			check_result($result);
		}

		$result_commission = $commission->delete_commission();
		$result = array('commission' => $result_commission);
		echo json_encode($result);
        exit;
	}

	if($_POST['mode_other'] == 1)
	{
		$result_direction = $conn->query('SELECT * FROM direction');
		while($arr = $result_direction->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'cipher_direction' => $arr['cipher_direction'], 'name' => $arr['name']);
		}
		echo json_encode($arr_new);
        exit;
	}

	if($_POST['mode_other'] == 2)
	{
		$result_group = $conn->query('SELECT id, cipher_group FROM group_1');
		while($arr = $result_group->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'cipher_group' => $arr['cipher_group']);
		}
		echo json_encode($arr_new);
        exit;
	}

	if($_POST['mode_other'] == 3)
	{
		$result_commission = $conn->query('SELECT id, order_1 FROM commission');
		while($arr = $result_commission->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'order_1' => $arr['order_1']);
		}
		echo json_encode($arr_new);
        exit;
	}

	if($_POST['mode_other'] == 4)
	{
		$result_supervisor = $conn->query('SELECT id, cipher_teacher, last_name, first_name FROM teacher');
		while($arr = $result_supervisor->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'cipher_supervisor' => $arr['cipher_teacher'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name']);
		}
		echo json_encode($arr_new);
        exit;
	}

	if($_POST['mode_other'] == 5)
	{
		$result_member_ssk = $conn->query('SELECT id, last_name, first_name, post FROM member_ssk');
		while($arr = $result_member_ssk->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name'], 'post' => $arr['post']);
		}
		echo json_encode($arr_new);
        exit;
	}

?>