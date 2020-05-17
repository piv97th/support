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

		//echo $_POST['password'];
		//$user->password = $_POST['password'];
		//print_r($user);

		echo json_encode($result);
        exit;

		/*$login = $_POST['login'];
		$password = $_POST['password'];
		$flag1=FALSE;*/
		//$queryForSearchAccount=mysqli_query($d, "SELECT * FROM user");
		
		
		/*while($arr=mysqli_fetch_assoc($queryForSearchAccount))
		{
			if($arr['login']==$login && $arr['password'] == hash('sha512', $password))
			{
				//echo $arr['id'];
				$hash =  hash('sha512', generate_code(16)); //md5(generateCode(10));
				//$_SESSION['user_ok']=1;
				$flag1=TRUE;
				break;
			}
		}
		
		if($flag1==FALSE)
		{
			echo 0;
		}
		else
		{
			$uid = $arr['id'].rand(0,99);
			$uhu = mysqli_query($d, "UPDATE user SET uid = '$uid', hash = '$hash' WHERE login = '$arr[login]'");
			setcookie("uid", $uid, time()+60*60);
	        setcookie("hash", $hash, time()+60*60);
			echo 1;
		}*/
	}

?>