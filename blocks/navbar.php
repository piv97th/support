<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
	<a class="navbar-brand" href="index.php">Главная</a>

	<ul class="navbar-nav">

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
				Студенты
			</a>
			<div class="dropdown-menu">

				<div class="dropdown-header">На сайте</div>
				<a class="dropdown-item" href="form_add_student.php">Добавить</a>
				<a class="dropdown-item" href="choice_select.php?mode=1">Редактировать</a>
				<a class="dropdown-item" href="choice_select.php?mode=2">Удалить</a>
				<div class="dropdown-header">Через файл</div>
				<a class="dropdown-item" href="choice_group_blank.php">Скачать файл</a>
				<a class="dropdown-item" href="load_blank.php">Загрузить бланк</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
				Комиссии
			</a>
			<div class="dropdown-menu">
				
				<div class="dropdown-header">Комиссии</div>
				<a class="dropdown-item" href="form_add_commission.php">Добавить</a>
				<a class="dropdown-item" href="choice_str_upd.php?mode=3">Редактировать</a>
				<a class="dropdown-item" href="choice_str_del.php?mode=3">Удалить</a>
				<div class="dropdown-header">Назначить членов ГЭК на комиссию</div>
				<a class="dropdown-item" href="form_add_commission_member.php">Назначить</a>
				<a class="dropdown-item" href="form_del_commission_member.php">Удалить</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
				Госэкзамен
			</a>
			<div class="dropdown-menu">
				<div class="dropdown-header">Билеты</div>
				<a class="dropdown-item" href="form_add_ticket.php">Добавить</a>
				<a class="dropdown-item" href="choice_ticket_upd.php">Редактировать</a>
				<a class="dropdown-item" href="choice_ticket_del.php">Удалить</a>
				<div class="dropdown-header">Проведение госэкзамена</div>
				<a class="dropdown-item" href="choice_select.php?mode=3">Госэкзамен</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
				ВКР
			</a>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="choice_select.php?mode=4">Проведение ВКР</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
				Структура вуза
			</a>
			<div class="dropdown-menu">

				<div class="dropdown-header">Направление</div>
				<a class="dropdown-item" href="form_add_direction.php">Добавить</a>
				<a class="dropdown-item" href="choice_str_upd.php?mode=1">Редактировать</a>
				<a class="dropdown-item" href="choice_str_del.php?mode=1">Удалить</a>
				<div class="dropdown-header">Группы</div>
				<a class="dropdown-item" href="form_add_group.php">Добавить</a>
				<a class="dropdown-item" href="choice_str_upd.php?mode=2">Редактировать</a>
				<a class="dropdown-item" href="choice_str_del.php?mode=2">Удалить</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
				Научные руководители
			</a>
			<div class="dropdown-menu">

				<a class="dropdown-item" href="form_add_supervisor.php">Добавить</a>
				<a class="dropdown-item" href="choice_str_upd.php?mode=4">Редактировать</a>
				<a class="dropdown-item" href="choice_str_del.php?mode=4">Удалить</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
				Члены ГЭК
			</a>
			<div class="dropdown-menu">

				<a class="dropdown-item" href="form_add_member_ssk.php">Добавить</a>
				<a class="dropdown-item" href="choice_str_upd.php?mode=5">Редактировать</a>
				<a class="dropdown-item" href="choice_str_del.php?mode=5">Удалить</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
				Рецензия
			</a>
			<div class="dropdown-menu">

				<a class="dropdown-item" href="form_add_review.php">Добавить</a>
				<a class="dropdown-item" href="operation_review.php?mode=1">Редактировать</a>
				<a class="dropdown-item" href="operation_review.php?mode=2">Удалить</a>
			</div>
		</li>

		<li class="nav-item">
     		<a class="nav-link" href="list_document.php">Документы</a>
    	</li>

		<li class="nav-item">
			<button class="btn btn-light" type="button" id="logout">Выход</button>
		</li>
	</ul>
</nav>