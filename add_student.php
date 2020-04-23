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
			return 1;
		}
	}

	function check_name($data)
	{
		$status = check_empty($data);
		if($status == 0)
		{
			return $status;
		}
		$pattern_2 = '/^[а-яА-ЯЁё]{2,254}$/u';
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
		if(empty($data))
		{
			return 1;
		}
		else
		{
			$pattern_1 = '/^[0].[1-9][0-9]{0,16}$/u';
			if(!preg_match($pattern_1, $data))
			{
				return 2;
			}
		}
	}

	function choice_kind_work($data)
	{
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

	function get_diploma()
	{
		$qsd = $conn->query('SELECT id from diploma ORDER BY id DESC LIMIT 1');
		$
	}

	if(isset($_POST['nrb']))
	{
		$result = array('first' => check_nrb($_POST['nrb']), 'second' => check_name($_POST['last_name']), 'third' => check_name($_POST['first_name']), 'fourth' => check_name($_POST['patronymic']), 'fifth' => check_num($_POST['group_1']), 'sixth' => check_empty($_POST['topic']), 'seventh' => check_num($_POST['type_work']), 'eighth' => check_ap($_POST['anti_plagiarism']), 'ninth' => check_num($_POST['supervisor']));

		foreach($result as $val)
		{
			if($val != 1)
			{
				echo json_encode($result);
				exit;
			}
		}

		require('classes/class_man.php');
		require('classes/class_event.php');

		$student = new student($_POST['last_name'], $_POST['first_name'], $_POST['patronymic'], $_POST['nrb'], $_POST['group_1']);
		$supervisor = new supervisor($_POST['last_name'], $_POST['first_name'], $_POST['patronymic']);
		$diploma = new diploma($_POST['topic'], choice_kind_work($_POST['group_1']), $_POST['supervisor'])

		if(empty($_POST['anti_plagiarism'])
		{
			$diploma->anti_plagiarism = 'NULL';
		}
		else
		{
			$diploma->anti_plagiarism = $_POST['anti_plagiarism'];
		}

		$diploma->type_work = $_POST['type_work'];

		$qid = $conn->prepare('INSERT INTO diploma (topic, anti_plagiarism, id_kind_work_fk, id_teacher_fk, id_type_work_fk) VALUES(?,?,?,?,?)')

		$diploma->id = get_diploma()

		$qis = $conn->prepare('INSERT INTO student (number_record_book, last_name, first_name, patronymic, id_group_fk, id_diploma_fk) VALUES(?,?,?,?,?,?)')

		echo json_encode($result);
        //exit;
	}
?>