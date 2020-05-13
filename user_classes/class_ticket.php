<?php

	class ticket
	{
		public $id = 'NULL';
		public $fq = 'NULL';
		public $sq = 'NULL';
		public $tq = 'NULL';

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

		public function check_question_first($data)
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
				$this->fq = $data;
				return 1;
			}
		}

		public function check_question_second($data)
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
				$this->sq = $data;
				return 1;
			}
		}

		public function check_question_third($data)
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
				$this->tq = $data;
				return 1;
			}
		}

		public function add_ticket()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('INSERT INTO ticket (first_question, second_question, third_question) VALUES(?,?,?)');
			$stmt->bind_param('sss', $this->fq, $this->sq, $this->tq);
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