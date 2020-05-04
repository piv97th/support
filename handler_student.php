<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	$mode_1 = $_POST['mode_1'];

	if(isset($_POST['nrb']) && $mode_1 == 1)
	{
		require_once('user_classes/class_man.php');
		require_once('user_classes/class_inanimate.php');

		$student = new student();
		$diploma = new diploma();

		$result = array('nrb' => $student->check_nrb($_POST['nrb']), 'last_name' => $student->check_last_name($_POST['last_name']), 'first_name' => $student->check_first_name($_POST['first_name']), 'patronymic' =>  $student->check_patronymic($_POST['patronymic']), 'group_1' => $student->check_group($_POST['group_1']));

		$result += ['topic' => $diploma->check_topic($_POST['topic']), 'type_work' => $diploma->check_type_work($_POST['type_work']), 'anti_plagiarism' => $diploma->check_ap($_POST['anti_plagiarism']), 'supervisor' => $diploma->check_supervisor($_POST['supervisor'])];
		check_result($result);

		$diploma->kind_work = choice_kind_work($student->group_1);

		$diploma->add_diploma();
		$student->diploma = $diploma->get_diploma();
		$student->add_student();
		echo json_encode($result);
        exit;
	}

	if(isset($_POST['nrb']) && $mode_1 == 2)
	{
		/*$result = array('first' => check_nrb_u($_POST['nrb']), 'second' => check_name($_POST['last_name']), 'third' => check_name($_POST['first_name']), 'fourth' => check_name($_POST['patronymic']), 'fifth' => check_num($_POST['group_1']), 'seventh' => check_empty($_POST['topic']), 'eighth' => check_num($_POST['type_work']), 'ninth' => check_ap($_POST['anti_plagiarism']), 'tenth' => check_num($_POST['supervisor']), 'tenth' => check_num($_POST['arr_1']));

		foreach($result as $val)
		{
			if($val != 1)
			{
				echo json_encode($result);
				exit;
			}
		}*/

		require_once('user_classes/class_man.php');
		require_once('user_classes/class_inanimate.php');

		$student = new student(['last_name' => $_POST['last_name'], 'first_name' => $_POST['first_name'], 'patronymic' => $_POST['patronymic'], 'nrb' => $_POST['nrb'], 'group_1' => $_POST['group_1']]);
		$student->id = $_POST['arr_1'];

		$kind_work = choice_kind_work($_POST['group_1']);

		$diploma = new diploma(['topic' => $_POST['topic'], 'anti_plagiarism' => $_POST['anti_plagiarism'], 'kind_work' => $kind_work, 'supervisor' => $_POST['supervisor'], 'type_work' => $_POST['type_work']]);

		$diploma->id = $student->get_info_student['id_diploma_fk'];
		//$student->diploma = $diploma->get_diploma();
		$diploma->update_diploma();
		$student->update_student();

		echo json_encode($result);
        exit;
	}

	if($mode_1 == 3)
	{
		$result = array('first' => check_num($_POST['arr_1']), 'second' => check_num($_POST['mode_1']));

		check_result($result);

		require_once('user_classes/class_man.php');
		require_once('user_classes/class_inanimate.php');

		$student = new student(['id' => $_POST['arr_1']]);
		$result = $student->delete_student();

		echo json_encode($result);
        exit;
	}
?>