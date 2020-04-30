<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');
	require_once('Classes/PHPExcel.php');

	if($_FILES['file_blank']['error'] == 4)
	{
		$result = array('thirteenth' => 0);
	}

	if($_FILES['file_blank']['error'] == 0)
	{
		if(($_FILES['file_blank']['type'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || ($_FILES['file_blank']['type'] == "application/vnd.ms-excel"))
		{
			if($_FILES['file_blank']['size'] <= 15360)
			{
				$result = array('thirteenth' => 1);
			}
			else
			{
				$result = array('thirteenth' => 2);
			}
		}
		else
		{
			$result = array('thirteenth' => 0);
		}
	}
	else
	{
		$result = array('thirteenth' => 0);
	}

	foreach($result as $val)
	{
		if($val != 1)
		{
			echo json_encode($result);
			exit;
		}
	}

	$destination_dir = $_FILES['file_blank']['name'];
	if(!(move_uploaded_file($_FILES['file_blank']['tmp_name'], $destination_dir )))
	{
		$result = array('thirteenth' => 0);
		echo json_encode($result);
		exit;
	}

	$objPHPExcel = PHPExcel_IOFactory::load($destination_dir);

    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
    {
    	$result = array('first' => check_empty($worksheet->getHighestRow()), 'fourteenth' =>  check_empty($worksheet->getHighestColumn()), 'fifteenth' => check_empty($worksheet->getHighestColumn(PHPExcel_Cell::columnIndexFromString($lastColumn))), 'sixteenth' => check_group($worksheet->getCellByColumnAndRow(0, 1)->getValue();))

	    foreach($result as $val)
		{
			if($val != 1)
			{
				echo json_encode($result);
				exit;
			}
		}
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
		
		//cgroup($group_1);

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