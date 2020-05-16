<?php

	class question
	{
		public $id = 'NULL';
		public $arr_questions = 'NULL';
		public $diploma = 'NULL';
		public $se = 'NULL';
		public $arr_members = 'NULL';

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

		public function check_arr_members($arr)
		{
			foreach($arr as $member)
			{
				if($this->check_empty($member) == 0)
				{
					return 0;
				}
				if($this->check_num($member) == 2)
				{
					return 2;
				}
			}
			$this->arr_members = $arr;
			return 1;
		}

		public function check_arr_questions($arr)
		{
			foreach($arr as $question)
			{
				if($this->check_empty($question) == 0)
				{
					return 0;
				}
				if($this->check_string($question) == 2)
				{
					return 2;
				}
			}
			$this->arr_questions = $arr;
			return 1;
		}

		public function add_questions()
		{
			require('blocks/connect.php');
			$n = count($this->arr_members);
			//echo $n;
			for($i = 0; $i < $n; $i++)
			{
				//echo $this->diploma;
				//echo  $this->arr_members[$i];
				$stmt = $conn->prepare('INSERT INTO question_diploma (question, id_diploma_fk, id_member_fk) VALUES(?,?,?)') or die($conn->error);
				$stmt->bind_param('sii', $this->arr_questions[$i], $this->diploma, $this->arr_members[$i]);
				if($stmt->execute()!= 1)
				{
					return 0;
				}
				//echo 1;
			}
			return 1;
		}

		public function add_questions_se()
		{
			require('blocks/connect.php');
			$n = count($this->arr_members);
			//echo $n;
			for($i = 0; $i < $n; $i++)
			{
				//echo $this->se;
				//echo  $this->arr_members[$i];
				$stmt = $conn->prepare('INSERT INTO question_se (question, id_se_fk, id_member_fk) VALUES(?,?,?)') or die($conn->error);
				$stmt->bind_param('sii', $this->arr_questions[$i], $this->se, $this->arr_members[$i]);
				if($stmt->execute()!= 1)
				{
					return 0;
				}
				//echo 1;
			}
			return 1;
		}
	}

?>