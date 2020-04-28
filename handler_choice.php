<?php
	require('blocks/connect.php');

	if(isset($_GET['mode']))
	{
		$mode = $_GET['mode'];
		$select = $_GET['select'];
		if($mode == 1 && (0 < $select && $select < 1000))
		{
			$result = $conn->query('SELECT id, number_record_book, last_name, first_name FROM student WHERE id_group_fk ='.$select) or die($conn->error);
			while($arr = $result->fetch_assoc())
			{
				$arr_new[] = array('arr_1' => $arr['id'], 'number_record_book' => $arr['number_record_book'], 'last_name' => $arr['last_name'], 'first_name' => $arr['first_name']);
/*				$arr_new[] = $arr['id'];
				$arr_new[] = $arr['number_record_book'];*/
			}
		}
		echo json_encode($arr_new);
	}
/*	$pr = mysqli_query($d, "SELECT name FROM tovar1");
	while($arr = mysqli_fetch_assoc($pr))
	{
		$arr_new[] = $arr['name'];
	}
	echo json_encode($arr_new);
   	exit;*/
?>