<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	$mode_1 = $_POST['mode_1'];
	check_get($mode_1);

	if(isset($_POST['fq']) && $mode_1 == 1)
	{
		require_once('user_classes/class_ticket.php');

		$ticket = new ticket();

		$result = array('fq' => $ticket->check_question_first($_POST['fq']), 'sq' => $ticket->check_question_second($_POST['sq']), 'tq' => $ticket->check_question_third($_POST['tq']));
		check_result($result);

		$result_ticket = $ticket->add_ticket();
		$result = array('ticket' => $result_ticket);
		echo json_encode($result);
        exit;
	}
?>