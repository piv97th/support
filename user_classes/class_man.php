<?php
	class man
	{
		public $id = 'NULL';
		public $last_name = 'NULL';
		public $first_name = 'NULL';
		public $patronymic = 'NULL';

	}

	class student extends man
	{
		public $nrb = 'NULL';
		public $group_1 = 'NULL';
		public $se = 'NULL';
		public $diploma = 'NULL';
		public $review = 'NULL';

		public function __construct($fields)
		{
			foreach($fields as $key => $value) {
				$this->$key = $value;
			}
		}

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

		public function __construct($fields)
		{
			foreach($fields as $key => $value) {
				$this->$key = $value;
			}
		}

	}

	class member_ssk extends man
	{
		public $degree = 'NULL';
		public $rank = 'NULL';
		public $post = 'NULL';
		public $role = 'NULL';
		public $commission = 'NULL';

		public function __construct($fields)
		{
			foreach($fields as $key => $value) {
				$this->$key = $value;
			}
		}

	}


?>