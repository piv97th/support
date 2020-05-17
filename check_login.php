<?php

	require('blocks/connect.php');

	if(!isset($_COOKIE['uid']) || !isset($_COOKIE['hash']))
	{
		header('Location: http://localhost/newspt/form_login.php');
	}
	else
	{

		$uid = $_COOKIE['uid'];
		$hash = $_COOKIE['hash'];
		$result_uid = $conn->prepare('SELECT id, uid, hash FROM user WHERE uid = ? AND hash = ?');
		$result_uid->bind_param('is', $uid, $hash);
		$result_uid->execute();
		$res_uid = $result_uid->get_result();
		$row_uid = $res_uid->fetch_assoc();

		if($row_uid['uid'] != $uid || $row_uid['hash'] != $hash)
		{
			setcookie("uid", "", time() - 3600*24*30*12, "/");
			setcookie("hash", "", time() - 3600*24*30*12, "/");
			header('Location: http://localhost/newspt/form_login.php');
		}
	}

?>