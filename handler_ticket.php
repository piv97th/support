<?php require('check_login.php'); ?>
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

	if(isset($_POST['fq']) && $mode_1 == 2)
	{
		require_once('user_classes/class_ticket.php');

		$ticket = new ticket();

		$result = array('arr_1' => $ticket->check_arr_1($_POST['arr_1']), 'fq' => $ticket->check_question_first($_POST['fq']), 'sq' => $ticket->check_question_second($_POST['sq']), 'tq' => $ticket->check_question_third($_POST['tq']));
		check_result($result);

		$result_ticket = $ticket->update_ticket();
		$result = array('ticket' => $result_ticket);
		echo json_encode($result);
        exit;
	}

	if($mode_1 == 3)
	{
		require_once('user_classes/class_ticket.php');
		$ticket = new ticket();

		$result = array('arr_1' => $ticket->check_arr_1($_POST['arr_1']));
		check_result($result);

		$result_ticket = $ticket->delete_ticket();
		$result = array('ticket' => $result_ticket);
		echo json_encode($result);
        exit;
	}

	if($_POST['mode_other'] == 1)
	{
		require('blocks/connect.php');
		$result_ticket = $conn->query('SELECT * FROM ticket');
		while($arr = $result_ticket->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'fq' => $arr['first_question'], 'sq' => $arr['second_question'], 'tq' => $arr['third_question']);
		}
		echo json_encode($arr_new);
        exit;
	}
?>