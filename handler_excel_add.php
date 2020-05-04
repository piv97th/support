<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');
	require_once('Classes/PHPExcel.php');

	if($_FILES['file_blank']['error'] == 4)
	{
		$result = array('file' => 0);
	}

	if($_FILES['file_blank']['error'] == 0)
	{
		if(($_FILES['file_blank']['type'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || ($_FILES['file_blank']['type'] == "application/vnd.ms-excel"))
		{
			if($_FILES['file_blank']['size'] <= 15360)
			{
				$result = array('file' => 1);
			}
			else
			{
				$result = array('file' => 2);
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
		require_once('user_classes/class_inanimate.php');

		$student = new student();
		$diploma = new diploma();
    	
    	$result = array('last_use_row' => check_empty($worksheet->getHighestRow()), 'last_use_column' =>  check_empty($worksheet->getHighestColumn()), 'last_use_column_index' => check_empty($worksheet->getHighestColumn(PHPExcel_Cell::columnIndexFromString($lastColumn))), 'group_1' => $student->check_group($worksheet->getCellByColumnAndRow(0, 1)->getValue();))

		check_result($result);
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

		$result = array('nrb' => $student->check_nrb($_POST['nrb']), 'last_name' => $student->check_last_name($_POST['last_name']), 'first_name' => $student->check_first_name($_POST['first_name']), 'patronymic' =>  $student->check_patronymic($_POST['patronymic']), 'group_1' => $student->check_group($_POST['group_1']));

		$result += ['topic' => $diploma->check_topic($_POST['topic']), 'type_work' => $diploma->check_type_work($_POST['type_work']), 'anti_plagiarism' => $diploma->check_ap($_POST['anti_plagiarism']), 'supervisor' => $diploma->check_supervisor($_POST['supervisor'])];
		check_result($result);

		for ($row = $first_need_row; $row <= $lastRow; ++$row)
		{
			$arr_data = array();
			for ($col = 0; $col < $lastColumnIndex; ++ $col)
			{
				
			}
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