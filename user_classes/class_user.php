<?php
	class user
	{
		public $id = 'NULL';
		public $login = 'NULL';
		public $password = 'NULL';
		public $uid = 'NULL';
		public $hash = 'NULL';
		public $access = 'NULL';
		public $curevent = 'NULL';

		protected function check_empty($data)
		{
			if(empty($data))
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		protected function exist_login($data)
		{
			require('blocks/connect.php');
			$sql = "SELECT COUNT(login) as `count` FROM user WHERE login = '$data'";
			$result = $conn->query($sql) or die($conn->error);
			$row = $result->fetch_assoc();
			if($row['count'] > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function check_login($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			$pattern_login = '/^[A-Za-z0-9_]{4,16}$/u';
			if(!preg_match($pattern_login, $data))
			{
				return 2;
			}
			else
			{
				if($this->exist_login($data) == 1)
				{
					return 3;
				}
				else
				{
					$this->login = $data;
					return 1;
				}
			}
		}

		public function check_login_enter($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			$pattern_login = '/^[A-Za-z0-9_]{4,16}$/u';
			if(!preg_match($pattern_login, $data))
			{
				return 2;
			}
			else
			{
				$this->login = $data;
				return 1;
			}
		}

		public function check_password($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			$pattern_password = '/^[A-Za-z0-9_]{8,16}$/u';
			if(!preg_match($pattern_password, $data))
			{
				return 2;
			}
			else
			{
				$this->password = $data;
				return 1;
			}
		}

		protected function generate_code($length=6)
		{

			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

			$code = "";

			$clen = strlen($chars) - 1;  
			while (strlen($code) < $length)
			{
				$code .= $chars[mt_rand(0,$clen)];  
			}

			return $code;
		}

		public function add_user()
		{
			require('blocks/connect.php');
			$access = 3;
			$sha512 = hash('sha512', $this->password); 
			$stmt = $conn->prepare('INSERT INTO user (login, password, access, id_curevent_fk) VALUES(?,?,?,?)') or die($conn->error);
			$stmt->bind_param('ssii', $this->login, $sha512, $access, $this->curevent);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}
		public function login()
		{
			require('blocks/connect.php');
			$result_acc = $conn->query('SELECT * FROM user');
			$flag1=FALSE;

			while($arr_acc = $result_acc->fetch_assoc())
			{
				if($arr_acc['login']==$this->login && $arr_acc['password'] == hash('sha512', $this->password))
				{
					$hash =  hash('sha512', $this->generate_code(16));
					$flag1=TRUE;
					break;
				}
			}

			if($flag1==FALSE)
			{
				return 0;
			}
			else
			{
				$uid = $arr['id'].rand(0,99);
				$result_hash = $conn->query("UPDATE user SET uid = '$uid', hash = '$hash' WHERE login = '$this->login'") or die($conn->error);
				setcookie("uid", $uid, time()+60*60);
		        setcookie("hash", $hash, time()+60*60);
				return 1;
			}
		}
	}
?>