<?php
	class event
	{
		public $id = 'NULL';
		public $number_protocol = 'NULL';
		public $meeting = 'NULL';
		public $mark = 'NULL';

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

		public function check_topic($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				$this->topic = $data;
				return 1;
			}
		}

		public function check_type_work($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				$this->type_work = $data;
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
				return 1;
			}
		}
	}

	class diploma extends event
	{
		public $topic = 'NULL';
		public $anti_plagiarism = 'NULL';
		public $kind_work = 'NULL';
		public $supervisor = 'NULL';
		public $type_work = 'NULL';

/*		public function __construct($fields)
		{
			foreach($fields as $key => $value) {
				$this->$key = $value;
			}
		}
*/
		public function check_ap($data)
		{
			if(empty($data) && isset($data))
			{
				$this->anti_plagiarism = $data;
				return 1;
			}
			$pattern_1 = '/^[0].[0-9]{0,7}$/u';
			if(!preg_match($pattern_1, $data))
			{
				return 2;
			}
			else
			{
				return 1;
			}
		}

		public function check_supervisor($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return 0;
			}
			else
			{
				require('blocks/connect.php');
				$result_supervisor = $conn->query('SELECT id FROM teacher WHERE id = '.$data);
				$arr = $result_supervisor->fetch_assoc();
				if($arr['id'] == NULL)
				{
					return 3;
				}
				else
				{
					$this->supervisor = $data;
					return 1;
				}
			}
		}

		public function add_diploma()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('INSERT INTO diploma (topic, anti_plagiarism, id_kind_work_fk, id_teacher_fk, id_type_work_fk) VALUES(?,?,?,?,?)');
			$stmt->bind_param('sdiii', $this->topic, $this->anti_plagiarism, $this->kind_work, $this->supervisor, $this->type_work);
			$stmt->execute();
		}

		public function get_diploma()
		{
			require('blocks/connect.php');
			$query = $conn->query('SELECT id from diploma ORDER BY id DESC LIMIT 1');
			$result = $query->fetch_row()[0];
			if($result == NULL)
			{
				$result = 1;
			}
			return $result;
		}

	}

	class se extends event
	{
		public $ticket = 'NULL';

		public function __construct($fields)
		{
			foreach($fields as $key => $value) {
				$this->$key = $value;
			}
		}
	}


?>