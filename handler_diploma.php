<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

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

?>