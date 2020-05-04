<?php
	class man
	{
		public $id = 'NULL';
		public $last_name = 'NULL';
		public $first_name = 'NULL';
		public $patronymic = 'NULL';

		public function check_empty($data)
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

		public function check_name($data)
		{
			$pattern_2 = '/^[А-ЯЁ][а-яё]{1,254}$/u';
			$data = mb_strtoupper(mb_substr($data, 0, 1)) . mb_strtolower(mb_substr($data, 1));
			if(!preg_match($pattern_2, $data))
			{
				return 2;
			}
			else
			{
				return 1;
			}
		}

		public function check_last_name($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			if($this->check_name($data) == 2)
			{
				return 2;
			}
			else
			{
				$this->last_name = $data;
				return 1;
			}
		}

		public function check_first_name($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			if($this->check_name($data) == 2)
			{
				return 2;
			}
			else
			{
				$this->first_name = $data;
				return 1;
			}
		}

		public function check_patronymic($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			if($this->check_name($data) == 2)
			{
				return 2;
			}
			else
			{
				$this->patronymic = $data;
				return 1;
			}
		}

		public function check_num($data)
		{
			$status = $this->check_empty($data);
			if(!is_numeric($data) || 1 > mb_strlen($data) || 8 < mb_strlen($data))
			{
				return 2;
			}
			else
			{
				$this->last_name = $data;
				return 1;
			}
		}

	}

	class student extends man
	{
		public $nrb = 'NULL';
		public $group_1 = 'NULL';
		public $se = 'NULL';
		public $diploma = 'NULL';
		public $review = 'NULL';

/*		public function __construct($fields)
		{
			foreach($fields as $key => $value) {
				$this->$key = $value;
			}
		}*/

		public function exist_nrb_u($data)
		{
			require('blocks/connect.php');
			$sql = "SELECT COUNT(number_record_book) as `count` FROM student WHERE number_record_book = '$data'";
			$result = $conn->query($sql) or die($conn->error);
			$row = $result->fetch_assoc();
			if($row['count'] > 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		public function check_nrb_u($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			$arr_was = array("б", "м", "с");
			$arr_become = array("Б", "М", "С");
			$data = str_replace($arr_was, $arr_become, $data);
			$pattern_1 = '/^[0-9]{2}[Б,М,С][0-9]{4}$/u';
			if(!preg_match($pattern_1, $data))
			{
				return 2;
			}
			else
			{
				if($this->exist_nrb_u($data) == TRUE)
				{
					return 3;
				}
				else
				{
					return 1;
				}
			}
		}

		public function exist_nrb($data)
		{
			require('blocks/connect.php');
			$sql = "SELECT COUNT(number_record_book) as `count` FROM student WHERE number_record_book = '$data'";
			$result = $conn->query($sql) or die($conn->error);
			$row = $result->fetch_assoc();
			if($row['count'] > 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		public function check_nrb($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			$arr_was = array("б", "м", "с");
			$arr_become = array("Б", "М", "С");
			$data = str_replace($arr_was, $arr_become, $data);
			$pattern_1 = '/^[0-9]{2}[Б,М,С][0-9]{4}$/u';
			if(!preg_match($pattern_1, $data))
			{
				return 2;
			}
			else
			{
				if($this->exist_nrb($data) == TRUE)
				{
					return 3;
				}
				else
				{
					$this->nrb = $data;
					return 1;
				}
			}
		}


		public function check_group($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return 0;
			}
			else
			{
				require('blocks/connect.php');
				$result_group = $conn->query('SELECT id FROM group_1 WHERE id = '.$data);
				$arr = $result_group->fetch_assoc();
				if($arr['id'] == NULL)
				{
					return 2;
				}
				else
				{
					$this->group_1 = $data;
					return 1;
				}
			}
		}

/*		public function data_student($nrb, $last_name, $first_name, $patronymic, $group_1, $topic, $type_work, $anti_plagiarism, $supervisor, $mode_1, $arr_1)
		{
			//require('blocks/connect.php');
			$this->$
		}*/

		public function add_student()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('INSERT INTO student (number_record_book, last_name, first_name, patronymic, id_group_fk, id_diploma_fk) VALUES(?,?,?,?,?,?)');
			$stmt->bind_param('ssssii', $this->nrb, $this->last_name, $this->first_name, $this->patronymic, $this->group_1, $this->diploma);
			$stmt->execute();
		}

		public function update_student()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE student SET number_record_book=?, last_name=?, first_name=?, patronymic=?, id_group_fk=?');
			$stmt->bind_param('ssssii', $this->nrb, $this->last_name, $this->first_name, $this->patronymic, $this->group_1, $this->diploma);
			$stmt->execute();
		}

		public function delete_student()
		{
			require('blocks/connect.php');
			$arr = $this->get_info_student();
			if($arr['id_diploma_fk'] != NULL && $arr['id_se_fk'] == NULL && $arr['id_review_fk'] == NULL)
			{
				$result_diploma = $conn->query('DELETE FROM diploma WHERE id = '.$arr["id_diploma_fk"]);
				if($result_diploma == 1)
				{
					$result = array('eleventh' => 1);
					return $result;
				}
				else
				{
					$result = array('eleventh' => 0);
					return $result;
				}
			}
			else
			{
				if($arr['id_diploma_fk'] != NULL && $arr['id_se_fk'] != NULL && $arr['id_review_fk'] == NULL)
				{
					$result_se = $conn->query('DELETE FROM se WHERE id = '.$arr[id_se_fk]);
					$result_diploma = $conn->query('DELETE FROM diploma WHERE id = '.$arr[id_diploma_fk]);
					if($result_diploma == 1 && $result_se == 1 )
					{
						$result = array('eleventh' => 1, 'twelfth' => 1);
						return $result;
					}
					else
					{
						$result = array('eleventh' => 0, 'twelfth' => 0);
						return $result;
					}
				}
				else
				{
					$result_review = $conn->query('DELETE FROM review WHERE id = '.$arr[id_review_fk]);
					$result_diploma = $conn->query('DELETE FROM diploma WHERE id = '.$arr[id_diploma_fk]);
					if($result_diploma == 1 && $result_review == 1 )
					{
						$result = array('eleventh' => 1, 'twelfth' => 1);
						return $result;
					}
					else
					{
						$result = array('eleventh' => 0, 'twelfth' => 0);
						return $result;
					}
				}
			}
		}

		public function get_info_student()
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT * FROM student WHERE id = '.$this->id);
			$arr = $result->fetch_assoc();
			return $arr;
		}
	}

	class supervisor extends man
	{
		public $cipher_supervisor = 'NULL';
		public $degree = 'NULL';
		public $rank = 'NULL';
		public $post = 'NULL';

/*		public function __construct($fields)
		{
			foreach($fields as $key => $value) {
				$this->$key = $value;
			}
		}*/

	}

	class member_ssk extends man
	{
		public $degree = 'NULL';
		public $rank = 'NULL';
		public $post = 'NULL';
		public $role = 'NULL';
		public $commission = 'NULL';

/*		public function __construct($fields)
		{
			foreach($fields as $key => $value) {
				$this->$key = $value;
			}
		}*/

	}
?>