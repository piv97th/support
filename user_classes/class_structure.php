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

		public function delete_direction()
		{
			require('blocks/connect.php');
			$res = $conn->query('DELETE FROM direction WHERE id='.$this->id);
			if($res != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}
	}

	class group extends structure
	{
		public $cipher_group = 'NULL';
		public $qualification = 'NULL';
		public $university = 1;
		public $institute = 1;
		public $direction = 'NULL';
		public $form_studying = 'NULL';
		public $cathedra = 'NULL';

		private function exist_cipher_group($data)
		{
			require('blocks/connect.php');
			$sql = "SELECT COUNT(cipher_group) as `count` FROM group_1 WHERE cipher_group = '$data'";
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

		public function check_cipher_group($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				require('blocks/connect.php');
				$pattern_group = '/^[А-ЯЁ]{2}[Б,М,С][В,З,О][-][0-9]{2}[-][0-9]{2}$/u';
				if(!preg_match($pattern_group, $data))
				{
					return 2;
				}
				else
				{
					$data = mb_strtoupper($data);
					if($this->exist_cipher_group($data) == 1)
					{
						return 3;
					}
					else
					{
						$this->cipher_group = $data;
						return 1;
					}
				}
			}
		}

		private function is_old_cipher_group($data)
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT cipher_group FROM group_1 WHERE id = '.$this->id) or die($conn->error);
			$arr = $result->fetch_assoc();
			if($arr['cipher_group'] == $data)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function check_cipher_group_u($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				require('blocks/connect.php');
				$pattern_group = '/^[А-ЯЁ]{2}[Б,М,С][В,З,О][-][0-9]{2}[-][0-9]{2}$/u';
				if(!preg_match($pattern_group, $data))
				{
					return 2;
				}
				else
				{
					$data = mb_strtoupper($data);
					if(($this->exist_cipher_group($data) == 1))
					{
						if($this->is_old_cipher_group($data) == 1)
						{
							$this->cipher_group = $data;
							return 1;
						}
						else
						{
							return 3;
						}
					}
					else
					{
						$this->cipher_group = $data;
						return 1;
					}
				}
			}
		}

		public function check_qualification($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				if($data < 1 || 3 < $data)
				{
					return 2;
				}
				else
				{
					$this->qualification = $data;
					return 1;
				}
			}
		}

		public function check_cathedra($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				if($data < 1 || 99 < $data)
				{
					return 2;
				}
				else
				{
					$this->cathedra = $data;
					return 1;
				}
			}
		}

		public function check_direction($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				if($data < 1 || 9999 < $data)
				{
					return 2;
				}
				else
				{
					$this->direction = $data;
					return 1;
				}
			}
		}

		public function check_fs($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				if($data < 1 || 3 < $data)
				{
					return 2;
				}
				else
				{
					$this->form_studying = $data;
					return 1;
				}
			}
		}

		public function add_group()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('INSERT INTO group_1 (cipher_group, id_qualification_fk, id_university_fk, id_institute_fk, id_direction_fk, id_form_studying_fk, id_cathedra_fk) VALUES(?,?,?,?,?,?,?)');
			$stmt->bind_param('siiiiii', $this->cipher, $this->qualification, $this->university, $this->institute, $this->direction, $this->form_studying, $this->cathedra);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function update_group()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE group_1 SET cipher_group = ?, id_qualification_fk = ?, id_university_fk = ?, id_institute_fk = ?, id_direction_fk = ?, id_form_studying_fk = ?, id_cathedra_fk = ? WHERE id = ?');
			$stmt->bind_param('siiiiiii', $this->cipher_group, $this->qualification, $this->university, $this->institute, $this->direction, $this->form_studying, $this->cathedra, $this->id);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function delete_group()
		{
			require('blocks/connect.php');
			$res = $conn->query('DELETE FROM group_1 WHERE id='.$this->id);
			if($res != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}
	}

	class commission extends structure
	{
		public $order_1 = 'NULL';
		public $year = 'NULL';

		public function check_order_1($data)
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
				$this->order_1 = $data;
				return 1;
			}
		}

		public function check_year($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				$this->year = $data;
				return 1;
			}
		}

		public function add_commission()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('INSERT INTO commission (order_1, year) VALUES(?,?)');
			$stmt->bind_param('si', $this->order_1, $this->year);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function update_commission()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE commission SET order_1 = ?, year = ? WHERE id = ?');
			$stmt->bind_param('sii', $this->order_1, $this->year, $this->id);
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