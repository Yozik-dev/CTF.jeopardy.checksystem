-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 29, 2015 at 10:35 PM
-- Server version: 5.6.25-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `checksystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `accepted_requests`
--

CREATE TABLE IF NOT EXISTS `accepted_requests` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hints`
--

CREATE TABLE IF NOT EXISTS `hints` (
`id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `created` datetime NOT NULL,
  `result` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `scoreboard`
--
CREATE TABLE IF NOT EXISTS `scoreboard` (
`login` varchar(64)
,`result` decimal(32,0)
,`university` varchar(256)
,`city` varchar(256)
,`logo` varchar(256)
);
-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
`id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `cost` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `category` int(11) NOT NULL,
  `checker_name` int(11) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `cost`, `visible`, `answer`, `category`, `checker_name`, `position`) VALUES
(1, 'jsPuzzle', 'Командам выдается архив, содержащий в себе HTML документ с популярной игрой пятнашки. Изначально поле находится в беспорядке. Задача – собрать поле. Внизу страницы расположено текстовое поле для ввода пароля. В зависимости от введенного текста, пятнашки будут перемещаться. Также, перемещать пятнашки можно кликами мыши на поле.', 100, 1, 'crypto_jspuzzle', 0, 0, 1),
(2, 'new_task', 'new_task', 200, 1, 'new_task', 0, 0, 2),
(3, 'LLR', 'LLRLLR', 300, 1, 'LLR', 2, 0, 2),
(4, 'tcpShop', 'tcpShop task', 300, 1, 'KCTF{}', 5, 0, 1),
(5, 'Pyramid', 'Pyramid', 100, 1, 'Pyramid', 1, 0, 1),
(7, '123', '123', 123, 1, '123', 0, 0, 123),
(8, 'Черный рынок', '1234', 1234, 1, '1234', 0, 0, 1234),
(9, '12345', '12345', 12345, 1, '12345', 0, 0, 12345);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `logo` varchar(256) NOT NULL DEFAULT '/images/index.png',
  `university` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `admin`, `logo`, `university`, `city`, `score`) VALUES
(1, 'admin', 'admin', 1, '/images/index.png', 'ИТМО', 'Санкт-Петербург', 12445),
(2, 'Yozik', 'XTWIA_12RLO', 0, '/images/index.png', 'СФУ', 'Красноярск', 0),
(3, 'Котик', 'PBLR4_ZIA4I', 0, '/images/index.png', 'СФУ', 'Красноярск', 0);

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `extra_points` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `extra_points`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `extra_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Structure for view `scoreboard`
--
DROP TABLE IF EXISTS `scoreboard`;
DROP VIEW IF EXISTS `scoreboard`;
DROP TABLE IF EXISTS `scoreboard_helper_accepted`;
DROP VIEW IF EXISTS `scoreboard_helper_accepted`;
DROP TABLE IF EXISTS `scoreboard_helper_extra`;
DROP VIEW IF EXISTS `scoreboard_helper_extra`;
--ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER
CREATE VIEW `scoreboard_helper_accepted` AS
	SELECT `user_id`, 
	sum(`tasks`.`cost`) as `tasks_points` FROM
	`accepted_requests` 
	left join `tasks` on(`tasks`.`id` = `accepted_requests`.`task_id`) 
	GROUP BY `accepted_requests`.`user_id`;
	
CREATE VIEW `scoreboard_helper_extra` AS
	SELECT `user_id`, 
	sum(`extra_points`.`cost`) as `extra_points` FROM
	`extra_points` GROUP BY `extra_points`.`user_id`;

CREATE VIEW `scoreboard` AS
	select `users`.`login` AS `login`,
	`extra_points` + `tasks_points` AS `result`,
	`users`.`university` AS `university`,
	`users`.`city` AS `city`,
	`users`.`logo` AS `logo` FROM(
		`users` 
		LEFT JOIN scoreboard_helper_accepted AS accept on (`users`.`id` = `accept`.`user_id`)
		LEFT JOIN scoreboard_helper_extra as extra on (`users`.`id` = `extra`.`user_id`)
	) where (`users`.`admin` = 0);
		
--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_requests`
--
ALTER TABLE `accepted_requests`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `unique_index` (`user_id`,`task_id`);

--
-- Indexes for table `hints`
--
ALTER TABLE `hints`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accepted_requests`
--
ALTER TABLE `accepted_requests`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hints`
--
ALTER TABLE `hints`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
