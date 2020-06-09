<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	function check_result_1($arr)
	{
		foreach($arr as $key => $i)
		{
			//if($i != 1 || !in_array("data", $arr))
			if($i == 1 || $key == "data")
			{
				if($key == "data")
				{
					foreach($i as $j)
					{
						if($j != 1)
						{
							echo json_encode($arr);
							exit;
						}
					}
				}
			}
			else
			{
				echo json_encode($arr);
				exit;
			}
		}
	}

	$mode_1 = $_POST['mode_1'];

	if($mode_1 == 1)
	{
		require_once('user_classes/class_structure.php');
		$direction = new direction();

		$result = array('cipher_direction' => $direction->check_cipher($_POST['cipher_direction']), 'name_cipher' => $direction->check_name($_POST['name_cipher']), 'qualification' => $direction->check_qualification($_POST['qualification']));
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

		$result = array('arr_1' => $direction->check_arr_1($_POST['arr_1']), 'cipher_direction' => $direction->check_cipher_u($_POST['cipher_direction']), 'name_cipher' => $direction->check_name($_POST['name_cipher']), $direction->check_qualification($_POST['qualification']));
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

		$result = array('cipher_group' => $group->check_cipher_group($_POST['cipher_group']), 'cathedra' => $group->check_cathedra($_POST['cathedra']), 'direction' => $group->check_direction($_POST['direction']), 'form_studying' => $group->check_fs($_POST['form_studying']));
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

		$result = array('arr_1' => $group->check_arr_1($_POST['arr_1']), 'cipher_group' => $group->check_cipher_group_u($_POST['cipher_group']), 'cathedra' => $group->check_cathedra($_POST['cathedra']), 'direction' => $group->check_direction($_POST['direction']), 'form_studying' => $group->check_fs($_POST['form_studying']));

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

		$result = array('number_commission' => $commission->check_number_commission($_POST['number_commission']), 'order_1' => $commission->check_order_1($_POST['order_1']));
		check_result_1($result);

		//проверяется, сортируется дата и пишется дата, группа и тип ГИА в класс и БД
		$result += ['data' => $meeting->check_arr_mixed($_POST['arr_mixed'])];
		check_result_1($result);


		$result_commission = $commission->add_commission();
		$result = array('commission' => $result_commission);
		check_result_1($result);

		$meeting->commission_fk = $commission->get_commission_fk();

		$result_meeting = $meeting->add_meeting();
		$result += ['meeting' => $result_meeting];
		check_result_1($result);

		$result_group = $meeting->add_meeting_to_group();
		$result += ['meeting_to_group' => $result_group];

		echo json_encode($result);
        exit;
	}

	if($mode_1 == 8)
	{
		require_once('user_classes/class_structure.php');
		$commission = new commission();
		$meeting = new meeting();

		$result = array('arr_1' => $commission->check_arr_1($_POST['arr_1']),'number_commission' => $commission->check_number_commission_u($_POST['number_commission']), 'order_1' => $commission->check_order_1($_POST['order_1']));
		check_result_1($result);

		$result += ['data' => $meeting->check_arr_mixed($_POST['arr_mixed'])];
		check_result_1($result);

		$meeting->commission_fk = $commission->get_commission_fk();
		$result_setnull_group = $meeting->setnull_group();
		$result = array('meeting' => $result_setnull_group);
		check_result($result);

		/*require_once('user_classes/class_structure.php');
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
		$result += ['commission' => $result_commission];*/

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
		$result_meeting = $meeting->delete_meeting();
		$result = array('meeting' => $result_meeting);
		check_result($result);

		$result_commission = $commission->delete_commission();
		$result = array('commission' => $result_commission);
		echo json_encode($result);
        exit;
	}

	if($_POST['mode_other'] == 1)
	{
		$result_direction = $conn->query('SELECT direction.*, qualification.id as `qualification_id`, qualification.name as `qualification_name` FROM direction INNER JOIN qualification ON direction.id_qualification_fk = qualification.id');
		while($arr = $result_direction->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'cipher_direction' => $arr['cipher_direction'], 'name' => $arr['name'], 'qualification_name' => $arr['qualification_name']);
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
		$result_commission = $conn->query('SELECT id, number FROM commission');
		while($arr = $result_commission->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'number' => $arr['number']);
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

	if($_POST['mode_other'] == 6)
	{
		$result_group = $conn->query('SELECT id, cipher_group FROM group_1 WHERE id_meeting_se_fk IS NULL AND id_meeting_diploma_fk IS NULL');
		while($arr = $result_group->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'cipher_group' => $arr['cipher_group']);
		}
		echo json_encode($arr_new);
        exit;
	}

	if($_POST['mode_other'] == 7)
	{
		$commission = $_POST['commission'];
		$result_group = $conn->query('SELECT COUNT(group_1.id) as `count` FROM group_1 INNER JOIN timetable_meeting ON group_1.id_meeting_se_fk = timetable_meeting.id OR group_1.id_meeting_diploma_fk = timetable_meeting.id WHERE id_commission_fk = (SELECT id FROM commission WHERE id = '.$commission.')');
		$c = $result_group->fetch_assoc()['count'];
		echo $c;
        exit;
	}

	if($_POST['mode_other'] == 8)
	{
		$result_group = $conn->query('SELECT id, cipher_group FROM group_1');
		while($arr = $result_group->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'cipher_group' => $arr['cipher_group']);
		}
		echo json_encode($arr_new);
        exit;
	}

	if($_POST['mode_other'] == 9)
	{
		$commission = $_POST['commission'];
		$qs_grp_tmtm = $conn->query('SELECT group_1.id as `id_group`, group_1.cipher_group, timetable_meeting.id, timetable_meeting.number_meeting, timetable_meeting.type_meeting, timetable_meeting.date FROM group_1 INNER JOIN timetable_meeting ON group_1.id_meeting_se_fk = timetable_meeting.id OR group_1.id_meeting_diploma_fk = timetable_meeting.id WHERE id_commission_fk = (SELECT id FROM commission WHERE id = '.$commission.')');
		while($arr_qs_gt = $qs_grp_tmtm->fetch_assoc())
		{
			$arr_qs_gt_new[] = array('arr_1_group' => $arr_qs_gt['id_group'], 'cipher_group' => $arr_qs_gt['cipher_group'], 'arr_1' => $arr_qs_gt['id'], 'number_meeting' => $arr_qs_gt['number_meeting'], 'type_meeting' => $arr_qs_gt['type_meeting'], 'date' => $arr_qs_gt['date']);
		}
		echo json_encode($arr_qs_gt_new);
        exit;
	}

?>