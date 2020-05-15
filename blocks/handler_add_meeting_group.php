<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php')

	if($_POST['mode_other'] == 1)
	{
		$mode_other = $_POST['mode_other'];
		check_get($mode_other);

		$commission = $_POST['commission'];
		check_get($commission);

		$result_meeting = $conn->query('SELECT id, number_meeting, date FROM timetable_meeting ')
	}

?>