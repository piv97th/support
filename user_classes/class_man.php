<?php
	class man
	{
		public $id = 'NULL';
		public $last_name = 'NULL';
		public $first_name = 'NULL';
		public $patronymic = 'NULL';

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

		public function check_name($data)
		{
			$pattern_2 = '/^[А-ЯЁ][а-яё]{1,254}$/u';
			$data = mb_strtoupper(mb_substr($data, 0, 1)) . mb_strtolower(mb_substr($data, 1));
			if(!preg_match($pattern_2, $data))
			{
				return 2;
			}
			else
			{
				return 1;
			}
		}

		public function check_last_name($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			if($this->check_name($data) == 2)
			{
				return 2;
			}
			else
			{
				$this->last_name = $data;
				return 1;
			}
		}

		public function check_first_name($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			if($this->check_name($data) == 2)
			{
				return 2;
			}
			else
			{
				$this->first_name = $data;
				return 1;
			}
		}

		public function check_patronymic($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			if($this->check_name($data) == 2)
			{
				return 2;
			}
			else
			{
				$this->patronymic = $data;
				return 1;
			}
		}

		public function check_num($data)
		{
			//$this->check_empty($data);
			if(!is_numeric($data) || 1 > mb_strlen($data) || 8 < mb_strlen($data))
			{
				return 2;
			}
			else
			{
				return 1;
			}
		}

		public function check_numeral($data)
		{
			if(0 > $data || $data > 9)
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

	class student extends man
	{
		public $nrb = 'NULL';
		public $group_1 = 'NULL';
		public $se = 'NULL';
		public $diploma = 'NULL';
		public $review = 'NULL';
		public $cipher_group = 'NULL';

		public function get_id_student()
		{
			return $this->id;
		}

		public function get_old_nrb()
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT number_record_book FROM student WHERE id ='.$this->id) or die($conn->error);
			$arr = $result->fetch_assoc();
			return $arr['number_record_book'];
		}

		public function check_nrb_u($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			$arr_was = array("б", "м", "с");
			$arr_become = array("Б", "М", "С");
			$data = str_replace($arr_was, $arr_become, $data);
			$pattern_1 = '/^[0-9]{2}[Б,М,С][0-9]{4}$/u';
			if(!preg_match($pattern_1, $data))
			{
				return 2;
			}
			else
			{
				if(($this->exist_nrb($data) == TRUE) && ($data != $this->get_old_nrb()))
				{
					return 3;
				}
				else
				{
					$this->nrb = $data;
					return 1;
				}
			}
		}

		public function exist_nrb($data)
		{
			require('blocks/connect.php');
			$sql = "SELECT COUNT(number_record_book) as `count` FROM student WHERE number_record_book = '$data'";
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

		public function check_nrb($data)
		{
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return $status;
			}
			$arr_was = array("б", "м", "с");
			$arr_become = array("Б", "М", "С");
			$data = str_replace($arr_was, $arr_become, $data);
			$pattern_1 = '/^[0-9]{2}[Б,М,С][0-9]{4}$/u';
			if(!preg_match($pattern_1, $data))
			{
				return 2;
			}
			else
			{
				if($this->exist_nrb($data) == TRUE)
				{
					return 3;
				}
				else
				{
					$this->nrb = $data;
					return 1;
				}
			}
		}


		public function check_group($data)
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
					$this->group_1 = $data;
					return 1;
				}
			}
		}

		public function check_group_by_cipher()
		{
			$data = (string)$this->cipher_group;
			$status = $this->check_empty($data);
			if($status == 0)
			{
				return 0;
			}
			else
			{
				require('blocks/connect.php');
				$result_group = $conn->query("SELECT id FROM group_1 WHERE cipher_group = '$data'") or die($conn->error);
				$arr = $result_group->fetch_assoc();
				if($arr['id'] == NULL)
				{
					return 2;
				}
				else
				{
					$this->group_1 = $data;
					return 1;
				}
			}
		}

		private function have_review()
		{
			$result = $conn->query('SELECT id_review_fk FROM diploma WHERE id = '.$this->diploma);
			$review = $result->fetch_assoc()['id_review_fk'];
			if($review != NULL)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function add_student()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('INSERT INTO student (number_record_book, last_name, first_name, patronymic, id_group_fk, id_diploma_fk) VALUES(?,?,?,?,?,?)');
			$stmt->bind_param('ssssii', $this->nrb, $this->last_name, $this->first_name, $this->patronymic, $this->group_1, $this->diploma);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function update_student()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE student SET number_record_book=?, last_name=?, first_name=?, patronymic=?, id_group_fk=? WHERE id = ?');
			$stmt->bind_param('ssssii', $this->nrb, $this->last_name, $this->first_name, $this->patronymic, $this->group_1, $this->id);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function delete_student()
		{
			require('blocks/connect.php');
			$arr = $this->get_info_student();
			$arr_diploma = $this->get_info_diploma();
			if($arr['id_diploma_fk'] != NULL && $arr['id_se_fk'] == NULL)
			{
				$result_diploma = $conn->query('DELETE FROM diploma WHERE id = '.$arr["id_diploma_fk"]);
				if($result_diploma == 1)
				{
					return 1;
				}
				else
				{
					return 0;
				}
			}
			else
			{
				if($arr['id_diploma_fk'] != NULL && $arr['id_se_fk'] != NULL)
				{
					$result_se = $conn->query('DELETE FROM se WHERE id = '.$arr['id_se_fk']);
					$result_diploma = $conn->query('DELETE FROM diploma WHERE id = '.$arr['id_diploma_fk']);
					if($result_diploma == 1 && $result_se == 1 )
					{
						if(have_review() == 1)
						{
							$delete_review = $conn->query('DELETE FROM review WHERE id = '.$arr_diploma['id_review_fk']);
							if($delete_review == 1)
							{
								return 1;
							}
							else
							{
								return 0;
							}
						}
						return 1;
					}
					else
					{
						return 0;
					}
				}
			}
		}

		public function insert_se()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE student SET id_se_fk = ? WHERE id = ?') or die($conn->error);
			$stmt->bind_param('ii', $this->se, $this->id);
			if($stmt->execute()!= 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function get_info_student()
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT * FROM student WHERE id = '.$this->id);
			$arr = $result->fetch_assoc();
			return $arr;
		}
		public function get_info_diploma()
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT * FROM diploma WHERE id = (SELECT id_diploma_fk FROM student WHERE id = '.$this->id.')');
			$arr = $result->fetch_assoc();
			return $arr;
		}
		public function get_diploma_fk()
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT id_diploma_fk FROM student WHERE id = '.$this->id);
			$arr = $result->fetch_assoc();
			return $arr['id_diploma_fk'];
		}
		public function get_se_fk()
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT id_se_fk FROM student WHERE id = '.$this->id);
			$arr = $result->fetch_assoc();
			return $arr['id_se_fk'];
		}
	}

	class supervisor extends man
	{
		public $cipher_supervisor = 'NULL';
		public $degree = 'NULL';
		public $rank = 'NULL';
		public $post = 'NULL';

		private function is_old_cipher_supervisor($data)
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT cipher_teacher FROM teacher WHERE id = '.$this->id) or die($conn->error);
			$arr = $result->fetch_assoc();
			if($arr['cipher_teacher'] == $data)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		private function exist_cipher_supervisor($data)
		{
			require('blocks/connect.php');
			$sql = "SELECT COUNT(cipher_teacher) as `count` FROM teacher WHERE cipher_teacher = '$data'";
			$result = $conn->query($sql) or die($conn->error);
			$row = $result->fetch_assoc();
			if($row['count'] > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function check_cipher_supervisor($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			$pattern_cs = '/^[0-9]{2,4}$/';
			if(!preg_match($pattern_cs, $data))
			{
				return 2;
			}
			else
			{
				if($this->exist_cipher_supervisor($data) == 1)
				{
					return 3;
				}
				else
				{
					$this->cipher_supervisor = $data;
					return 1;
				}
			}
		}

		public function check_cipher_supervisor_u($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			$pattern_cs = '/^[0-9]{2,4}$/';
			if(!preg_match($pattern_cs, $data))
			{
				return 2;
			}
			else
			{
				if(($this->exist_cipher_supervisor($data) == 1))
				{
					if($this->is_old_cipher_supervisor($data) == 1)
					{
						$this->cipher_supervisor = $data;
						return 1;
					}
					else
					{
						return 3;
					}
				}
				else
				{
					$this->cipher_supervisor = $data;
					return 1;
				}
			}
		}

		public function check_degree($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			if($this->check_numeral($data) == 2)
			{
				return 2;
			}
			else
			{
				$this->degree = $data;
				return 1;
			}
		}

		public function check_rank($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				$this->rank = $data;
				return 1;
			}
		}

		public function check_post($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				$this->post = $data;
				return 1;
			}
		}

		public function add_supervisor()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('INSERT INTO teacher (cipher_teacher, last_name, first_name, patronymic, degree, rank, post) VALUES(?,?,?,?,?,?,?)');
			$stmt->bind_param('ssssiss', $this->cipher_supervisor, $this->last_name, $this->first_name, $this->patronymic, $this->degree, $this->rank, $this->post);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function update_supervisor()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE teacher SET cipher_teacher=?, last_name=?, first_name=?, patronymic=?, degree=?, rank=?, post=? WHERE id = ?');
			$stmt->bind_param('ssssissi', $this->cipher_supervisor, $this->last_name, $this->first_name, $this->patronymic, $this->degree, $this->rank, $this->post, $this->id);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function delete_supervisor()
		{
			require('blocks/connect.php');
			$res = $conn->query('DELETE FROM teacher WHERE id='.$this->id);
			if($res != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}		

	}

	class member_ssk extends man
	{
		public $degree = 'NULL';
		public $rank = 'NULL';
		public $post = 'NULL';

		private function is_old_cipher_supervisor($data)
		{
			require('blocks/connect.php');
			$result = $conn->query('SELECT cipher_teacher FROM teacher WHERE id = '.$this->id) or die($conn->error);
			$arr = $result->fetch_assoc();
			if($arr['cipher_teacher'] == $data)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		private function exist_cipher_supervisor($data)
		{
			require('blocks/connect.php');
			$sql = "SELECT COUNT(cipher_teacher) as `count` FROM teacher WHERE cipher_teacher = '$data'";
			$result = $conn->query($sql) or die($conn->error);
			$row = $result->fetch_assoc();
			if($row['count'] > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function check_cipher_supervisor($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			$pattern_cs = '/^[0-9]{2,4}$/';
			if(!preg_match($pattern_cs, $data))
			{
				return 2;
			}
			else
			{
				if($this->exist_cipher_supervisor($data) == 1)
				{
					return 3;
				}
				else
				{
					$this->cipher_supervisor = $data;
					return 1;
				}
			}
		}

		public function check_cipher_supervisor_u($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			$pattern_cs = '/^[0-9]{2,4}$/';
			if(!preg_match($pattern_cs, $data))
			{
				return 2;
			}
			else
			{
				if(($this->exist_cipher_supervisor($data) == 1))
				{
					if($this->is_old_cipher_supervisor($data) == 1)
					{
						$this->cipher_supervisor = $data;
						return 1;
					}
					else
					{
						return 3;
					}
				}
				else
				{
					$this->cipher_supervisor = $data;
					return 1;
				}
			}
		}

		public function check_degree($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			if($this->check_numeral($data) == 2)
			{
				return 2;
			}
			else
			{
				$this->degree = $data;
				return 1;
			}
		}

		public function check_rank($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				$this->rank = $data;
				return 1;
			}
		}

		public function check_post($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				$this->post = $data;
				return 1;
			}
		}

		public function add_member_ssk()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('INSERT INTO member_ssk (last_name, first_name, patronymic, post, degree, rank) VALUES(?,?,?,?,?,?)');
			$stmt->bind_param('ssssis', $this->last_name, $this->first_name, $this->patronymic, $this->post, $this->degree, $this->rank);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function update_member_ssk()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE member_ssk SET last_name=?, first_name=?, patronymic=?, post=?, degree=?, rank=? WHERE id = ?');
			$stmt->bind_param('ssssisi', $this->last_name, $this->first_name, $this->patronymic, $this->post, $this->degree, $this->rank, $this->id);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		public function delete_member_ssk()
		{
			require('blocks/connect.php');
			$res = $conn->query('DELETE FROM member_ssk WHERE id='.$this->id);
			if($res != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}
	}

	class reviewer extends man
	{
		public $post = 'NULL';
		public $place_work = 'NULL';
		public $student = 'NULL';

		public function check_post($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				if(mb_strlen($data, 'UTF-8') > 255)
				{
					return 2;
				}
				else
				{
					$this->post = $data;
					return 1;
				}
			}
		}

		public function check_place_work($data)
		{
			if($this->check_empty($data) == 0)
			{
				return 0;
			}
			else
			{
				if(mb_strlen($data, 'UTF-8') > 255)
				{
					return 2;
				}
				else
				{
					$this->place_work = $data;
					return 1;
				}
			}
		}

		public function check_student($data)
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
					$this->student = $data;
					return 1;
				}
			}
		}

		public function add_reviewer()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('INSERT INTO review (last_name, first_name, patronymic, post, place_work) VALUES(?,?,?,?,?)');
			$stmt->bind_param('sssss', $this->last_name, $this->first_name, $this->patronymic, $this->post, $this->place_work);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				$res = $conn->query('SELECT id FROM review ORDER BY id DESC LIMIT 1');
				$last_review = $res->fetch_assoc()['id'];
				$res = $conn->query('UPDATE diploma SET id_review_fk = '.$last_review.' WHERE id = (SELECT id_diploma_fk FROM student WHERE id = '.$this->student.')');
				if($res != 1)
				{
					return 0;
				}
				else
				{
					return 1;
				}
			}
		}

		public function update_review()
		{
			require('blocks/connect.php');
			$stmt = $conn->prepare('UPDATE review SET last_name = ?, first_name = ?, patronymic = ?, post = ?, place_work = ? WHERE id = (SELECT id_review_fk FROM diploma WHERE id = (SELECT id_diploma_fk FROM student WHERE id = ?))');
			$stmt->bind_param('sssssi', $this->last_name, $this->first_name, $this->patronymic, $this->post, $this->place_work, $this->student);
			if($stmt->execute() != 1)
			{
				return 0;
			}
			else
			{
				return 1;
			}
		}

		//удаление рецензии
		public function delete_reviewer()
		{
			require('blocks/connect.php');
			$res = $conn->query('DELETE FROM review WHERE id = (SELECT id_review_fk FROM diploma WHERE id = (SELECT id_diploma_fk FROM student WHERE id = '.$this->student.'))');
			if($res != 1)
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