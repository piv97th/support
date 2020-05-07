<?php
	class structure
	{
		public	$id = 'NULL';
		public	$name = 'NULL';


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

		protected function check_isset($data)
		{
			if(!isset($data))
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		protected function check_num($data)
		{
			if(!is_numeric($data) || 1 > mb_strlen($data) || 8 < mb_strlen($data))
			{
				return 2;
			}
			else
			{
				return 1;
			}
		}

		protected function check_string($data)
		{
			if(1 > mb_strlen($data) || 255 < mb_strlen($data))
			{
				return 2;
			}
			else
			{
				return 1;
			}
		}

		public function check_arr_1($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			if($this->check_num($data) == 2)
			{
				return 2;
			}
			else
			{
				$this->id = $data;
				return 1;
			}
		}

		public function check_name($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			if($this->check_string($data) == 2)
			{
				return 2;
			}
			else
			{
				$this->name = $data;
				return 1;
			}
		}
	}

	class direction extends structure
	{
		public $cipher = 'NULL';

		private function exist_cipher($data)
		{
			require('blocks/connect.php');
			$sql = "SELECT COUNT(cipher_direction) as `count` FROM direction WHERE cipher_direction = '$data'";
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

		public function check_cipher($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			$pattern_cd = '/^[0-9]{2}[.][0-9]{2}[.][0-9]{2}$/u';
			if(!preg_match($pattern_cd, $data))
			{
				return 2;
			}
			else
			{
				if($this->exist_cipher($data) == 1)
				{
					return 3;
				}
				else
				{
					$this->cipher = $data;
					return 1;
				}
			}
		}

		private function is_old_cipher($data)
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT cipher_direction FROM direction WHERE id = '.$this->id) or die($conn->error);
			$arr = $result->fetch_assoc();
			if($arr['cipher_direction'] == $data)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function check_cipher_u($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			$pattern_cd = '/^[0-9]{2}[.][0-9]{2}[.][0-9]{2}$/u';
			if(!preg_match($pattern_cd, $data))
			{
				return 2;
			}
			else
			{
				if(($this->exist_cipher($data) == 1))
				{
					if($this->is_old_cipher($data) == 1)
					{
						$this->cipher = $data;
						return 1;
					}
					else
					{
						return 3;
					}
				}
				else
				{
					$this->cipher = $data;
					return 1;
				}
/*				{
					return 3;
				}
				else
				{
					$this->cipher = $data;
					return 1;
				}*/
			}
		}

		public function add_direction()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('INSERT INTO direction (cipher_direction, name) VALUES(?,?)');
			$stmt->bind_param('ss', $this->cipher, $this->name);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function update_direction()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE direction SET cipher_direction = ?, name = ? WHERE id = ?');
			$stmt->bind_param('ssi', $this->cipher, $this->name, $this->id);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}
	}
?>