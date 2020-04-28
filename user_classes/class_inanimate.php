<?php
	class event
	{
		public $id = 'NULL';
		public $number_protocol = 'NULL';
		public $meeting = 'NULL';
		public $mark = 'NULL';
	}

	class diploma extends event
	{
		public $topic = 'NULL';
		public $anti_plagiarism = 'NULL';
		public $kind_work = 'NULL';
		public $supervisor = 'NULL';
		public $type_work = 'NULL';

		public function __construct($fields)
		{
			foreach($fields as $key => $value) {
				$this->$key = $value;
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