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