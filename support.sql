-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 29 2021 г., 10:14
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `support`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cathedra`
--

CREATE TABLE `cathedra` (
  `id` int(4) NOT NULL,
  `abbreviation` varchar(8) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cathedra`
--

INSERT INTO `cathedra` (`id`, `abbreviation`, `name`) VALUES
(1, 'КБ-1', 'защита информации'),
(2, 'КБ-3', 'управление и моделирование систем'),
(3, 'КБ-4', 'интеллектуальные системы информационной безопасности'),
(4, 'ВТ-1', 'вычислительная техника');

-- --------------------------------------------------------

--
-- Структура таблицы `commission`
--

CREATE TABLE `commission` (
  `id` int(4) NOT NULL,
  `order_1` text NOT NULL,
  `year` int(2) NOT NULL,
  `id_user_fk` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `commission`
--

INSERT INTO `commission` (`id`, `order_1`, `year`, `id_user_fk`) VALUES
(1, 'sssssssss', 20, 0),
(2, 'wwwwwwwwwwwwwwww', 20, 0),
(3, 'dddddddd', 20, 0),
(13, 'ssssss', 2020, 0),
(29, 'qwertyuytrewq', 2020, 0),
(35, 'vfbgf', 2020, 3),
(36, 'vfbgf', 2020, 3),
(37, 'sssss', 2020, 3),
(38, 'zxcbn', 2020, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `curation`
--

CREATE TABLE `curation` (
  `id` int(4) NOT NULL,
  `id_user_fk` int(4) NOT NULL,
  `id_group_fk` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `curation`
--

INSERT INTO `curation` (`id`, `id_user_fk`, `id_group_fk`) VALUES
(8, 9, 2),
(9, 9, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `diploma`
--

CREATE TABLE `diploma` (
  `id` int(8) NOT NULL,
  `number_protocol` int(2) DEFAULT NULL,
  `topic` text NOT NULL,
  `anti_plagiarism` double DEFAULT NULL,
  `id_kind_work_fk` int(1) NOT NULL,
  `id_teacher_fk` int(4) NOT NULL,
  `id_meeting_fk` int(4) DEFAULT NULL,
  `id_mark_fk` int(1) DEFAULT NULL,
  `id_type_work_fk` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `diploma`
--

INSERT INTO `diploma` (`id`, `number_protocol`, `topic`, `anti_plagiarism`, `id_kind_work_fk`, `id_teacher_fk`, `id_meeting_fk`, `id_mark_fk`, `id_type_work_fk`) VALUES
(4, NULL, 'Анализ безопасности данных 2', NULL, 1, 2, NULL, NULL, 1),
(14, NULL, 'ssssssss', 0.3, 2, 1, NULL, NULL, 1),
(15, NULL, 'sssssssssss', 0.65, 2, 1, NULL, NULL, 2),
(16, NULL, 'sssssssssss', 0.65, 2, 1, NULL, NULL, 2),
(17, NULL, 'sssssssssss', 0.65, 2, 1, NULL, NULL, 2),
(18, NULL, 'sssssssssss', 0.65, 2, 1, NULL, NULL, 2),
(19, NULL, 'sssssssssss', 0.65, 2, 1, NULL, NULL, 2),
(24, NULL, '16Б0007', 0.7, 3, 1, NULL, NULL, 1),
(25, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(26, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(27, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(28, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(29, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(30, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(31, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(32, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(33, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(34, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(35, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(36, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(38, NULL, '16Б0007', 0.7, 1, 1, NULL, NULL, 1),
(47, NULL, 'Прикольная', 0.45, 3, 1, NULL, NULL, 2),
(48, NULL, 'Прикольная', 0, 3, 1, NULL, NULL, 2),
(49, NULL, 'Прикольная', 0, 3, 1, NULL, NULL, 1),
(50, NULL, 'Прикольная', 0, 3, 1, NULL, NULL, 1),
(51, NULL, 'Прикольная', 0, 3, 1, NULL, NULL, 1),
(52, NULL, 'Прикольная', 0, 3, 1, NULL, NULL, 1),
(53, NULL, 'dfh', 0.45, 1, 3, NULL, NULL, 1),
(54, NULL, 'ори', 0, 1, 1, NULL, NULL, 1),
(55, NULL, 'vbn', 0, 1, 1, NULL, NULL, 1),
(57, NULL, 'ыы', 0.6, 1, 1, NULL, NULL, 1),
(58, NULL, 'ыы', 0.6, 1, 1, NULL, NULL, 1),
(59, NULL, 'ыы', 0.6, 1, 1, NULL, NULL, 1),
(60, NULL, 'ыы', 0.6, 1, 1, NULL, NULL, 1),
(61, NULL, 'ыы', 0.6, 1, 1, NULL, NULL, 1),
(62, NULL, 'ыы', 0.6, 1, 1, NULL, NULL, 1),
(63, NULL, 'ыа', 0, 2, 2, NULL, NULL, 2),
(64, NULL, 'Простая', 0, 1, 2, NULL, NULL, 1),
(65, NULL, 'Простая', 0, 1, 3, NULL, NULL, 3),
(66, NULL, 'Суперская', NULL, 1, 3, NULL, NULL, 3),
(67, NULL, 'Суперская', NULL, 1, 3, NULL, NULL, 3),
(68, NULL, 'Суперская', NULL, 1, 3, NULL, NULL, 3),
(69, NULL, 'Суперская', NULL, 1, 3, NULL, NULL, 3),
(70, NULL, 'Суперская', NULL, 1, 3, NULL, NULL, 3),
(71, NULL, 'Суперская', NULL, 1, 3, NULL, NULL, 3),
(72, NULL, 'Суперская', NULL, 1, 3, NULL, NULL, 3),
(73, NULL, 'выпр', NULL, 1, 3, NULL, NULL, 1),
(74, NULL, 'Простая', 0, 1, 3, NULL, NULL, 3),
(75, 3, 'Простая', 0, 1, 3, 14, NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `direction`
--

CREATE TABLE `direction` (
  `id` int(4) NOT NULL,
  `cipher_direction` varchar(8) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `direction`
--

INSERT INTO `direction` (`id`, `cipher_direction`, `name`) VALUES
(1, '10.03.01', 'информационная безопасность'),
(2, '10.05.02', 'информационная безопасность телекоммуникационных систем'),
(3, '09.03.04', 'программная инженерия'),
(6, '09.03.01', 'информатика и вычислительная техника'),
(7, '09.03.02', 'информационные системы и технологии'),
(9, '15.03.02', 'технологические машины и оборудование');

-- --------------------------------------------------------

--
-- Структура таблицы `form_studying`
--

CREATE TABLE `form_studying` (
  `id` int(1) NOT NULL,
  `form` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `form_studying`
--

INSERT INTO `form_studying` (`id`, `form`) VALUES
(1, 'очная'),
(2, 'очно-заочная'),
(3, 'заочная');

-- --------------------------------------------------------

--
-- Структура таблицы `group_1`
--

CREATE TABLE `group_1` (
  `id` int(4) NOT NULL,
  `cipher_group` varchar(16) NOT NULL,
  `id_qualification_fk` int(1) NOT NULL,
  `id_university_fk` int(1) NOT NULL,
  `id_institute_fk` int(2) NOT NULL,
  `id_direction_fk` int(4) NOT NULL,
  `id_form_studying_fk` int(1) NOT NULL,
  `id_cathedra_fk` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `group_1`
--

INSERT INTO `group_1` (`id`, `cipher_group`, `id_qualification_fk`, `id_university_fk`, `id_institute_fk`, `id_direction_fk`, `id_form_studying_fk`, `id_cathedra_fk`) VALUES
(1, 'БББО-01-16', 1, 1, 1, 1, 1, 1),
(2, 'БББО-02-16', 1, 1, 1, 1, 1, 1),
(3, 'БББО-03-16', 1, 1, 1, 1, 1, 1),
(4, 'БТСО-01-16', 3, 1, 1, 2, 1, 1),
(5, 'БТСО-02-16', 1, 1, 1, 2, 3, 1),
(6, 'БКБО-01-16', 1, 1, 1, 3, 1, 2),
(7, 'БКБО-02-16', 1, 1, 1, 3, 1, 2),
(8, 'БВБО-01-16', 1, 1, 1, 6, 1, 3),
(9, 'БСБО-01-16', 1, 1, 1, 7, 2, 3),
(10, 'БСБО-02-16', 1, 1, 1, 7, 1, 3),
(11, 'ТРБО-01-16', 1, 1, 2, 9, 1, 4),
(12, 'БТСО-01-15', 3, 1, 1, 2, 1, 1),
(13, 'БСМО-01-18', 2, 1, 1, 7, 1, 2),
(15, 'БСБО-03-16', 1, 1, 1, 7, 1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `institute`
--

CREATE TABLE `institute` (
  `id` int(2) NOT NULL,
  `name_institute` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `institute`
--

INSERT INTO `institute` (`id`, `name_institute`) VALUES
(1, 'институт комплексной безопасности и специального приборостроения'),
(2, 'физико-технологический институт');

-- --------------------------------------------------------

--
-- Структура таблицы `kind_work`
--

CREATE TABLE `kind_work` (
  `id` int(1) NOT NULL,
  `name_kind` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kind_work`
--

INSERT INTO `kind_work` (`id`, `name_kind`) VALUES
(1, 'Бакалаврская работа'),
(2, 'магистерская работа'),
(3, 'дипломная работа');

-- --------------------------------------------------------

--
-- Структура таблицы `mark`
--

CREATE TABLE `mark` (
  `id` int(1) NOT NULL,
  `mark` varchar(32) NOT NULL,
  `characteristic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mark`
--

INSERT INTO `mark` (`id`, `mark`, `characteristic`) VALUES
(1, 'неудовлетворительно', 'Не имеет необходимых представлений о проверяемом материале'),
(2, 'удовлетворительно', 'Знает и умет на репродуктивном уровне. Знает изученный элемент содержания репродуктивно: произвольно воспроизводит свои знания устно, письменно или в демонстрируемых действиях.'),
(3, 'хорошо', 'Знает, умет, владет на аналитическом уровне. Знает на репродуктивном уровне, указывает на особенности и взаимосвязи изученных объектов, на их достоинства, ограничения, историю и перспективы развития и особенности для разных объектов усвоения'),
(4, 'отлично', 'Знает изученный элемент содержания образовательной программы на системном уровне. Системно, произвольно и доказательно воспроизводит свои знания устно, письменно или в демонстрируемых действиях, учитывая и указывая связи и зависимости между этим элементом и другими элементами содержания  его значимость в содержании профессиональной подготовки.');

-- --------------------------------------------------------

--
-- Структура таблицы `member_ssk`
--

CREATE TABLE `member_ssk` (
  `id` int(4) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `post` text DEFAULT NULL,
  `degree` varchar(255) NOT NULL,
  `rank` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `id_commission_fk` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `member_ssk`
--

INSERT INTO `member_ssk` (`id`, `last_name`, `first_name`, `patronymic`, `post`, `degree`, `rank`, `role`, `id_commission_fk`) VALUES
(3, 'Петров', 'Иван', 'Александрович', 'Доцент КБ-4', 'кандидат наук', 'Доцент', 'Председатель', 1),
(4, 'Андреева', 'Александра', 'Николаевна', 'Доцент КБ-4', 'доктор наук', 'Доцент', 'Член', 1),
(5, 'Киров', 'Иван', 'Аркадьевич', 'Доцент', 'кандидат наук', 'доцент', 'секретарь', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `qualification`
--

CREATE TABLE `qualification` (
  `id` int(1) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `qualification`
--

INSERT INTO `qualification` (`id`, `name`) VALUES
(1, 'бакалавр'),
(2, 'магистр'),
(3, 'специалист');

-- --------------------------------------------------------

--
-- Структура таблицы `question_diploma`
--

CREATE TABLE `question_diploma` (
  `id` int(8) NOT NULL,
  `question` text CHARACTER SET utf8mb4 NOT NULL,
  `id_diploma_fk` int(4) NOT NULL,
  `id_member_fk` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `question_member`
--

CREATE TABLE `question_member` (
  `id` int(8) NOT NULL,
  `first_member_fk` int(8) DEFAULT NULL,
  `second_member_fk` int(8) DEFAULT NULL,
  `third_member_fk` int(8) DEFAULT NULL,
  `fourth_member_fk` int(8) DEFAULT NULL,
  `fifth_member_fk` int(8) DEFAULT NULL,
  `sixth_member_fk` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `question_se`
--

CREATE TABLE `question_se` (
  `id` int(8) NOT NULL,
  `question` text DEFAULT NULL,
  `id_se_fk` int(8) NOT NULL,
  `id_member_fk` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `review`
--

CREATE TABLE `review` (
  `id` int(4) NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf16 NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `post` text NOT NULL,
  `place_work` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `se`
--

CREATE TABLE `se` (
  `id` int(8) NOT NULL,
  `number_protocol` int(4) NOT NULL,
  `id_ticket_fk` int(4) DEFAULT NULL,
  `id_mark_fk` int(1) DEFAULT NULL,
  `id_meeting_fk` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `se`
--

INSERT INTO `se` (`id`, `number_protocol`, `id_ticket_fk`, `id_mark_fk`, `id_meeting_fk`) VALUES
(134, 11, 11, 3, 23);

-- --------------------------------------------------------

--
-- Структура таблицы `student`
--

CREATE TABLE `student` (
  `id` int(8) NOT NULL,
  `number_record_book` varchar(8) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `id_group_fk` int(4) NOT NULL,
  `id_se_fk` int(4) DEFAULT NULL,
  `id_diploma_fk` int(4) DEFAULT NULL,
  `id_review_fk` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `student`
--

INSERT INTO `student` (`id`, `number_record_book`, `last_name`, `first_name`, `patronymic`, `id_group_fk`, `id_se_fk`, `id_diploma_fk`, `id_review_fk`) VALUES
(4, '16Б0004', 'Янов', 'Ян', 'Янович', 1, NULL, 14, NULL),
(45, '15Б0088', 'Анакина', 'Анна', 'Ивановна', 12, NULL, 47, NULL),
(46, '15Б0088', 'Анакина', 'Анна', 'Ивановна', 12, NULL, 48, NULL),
(47, '15Б0088', 'Анакина', 'Анна', 'Ивановна', 12, NULL, 49, NULL),
(48, '15Б0088', 'Анакина', 'Анна', 'Ивановна', 12, NULL, 50, NULL),
(49, '15Б0088', 'Анакина', 'Анна', 'Ивановна', 12, NULL, 51, NULL),
(50, '15Б0088', 'Анакина', 'Анна', 'Ивановна', 12, NULL, 52, NULL),
(51, '16Б7778', 'Кукушкин', 'Анна', 'Ивановна', 11, NULL, 53, NULL),
(52, '16Б7773', 'Анакина', 'Матвей', 'Петрович', 1, NULL, 54, NULL),
(53, '16Б7777', 'Попов', 'Иван', 'Владимирович', 2, NULL, 55, NULL),
(55, '16Б7777', 'Анакина', 'Адам', 'Ивановна', 3, NULL, 57, NULL),
(56, '16Б7777', 'Анакина', 'Адам', 'Ивановна', 3, NULL, 58, NULL),
(57, '16Б7777', 'Анакина', 'Адам', 'Ивановна', 3, NULL, 59, NULL),
(58, '16Б7777', 'Анакина', 'Адам', 'Ивановна', 3, NULL, 60, NULL),
(59, '16Б7777', 'Анакина', 'Адам', 'Ивановна', 3, NULL, 61, NULL),
(60, '16Б7770', 'Анакина', 'Адам', 'Ивановна', 3, NULL, 62, NULL),
(61, '16Б7771', 'Попов', 'Иван', 'Владимирович', 13, NULL, 63, NULL),
(62, '17Б0001', 'Иванова', 'Анна', 'Ивановна', 1, NULL, 64, NULL),
(63, '17Б0002', 'Павленко', 'Татьяна', 'Петровна', 1, NULL, 65, NULL),
(64, '1', 'Александров', 'Иван', 'Ильич', 10, NULL, 68, NULL),
(65, '16Б0005', 'Александров', 'Иван', 'Ильич', 10, NULL, 69, NULL),
(66, '16Б0005', 'Александров', 'Иван', 'Ильич', 10, NULL, 70, NULL),
(67, '16Б0003', 'Александров', 'Иван', 'Ильич', 10, NULL, 71, NULL),
(68, '17Б0003', 'Александров', 'Иван', 'Ильич', 10, NULL, 72, NULL),
(69, '17Б0004', 'Александров', 'Иван', 'Ильич', 10, NULL, 73, NULL),
(70, '17Б0007', 'Павленко', 'Татьяна', 'Петровна', 1, NULL, 74, NULL),
(71, '17Б0009', 'Павло', 'Анна', 'Павловна', 15, 134, 75, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE `teacher` (
  `id` int(4) NOT NULL,
  `cipher_teacher` varchar(16) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `rank` varchar(255) NOT NULL,
  `post` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`id`, `cipher_teacher`, `last_name`, `first_name`, `patronymic`, `degree`, `rank`, `post`) VALUES
(1, '00П0022', 'Алексеев', 'Альберт', 'Юрьевич', 'Доктор наук', 'Профессор', 'Преподаватель'),
(2, '10П0001', 'Сидоров', 'Сидр', 'Сидрович', 'Кандидат наук', 'Профессор', 'Преподаватель'),
(3, '10П0002', 'Павлов', 'Петр', 'Алексеевич', 'Доктор наук', 'Профессор', 'Преподаватель');

-- --------------------------------------------------------

--
-- Структура таблицы `ticket`
--

CREATE TABLE `ticket` (
  `id` int(4) NOT NULL,
  `first_question` text NOT NULL,
  `second_question` text NOT NULL,
  `third_question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ticket`
--

INSERT INTO `ticket` (`id`, `first_question`, `second_question`, `third_question`) VALUES
(2, 'ssss', 'sssss', 'sssss'),
(3, 'ssss', 'sssss', 'sssss'),
(4, 'third_question', 'third_question', 'third_question'),
(7, 'ssssss', 'ssssss', 'ssssss'),
(8, 'sssss', 'ssssss', 'sssss'),
(11, 'ddd', 'ddddddd', 'dddddd'),
(12, 'ssss', 'ssss', 'sssss'),
(13, 'ssss', 'ssssss', 'ssss'),
(14, 'sssss', 'sssssss', 'ssssss'),
(15, 'sss', 'sssss', 'ssss');

-- --------------------------------------------------------

--
-- Структура таблицы `timetable_meeting`
--

CREATE TABLE `timetable_meeting` (
  `id` int(8) NOT NULL,
  `number_meeting` int(4) NOT NULL,
  `date` date DEFAULT NULL,
  `id_commission_fk` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `timetable_meeting`
--

INSERT INTO `timetable_meeting` (`id`, `number_meeting`, `date`, `id_commission_fk`) VALUES
(1, 1, '2020-05-18', 1),
(2, 2, '2020-05-19', 1),
(3, 3, '2020-05-22', 1),
(4, 1, '2020-05-19', 2),
(5, 2, '2020-05-25', 2),
(6, 1, NULL, 13),
(7, 2, NULL, 13),
(8, 3, NULL, 13),
(9, 4, NULL, 13),
(10, 5, NULL, 13),
(11, 6, NULL, 13),
(12, 7, NULL, 13),
(13, 8, NULL, 13),
(14, 1, NULL, 29),
(15, 2, NULL, 29),
(16, 3, NULL, 29),
(17, 1, NULL, 29),
(18, 2, NULL, 29),
(19, 1, NULL, 29),
(20, 2, NULL, 29),
(21, 1, NULL, 29),
(22, 2, NULL, 29),
(23, 1, NULL, 29),
(24, 2, NULL, 29),
(25, 3, NULL, 29),
(26, 1, NULL, 29),
(27, 2, NULL, 29),
(28, 3, NULL, 29),
(29, 1, NULL, 35),
(30, 2, NULL, 35),
(31, 3, NULL, 35),
(32, 1, NULL, 36),
(33, 2, NULL, 36),
(34, 3, NULL, 36),
(35, 1, '2020-04-02', 37),
(36, 2, '2020-04-15', 37),
(37, 3, '2020-04-01', 37),
(38, 1, '2020-04-08', 38),
(39, 2, '2020-04-22', 38);

-- --------------------------------------------------------

--
-- Структура таблицы `type_work`
--

CREATE TABLE `type_work` (
  `id` int(1) NOT NULL,
  `name_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `type_work`
--

INSERT INTO `type_work` (`id`, `name_type`) VALUES
(1, 'простая работа'),
(2, 'заказная работа'),
(3, 'университетская работа');

-- --------------------------------------------------------

--
-- Структура таблицы `university`
--

CREATE TABLE `university` (
  `id` int(1) NOT NULL,
  `abbreviation` varchar(32) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `full_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `university`
--

INSERT INTO `university` (`id`, `abbreviation`, `name`, `full_name`) VALUES
(1, 'РТУ МИРЭА', 'московский институт радиотехники, электроники и автоматики', 'федеральное государственное бюджетное образовательное учреждение высшего образования «МИРЭА — Российский технологический университет»');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(4) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `uid` int(9) DEFAULT NULL,
  `hash` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `uid`, `hash`) VALUES
(1, 'admin', '8450eca01665516d9aeb5317764902b78495502637c96192c81b1683d32d691a0965cf037feca8b9ed9ee6fc6ab8f27fce8f77c4fd9b4a442a00fc317b8237e6', 20, '8c04e7a2dd504f96016721a1fa02c5a37d1a7ad088db940e45204e0664e1fae8f0427fef0a34bc0d0336d751969da7029a6d2d093dcade3adfc8a4d245d8b5f8'),
(9, 'sssssssss', '5c3718fd2b374d6254176036bca81f8a3de678484bad7a88fffd0910080aba1a6a066f6a519b72bd7f1ca8e77a9f95d376b8b4edd5119e03f0a7d738017b4cc0', NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cathedra`
--
ALTER TABLE `cathedra`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `commission`
--
ALTER TABLE `commission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_fk` (`id_user_fk`);

--
-- Индексы таблицы `curation`
--
ALTER TABLE `curation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_group_fk_2` (`id_group_fk`),
  ADD KEY `id_user_fk` (`id_user_fk`),
  ADD KEY `id_group_fk` (`id_group_fk`);

--
-- Индексы таблицы `diploma`
--
ALTER TABLE `diploma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kind_work_fk` (`id_kind_work_fk`),
  ADD KEY `cipher_teacher_fk` (`id_teacher_fk`),
  ADD KEY `number_meeting_fk` (`id_meeting_fk`),
  ADD KEY `mark_fk` (`id_mark_fk`),
  ADD KEY `type_work_fk` (`id_type_work_fk`);

--
-- Индексы таблицы `direction`
--
ALTER TABLE `direction`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `form_studying`
--
ALTER TABLE `form_studying`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `group_1`
--
ALTER TABLE `group_1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_university_fk` (`id_university_fk`),
  ADD KEY `id_institute_fk` (`id_institute_fk`),
  ADD KEY `id_direction_fk` (`id_direction_fk`),
  ADD KEY `id_form_studying` (`id_form_studying_fk`),
  ADD KEY `id_cathedra` (`id_cathedra_fk`),
  ADD KEY `id_qualification_fk` (`id_qualification_fk`);

--
-- Индексы таблицы `institute`
--
ALTER TABLE `institute`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kind_work`
--
ALTER TABLE `kind_work`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mark`
--
ALTER TABLE `mark`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `member_ssk`
--
ALTER TABLE `member_ssk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `number_commission_fk` (`id_commission_fk`);

--
-- Индексы таблицы `qualification`
--
ALTER TABLE `qualification`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `question_diploma`
--
ALTER TABLE `question_diploma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_diploma_fk` (`id_diploma_fk`),
  ADD KEY `id_member_fk` (`id_member_fk`);

--
-- Индексы таблицы `question_member`
--
ALTER TABLE `question_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_member_fk` (`first_member_fk`),
  ADD KEY `second_member_fk` (`second_member_fk`),
  ADD KEY `third_member_fk` (`third_member_fk`),
  ADD KEY `fourth_member_fk` (`fourth_member_fk`),
  ADD KEY `fifth_member_fk` (`fifth_member_fk`),
  ADD KEY `sixth_member_fk` (`sixth_member_fk`);

--
-- Индексы таблицы `question_se`
--
ALTER TABLE `question_se`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_member_fk` (`id_member_fk`),
  ADD KEY `id_se_fk` (`id_se_fk`);

--
-- Индексы таблицы `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `se`
--
ALTER TABLE `se`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mark_fk` (`id_mark_fk`),
  ADD KEY `number_meeting_fk` (`id_meeting_fk`),
  ADD KEY `number_ticket_fk` (`id_ticket_fk`);

--
-- Индексы таблицы `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cipher_group_fk` (`id_group_fk`),
  ADD KEY `number_protocol_se_fk` (`id_se_fk`,`id_diploma_fk`),
  ADD KEY `id_review_fk` (`id_review_fk`),
  ADD KEY `student_ibfk_4` (`id_diploma_fk`);

--
-- Индексы таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `timetable_meeting`
--
ALTER TABLE `timetable_meeting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `number_commission_fk` (`id_commission_fk`);

--
-- Индексы таблицы `type_work`
--
ALTER TABLE `type_work`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `university`
--
ALTER TABLE `university`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cathedra`
--
ALTER TABLE `cathedra`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `commission`
--
ALTER TABLE `commission`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `curation`
--
ALTER TABLE `curation`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `diploma`
--
ALTER TABLE `diploma`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT для таблицы `direction`
--
ALTER TABLE `direction`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `form_studying`
--
ALTER TABLE `form_studying`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `group_1`
--
ALTER TABLE `group_1`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `institute`
--
ALTER TABLE `institute`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `kind_work`
--
ALTER TABLE `kind_work`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `mark`
--
ALTER TABLE `mark`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `member_ssk`
--
ALTER TABLE `member_ssk`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `qualification`
--
ALTER TABLE `qualification`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `question_diploma`
--
ALTER TABLE `question_diploma`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `question_member`
--
ALTER TABLE `question_member`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `question_se`
--
ALTER TABLE `question_se`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `se`
--
ALTER TABLE `se`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT для таблицы `student`
--
ALTER TABLE `student`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT для таблицы `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `timetable_meeting`
--
ALTER TABLE `timetable_meeting`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `type_work`
--
ALTER TABLE `type_work`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `university`
--
ALTER TABLE `university`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `curation`
--
ALTER TABLE `curation`
  ADD CONSTRAINT `curation_ibfk_1` FOREIGN KEY (`id_group_fk`) REFERENCES `group_1` (`id`),
  ADD CONSTRAINT `curation_ibfk_2` FOREIGN KEY (`id_user_fk`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `diploma`
--
ALTER TABLE `diploma`
  ADD CONSTRAINT `diploma_ibfk_10` FOREIGN KEY (`id_type_work_fk`) REFERENCES `type_work` (`id`),
  ADD CONSTRAINT `diploma_ibfk_11` FOREIGN KEY (`id_kind_work_fk`) REFERENCES `kind_work` (`id`),
  ADD CONSTRAINT `diploma_ibfk_12` FOREIGN KEY (`id_mark_fk`) REFERENCES `mark` (`id`),
  ADD CONSTRAINT `diploma_ibfk_13` FOREIGN KEY (`id_meeting_fk`) REFERENCES `timetable_meeting` (`id`),
  ADD CONSTRAINT `diploma_ibfk_9` FOREIGN KEY (`id_teacher_fk`) REFERENCES `teacher` (`id`);

--
-- Ограничения внешнего ключа таблицы `group_1`
--
ALTER TABLE `group_1`
  ADD CONSTRAINT `group_1_ibfk_1` FOREIGN KEY (`id_university_fk`) REFERENCES `university` (`id`),
  ADD CONSTRAINT `group_1_ibfk_2` FOREIGN KEY (`id_institute_fk`) REFERENCES `institute` (`id`),
  ADD CONSTRAINT `group_1_ibfk_3` FOREIGN KEY (`id_direction_fk`) REFERENCES `direction` (`id`),
  ADD CONSTRAINT `group_1_ibfk_4` FOREIGN KEY (`id_form_studying_fk`) REFERENCES `form_studying` (`id`),
  ADD CONSTRAINT `group_1_ibfk_5` FOREIGN KEY (`id_cathedra_fk`) REFERENCES `cathedra` (`id`),
  ADD CONSTRAINT `group_1_ibfk_6` FOREIGN KEY (`id_qualification_fk`) REFERENCES `qualification` (`id`);

--
-- Ограничения внешнего ключа таблицы `member_ssk`
--
ALTER TABLE `member_ssk`
  ADD CONSTRAINT `member_ssk_ibfk_1` FOREIGN KEY (`id_commission_fk`) REFERENCES `commission` (`id`);

--
-- Ограничения внешнего ключа таблицы `question_diploma`
--
ALTER TABLE `question_diploma`
  ADD CONSTRAINT `question_diploma_ibfk_1` FOREIGN KEY (`id_diploma_fk`) REFERENCES `diploma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_diploma_ibfk_2` FOREIGN KEY (`id_member_fk`) REFERENCES `member_ssk` (`id`);

--
-- Ограничения внешнего ключа таблицы `question_se`
--
ALTER TABLE `question_se`
  ADD CONSTRAINT `question_se_ibfk_1` FOREIGN KEY (`id_member_fk`) REFERENCES `member_ssk` (`id`),
  ADD CONSTRAINT `question_se_ibfk_2` FOREIGN KEY (`id_se_fk`) REFERENCES `se` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `se`
--
ALTER TABLE `se`
  ADD CONSTRAINT `se_ibfk_5` FOREIGN KEY (`id_ticket_fk`) REFERENCES `ticket` (`id`),
  ADD CONSTRAINT `se_ibfk_7` FOREIGN KEY (`id_mark_fk`) REFERENCES `mark` (`id`),
  ADD CONSTRAINT `se_ibfk_8` FOREIGN KEY (`id_meeting_fk`) REFERENCES `timetable_meeting` (`id`);

--
-- Ограничения внешнего ключа таблицы `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`id_se_fk`) REFERENCES `se` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_ibfk_3` FOREIGN KEY (`id_review_fk`) REFERENCES `review` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_ibfk_4` FOREIGN KEY (`id_diploma_fk`) REFERENCES `diploma` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_ibfk_5` FOREIGN KEY (`id_group_fk`) REFERENCES `group_1` (`id`);

--
-- Ограничения внешнего ключа таблицы `timetable_meeting`
--
ALTER TABLE `timetable_meeting`
  ADD CONSTRAINT `timetable_meeting_ibfk_1` FOREIGN KEY (`id_commission_fk`) REFERENCES `commission` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
