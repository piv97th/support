<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');
	require_once('Classes/PHPExcel.php');

	function get_last_id()
	{
		require("blocks/connect.php");
		$res = $conn->query('SELECT id from diploma ORDER BY id DESC LIMIT 1');
		$qdiploma_id = $res->fetch_assoc();
		if($qdiploma_id == NULL)
		{
			return 1;
		}
		else
		{
			return $qdiploma_id['id'];
		}
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
		
		return $group['id'];
	}

	function cin_data($var, $col, $row)
	{
		if(empty($var))
		{
			$result = array('cell' => 0);
			echo json_encode($result);
			exit;
		}
		
		$pattern_1 = '/^[0-9]{2}[Б,М,С][0-9]{4}$/u';
		$pattern_2 = '/^[а-яА-ЯЁё]{2,254}$/u';
		
		if($col == 0)
		{
			$arr_was = array("б", "м", "с");
			$arr_become = array("Б", "М", "С");
			$var = str_replace($arr_was, $arr_become, $var);
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
			if(!preg_match($pattern_2, $var))
			{
				$result = array('cellname' => 2);
				echo json_encode($result);
				exit;
			}
		}

		if($col == 4)
		{
			if(1 > mb_strlen($var) || 255 < mb_strlen($var))
			{
				$result = array('celltopic' => 2);
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

	function insert_data($arr_data, $id_group_fk, $id_kind_work_fk)
	{
		require("blocks/connect.php");



		$c = count($arr_data);

		for($i = 0; $i < $c ; $i++)
		{
			$arr_id_teacher_fk[] = ssupervisor($arr_data[$i+4][6], $arr_data[$i+4][7], $arr_data[$i+4][8]);
		}
		for($i = 0; $i < $c; $i++)
		{
			$stmt_diploma = $conn->prepare('INSERT INTO diploma (topic, id_kind_work_fk, id_teacher_fk, id_type_work_fk) VALUES(?,?,?,?)');
			$stmt_diploma->bind_param('siii', $arr_data[$i+4][4],  $id_kind_work_fk, $arr_id_teacher_fk[$i], $arr_data[$i+4][5]);
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
			$insert_id = get_last_id();

			$stmt_student = $conn->prepare('INSERT INTO student (number_record_book, last_name, first_name, patronymic, id_group_fk, id_diploma_fk) VALUES(?,?,?,?,?,?)');

			$stmt_student->bind_param('ssssii', $arr_data[$i+4][0], $arr_data[$i+4][1], $arr_data[$i+4][2], $arr_data[$i+4][3], $id_group_fk, $insert_id);
			if($stmt_student->execute() != 1)
			{
				$result = array('student' => '0');
				echo json_encode($result);
				exit;
			}
			else
			{
				$result = array('student' => 1);
			}
		}
	}

	if($_FILES['file_blank']['error'] != 4)
	{
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
	}
	else
	{
		$result = array('file' => 0);
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
		$student = new student();
		$student->cipher_group = $worksheet->getCellByColumnAndRow(0, 1)->getValue();
    	
    	$result = array('last_use_row' => check_empty($worksheet->getHighestRow()), 'last_use_column' =>  check_empty($worksheet->getHighestColumn()), 'last_use_column_index' => check_empty($worksheet->getHighestColumn(PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn()))), 'group_1' => $student->check_group_by_cipher());

		check_result($result);
        //Последняя используемая строка
        $lastRow         = $worksheet->getHighestRow();
        //Последний используемый столбец
        $lastColumn      = $worksheet->getHighestColumn();
        //Последний используемый индекс столбца
        $lastColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
		// Первая строка с данными
		$first_need_row = 4;

		//$arr_data = [[]];
		for ($row = $first_need_row; $row <= $lastRow; ++$row)
		{
			if(TRUE)
			{
				for ($col = 0; $col < $lastColumnIndex; ++ $col)
				{
					$arr_data[$row][$col] = cin_data($worksheet->getCellByColumnAndRow($col, $row)->getValue(), $col, $row);
				}
			}
		}
		$id_group_fk = sgroup($student->group_1);
		$id_kind_work_fk = ckind_work($student->group_1);
		insert_data($arr_data, $id_group_fk, $id_kind_work_fk);

		echo json_encode($result);
        exit;
	}
?>