<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	if($_POST['mode_1'] == 1)
	{
		$mode_1 = $_POST['mode_1'];
		check_get($mode_1);

		require_once('user_classes/class_inanimate.php');
		require_once('user_classes/class_question.php');
		require_once('user_classes/class_man.php');

		$se = new se();
		$q = new question();
		$student = new student();
		//echo $_POST['arr_1_group'];
		$result = array('arr_1_meeting' => $se->check_meeting($_POST['arr_1_meeting']), 'ticket' => $se->check_ticket($_POST['ticket']), 'mark' => $se->check_mark($_POST['mark']), 'arr_1_group' => $se->check_group_other($_POST['arr_1_group']));
		$result += ['members_ssk' => $q->check_arr_members($_POST['members_ssk']), 'questions' => $q->check_arr_questions($_POST['questions'])];
		$result += ['arr_1_student' => $student->check_arr_1($_POST['arr_1_student'])];
		check_result($result);

		$result_se = $se->make_add_se();
		$result = array('se' => $result_se);
		check_result($result);

		$student->se = $se->get_id_se();

		$result_student = $student->insert_se();
		$result = array('student' => $result_student);
		check_result($result);

		$q->se = $se->get_id_se();

		$result_questions = $q->add_questions_se();
		$result = array('questions' => $result_questions);

		echo json_encode($result);
        exit;

	}

	if($_POST['mode_other'] == 1)
	{
		$mode_other = $_POST['mode_other'];
		check_get($mode_other);

		$arr_1_meeting = $_POST['arr_1_meeting'];
		check_get($arr_1_meeting);

		$result_member_ssk = $conn->query('SELECT member_ssk.id as id, member_ssk.last_name as last_name, member_ssk.first_name as first_name, member_ssk.patronymic as patronymic, member_ssk.post as post FROM curation_event JOIN commission ON commission.id=curation_event.id_commission_fk JOIN member_ssk ON member_ssk.id=curation_event.id_member_ssk_fk WHERE curation_event.id_commission_fk = (SELECT id_commission_fk FROM timetable_meeting WHERE id = '.$arr_1_meeting.')');
		while($arr = $result_member_ssk->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name'], 'patronymic' => $arr['patronymic'], 'post' => $arr['post']);
		}
		echo json_encode($arr_new);
        exit;
	}

	if($_POST['mode_other'] == 2)
	{
		$mode_other = $_POST['mode_other'];
		check_get($mode_other);

		$arr_1_meeting = $_POST['arr_1_meeting'];
		check_get($arr_1_meeting);

		$result_member_ssk = $conn->query('SELECT member_ssk.id as id, member_ssk.last_name as last_name, member_ssk.first_name as first_name, member_ssk.patronymic as patronymic, member_ssk.post as post FROM curation_event JOIN commission ON commission.id=curation_event.id_commission_fk JOIN member_ssk ON member_ssk.id=curation_event.id_member_ssk_fk WHERE curation_event.id_commission_fk = (SELECT id_commission_fk FROM timetable_meeting WHERE id = '.$arr_1_meeting.')');
		while($arr = $result_member_ssk->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name'], 'patronymic' => $arr['patronymic'], 'post' => $arr['post']);
		}
		echo json_encode($arr_new);
        exit;
	}

?>