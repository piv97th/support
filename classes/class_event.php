<?php
	class diploma
	{
		public $id, $number_protocol, $topic, $anti_plagiarism, $kind_work, $supervisor, $meeting, $mark, $type_work;

		function __construct($topic, $kind_work, $supervisor)
		{
			$this->topic = $topic;
			$this->supervisor = $supervisor;
		}

	}
?>