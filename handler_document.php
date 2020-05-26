<?php require('check_login.php'); ?>
<?php
	require('blocks/connect.php');
	require_once('blocks/check_data.php');

	function exsist_ap($student)
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT anti_plagiarism FROM diploma WHERE id = (SELECT id_diploma_fk FROM student WHERE id = '.$student.') AND anti_plagiarism IS NOT NULL ');
		$row = $result->fetch_assoc();
		if($row['anti_plagiarism'] != 0 || $row['anti_plagiarism'] != NULL)
		{
			return 1;
		}
	}

	function exsist_protocol_se($student)
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id_mark_fk FROM se WHERE id = (SELECT id_se_fk FROM student WHERE id = '.$student.') AND id_mark_fk IS NOT NULL');
		$row = $result->fetch_assoc();
		if($row['id_se_fk'] != 0 || $row['id_se_fk'] != NULL)
		{
			return 1;
		}
	}

	function exsist_protocol_diploma($student)
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id_mark_fk FROM diploma WHERE id = (SELECT id_diploma_fk FROM student WHERE id = '.$student.') AND id_mark_fk IS NOT NULL');
		$row = $result->fetch_assoc();
		if($row['id_diploma_fk'] != NULL)
		{
			return 1;
		}
	}

	$mode_1 = $_POST['mode_1'];

	if($mode_1 == 1)
	{
		
	}

	if($_POST['mode_other'] == 1)
	{
		if(0 < $_POST['select'] && $_POST['select'] < 10000)
		{
			$select = $_POST['select'];
			$result_student = $conn->query('SELECT id, number_record_book, last_name, first_name FROM student WHERE id_group_fk = '.$select);
			// id_diploma_fk IN (SELECT id FROM diploma WHERE id_mark_fk IS NOT NULL) AND id_se_fk IN (SELECT id FROM se WHERE id_mark_fk IS NOT NULL) AND
			while($arr = $result_student->fetch_assoc())
			{
				$arr_new[] = array('arr_1' => $arr['id'], 'number_record_book' => $arr['number_record_book'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name']);
			}
			echo json_encode($arr_new);
		}
	    exit;
	}

	if($_POST['mode_other'] == 2)
	{
		$student = $_POST['arr_1'];
		$result = array('reference' => 1);
		if(exsist_ap($student) == 1)
		{
			$result += ['conclusion' => 2];
			if(exsist_protocol_se($student) == 1)
			{
				$result += ['protocol_se' => 3];
				if(exsist_protocol_diploma($student) == 1)
				{
					$result += ['protocol_diploma' => 4];
					$result += ['protocol_certification' => 5];
					$result += ['private file' => 6];
				}
			}
		}
		echo json_encode($result);
	}

	if($_POST['mode_other'] == 3)
	{
		$result_commission = $conn->query('SELECT id, order_1 FROM commission');
		while($arr = $result_commission->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'order_1' => $arr['order_1']);
		}
		echo json_encode($arr_new);
        exit;
	}

	if($_POST['mode_other'] == 4)
	{
		$result_supervisor = $conn->query('SELECT id, cipher_teacher, last_name, first_name FROM teacher');
		while($arr = $result_supervisor->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'cipher_supervisor' => $arr['cipher_teacher'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name']);
		}
		echo json_encode($arr_new);
        exit;
	}

	if($_POST['mode_other'] == 5)
	{
		$result_member_ssk = $conn->query('SELECT id, last_name, first_name, post FROM member_ssk');
		while($arr = $result_member_ssk->fetch_assoc())
		{
			$arr_new[] = array('arr_1' => $arr['id'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name'], 'post' => $arr['post']);
		}
		echo json_encode($arr_new);
        exit;
	}

?>