<?php

	function check_get($get)
	{
		if(empty($get))
	{
		if(0 > $get || $get > 100000000)
		{
			exit;
		}
		exit;
	}
	}

	function check_result($arr)
	{
		foreach($arr as $i)
		{
			if($i != 1)
			{
				echo json_encode($arr);
				exit;
			}
		}
	}
	function check_empty($data)
	{
		if(empty($data))
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

		function exist_nrb_u($data)
	{
		require('blocks/connect.php');
		$sql = "SELECT COUNT(number_record_book) as `count` FROM student WHERE number_record_book = '$data'";
		$result = $conn->query($sql) or die($conn->error);
		$row = $result->fetch_assoc();
		if($row['count'] > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function check_nrb_u($data)
	{
		$status = check_empty($data);
		if($status == 0)
		{
			return $status;
		}
		$arr_was = array("б", "м", "с");
		$arr_become = array("Б", "М", "С");
		$data = str_replace($arr_was, $arr_become, $data);
		$pattern_1 = '/^[0-9]{2}[Б,М,С][0-9]{4}$/u';
		if(!preg_match($pattern_1, $data))
		{
			return 2;
		}
		else
		{
			if(exist_nrb_u($data) == TRUE)
			{
				return 3;
			}
			else
			{
				return 1;
			}
		}
	}

	function exist_nrb($data)
	{
		require('blocks/connect.php');
		$sql = "SELECT COUNT(number_record_book) as `count` FROM student WHERE number_record_book = '$data'";
		$result = $conn->query($sql) or die($conn->error);
		$row = $result->fetch_assoc();
		if($row['count'] > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function check_nrb($data)
	{
		$status = check_empty($data);
		if($status == 0)
		{
			return $status;
		}
		$arr_was = array("б", "м", "с");
		$arr_become = array("Б", "М", "С");
		$data = str_replace($arr_was, $arr_become, $data);
		$pattern_1 = '/^[0-9]{2}[Б,М,С][0-9]{4}$/u';
		if(!preg_match($pattern_1, $data))
		{
			return 2;
		}
		else
		{
			if(exist_nrb($data) == TRUE)
			{
				return 3;
			}
			else
			{
				return 1;
			}
		}
	}

	function check_name($data)
	{
		$status = check_empty($data);
		if($status == 0)
		{
			return $status;
		}
		$pattern_2 = '/^[А-ЯЁ][а-яё]{1,254}$/u';
		$data = mb_strtoupper(mb_substr($data, 0, 1)) . mb_strtolower(mb_substr($data, 1));
		if(!preg_match($pattern_2, $data))
		{
			return 2;
		}
		else
		{
			return 1;
		}
	}

	function check_num($data)
	{
		$status = check_empty($data);
		if(!is_numeric($data) || 1 > mb_strlen($data) || 8 < mb_strlen($data))
		{
			return 2;
		}
		else
		{
			return 1;
		}
	}

	function choice_kind_work($data)
	{
		require('blocks/connect.php');
		$query = $conn->query('SELECT cipher_group from group_1 WHERE id = '.$data);
		$data = $query->fetch_row()[0];
		$kw;
		switch(mb_substr($data,2,1,'UTF-8'))
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

	function check_group($data)
	{
		$status = check_empty($data);
		if($status == 0)
		{
			return 0;
		}
		else
		{
			$pattern_1 = '/^[А-ЯЁ][А-ЯЁ][Б,М,С][В,З,О]-[0-9]{2}-[0-9]{2}$/u';
			if(!preg_match($pattern_1, $data))
			{
				return 2;
			}
			else
			{
				require('blocks/connect.php');
				$result_group = $conn->query('SELECT cipher_group FROM group_1 WHERE cipher_group = '.$data);
				$arr = $result_group->fetch_assoc();
				if($arr['cipher_group'] == NULL)
				{
					return 3;
				}
				else
				{
					return 1;
				}
			}
		}
	}
?>