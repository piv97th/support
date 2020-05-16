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

	}

	class e_add_meeting_group extends event_main
	{
		public $id = 'NULL';
		public $arr_meeting = [];
		public $arr_date = [];
		public $arr_group = [];

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

		/*public function check_commision($arr)
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
		}*/

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

		public function del_meeting_group()
		{
			//UPDATE diploma SET id_meeting_fk = NULL WHERE id_meeting_fk IN (SELECT id FROM timetable_meeting WHERE id_commission_fk = 111)
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE diploma SET id_meeting_fk = NULL WHERE id_meeting_fk IN (SELECT id FROM timetable_meeting WHERE id_commission_fk = ?)') or die($conn->error);
			$stmt->bind_param('i', $this->id);
			if($stmt->execute()!= 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}

		}
	}

	class e_commission_member extends event_main
	{
		public $id = 'NULL';
		public $arr_member_ssk = [];
		public $arr_role = [];
		public $id_commission = 'NULL';

		public function check_arr_1_com($data)
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
					$this->id_commission = $data;
					return 1;
				}
			}
		}

		public function check_arr_member($arr)
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
			$this->arr_member_ssk = $arr;
			return 1;
		}

		public function check_arr_role($arr)
		{
			foreach($arr as $role)
			{
				if($this->check_empty($role) == 0)
				{
					return 0;
				}
				if($this->check_num($role) == 2)
				{
					return 2;
				}
			}
			$this->arr_role = $arr;
			return 1;
		}

		public function add_commission_member()
		{
			require('blocks/connect.php');
			$n = count($this->arr_member_ssk);
			for($i = 0; $i < $n; $i++)
			{
				$stmt = $conn->prepare('INSERT INTO curation_event (id_member_ssk_fk, id_commission_fk, role) VALUES (?,?,?)') or die($conn->error);
				$stmt->bind_param('iii', $this->arr_member_ssk[$i], $this->id_commission, $this->arr_role[$i]);
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