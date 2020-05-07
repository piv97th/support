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

	if($_POST['mode_other'] == 3)
	{
		$result_direction = $conn->query('SELECT * FROM direction');
		while($arr = $result_direction->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'cipher_direction' => $arr['cipher_direction'], 'name' => $arr['name']);
		}
		echo json_encode($arr_new);
        exit;
	}

?>