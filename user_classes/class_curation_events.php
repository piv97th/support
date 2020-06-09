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
			}
			return 1;
		}

		public function del_meeting_group()
		{
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
		public $chairman = 'NULL';
		public $secretary = 'NULL';
		public $arr_member_ssk = [];
		public $id_commission = 'NULL';
		public $id_secr_curevent = 'NULL';

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

		public function check_arr_chairman($data)
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
					$this->chairman = $data;
					return 1;
				}
			}
		}

		public function check_arr_secr($data)
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
					$this->secretary = $data;
					return 1;
				}
			}
		}

		private function check_repeat($arr)
		{
			array_push($arr, $this->chairman, $this->secretary);
			$c = count($arr);
			for($i = 0; $i < $c - 1; $i++)
			{
				for($k = 1 + $i; $k < $c; $k++)
				{
					if($arr[$i] == $arr[$k])
					{
						return 3;
					}
				}
			}
			return 1;
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
			if($this->check_repeat($arr) == 3)
				{
					return 3;
				}
			$this->arr_member_ssk = $arr;
			return 1;
		}

		private function get_last_id_secr_curevent()
		{
			require('blocks/connect.php');
			$query = $conn->query('SELECT id FROM curation_event WHERE role = 3 ORDER BY id DESC LIMIT 1');
			$result = $query->fetch_row()[0];
			if($result == NULL)
			{
				$result = 1;
			}
			$this->id_secr_curevent = $result;
		}

		public function get_last_secr_curevent()
		{
			return $this->id_secr_curevent;
		}

		public function add_commission_member()
		{
			require('blocks/connect.php');
			$role = 1;
			$stmt_cm = $conn->prepare('INSERT INTO curation_event (id_member_ssk_fk, id_commission_fk, role) VALUES (?,?,?)') or die($conn->error);
			$stmt_cm->bind_param('iii', $this->chairman, $this->id_commission, $role);
			if($stmt_cm->execute()!= 1)
			{
				return 0;
			}

			$role = 3;
			$stmt_sct = $conn->prepare('INSERT INTO curation_event (id_member_ssk_fk, id_commission_fk, role) VALUES (?,?,?)') or die($conn->error);
			$stmt_sct->bind_param('iii', $this->secretary, $this->id_commission, $role);
			if($stmt_sct->execute()!= 1)
			{
				return 0;
			}
			$this->get_last_id_secr_curevent();

			$n = count($this->arr_member_ssk);
			$role = 2;
			for($i = 0; $i < $n; $i++)
			{
				$stmt = $conn->prepare('INSERT INTO curation_event (id_member_ssk_fk, id_commission_fk, role) VALUES (?,?,?)') or die($conn->error);
				$stmt->bind_param('iii', $this->arr_member_ssk[$i], $this->id_commission, $role);
				if($stmt->execute()!= 1)
				{
					return 0;
				}
			}
			return 1;
		}

		public function del_commission_member()
		{
			require('blocks/connect.php');
			$result = $conn->query('DELETE FROM curation_event WHERE id_commission_fk = '.$this->id_commission) or die($conn->error);
			if($result != 1)
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