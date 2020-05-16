<?php

	class event_main
	{
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

		public function check_arr_1($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return 0;
			}
			else
			{
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
		}

	}

	class e_add_meeting_group extends event_main
	{

		public $arr_meeting = [];
		public $arr_date = [];
		public $arr_group = [];

		public function check_arr_meeting($arr)
		{
			foreach($arr as $meeting)
			{
				if($this->check_empty($meeting) == 0)
				{
					return 0;
				}
				if($this->check_num($meeting) == 2)
				{
					return 2;
				}
			}
			$this->arr_meeting = $arr;
			return 1;
		}

		public function check_arr_group($arr)
		{
			foreach($arr as $group)
			{
				if($this->check_empty($group) == 0)
				{
					return 0;
				}
				if($this->check_num($group) == 2)
				{
					return 2;
				}
			}
			$this->arr_group = $arr;
			return 1;
		}

		public function check_arr_date($data)
		{
			$pattern_date = '/^[0-9,-]{10}$/';
			foreach($data as $date)
			{
				if($this->check_empty($date) == 0)
				{
					return 0;
				}
				if(!preg_match($pattern_date, $date))
				{
					return 2;
				}
			}
			$this->date = $data;
			return 1;
		}

		public function add_meeting_group()
		{
			require('blocks/connect.php');
			$n = count($this->arr_meeting);
			for($i = 0; $i < $n; $i++)
			{
				$stmt = $conn->prepare('UPDATE diploma SET id_meeting_fk = ? WHERE id IN (SELECT id_diploma_fk FROM student WHERE id_group_fk = ?)') or die($conn->error);
				$stmt->bind_param('ii', $this->arr_meeting[$i], $this->arr_group[$i]);
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