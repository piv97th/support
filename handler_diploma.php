<?php require('check_login_general.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	if($_POST['mode_1'] == 1)
	{
		$mode_1 = $_POST['mode_1'];
		check_get($mode_1);

		require_once('user_classes/class_inanimate.php');
		require_once('user_classes/class_question.php');

		$diploma = new diploma();
		$q = new question();

		$result = array('arr_1' => $diploma->check_arr_1($_POST['arr_1']), 'mark' => $diploma->check_mark($_POST['mark']));

		$result += ['members_ssk' => $q->check_arr_members($_POST['members_ssk']), 'questions' => $q->check_arr_questions($_POST['questions'])];
		check_result($result);
		$q->diploma = $diploma->get_id_diploma();

		$result_diploma = $diploma->make_add_diploma();
		$result = array('diploma' => $result_diploma);
		check_result($result);

		$result_questions = $q->add_questions();
		$result = array('questions' => $result_questions);

		echo json_encode($result);
        exit;

	}

	if($_POST['mode_other'] == 1)
	{
		$mode_other = $_POST['mode_other'];
		check_get($mode_other);

		$arr_1_group = $_POST['arr_1_group'];
		check_get($arr_1_group);

		$result_member_ssk = $conn->query('SELECT member_ssk.id, member_ssk.last_name, member_ssk.first_name, member_ssk.patronymic, member_ssk.post FROM member_ssk INNER JOIN curation_event ON member_ssk.id=curation_event.id_member_ssk_fk JOIN commission ON curation_event.id_commission_fk = commission.id WHERE commission.id IN (SELECT id_commission_fk FROM timetable_meeting WHERE id IN (SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_1_group.')) AND curation_event.role <> 3 ');
		while($arr = $result_member_ssk->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name'], 'patronymic' => $arr['patronymic'], 'post' => $arr['post']);
		}
		echo json_encode($arr_new);
        exit;
	}

?>