<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	$mode_1 = $_POST['mode_1'];

	if($mode_1 == 1)
	{
		require_once('user_classes/class_man.php');

		$reviewer = new reviewer();

		$result = array('last_name' => $reviewer->check_last_name($_POST['last_name']), 'first_name' => $reviewer->check_first_name($_POST['first_name']), 'patronymic' => $reviewer->check_patronymic($_POST['patronymic']), 'post' => $reviewer->check_post($_POST['post']), 'place_work' => $reviewer->check_place_work($_POST['place_work']), 'student' => $reviewer->check_student($_POST['student']), );
		check_result($result);

		$result_reviewer = $reviewer->add_reviewer();
		$result = array('review' => $result_reviewer);
		echo json_encode($result);
        exit;
	}

	if($mode_1 == 2)
	{
		require_once('user_classes/class_man.php');

		$reviewer = new reviewer();

		$result = array('student' => $reviewer->check_student($_POST['student']), 'last_name' => $reviewer->check_last_name($_POST['last_name']), 'first_name' => $reviewer->check_first_name($_POST['first_name']), 'patronymic' =>  $reviewer->check_patronymic($_POST['patronymic']), 'post' => $reviewer->check_post($_POST['post']), 'place_work' => $reviewer->check_place_work($_POST['place_work']));
		check_result($result);

		$result_supervisor = $reviewer->update_review();
		$result = array('review' => $result_supervisor);
		echo json_encode($result);
        exit;
	}

	if($mode_1 == 3)
	{
		require_once('user_classes/class_man.php');
		$reviewer = new reviewer();

		$result = array('arr_1' => $reviewer->check_student($_POST['arr_1']));
		check_result($result);

		$result_reviewer = $reviewer->delete_reviewer();
		$result = array('review' => $result_reviewer);
		echo json_encode($result);
        exit;
	}

	if($_POST['mode_other'] == 1)
	{
		if(0 < $_POST['group'] && $_POST['group'] < 10000)
		{
			$group = $_POST['group'];
			$result_student = $conn->query('SELECT id, number_record_book, last_name, first_name FROM student WHERE id_group_fk = '.$group.' AND id_diploma_fk IN (SELECT id FROM diploma WHERE id_review_fk IS NULL)'); // AND (id_kind_work_fk = 2 OR id_kind_work_fk = 3)
			while($arr = $result_student->fetch_assoc())
			{
				$arr_new[] = array('arr_1' => $arr['id'], 'number_record_book' => $arr['number_record_book'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name']);
			}
			echo json_encode($arr_new);
		}
	    exit;
	}

	if($_GET['mode_other'] == 2)
	{
		$select = $_GET['select'];
		if(0 < $select && $select < 1000)
		{
			$result = $conn->query('SELECT id, number_record_book, last_name, first_name FROM student WHERE id_group_fk ='.$select.' AND id_diploma_fk IN (SELECT id FROM diploma WHERE id_review_fk IS NOT NULL)') or die($conn->error);
			while($arr = $result->fetch_assoc())
			{
				$arr_new[] = array('arr_1' => $arr['id'], 'number_record_book' => $arr['number_record_book'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name']);
			}
			echo json_encode($arr_new);
		}
	}
?>