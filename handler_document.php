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

		$res_group = $conn->query('SELECT cathedra.name, cathedra.last_name, LEFT(cathedra.first_name, 1) as `first_name`, LEFT(cathedra.patronymic, 1) as `patronymic`, cathedra.abbreviation, direction.cipher_direction, group_1.id FROM group_1 INNER JOIN cathedra ON group_1.id_cathedra_fk = cathedra.id INNER JOIN direction ON group_1.id_direction_fk = direction.id WHERE group_1.id = (SELECT id_group_fk FROM student WHERE id = '.$student.')');
		$arr_group = $res_group->fetch_assoc();

		$result_member_ssk = $conn->query('SELECT last_name, LEFT(first_name, 1) as `first_name`, LEFT(patronymic, 1) as `patronymic` FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 1 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');
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
		$section->addText("Институт комплексной безопасности и специального приборостроения", $arr_style_text, $arr_paragraph_center);
		$section->addText("Кафедра $arr_group[name]", $arr_style_text, $arr_paragraph_center);
		
		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText('Направление', array('size' => 16), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group['cipher_direction'], array('size' => 16), array('align'=>'center'));

		$section->addText("ПРЕДСЕДАТЕЛЮ ЭКЗАМЕНАЦИОННОЙ КОМИССИИ", $arr_style_text, $arr_paragraph_center);

		$nc = new NCLNameCaseRu();
		$last_name_cm = $arr_member_ssk['last_name'];
		$first_name_cm = $arr_member_ssk['first_name'];
		$patronymic_cm = $arr_member_ssk['patronymic'];

		$section->addText($nc->qSecondName($last_name_cm, NCL::$DATELN).' '.$first_name_cm.'.'.$patronymic_cm.'.', array('name' => 'Arial', 'size' => 16, 'bold' => true), $arr_paragraph_center);
		
		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(4000, array('valign' => 'center'))->addText('Студент', array('size' => 16), array('align'=>'center'));
		$table->addCell(8000, array('valign' => 'center'))->addText($arr_student["last_name"].' '.$arr_student["first_name"].' '.$arr_student["patronymic"], array('size' => 16, 'bold' => true), array('align'=>'center'));


		$section->addText("Выполнил выпускную квалификационную работу на тему:", $arr_style_text, $arr_paragraph_center);
		$section->addText($arr_diploma["topic"], array('name' => 'Arial', 'size' => 16, 'bold' => true), $arr_paragraph_center);
		$section->addText("к защите выпускной квалификационной работы в Государственной экзаменационнойкомиссии ДОПУЩЕН", $arr_style_text, $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText('Зав. кафедрой '.$arr_group["abbreviation"], array('size' => 16), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["last_name"].'.'.$arr_group["first_name"].'.'.$arr_group["patronymic"], array('size' => 16), array('align'=>'center'));


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

	if($_POST['doc'] == 2)
	{
		$student = $_POST['arr_1_student'];


		$res_student = $conn->query('SELECT * FROM student WHERE id = '.$student);
		$arr_student = $res_student->fetch_assoc();

		$res_group = $conn->query('SELECT cipher_group FROM group_1 WHERE id = '.$arr_student["id_group_fk"]);
		$arr_group = $res_group->fetch_assoc();

		$res_diploma = $conn->query('SELECT topic, anti_plagiarism, id_kind_work_fk, id_teacher_fk FROM diploma WHERE id = '.$arr_student["id_diploma_fk"]);
		$arr_diploma = $res_diploma->fetch_assoc();

		$res_supervisor = $conn->query('SELECT last_name, LEFT(first_name, 1) as `first_name`, LEFT(patronymic, 1) as `patronymic`, degree, rank FROM teacher WHERE id = '.$arr_diploma["id_teacher_fk"]);
		$arr_supervisor = $res_supervisor->fetch_assoc();

		$res_group = $conn->query('SELECT cathedra.name, cathedra.last_name, LEFT(cathedra.first_name, 1) as `first_name`, LEFT(cathedra.patronymic, 1) as `patronymic`, cathedra.abbreviation, group_1.cipher_group FROM group_1 INNER JOIN cathedra ON group_1.id_cathedra_fk = cathedra.id WHERE group_1.id = (SELECT id_group_fk FROM student WHERE id = '.$student.')');
		$arr_group = $res_group->fetch_assoc();

		require 'vendor/autoload.php';
		require 'ncl_lib/NCLNameCaseRu.php';

		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		$section = $phpWord->createSection();

		$arr_style_text = array('name' => 'Arial', 'size' => 12);
		$arr_paragraph_center = array('align' => 'center', 'lineHeight' => 1.0);
		$arr_paragraph_left = array('align' => 'left', 'lineHeight' => 1.0);

		$section->addImage('img/gerb.png', array('width' => 100, 'height' => 100, 'align'=>'center'));

		$section->addText("МИНОБРНАУКИ РОССИИ", $arr_style_text, $arr_paragraph_center);
		$section->addText("Федеральное государственное бюджетное образовательное учреждение", $arr_style_text, $arr_paragraph_center);
		$section->addText("«МИРЭА - Российский технологический университет»", $arr_style_text, $arr_paragraph_center);
		$section->addText("Институт комплексной безопасности и специального приборостроения", $arr_style_text, $arr_paragraph_center);
		$section->addText("Кафедра $arr_group[name]", $arr_style_text, $arr_paragraph_center);

		$section->addText("ЗАКЛЮЧЕНИЕ", array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_center);

		if($arr_diploma["id_kind_work_fk"] == 1)
		{
			$kind_work = "бакалаврская работа";
		}
		else
		{
			if($arr_diploma["id_kind_work_fk"] == 2)
			{
				$kind_work = "магистерская диссертация";
			}
			else
			{
				$kind_work = "дипломная работа";
			}
		}
		$section->addText('ВКР ('.$kind_work.') студента', $arr_style_text, $arr_paragraph_center);

		$nc = new NCLNameCaseRu();
		$fio = $nc->qFullName($arr_student["last_name"], $arr_student["first_name"], $arr_student["patronymic"], null, NCL::$RODITLN);

		$section->addText($fio, array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText('группы '.$arr_group["cipher_group"], array('size' => 12, 'bold' => true), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText("на тему", array('size' => 12), array('align'=>'center'));

		$section->addText($arr_diploma["topic"], array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_center);

		$section->addText("в соответствии с Временным порядком проведения проверки на объем заимствования и размещения в сети интернет выпускных квалификационных работ СМКО МИРЭА 7.5.1/03.11.57-16 прошла автоматизированный анализ в системе РУКОНТТЕКСТ (text.rucont.ru).", $arr_style_text, $arr_paragraph_center);
		
		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText('Доля авторского текста (оригинальности) в результате автоматизированной проверки составила', array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText(round($arr_diploma["anti_plagiarism"]*100).' %', array('size' => 12), array('align'=>'center'));

		$section->addText("Анализ результата автоматизированной проверки системой (РУКОНТТЕКСТ - text.rucont.ru) и мнение руководителя ВКР о достоверности, фактической доле оригинального текста и степени самостоятельности студента при написании работы:", $arr_style_text, $arr_paragraph_center);

		$section->addText("соответствует предельным значениям фактической доли авторского текста", $arr_style_text, $arr_paragraph_center);

		if($arr_supervisor["degree"] == 1)
		{
			$degree = "к.т.н.";
		}
		else
		{
			$degree = "д.т.н.";
		}

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(4000, array('valign' => 'center'))->addText('Руководитель ВКР', array('size' => 12), array('align'=>'center'));
		$table->addCell(8000, array('valign' => 'center'))->addText($arr_supervisor["last_name"].' '.$arr_supervisor["first_name"].' '.$arr_supervisor["patronymic"].', '.$degree.', '.$arr_supervisor["rank"], array('size' => 12, 'bold' => true), array('align'=>'center'));

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText('Зав. кафедрой '.$arr_group["abbreviation"], array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["last_name"].'.'.$arr_group["first_name"].'.'.$arr_group["patronymic"], array('size' => 12), array('align'=>'center'));

		$file = 'Заключение_'.$arr_student["number_record_book"].'_'.$arr_student["last_name"].'_'.$arr_student["first_name"].'.docx';
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$xmlWriter->save("php://output");
		
	}

	if($_POST['doc'] == 3)
	{
		$student = $_POST['arr_1_student'];


		$res_student = $conn->query('SELECT * FROM student WHERE id = '.$student);
		$arr_student = $res_student->fetch_assoc();

		/*$res_diploma = $conn->query('SELECT number_protocol, topic, anti_plagiarism, id_kind_work_fk, id_teacher_fk FROM diploma WHERE id = '.$arr_student["id_diploma_fk"]);
		$arr_diploma = $res_diploma->fetch_assoc();*/

		$res_se = $conn->query('SELECT id, number_protocol FROM se WHERE id = '.$arr_student["id_se_fk"]);
		$arr_se = $res_se->fetch_assoc();

		/*$res_supervisor = $conn->query('SELECT last_name, LEFT(first_name, 1) as `first_name`, LEFT(patronymic, 1) as `patronymic`, degree, rank FROM teacher WHERE id = '.$arr_diploma["id_teacher_fk"]);
		$arr_supervisor = $res_supervisor->fetch_assoc();*/

		$res_group = $conn->query('SELECT cathedra.name as `name_cathedra`, cathedra.last_name, LEFT(cathedra.first_name, 1) as `first_name`, LEFT(cathedra.patronymic, 1) as `patronymic`, cathedra.abbreviation, direction.cipher_direction, direction.name, group_1.id FROM group_1 INNER JOIN cathedra ON group_1.id_cathedra_fk = cathedra.id INNER JOIN direction ON group_1.id_direction_fk = direction.id WHERE group_1.id = (SELECT id_group_fk FROM student WHERE id = '.$student.')');
		$arr_group = $res_group->fetch_assoc();

		$res_meeting = $conn->query('SELECT date, SUBSTRING(date, 3, 2) as `year2` FROM timetable_meeting WHERE id IN (SELECT id_meeting_se_fk FROM group_1 WHERE id = '.$arr_group["id"].')');
		$arr_meeting = $res_meeting->fetch_assoc();

		$result_chairman = $conn->query('SELECT last_name, first_name, patronymic, LEFT(first_name, 1) as `f`, LEFT(patronymic, 1) as `p` FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 1 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');
		$arr_chairman = $result_chairman->fetch_assoc();

		$result_secretary = $conn->query('SELECT last_name, LEFT(first_name, 1) as `f`, LEFT(patronymic, 1) as `p` FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 2 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');
		$arr_secretary = $result_secretary->fetch_assoc();

		$result_member_ssk = $conn->query('SELECT last_name, LEFT(first_name, 1) as `first_name`, LEFT(patronymic, 1) as `patronymic` FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 2 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');
		
		$res_ticket = $conn->query('SELECT * FROM ticket WHERE id IN (SELECT id_ticket_fk FROM se WHERE id = '.$arr_se["id"].')');
		$arr_ticket = $res_ticket->fetch_assoc();

		$res_question_se = $conn->query('SELECT question_se.question, member_ssk.last_name, LEFT(member_ssk.first_name, 1) as `first_name`, LEFT(member_ssk.patronymic, 1) as `patronymic` FROM question_se INNER JOIN se ON question_se.id_se_fk = se.id INNER JOIN member_ssk ON question_se.id_member_fk = member_ssk.id WHERE se.id = '.$arr_se["id"].'');

		$res_mark = $conn->query('SELECT * FROM mark WHERE id IN (SELECT id_mark_fk FROM se WHERE id = '.$arr_se["id"].')');
		$arr_mark = $res_mark->fetch_assoc();

		require 'vendor/autoload.php';
		require 'ncl_lib/NCLNameCaseRu.php';

		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		$section = $phpWord->createSection();

		$arr_style_text = array('name' => 'Arial', 'size' => 12);
		$arr_paragraph_center = array('align' => 'center', 'lineHeight' => 1.0);
		$arr_paragraph_left = array('align' => 'left', 'lineHeight' => 1.0);

		$section->addImage('img/gerb.png', array('width' => 100, 'height' => 100, 'align'=>'center'));

		$section->addText("МИНОБРНАУКИ РОССИИ", $arr_style_text, $arr_paragraph_center);
		$section->addText("Федеральное государственное бюджетное образовательное учреждение", $arr_style_text, $arr_paragraph_center);
		$section->addText("«МИРЭА - Российский технологический университет»", $arr_style_text, $arr_paragraph_center);
		$section->addText("Институт комплексной безопасности и специального приборостроения", $arr_style_text, $arr_paragraph_center);
		$section->addText("Кафедра $arr_group[name_cathedra]", $arr_style_text, $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["cipher_direction"], array('size' => 12, 'bold' => true), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["name"], array('size' => 12, 'bold' => true), array('align'=>'center'));

		if(strlen($arr_se["number_protocol"]) == 1)
		{
			$protocol = '0'.$arr_se["number_protocol"];
		}
		else
		{
			$protocol = $arr_se["number_protocol"];
		}
		$section->addText('Протокол №'.$protocol.'/'.$arr_meeting["year2"], $arr_style_text, $arr_paragraph_center);

		$section->addText("заседания Государственной экзаменационной комиссии", $arr_style_text, $arr_paragraph_center);

		$section->addText(date('d.m.Y', strtotime($arr_meeting["date"])), $arr_style_text, $arr_paragraph_center);

		$section->addText("по приему государственного аттестационного испытания —", $arr_style_text, $arr_paragraph_center);
		$section->addText("государственного экзамена", $arr_style_text, $arr_paragraph_center);
		$section->addText("Направление подготовки/специальность", $arr_style_text, $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["cipher_direction"], array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["name"], array('size' => 12), array('align'=>'center'));

		$section->addText("ПРИСУТСТВОВАЛИ:", array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_left);
		$section->addText("Председатель Государственной экзаменационной комиссии:", $arr_style_text, $arr_paragraph_left);
		$section->addText($arr_chairman["last_name"].' '.$arr_chairman["first_name"].' '.$arr_chairman["patronymic"], $arr_style_text, $arr_paragraph_left);
		$section->addText("Члены Государственной экзаменационной комиссии ", $arr_style_text, $arr_paragraph_left);

		while($arr_member_ssk = $result_member_ssk->fetch_assoc())
		{
			$section->addListItem($arr_member_ssk["last_name"].' '.$arr_member_ssk["first_name"].'.'.$arr_member_ssk["patronymic"].'.', 0);
		}

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("Студент(ка)", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_student["last_name"].' '.$arr_student["first_name"].' '.$arr_student["patronymic"], array('size' => 12), array('align'=>'center'));

		$section->addText("Вопросы государственного (междисциплинарного) экзамена:", array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_center);

		$section->addListItem($arr_ticket["first_question"], 0);
		$section->addListItem($arr_ticket["second_question"], 0);
		$section->addListItem($arr_ticket["third_question"], 0);

		$section->addText("Студенту(ке) были заданы следующие вопросы:", array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_center);

		while($arr_question_se = $res_question_se->fetch_assoc())
		{
			$section->addListItem($arr_question_se["last_name"].' '.$arr_question_se["first_name"].'.'.$arr_question_se["patronymic"].'.', 0);
			$section->addText($arr_question_se["question"], $arr_style_text, $arr_paragraph_left);
		}

		$section->addText("Общая характеристика ответов студента(ки) на заданные ему(ей)", $arr_style_text, $arr_paragraph_center);
		$section->addText($arr_mark["characteristic"], $arr_style_text, $arr_paragraph_center);

		$section->addText("ПОСТАНОВИЛИ:", array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("1 Признать, что студент(ка) сдал(а) государственный экзамен по", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_student["last_name"].' '.$arr_student["first_name"].' '.$arr_student["patronymic"], array('size' => 12), array('align'=>'center'));

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["cipher_direction"], array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["name"], array('size' => 12), array('align'=>'center'));

		$section->addText('С оценкой: '.$arr_mark["mark"], $arr_style_text, $arr_paragraph_center);

		$section->addText('2 Особое мнение членов комиссии:', $arr_style_text, $arr_paragraph_center);
		$section->addText(' (мнения  членов  государственной  экзаменационной  комиссии  о  выявленном  в  ходе государственного аттестационного испытания уровне подготовленности обучающегося к решению профессиональных задач, а также о выявленных недостатках в теоретической и практической подготовке обучающегося)',array('name' => 'Arial', 'size' => 8), $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("Председатель Государственной экзаменационной комиссии", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_chairman["last_name"].' '.$arr_chairman["f"].'.'.$arr_chairman["p"].'.', array('size' => 12), array('align'=>'center'));

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("Секретарь Государственной экзаменационной комиссии", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_secretary["last_name"].' '.$arr_secretary["f"].'.'.$arr_secretary["p"].'.', array('size' => 12), array('align'=>'center'));


		$file = 'Протокол_ГЭ_'.$arr_student["number_record_book"].'_'.$arr_student["last_name"].'_'.$arr_student["first_name"].'.docx';
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$xmlWriter->save("php://output");


	}

	if($_POST['doc'] == 4)
	{
		$student = $_POST['arr_1_student'];


		$res_student = $conn->query('SELECT * FROM student WHERE id = '.$student);
		$arr_student = $res_student->fetch_assoc();

		$res_diploma = $conn->query('SELECT id, number_protocol, topic, anti_plagiarism, id_kind_work_fk, id_teacher_fk FROM diploma WHERE id = '.$arr_student["id_diploma_fk"]);
		$arr_diploma = $res_diploma->fetch_assoc();

		/*$res_se = $conn->query('SELECT id, number_protocol FROM se WHERE id = '.$arr_student["id_se_fk"]);
		$arr_se = $res_se->fetch_assoc();*/

		$res_supervisor = $conn->query('SELECT last_name, LEFT(first_name, 1) as `first_name`, LEFT(patronymic, 1) as `patronymic`, degree, rank FROM teacher WHERE id = '.$arr_diploma["id_teacher_fk"]);
		$arr_supervisor = $res_supervisor->fetch_assoc();

		$res_group = $conn->query('SELECT cathedra.name as `name_cathedra`, cathedra.last_name, LEFT(cathedra.first_name, 1) as `first_name`, LEFT(cathedra.patronymic, 1) as `patronymic`, cathedra.abbreviation, direction.cipher_direction, direction.name, group_1.id FROM group_1 INNER JOIN cathedra ON group_1.id_cathedra_fk = cathedra.id INNER JOIN direction ON group_1.id_direction_fk = direction.id WHERE group_1.id = (SELECT id_group_fk FROM student WHERE id = '.$student.')');
		$arr_group = $res_group->fetch_assoc();

		$res_meeting = $conn->query('SELECT date, SUBSTRING(date, 3, 2) as `year2` FROM timetable_meeting WHERE id IN (SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].')');
		$arr_meeting = $res_meeting->fetch_assoc();

		$res_review = $conn->query('SELECT * FROM review WHERE id IN (SELECT id_review_fk FROM diploma WHERE id = '.$arr_diploma["id"].')');
		$arr_review = $res_review->fetch_assoc();

		$result_chairman = $conn->query('SELECT last_name, first_name, patronymic, LEFT(first_name, 1) as `f`, LEFT(patronymic, 1) as `p` FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 1 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');
		$arr_chairman = $result_chairman->fetch_assoc();

		$result_secretary = $conn->query('SELECT last_name, LEFT(first_name, 1) as `f`, LEFT(patronymic, 1) as `p` FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 2 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');
		$arr_secretary = $result_secretary->fetch_assoc();

		$result_member_ssk = $conn->query('SELECT last_name, LEFT(first_name, 1) as `first_name`, LEFT(patronymic, 1) as `patronymic` FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 2 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');
		
		/*$res_ticket = $conn->query('SELECT * FROM ticket WHERE id IN (SELECT id_ticket_fk FROM se WHERE id = '.$arr_se["id"].')');
		$arr_ticket = $res_ticket->fetch_assoc();*/

		$res_question_diploma = $conn->query('SELECT question_diploma.question, member_ssk.last_name, LEFT(member_ssk.first_name, 1) as `first_name`, LEFT(member_ssk.patronymic, 1) as `patronymic` FROM question_diploma INNER JOIN diploma ON question_diploma.id_diploma_fk = diploma.id INNER JOIN member_ssk ON question_diploma.id_member_fk = member_ssk.id WHERE diploma.id = '.$arr_diploma["id"].'');

		$res_mark = $conn->query('SELECT * FROM mark WHERE id IN (SELECT id_mark_fk FROM diploma WHERE id = '.$arr_diploma["id"].')');
		$arr_mark = $res_mark->fetch_assoc();

		require 'vendor/autoload.php';
		require 'ncl_lib/NCLNameCaseRu.php';

		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		$section = $phpWord->createSection();

		$arr_style_text = array('name' => 'Arial', 'size' => 12);
		$arr_paragraph_center = array('align' => 'center', 'lineHeight' => 1.0);
		$arr_paragraph_left = array('align' => 'left', 'lineHeight' => 1.0);

		$section->addImage('img/gerb.png', array('width' => 100, 'height' => 100, 'align'=>'center'));

		$section->addText("МИНОБРНАУКИ РОССИИ", $arr_style_text, $arr_paragraph_center);
		$section->addText("Федеральное государственное бюджетное образовательное учреждение", $arr_style_text, $arr_paragraph_center);
		$section->addText("«МИРЭА - Российский технологический университет»", $arr_style_text, $arr_paragraph_center);
		$section->addText("Институт комплексной безопасности и специального приборостроения", $arr_style_text, $arr_paragraph_center);
		$section->addText("Кафедра $arr_group[name_cathedra]", $arr_style_text, $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["cipher_direction"], array('size' => 12, 'bold' => true), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["name"], array('size' => 12, 'bold' => true), array('align'=>'center'));

		if(strlen($arr_diploma["number_protocol"]) == 1)
		{
			$protocol = '0'.$arr_diploma["number_protocol"];
		}
		else
		{
			$protocol = $arr_diploma["number_protocol"];
		}
		$section->addText('Протокол №'.$protocol.'/'.$arr_meeting["year2"], $arr_style_text, $arr_paragraph_center);

		$section->addText("заседания Государственной экзаменационной комиссии", $arr_style_text, $arr_paragraph_center);

		$section->addText(date('d.m.Y', strtotime($arr_meeting["date"])), $arr_style_text, $arr_paragraph_center);

		$section->addText("по приему государственного аттестационного испытания —", $arr_style_text, $arr_paragraph_center);
		$section->addText("защиты выпускной квалификационной работы (ВКР)", $arr_style_text, $arr_paragraph_center);
		$section->addText("Направление подготовки/специальность", $arr_style_text, $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["cipher_direction"], array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["name"], array('size' => 12), array('align'=>'center'));

		$section->addText("ПРИСУТСТВОВАЛИ:", array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_left);

		$section->addText("Председатель Государственной экзаменационной комиссии:", $arr_style_text, $arr_paragraph_left);
		$section->addText($arr_chairman["last_name"].' '.$arr_chairman["first_name"].' '.$arr_chairman["patronymic"], $arr_style_text, $arr_paragraph_left);
		$section->addText("Члены Государственной экзаменационной комиссии ", $arr_style_text, $arr_paragraph_left);

		while($arr_member_ssk = $result_member_ssk->fetch_assoc())
		{
			$section->addListItem($arr_member_ssk["last_name"].' '.$arr_member_ssk["first_name"].'.'.$arr_member_ssk["patronymic"].'.', 0);
		}

		$section->addText("Слушали защиту студента(ки)", $arr_style_text, $arr_paragraph_left);

		$nc = new NCLNameCaseRu();
		$fio = $nc->qFullName($arr_student["last_name"], $arr_student["first_name"], $arr_student["patronymic"], null, NCL::$RODITLN);

		$section->addText($fio, array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_left);
		$section->addText("На тему:", $arr_style_text, $arr_paragraph_left);
		$section->addText($arr_diploma["topic"], array('name' => 'Arial', 'size' => 16, 'bold' => true), $arr_paragraph_center);

		$section->addText("ВКР выполнена в виде:", $arr_style_text, $arr_paragraph_left);

		if($arr_diploma["id_kind_work_fk"] == 1)
		{
			$kind_work = "бакалаврская работа";
		}
		else
		{
			if($arr_diploma["id_kind_work_fk"] == 2)
			{
				$kind_work = "магистерская диссертация";
			}
			else
			{
				$kind_work = "дипломная работа";
			}
		}

		$section->addText($kind_work, $arr_style_text, $arr_paragraph_left);

		if($arr_supervisor["degree"] == 1)
		{
			$degree = "к.т.н.";
		}
		else
		{
			$degree = "д.т.н.";
		}

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(4000, array('valign' => 'center'))->addText('Руководитель ВКР', array('size' => 12), array('align'=>'center'));
		$table->addCell(8000, array('valign' => 'center'))->addText($arr_supervisor["last_name"].' '.$arr_supervisor["first_name"].'.'.$arr_supervisor["patronymic"].'., '.$degree.', '.$arr_supervisor["rank"], array('size' => 12, 'bold' => true), array('align'=>'center'));

		$section->addText("Рецензент для ВКР в виде дипломного проекта (или дипломной работы), магистерской диссертации:", $arr_style_text, $arr_paragraph_left);
		$section->addText($arr_review["last_name"].' '.$arr_review["first_name"].' '.$arr_review["patronymic"], $arr_style_text, $arr_paragraph_left);

		$section->addText("В Государственную экзаменационную комиссию предоставлены следующие материалы:", $arr_style_text, $arr_paragraph_left);

		$section->addListItem("ВКР, отчетные материалы в соответствии с заданием на ВКР (чертежи, таблицы, фотографии, иллюстрации, презентация).", 0);
		$section->addListItem("Отчет о проверке на заимствования.", 0);
		$section->addListItem("Отзыв руководителя ВКР.", 0);

		$section->addText("После сообщения о результатах выполнения ВКР студенту(ке) были заданы следующие вопросы:", $arr_style_text, $arr_paragraph_left);

		while($arr_question_diploma = $res_question_diploma->fetch_assoc())
		{
			$section->addListItem($arr_question_diploma["last_name"].' '.$arr_question_diploma["first_name"].'.'.$arr_question_diploma["patronymic"].'.', 0);
			$section->addText($arr_question_diploma["question"], $arr_style_text, $arr_paragraph_left);
		}

		$section->addText("Общая характеристика ответов студента(ки) на заданные ему(ей)", $arr_style_text, $arr_paragraph_left);
		$section->addText($arr_mark["characteristic"], $arr_style_text, $arr_paragraph_left);

		$section->addText("ПОСТАНОВИЛИ:", array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("1 Признать, что студент(ка) выполнил(а) и защитил(а) ВКР с оценкой", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_student["last_name"].' '.$arr_student["first_name"].' '.$arr_student["patronymic"], array('size' => 12), array('align'=>'center'));

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["cipher_direction"], array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["name"], array('size' => 12), array('align'=>'center'));

		$section->addText('С оценкой: '.$arr_mark["mark"], $arr_style_text, $arr_paragraph_center);

		$section->addText('2 Особое мнение членов комиссии:', $arr_style_text, $arr_paragraph_center);
		$section->addText(' (мнения  членов  государственной  экзаменационной  комиссии  о  выявленном  в  ходе государственного аттестационного испытания уровне подготовленности обучающегося к решению профессиональных задач, а также о выявленных недостатках в теоретической и практической подготовке обучающегося)',array('name' => 'Arial', 'size' => 8), $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("Председатель Государственной экзаменационной комиссии", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_chairman["last_name"].' '.$arr_chairman["f"].'.'.$arr_chairman["p"].'.', array('size' => 12), array('align'=>'center'));

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("Секретарь Государственной экзаменационной комиссии", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_secretary["last_name"].' '.$arr_secretary["f"].'.'.$arr_secretary["p"].'.', array('size' => 12), array('align'=>'center'));


		$file = 'Протокол_ВКР_'.$arr_student["number_record_book"].'_'.$arr_student["last_name"].'_'.$arr_student["first_name"].'.docx';
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$xmlWriter->save("php://output");
	}

	if($_POST['doc'] == 5)
	{
		$student = $_POST['arr_1_student'];
		$honours = $_POST['honours'];


		$res_student = $conn->query('SELECT * FROM student WHERE id = '.$student);
		$arr_student = $res_student->fetch_assoc();

		$res_diploma = $conn->query('SELECT id, number_protocol, topic, anti_plagiarism, id_kind_work_fk, id_teacher_fk FROM diploma WHERE id = '.$arr_student["id_diploma_fk"]);
		$arr_diploma = $res_diploma->fetch_assoc();

		$res_se = $conn->query('SELECT id, number_protocol FROM se WHERE id = '.$arr_student["id_se_fk"]);
		$arr_se = $res_se->fetch_assoc();

		/*$res_supervisor = $conn->query('SELECT last_name, LEFT(first_name, 1) as `first_name`, LEFT(patronymic, 1) as `patronymic`, degree, rank FROM teacher WHERE id = '.$arr_diploma["id_teacher_fk"]);
		$arr_supervisor = $res_supervisor->fetch_assoc();*/

		$res_group = $conn->query('SELECT cathedra.name as `name_cathedra`, cathedra.last_name, LEFT(cathedra.first_name, 1) as `first_name`, LEFT(cathedra.patronymic, 1) as `patronymic`, cathedra.abbreviation, direction.cipher_direction, direction.name, group_1.id FROM group_1 INNER JOIN cathedra ON group_1.id_cathedra_fk = cathedra.id INNER JOIN direction ON group_1.id_direction_fk = direction.id WHERE group_1.id = (SELECT id_group_fk FROM student WHERE id = '.$student.')');
		$arr_group = $res_group->fetch_assoc();

		$res_meeting_se = $conn->query('SELECT date, SUBSTRING(date, 3, 2) as `year2` FROM timetable_meeting WHERE id IN (SELECT id_meeting_se_fk FROM group_1 WHERE id = '.$arr_group["id"].')');
		$arr_meeting_se = $res_meeting_se->fetch_assoc();

		$res_meeting_diploma = $conn->query('SELECT date, SUBSTRING(date, 3, 2) as `year2` FROM timetable_meeting WHERE id IN (SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].')');
		$arr_meeting_diploma = $res_meeting_diploma->fetch_assoc();

		/*$res_review = $conn->query('SELECT * FROM review WHERE id IN (SELECT id_review_fk FROM diploma WHERE id = '.$arr_diploma["id"].')');
		$arr_review = $res_review->fetch_assoc();*/

		$result_chairman = $conn->query('SELECT last_name, first_name, patronymic, LEFT(first_name, 1) as `f`, LEFT(patronymic, 1) as `p` FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 1 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');
		$arr_chairman = $result_chairman->fetch_assoc();

		$result_secretary = $conn->query('SELECT last_name, LEFT(first_name, 1) as `f`, LEFT(patronymic, 1) as `p` FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 2 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');
		$arr_secretary = $result_secretary->fetch_assoc();

		$result_member_ssk = $conn->query('SELECT last_name, LEFT(first_name, 1) as `first_name`, LEFT(patronymic, 1) as `patronymic` FROM member_ssk WHERE id IN (SELECT id_member_ssk_fk FROM curation_event WHERE role = 2 AND id_commission_fk IN(SELECT id FROM commission WHERE id IN(SELECT id_commission_fk FROM timetable_meeting WHERE id IN(SELECT id_meeting_diploma_fk FROM group_1 WHERE id = '.$arr_group["id"].'))))');

		$res_qualification = $conn->query('SELECT name FROM qualification WHERE id IN (SELECT id_qualification_fk FROM direction WHERE id IN (SELECT id_direction_fk FROM group_1 WHERE id = '.$arr_group["id"].'))');
		$arr_qualification = $res_qualification->fetch_assoc();
		
		/*$res_ticket = $conn->query('SELECT * FROM ticket WHERE id IN (SELECT id_ticket_fk FROM se WHERE id = '.$arr_se["id"].')');
		$arr_ticket = $res_ticket->fetch_assoc();*/

		/*$res_question_diploma = $conn->query('SELECT question_diploma.question, member_ssk.last_name, LEFT(member_ssk.first_name, 1) as `first_name`, LEFT(member_ssk.patronymic, 1) as `patronymic` FROM question_diploma INNER JOIN diploma ON question_diploma.id_diploma_fk = diploma.id INNER JOIN member_ssk ON question_diploma.id_member_fk = member_ssk.id WHERE diploma.id = '.$arr_diploma["id"].'');*/

		$res_mark_se = $conn->query('SELECT * FROM mark WHERE id IN (SELECT id_mark_fk FROM se WHERE id = '.$arr_se["id"].')');
		$arr_mark_se = $res_mark_se->fetch_assoc();

		$res_mark_diploma = $conn->query('SELECT * FROM mark WHERE id IN (SELECT id_mark_fk FROM diploma WHERE id = '.$arr_diploma["id"].')');
		$arr_mark_diploma = $res_mark_diploma->fetch_assoc();

		require 'vendor/autoload.php';
		require 'ncl_lib/NCLNameCaseRu.php';

		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		$section = $phpWord->createSection();

		$arr_style_text = array('name' => 'Arial', 'size' => 12);
		$arr_paragraph_center = array('align' => 'center', 'lineHeight' => 1.0);
		$arr_paragraph_left = array('align' => 'left', 'lineHeight' => 1.0);

		$section->addImage('img/gerb.png', array('width' => 100, 'height' => 100, 'align'=>'center'));

		$section->addText("МИНОБРНАУКИ РОССИИ", $arr_style_text, $arr_paragraph_center);
		$section->addText("Федеральное государственное бюджетное образовательное учреждение", $arr_style_text, $arr_paragraph_center);
		$section->addText("«МИРЭА - Российский технологический университет»", $arr_style_text, $arr_paragraph_center);
		$section->addText("Институт комплексной безопасности и специального приборостроения", $arr_style_text, $arr_paragraph_center);
		$section->addText("Кафедра $arr_group[name_cathedra]", $arr_style_text, $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["cipher_direction"], array('size' => 12, 'bold' => true), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["name"], array('size' => 12, 'bold' => true), array('align'=>'center'));

		if(strlen($arr_diploma["number_protocol"]) == 1)
		{
			$protocol = '0'.$arr_diploma["number_protocol"];
		}
		else
		{
			$protocol = $arr_diploma["number_protocol"];
		}
		$section->addText('Протокол №'.$protocol.'/'.$arr_meeting_diploma["year2"], $arr_style_text, $arr_paragraph_center);

		$section->addText("заседания Государственной экзаменационной комиссии", $arr_style_text, $arr_paragraph_center);

		$section->addText(date('d.m.Y', strtotime($arr_meeting_diploma["date"])), $arr_style_text, $arr_paragraph_center);

		$section->addText("о присвоении квалификации студентам по результатам государственной итоговой аттестации и  выдаче диплома о высшем образовании", $arr_style_text, $arr_paragraph_center);
		$section->addText("Направление подготовки/специальность", $arr_style_text, $arr_paragraph_center);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["cipher_direction"], array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["name"], array('size' => 12), array('align'=>'center'));

		$section->addText("ПРИСУТСТВОВАЛИ:", array('name' => 'Arial', 'size' => 12, 'bold' => true), $arr_paragraph_left);

		$section->addText("Председатель Государственной экзаменационной комиссии:", $arr_style_text, $arr_paragraph_left);
		$section->addText($arr_chairman["last_name"].' '.$arr_chairman["first_name"].' '.$arr_chairman["patronymic"], $arr_style_text, $arr_paragraph_left);
		$section->addText("Члены Государственной экзаменационной комиссии ", $arr_style_text, $arr_paragraph_left);

		while($arr_member_ssk = $result_member_ssk->fetch_assoc())
		{
			$section->addListItem($arr_member_ssk["last_name"].' '.$arr_member_ssk["first_name"].'.'.$arr_member_ssk["patronymic"].'.', 0);
		}

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("Студент(ка)", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_student["last_name"].' '.$arr_student["first_name"].' '.$arr_student["patronymic"], array('size' => 12), array('align'=>'center'));

		$section->addText("Сдал(а) государственный (междисциплинарный) экзамен с оценкой:", $arr_style_text, $arr_paragraph_left);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_mark_se["mark"], array('size' => 12, 'underline' => 'single'), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText(date('d.m.Y', strtotime($arr_meeting_se["date"])), array('size' => 12, 'underline' => 'single'), array('align'=>'center'));

		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("(Оценка)", array('size' => 8, 'italic' => true), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText("(Дата сдачи)", array('size' => 8, 'italic' => true), array('align'=>'center'));

		$section->addText("и защитил(а) выпускную квалификационную работу с оценкой:", $arr_style_text, $arr_paragraph_left);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_mark_diploma["mark"], array('size' => 12, 'underline' => 'single'), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText(date('d.m.Y', strtotime($arr_meeting_diploma["date"])), array('size' => 12, 'underline' => 'single'), array('align'=>'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("(Оценка)", array('size' => 8, 'italic' => true), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText("(Дата сдачи)", array('size' => 8, 'italic' => true), array('align'=>'center'));

		$nc = new NCLNameCaseRu();
		$fio = $nc->qFullName($arr_student["last_name"], $arr_student["first_name"], $arr_student["patronymic"], null, NCL::$DATELN);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("Присвоить студенту(ке)", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($fio, array('size' => 12), array('align'=>'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("Квалификацию", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_qualification["name"], array('size' => 12), array('align'=>'center'));

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["cipher_direction"], array('size' => 12, 'bold' => true), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_group["name"], array('size' => 12, 'bold' => true), array('align'=>'center'));
		$table->addRow(200);
		if(isset($_POST['honours']))
		{
			$honours = 'С отличием';
		}
		else
		{
			$honours = 'Без отличия';
		}
		$table->addCell(5000, array('valign' => 'center'))->addText("Выдать диплом о высшем образовании", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($honours, array('size' => 12), array('align'=>'center'));

		$section->addText('Особое мнение членов комиссии:', $arr_style_text, $arr_paragraph_left);

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("Председатель Государственной экзаменационной комиссии", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_chairman["last_name"].' '.$arr_chairman["f"].'.'.$arr_chairman["p"].'.', array('size' => 12), array('align'=>'center'));

		$table = $section->addTable(array('align' => 'center', 'valign' => 'center'));
		$table->addRow(200);
		$table->addCell(5000, array('valign' => 'center'))->addText("Секретарь Государственной экзаменационной комиссии", array('size' => 12), array('align'=>'center'));
		$table->addCell(5000, array('valign' => 'center'))->addText($arr_secretary["last_name"].' '.$arr_secretary["f"].'.'.$arr_secretary["p"].'.', array('size' => 12), array('align'=>'center'));

		$file = 'Протокол_аттестации_'.$arr_student["number_record_book"].'_'.$arr_student["last_name"].'_'.$arr_student["first_name"].'.docx';
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