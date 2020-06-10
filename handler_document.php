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
		if($row['id_mark_fk'] != 0 || $row['id_mark_fk'] != NULL)
		{
			return 1;
		}
	}

	function exsist_protocol_diploma($student)
	{
		require('blocks/connect.php');
		$result = $conn->query('SELECT id_mark_fk FROM diploma WHERE id = (SELECT id_diploma_fk FROM student WHERE id = '.$student.') AND id_mark_fk IS NOT NULL');
		$row = $result->fetch_assoc();
		if($row['id_mark_fk'] != NULL)
		{
			return 1;
		}
	}

	//$mode_1 = $_POST['mode_1'];

	if($_POST['doc'] == 1)
	{
		$student = $_POST['arr_1_student'];


		$res_student = $conn->query('SELECT * FROM student WHERE id = '.$student);
		$arr_student = $res_student->fetch_assoc();

		$res_diploma = $conn->query('SELECT topic FROM diploma WHERE id = '.$arr_student["id_diploma_fk"]);
		$arr_diploma = $res_diploma->fetch_assoc();

		$res_group = $conn->query('SELECT cathedra.name, cathedra.last_name, cathedra.first_name, cathedra.patronymic, cathedra.abbreviation, direction.cipher_direction, group_1.id FROM group_1 INNER JOIN cathedra ON group_1.id_cathedra_fk = cathedra.id INNER JOIN direction ON group_1.id_direction_fk = direction.id WHERE group_1.id = (SELECT id_group_fk FROM student WHERE id = '.$student.')');
		$arr_group = $res_group->fetch_assoc();

		$result_member_ssk = $conn->query('SELECT last_name, first_name, patronymic FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 1 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');
		$arr_member_ssk = $result_member_ssk->fetch_assoc();

		require 'vendor/autoload.php';
		require 'ncl_lib/NCLNameCaseRu.php';

		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		$section = $phpWord->createSection();

		$arr_style_text = array('name' => 'Arial', 'size' => 16);
		$arr_paragraph_center = array('align' => 'center', 'lineHeight' => 1.5);
		$arr_paragraph_left = array('align' => 'left', 'lineHeight' => 1.5);

		$section->addImage('img/gerb.png', array('width' => 100, 'height' => 100, 'align'=>'center'));

		$section->addText("МИНОБРНАУКИ РОССИИ", $arr_style_text, $arr_paragraph_center);
		$section->addText("Федеральное государственное бюджетное образовательное учреждение", $arr_style_text, $arr_paragraph_center);
		$section->addText("«МИРЭА - Российский технологический университет»", $arr_style_text, $arr_paragraph_center);
		$section->addText("Кафедра $arr_group[name]", $arr_style_text, $arr_paragraph_center);
		
		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText('Направление', array('size' => 16), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group['cipher_direction'], array('size' => 16), array('align'=>'center'));

		$section->addText("ПРЕДСЕДАТЕЛЮ ЭКЗАМЕНАЦИОННОЙ КОМИССИИ", $arr_style_text, $arr_paragraph_center);

		$nc = new NCLNameCaseRu();
		//echo $nc->qFatherName("Николаевич", NCL::$DATELN)."\n";
		$last_name_cm = $nc->qFirstName($arr_member_ssk['last_name'], NCL::$DATELN);
		$first_name_cm = mb_strtoupper($arr_member_ssk['first_name']);
		$patronymic_cm = mb_strtoupper($arr_member_ssk['patronymic']);

//mb_substr($word,0,1,'UTF-8');
		$section->addText($arr_member_ssk['last_name'].' '.$first_name_cm.'.'.$patronymic_cm.'.', array('name' => 'Arial', 'size' => 16, 'bold' => 'true'), $arr_paragraph_center);
		$section->addText("«МИРЭА - Российский технологический университет»", $arr_style_text, $arr_paragraph_center);
		
		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText('Студент', array('size' => 16), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_student["last_name"].' '.$arr_student["first_name"].' '.$arr_student["patronymic"], array('size' => 16, 'bold' => 'true'), array('align'=>'center'));


		$section->addText("Выполнил выпускную квалификационную работу на тему:", $arr_style_text, $arr_paragraph_center);
		//enter
		$section->addText($arr_diploma["topic"], $arr_style_text, $arr_paragraph_center);
		//enter
		$section->addText("к защите выпускной квалификационной работы в Государственной экзаменационнойкомиссии           ДОПУЩЕН", $arr_style_text, $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText('Зав. кафедрой'.$arr_group["abbreviation"], array('size' => 16), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["last_name"].' '.$arr_group["first_name"].' '.$arr_group["patronymic"], array('size' => 16, 'bold' => 'true'), array('align'=>'center'));
		//enter
		//todo zav


		$file = 'Справка_'.$arr_student["number_record_book"].'_'.$arr_student["last_name"].'_'.$arr_student["first_name"].'.docx';
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$xmlWriter->save("php://output");
		
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
					$result += ['private_file' => 6];
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