<?php require('check_login.php'); ?>
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

		$result_diploma = $diploma->add_diploma();
		$result = array('diploma' => $result_diploma);
		check_result($result);

		$student->diploma = $diploma->get_diploma();
		
		$result_student = $student->add_student();
		$result += ['student' => $result_student];
		echo json_encode($result);
        exit;
	}

	if(isset($_POST['nrb']) && $mode_1 == 2)
	{

		require_once('user_classes/class_man.php');
		require_once('user_classes/class_inanimate.php');

		$student = new student();
		$diploma = new diploma();

		$result = array('arr_1' => $student->check_arr_1($_POST['arr_1']), 'nrb' => $student->check_nrb_u($_POST['nrb']), 'last_name' => $student->check_last_name($_POST['last_name']), 'first_name' => $student->check_first_name($_POST['first_name']), 'patronymic' =>  $student->check_patronymic($_POST['patronymic']), 'group_1' => $student->check_group($_POST['group_1']));

		$result += ['topic' => $diploma->check_topic($_POST['topic']), 'type_work' => $diploma->check_type_work($_POST['type_work']), 'anti_plagiarism' => $diploma->check_ap($_POST['anti_plagiarism']), 'supervisor' => $diploma->check_supervisor($_POST['supervisor'])];
		check_result($result);

		$diploma->id = $student->get_diploma_fk();

		if(isset($_POST['protocol_diploma']))
		{
			if(isset($_POST['mark_diploma']))
			{
				$result += ['protocol_diploma' => $diploma->check_protocol($_POST['protocol_diploma']), 'meeting_diploma' => $diploma->check_meeting($_POST['meeting_diploma']), 'mark_diploma' => $diploma->check_mark($_POST['mark_diploma'])];
			}
			else
			{
				$result += ['protocol_diploma' => $diploma->check_protocol($_POST['protocol_diploma']), 'meeting_diploma' => $diploma->check_meeting($_POST['meeting_diploma'])];
			}

		}

		$diploma->kind_work = choice_kind_work($student->group_1);

		if(isset($_POST['protocol_se']))
		{
			$se = new se();
			$se->id = $student->get_se_fk();
			if(isset($_POST['ticket_se']))
			{
				if(isset($_POST['mark_se']))
				{
					$result += ['protocol_se' => $se->check_protocol($_POST['protocol_se']), 'meeting_se' => $se->check_meeting($_POST['meeting_se']), 'ticket_se' => $se->check_ticket($_POST['ticket_se']), 'mark_se' => $se->check_mark($_POST['mark_se'])];
				}
				else
				{
					$result += ['protocol_se' => $se->check_protocol($_POST['protocol_se']), 'meeting_se' => $se->check_meeting($_POST['meeting_se']), 'ticket_se' => $se->check_ticket($_POST['ticket_se'])];
				}
			}
			else
			{
				$result += ['protocol_se' => $se->check_protocol($_POST['protocol_se']), 'meeting_se' => $se->check_meeting($_POST['meeting_se'])];
			}
			$result_se = $se->update_se();
			$result = array('se' => $result_se);
			check_result($result);
		}

		$result_diploma = $diploma->update_diploma();
		$result += ['diploma' => $result_diploma];
		check_result($result);
		
		$result_student = $student->update_student();
		$result += ['student' => $result_student];
		echo json_encode($result);
        exit;
	}

	if($mode_1 == 3)
	{
		require_once('user_classes/class_man.php');

		$student = new student();

		$result = array('arr_1' => $student->check_arr_1($_POST['arr_1']));
		check_result($result);

		$result_student = $student->delete_student();
		$result = array('student' => $result_student);

		echo json_encode($result);
        exit;
	}
?>