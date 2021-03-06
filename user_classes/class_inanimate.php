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

		public function check_isset($data)
		{
			if(!isset($data))
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

		public function check_arr_1($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
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

		public function check_protocol($data)
		{
			if($this->check_empty($data) == 0)
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
					$this->number_protocol = $data;
					return 1;
				}
			}
		}

		public function check_meeting($data)
		{
			if($this->check_empty($data) == 0)
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
					$this->meeting = $data;
					return 1;
				}
			}
		}

		public function check_mark($data)
		{
			if($this->check_empty($data) == 0)
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
					$this->mark = $data;
					return 1;
				}
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

		public function set_kind_work($student)
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE diploma SET id_kind_work_fk = ? WHERE id = (SELECT id_diploma_fk FROM student WHERE id = ?)');
			$stmt->bind_param('ii', $this->kind_work, $student);
			$stmt->execute();
		}

		private function get_old_protocol()
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT number_protocol FROM diploma WHERE id ='.$this->id) or die($conn->error);
			$arr = $result->fetch_assoc();
			return $arr['number_protocol'];
		}


		private function exsist_protocol($data)
		{
			require('blocks/connect.php');
			$sql = "SELECT COUNT(number_protocol) as `count` FROM diploma WHERE number_protocol = '$data'";
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

		public function check_protocol_u($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				if($this->check_num($data) == 2)
				{
					return 2;
				}
				elseif(($this->exsist_protocol($data) == TRUE) && ($data != $this->get_old_protocol()))
				{
					return 3;
				}
				else
				{
					$this->number_protocol = $data;
					return 1;
				}
			}
		}
		
		public function check_ap($data)
		{
			if(empty($data) && ($this->check_isset($data) == 1))
			{
				return 1;
			}
			$pattern_1 = '/^[0].[0-9]{0,7}$/u';
			if(!preg_match($pattern_1, $data))
			{
				return 2;
			}
			else
			{
				$this->anti_plagiarism = $data;
				return 1;
			}
		}

		public function check_topic($data)
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
				$this->topic = $data;
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
			$stmt = $conn->prepare('INSERT INTO diploma (topic, id_kind_work_fk, id_teacher_fk, id_type_work_fk) VALUES(?,?,?,?)');
			$stmt->bind_param('siii', $this->topic, $this->kind_work, $this->supervisor, $this->type_work);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function update_diploma()
		{
			require('blocks/connect.php');
			if($this->number_protocol != 'NULL')
			{
				if($this->mark != 'NULL')
				{
					$stmt = $conn->prepare('UPDATE diploma SET number_protocol = ?, topic = ?, anti_plagiarism = ?, id_kind_work_fk = ?, id_teacher_fk = ?, id_mark_fk = ?, id_type_work_fk = ? WHERE id = ?');
					$stmt->bind_param('isdiiiii', $this->number_protocol, $this->topic, $this->anti_plagiarism, $this->kind_work, $this->supervisor, $this->mark, $this->type_work, $this->id);
					if($stmt->execute() != 1)
					{
						return 0;
					}
					else
					{
						return 1;
					}
				}
				else
				{
					$stmt = $conn->prepare('UPDATE diploma SET number_protocol = ?, topic = ?, anti_plagiarism = ?, id_kind_work_fk = ?, id_teacher_fk = ?, id_type_work_fk = ? WHERE id = ?');
					$stmt->bind_param('isdiiii', $this->number_protocol, $this->topic, $this->anti_plagiarism, $this->kind_work, $this->supervisor, $this->type_work, $this->id);
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
			else
			{
				$stmt = $conn->prepare('UPDATE diploma SET topic = ?, anti_plagiarism = ?, id_kind_work_fk = ?, id_teacher_fk = ?, id_type_work_fk = ? WHERE id = ?');
				$stmt->bind_param('sdiiii', $this->topic, $this->anti_plagiarism, $this->kind_work, $this->supervisor, $this->type_work, $this->id);
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

		private function search_commission()
		{
			require('blocks/connect.php');
			$query = $conn->query('SELECT id_commission_fk FROM timetable_meeting WHERE id = (SELECT id_meeting_diploma_fk FROM group_1 WHERE id = (SELECT id_group_fk FROM student WHERE id_diploma_fk = '.$this->id.'))');
			$result = $query->fetch_assoc();
			return $result['id_commission_fk'];
		}

		private function insert_number_protocol()
		{
			require('blocks/connect.php');
			$commission_fk = $this->search_commission();
			$query = $conn->query('SELECT id, number_protocol FROM diploma WHERE id IN (SELECT id_diploma_fk FROM student WHERE id_group_fk IN (SELECT id FROM group_1 WHERE id_meeting_diploma_fk IN (SELECT id FROM timetable_meeting WHERE id_commission_fk = '.$commission_fk.'))) AND number_protocol IS NOT NULL ORDER BY number_protocol DESC LIMIT 1');
			$result = $query->fetch_assoc();
			if($result['number_protocol'] != 0)
			{
				$this->number_protocol = $result['number_protocol'] + 1;
			}
			else
			{
				$this->number_protocol = 1;
			}
		}

		public function make_add_diploma()
		{
			require('blocks/connect.php');
			$this->insert_number_protocol();

			$stmt = $conn->prepare('UPDATE diploma SET number_protocol = ?, id_mark_fk = ? WHERE id = ?');
			$stmt->bind_param('iii', $this->number_protocol, $this->mark, $this->id);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function get_diploma()
		{
			require('blocks/connect.php');
			$query = $conn->query('SELECT id FROM diploma ORDER BY id DESC LIMIT 1');
			$result = $query->fetch_row()[0];
			if($result == NULL)
			{
				$result = 1;
			}
			return $result;
		}

		public function get_id_diploma()
		{
			return $this->id;
		}

	}

	class se extends event
	{
		public $ticket = 'NULL';
		public $group_other = 'NULL';

		private function get_old_protocol()
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT number_protocol FROM se WHERE id ='.$this->id) or die($conn->error);
			$arr = $result->fetch_assoc();
			return $arr['number_protocol'];
		}


		private function exsist_protocol($data)
		{
			require('blocks/connect.php');
			$sql = "SELECT COUNT(number_protocol) as `count` FROM se WHERE number_protocol = '$data'";
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

		public function check_protocol_u($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				if($this->check_num($data) == 2)
				{
					return 2;
				}
				elseif(($this->exsist_protocol($data) == TRUE) && ($data != $this->get_old_protocol()))
				{
					return 3;
				}
				else
				{
					$this->number_protocol = $data;
					return 1;
				}
			}
		}

		public function check_group_other($data)
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
					$this->group_other = $data;
					return 1;
				}
			}
		}

		public function check_ticket($data)
		{
			if($this->check_empty($data) == 0)
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
					$this->ticket = $data;
					return 1;
				}
			}
		}

		public function get_id_se()
		{
			return $this->id;
		}

		private function get_last_id_se()
		{
			require('blocks/connect.php');
			$query = $conn->query('SELECT id FROM se ORDER BY id DESC LIMIT 1');
			$result = $query->fetch_row()[0];
			if($result == NULL)
			{
				$result = 1;
			}
			return $result;
		}

		private function search_commission()
		{
			require('blocks/connect.php');
			$query = $conn->query('SELECT id_commission_fk FROM timetable_meeting WHERE id = (SELECT id_meeting_se_fk FROM group_1 WHERE id = '.$this->group_other.')');
			$result = $query->fetch_assoc();
			return $result['id_commission_fk'];
		}

		private function insert_number_protocol()
		{
			require('blocks/connect.php');
			$commission_fk = $this->search_commission();
			$query = $conn->query('SELECT id, number_protocol FROM se WHERE id IN (SELECT id_se_fk FROM student WHERE id_group_fk IN (SELECT id FROM group_1 WHERE id_meeting_se_fk IN (SELECT id FROM timetable_meeting WHERE id_commission_fk = '.$commission_fk.'))) AND number_protocol IS NOT NULL ORDER BY number_protocol DESC LIMIT 1');
			$result = $query->fetch_assoc();
			if($result['number_protocol'] != 0)
			{
				$this->number_protocol = $result['number_protocol'] + 1;
			}
			else
			{
				$this->number_protocol = 1;
			}
		}

		public function make_add_se()
		{
			require('blocks/connect.php');
			$this->insert_number_protocol();
			$stmt = $conn->prepare('INSERT INTO se (number_protocol, id_ticket_fk, id_mark_fk) VALUES(?,?,?)');
			$stmt->bind_param('iii', $this->number_protocol, $this->ticket, $this->mark);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				$this->id = $this->get_last_id_se();
				return 1;
			}
		}

		public function update_se()
		{
			require('blocks/connect.php');
			if($this->ticket != 'NULL')
			{
				if($this->mark != 'NULL')
				{
					$stmt = $conn->prepare('UPDATE se SET number_protocol = ?, id_ticket_fk = ?, id_mark_fk = ? WHERE id = ?');
					$stmt->bind_param('iiii', $this->number_protocol, $this->ticket, $this->mark, $this->id);
					if($stmt->execute() != 1)
					{
						return 0;
					}
					else
					{
						return 1;
					}
				}
				else
				{
					$stmt = $conn->prepare('UPDATE se SET number_protocol = ?, id_ticket_fk = ? WHERE id = ?');
					$stmt->bind_param('iii', $this->number_protocol, $this->ticket, $this->id);
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
			else
			{
				$stmt = $conn->prepare('UPDATE se SET number_protocol = ? WHERE id = ?');
				$stmt->bind_param('ii', $this->number_protocol, $this->id);
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
	}


?>