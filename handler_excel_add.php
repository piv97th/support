<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');
	require_once('Classes/PHPExcel.php');

	function next_id_diploma($row)
	{
		//$row1 = $row;
		$row = $row - 3;
		//echo "Дружок-пирожок тобой выбрана неправильная дверь";
		require("blocks/connect.php");
		$res = $conn->query('SELECT id from diploma ORDER BY id DESC LIMIT 1');
		$qdiploma_id = $res->fetch_assoc();
		//var_dump(mysqli_query($d, "SELECT COUNT(id) FROM diploma"));
		//$qdiploma_id = mysqli_fetch_row(mysqli_query($d, "SELECT id from diploma ORDER BY id DESC LIMIT 1"))[0];
		//$stmt = $conn->query('');
			//var_dump($qdiploma_id);
		return $qdiploma_id['id'];
		/*else
		{
			return 1;
		}*/
		
	}

	function ckind_work($group_1)
	{
		$kw;
		switch(mb_substr($group_1,2,1,'UTF-8'))
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

	function ssupervisor($last_name_supervisor, $first_name_supervisor, $patronymic_supervisor)
	{
		require("blocks/connect.php");
		//var_dump($patronymic_supervisor);
		$stmt = $conn->prepare('SELECT id, last_name, first_name, patronymic FROM teacher WHERE last_name = ? AND first_name = ? AND patronymic = ? ORDER BY id DESC LIMIT 1');
		$stmt->bind_param('sss', $last_name_supervisor, $first_name_supervisor, $patronymic_supervisor);
		$stmt->execute();
		$res = $stmt->get_result();
		$supervisor = $res->fetch_assoc();
		if(empty($supervisor['id']))
		{
			$result = array('supervisor' => 6);
			echo json_encode($result);
			exit;
		}
/*		$qteacher = mysqli_prepare($d, 'SELECT id, last_name, first_name, patronymic FROM teacher WHERE last_name = ? AND first_name = ? AND patronymic = ? ORDER BY id DESC LIMIT 1');
		mysqli_stmt_bind_param($qteacher, 'sss', $last_name_supervisor, $first_name_supervisor, $patronymic_supervisor);
		mysqli_stmt_execute($qteacher);
		$q_res = mysqli_stmt_get_result($qteacher);
		$id_teacher = mysqli_fetch_row($q_res)[0];
		if(empty($id_teacher))
		{
			echo "Такого руководителя нет";
			exit;
		}*/
		//var_dump($id_teacher);
		return $supervisor['id'];
	}

	function sgroup($group_1)
	{
		require("blocks/connect.php");
		$stmt = $conn->prepare('SELECT id from group_1 WHERE cipher_group = ?');
		$stmt->bind_param('s', $group_1);
		$stmt->execute();
		$res = $stmt->get_result();
		$group = $res->fetch_assoc();
/*		$qgroup = mysqli_prepare($d, 'SELECT id from group_1 WHERE cipher_group = ?');
		mysqli_stmt_bind_param($qgroup, 's', $group_1);
		mysqli_stmt_execute($qgroup);
		$q_res = mysqli_stmt_get_result($qgroup);
		$group = mysqli_fetch_row($q_res)[0];*/
		
		return $group['id'];
	}

	function cin_data($var, $row, $col, $group_1)
	{
		$col_p = $col+1;
		if(empty($var))
		{
			$result = array('cell' => 0);
			echo json_encode($result);
			exit;
		}
		
		$pattern_1 = '/^[0-9]{2}[Б,М,С][0-9]{4}$/u';
		$pattern_2 = '/^[а-яА-ЯЁё]{2,254}$/u';
		//$pattern_3 = '/[а-яА-ЯЁё]{2,255}/u';
		
		if($col == 0)
		{
			//$text = "иваснов1";
			$arr_was = array("б", "м", "с");
			$arr_become = array("Б", "М", "С");
			//echo $text;
			$var = str_replace($arr_was, $arr_become, $var);
			//var_dump($var);
			if(!preg_match($pattern_1, $var, $match))
			{
				$result = array('cell0' => 2);
				echo json_encode($result);
				exit;
			}
			else
			{
				if(exist_nrb($var) == TRUE)
				{
					$result = array('cell0' => 3);
					echo json_encode($result);
					exit;
				}
			}
		}
		
		if($col == 1 || $col == 2 || $col == 3 || $col == 6 || $col == 7 || $col == 8)
		{
			$var = mb_strtoupper(mb_substr($var, 0, 1)) . mb_strtolower(mb_substr($var, 1));
			//var_dump($var);
			if(!preg_match($pattern_2, $var))
			{
				$result = array('cellname' => 2);
				echo json_encode($result);
				exit;
			}
		}
		if($col == 5)
		{
			$var = mb_strtolower($var);
			switch($var)
			{
				case "простая":
					$var = 1;
					break;
				case "заказная":
					$var = 2;
					break;
				case "университетская":
					$var = 3;
					break;
				default:
					$result = array('cell5' => 2);
					echo json_encode($result);
					exit;
			}
		}
		
		return $var;
	}

	function insert_data($nrb, $last_name, $first_name, $patronymic, $id_group_fk, $topic, $id_kind_work_fk, $id_teacher_fk, $id_type_work_fk, $row)
	{
		require("blocks/connect.php");
		
		$stmt_diploma = $conn->prepare('INSERT INTO diploma (topic, id_kind_work_fk, id_teacher_fk, id_type_work_fk) VALUES(?,?,?,?)');
		//$stdiploma = mysqli_prepare($d, 'INSERT INTO diploma (topic, id_kind_work_fk, id_teacher_fk, id_type_work_fk) VALUES(?,?,?,?)');
		//$ststudent = mysqli_prepare($d, 'INSERT INTO diploma (number_record_book, last_name, first_name, patronymic, id_group_fk, id_diploma_fk) VALUES(?,?,?,?,?,?)');
		
		$stmt_diploma->bind_param('siii', $topic,  $id_kind_work_fk, $id_teacher_fk, $id_type_work_fk);
		//mysqli_stmt_bind_param($ststudent, 'ssssii', $nrb, $last_name, $first_name, $patronymic, $id_group_fk, $id_diploma_fk);
		
		if($stmt_diploma->execute() != 1)
		{
			$result = array('diploma' => '0');
			echo json_encode($result);
			exit;
		}
		else
		{
			$result = array('diploma' => 1);
		}

		$stmt_student = $conn->prepare('INSERT INTO student (number_record_book, last_name, first_name, patronymic, id_group_fk, id_diploma_fk) VALUES(?,?,?,?,?,?)');
		$id_diploma_fk = next_id_diploma($row);
		//var_dump($id_diploma_fk);
		
		$stmt_student->bind_param('ssssii', $nrb, $last_name, $first_name, $patronymic, $id_group_fk, $id_diploma_fk);
		if($stmt_student->execute() != 1)
		{
			$result = array('student' => '0');
			echo json_encode($result);
			exit;
		}
		else
		{
			$result += ['student' => 1];
		}

/*		echo json_encode($result);
		exit;*/

/*		$flag_exit = FALSE;
		foreach($result as $i)
		{
			if($i != 1)
			{
				echo json_encode($arr);
				exit;
			}
		}*/
		//mysqli_stmt_bind_param($ststudent, 'ssssii', $nrb, $last_name, $first_name, $patronymic, $id_group_fk, $id_diploma_fk);
		//mysqli_stmt_execute($ststudent);
	}

	if($_FILES['file_blank']['error'] == 4)
	{
		$result = array('file' => 0);
	}

	if($_FILES['file_blank']['error'] == 0)
	{
		if(($_FILES['file_blank']['type'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || ($_FILES['file_blank']['type'] == "application/vnd.ms-excel"))
		{
			if($_FILES['file_blank']['size'] >= 15360)
			{
				$result = array('file' => 2);
			}
			else
			{
				$result = array('file' => 1);
			}
		}
		else
		{
			$result = array('file' => 4);
		}
	}
	else
	{
		$result = array('file' => 5);
	}

	check_result($result);

	$destination_dir = $_FILES['file_blank']['name'];
	if(!(move_uploaded_file($_FILES['file_blank']['tmp_name'], $destination_dir )))
	{
		$result = array('file' => 0);
		echo json_encode($result);
		exit;
	}

	$objPHPExcel = PHPExcel_IOFactory::load($destination_dir);

    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
    {
    	require_once('user_classes/class_man.php');
		//require_once('user_classes/class_inanimate.php');

		$student = new student();
		//$diploma = new diploma();
		$student->cipher_group = $worksheet->getCellByColumnAndRow(0, 1)->getValue();
		//echo $student->cipher_group;
    	
    	$result = array('last_use_row' => check_empty($worksheet->getHighestRow()), 'last_use_column' =>  check_empty($worksheet->getHighestColumn()), 'last_use_column_index' => check_empty($worksheet->getHighestColumn(PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn()))), 'group_1' => $student->check_group_by_cipher());

		check_result($result);
		//echo 111;
		//Имя таблицы
/*        $Title              = $worksheet->getTitle();
		cvar($Title);*/
        //Последняя используемая строка
        $lastRow         = $worksheet->getHighestRow();
        //Последний используемый столбец
        $lastColumn      = $worksheet->getHighestColumn();
        //Последний используемый индекс столбца
        $lastColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
		//var_dump($lastColumnIndex);
		// Первая строка с данными
		$first_need_row = 4;
		// Группа
		
		//var_dump($worksheet->getCellByColumnAndRow(0, 1)->getValue());
		
		//cgroup($group_1);*/

/*		$result = array('nrb' => $student->check_nrb($_POST['nrb']), 'last_name' => $student->check_last_name($_POST['last_name']), 'first_name' => $student->check_first_name($_POST['first_name']), 'patronymic' =>  $student->check_patronymic($_POST['patronymic']), 'group_1' => $student->check_group($_POST['group_1']));

		$result += ['topic' => $diploma->check_topic($_POST['topic']), 'type_work' => $diploma->check_type_work($_POST['type_work']), 'anti_plagiarism' => $diploma->check_ap($_POST['anti_plagiarism']), 'supervisor' => $diploma->check_supervisor($_POST['supervisor'])];*/
		//check_result($result);

		for ($row = $first_need_row; $row <= $lastRow; ++$row)
		{
			$arr_data = array();
			for ($col = 0; $col < $lastColumnIndex; ++ $col)
			{
				$arr_data[] = cin_data($worksheet->getCellByColumnAndRow($col, $row)->getValue(), $row, $col, $student->group_1);	
			}
			$group_fk = sgroup($student->group_1);
			$supervisor_fk = ssupervisor($arr_data[6], $arr_data[7], $arr_data[8]);
			$kind_work_fk=ckind_work($student->group_1);
			insert_data($arr_data[0], $arr_data[1], $arr_data[2], $arr_data[3], $group_fk, $arr_data[4], $kind_work_fk, $supervisor_fk, $arr_data[5], $row);
		}

	/*$mode_1 = $_POST['mode_1'];

	if(isset($_POST['nrb']) && $mode_1 == 1)
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

		require_once('user_classes/class_man.php');
		require_once('user_classes/class_inanimate.php');

		$student = new student(['last_name' => $_POST['last_name'], 'first_name' => $_POST['first_name'], 'patronymic' => $_POST['patronymic'], 'nrb' => $_POST['nrb'], 'group_1' => $_POST['group_1']]);

		$kind_work = choice_kind_work($_POST['group_1']);

		$diploma = new diploma(['topic' => $_POST['topic'], 'anti_plagiarism' => $_POST['anti_plagiarism'], 'kind_work' => $kind_work, 'supervisor' => $_POST['supervisor'], 'type_work' => $_POST['type_work']]);

		$diploma->add_diploma();
		$student->diploma = $diploma->get_diploma();
		$student->add_student();*/

		echo json_encode($result);
        exit;
	}
?>