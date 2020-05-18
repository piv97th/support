<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	
	
	if(isset($_POST['login']) && isset($_POST['password']))
	{
		require_once('user_classes/class_user.php');
		$user = new user();

		$result = array('login' => $user->check_login_enter($_POST['login']), 'password' => $user->check_password($_POST['password']));
		check_result($result);

		$result_user = $user->login();
		$result = array('user' => $result_user);

		echo json_encode($result);
        exit;
	}

?>