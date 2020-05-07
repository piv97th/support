<?php
	require_once('blocks/check_data.php');

	if(isset($_POST['mode_1']))
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

?>