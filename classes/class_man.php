<?php
	class man
	{
		public $last_name, $first_name, $patronymic;

		function __construct($last_name, $first_name, $patronymic)
		{
			$this->last_name = $last_name;
			$this->first_name = $first_name;
			$this->patronymic = $patronymic;
		}

	}

	class student extends man
	{
		public $nrb, $group_1, $se, $diploma;

		function __construct($last_name, $first_name, $patronymic, $nrb, $group_1)
		{
			parent::__construct($last_name, $first_name, $patronymic);
			$this->nrb = $nrb;
			$this->group_1 = $group_1;
		}
	}

	class supervisor extends man
	{
		public $cipher_supervisor, $degree, $rank, $post;

		function __construct($last_name, $first_name, $patronymic)
		{
			parent::__construct($last_name, $first_name, $patronymic);
		}

	}

?>