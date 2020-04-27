<?php
	require('blocks/connect.php');

	function check_empty($data)
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

	function exist_nrb($data)
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

	function check_nrb($data)
	{
		$status = check_empty($data);
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
			if(exist_nrb($data) == TRUE)
			{
				return 3;
			}
			else
			{
				return 1;
			}
		}
	}

	function check_name($data)
	{
		$status = check_empty($data);
		if($status == 0)
		{
			return $status;
		}
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

	function check_num($data)
	{
		$status = check_empty($data);
		if(!is_numeric($data) || 1 > mb_strlen($data) || 4 < mb_strlen($data))
		{
			return 2;
		}
		else
		{
			return 1;
		}
	}

	function check_ap($data)
	{
		if(empty($data) && isset($data))
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
			return 1;
		}
	}

	function choice_kind_work($data)
	{
		require('blocks/connect.php');
		$query = $conn->query('SELECT cipher_group from group_1 WHERE id = '.$data);
		$data = $query->fetch_row()[0];
		$kw;
		switch(mb_substr($data,2,1,'UTF-8'))
		{
			case "Б":
				$kw = 1;
				break;
			case "М":
				$kw = 2;
				break;
			case "С":
				$kw = 3;
				break;
		}

		return $kw;
	}

	if(isset($_POST['nrb']))
	{
		$result = array('first' => check_nrb($_POST['nrb']), 'second' => check_name($_POST['last_name']), 'third' => check_name($_POST['first_name']), 'fourth' => check_name($_POST['patronymic']), 'fifth' => check_num($_POST['group_1']), 'seventh' => check_empty($_POST['topic']), 'eighth' => check_num($_POST['type_work']), 'ninth' => check_ap($_POST['anti_plagiarism']), 'tenth' => check_num($_POST['supervisor']));

		foreach($result as $val)
		{
			if($val != 1)
			{
				echo json_encode($result);
				exit;
			}
		}

		require('classes/class_man.php');
		require('classes/class_inanimate.php');

		$student = new student(['last_name' => $_POST['last_name'], 'first_name' => $_POST['first_name'], 'patronymic' => $_POST['patronymic'], 'nrb' => $_POST['nrb'], 'group_1' => $_POST['group_1']]);

		$kind_work = choice_kind_work($_POST['group_1']);

		$diploma = new diploma(['topic' => $_POST['topic'], 'anti_plagiarism' => $_POST['anti_plagiarism'], 'kind_work' => $kind_work, 'supervisor' => $_POST['supervisor'], 'type_work' => $_POST['type_work']]);

		$diploma->add_diploma();
		$student->diploma = $diploma->get_diploma();
		$student->add_student();

		echo json_encode($result);
        exit;
	}
?>