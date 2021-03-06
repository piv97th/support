<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	$mode_1 = $_POST['mode_1'];
	check_get($mode_1);

	if(isset($_POST['cipher']) && $mode_1 == 1)
	{
		require_once('user_classes/class_man.php');

		$supervisor = new supervisor();

		$result = array('cipher' => $supervisor->check_cipher_supervisor($_POST['cipher']), 'last_name' => $supervisor->check_last_name($_POST['last_name']), 'first_name' => $supervisor->check_first_name($_POST['first_name']), 'patronymic' =>  $supervisor->check_patronymic($_POST['patronymic']), 'degree' => $supervisor->check_degree($_POST['degree']), 'rank' => $supervisor->check_rank($_POST['rank']), 'post' => $supervisor->check_post($_POST['post']));
		check_result($result);

		$result_supervisor = $supervisor->add_supervisor();
		$result = array('supervisor' => $result_supervisor);
		echo json_encode($result);
        exit;
	}

	if(isset($_POST['arr_1']) && $mode_1 == 2)
	{
		require_once('user_classes/class_man.php');

		$supervisor = new supervisor();

		$result = array('arr_1' => $supervisor->check_arr_1($_POST['arr_1']), 'cipher' => $supervisor->check_cipher_supervisor_u($_POST['cipher']), 'last_name' => $supervisor->check_last_name($_POST['last_name']), 'first_name' => $supervisor->check_first_name($_POST['first_name']), 'patronymic' =>  $supervisor->check_patronymic($_POST['patronymic']), 'degree' => $supervisor->check_degree($_POST['degree']), 'rank' => $supervisor->check_rank($_POST['rank']), 'post' => $supervisor->check_post($_POST['post']));
		check_result($result);

		$result_supervisor = $supervisor->update_supervisor();
		$result = array('supervisor' => $result_supervisor);
		echo json_encode($result);
        exit;
	}

	if(isset($_POST['arr_1']) && $mode_1 == 3)
	{
		require_once('user_classes/class_man.php');
		$supervisor = new supervisor();

		$result = array('arr_1' => $supervisor->check_arr_1($_POST['arr_1']));
		check_result($result);

		$result_supervisor = $supervisor->delete_supervisor();
		$result = array('supervisor' => $result_supervisor);
		echo json_encode($result);
        exit;
	}
?>