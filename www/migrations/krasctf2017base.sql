-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2017 at 12:40 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `krasctf`
--

-- --------------------------------------------------------

--
-- Table structure for table `accepted_requests`
--

CREATE TABLE `accepted_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `extra_points`
--

CREATE TABLE `extra_points` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `hints`
--

CREATE TABLE `hints` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1510227024);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
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
-- (See below for the actual view)
--
CREATE TABLE `scoreboard` (
`login` varchar(64)
,`result` decimal(33,0)
,`university` varchar(256)
,`city` varchar(256)
,`logo` varchar(256)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `scoreboard_helper_accepted`
-- (See below for the actual view)
--
CREATE TABLE `scoreboard_helper_accepted` (
`user_id` int(11)
,`tasks_points` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `scoreboard_helper_extra`
-- (See below for the actual view)
--
CREATE TABLE `scoreboard_helper_extra` (
`user_id` int(11)
,`extra_points` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `cost` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `category` int(11) NOT NULL,
  `checker_name` int(11) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `logo` varchar(256) NOT NULL DEFAULT '/images/index.png',
  `university` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `is_guest` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `admin`, `logo`, `university`, `city`, `score`, `is_guest`) VALUES
(1, 'admin', 'admin', 1, '/images/index.png', 'ИТМО', 'Санкт-Петербург', 12445, 0),
(2, 'Yozik', 'XTWIA_12RLO', 0, '/images/index.png', 'СФУ', 'Красноярск', 0, 0),
(3, 'Котик', 'PBLR4_ZIA4I', 0, '/images/index.png', 'СФУ', 'Красноярск', 0, 0);

-- --------------------------------------------------------

--
-- Structure for view `scoreboard`
--
DROP TABLE IF EXISTS `scoreboard`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `scoreboard`  AS  select `users`.`login` AS `login`,(`extra`.`extra_points` + `accept`.`tasks_points`) AS `result`,`users`.`university` AS `university`,`users`.`city` AS `city`,`users`.`logo` AS `logo` from ((`users` left join `scoreboard_helper_accepted` `accept` on((`users`.`id` = `accept`.`user_id`))) left join `scoreboard_helper_extra` `extra` on((`users`.`id` = `extra`.`user_id`))) where (`users`.`admin` = 0) ;

-- --------------------------------------------------------

--
-- Structure for view `scoreboard_helper_accepted`
--
DROP TABLE IF EXISTS `scoreboard_helper_accepted`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `scoreboard_helper_accepted`  AS  select `accepted_requests`.`user_id` AS `user_id`,sum(`tasks`.`cost`) AS `tasks_points` from (`accepted_requests` left join `tasks` on((`tasks`.`id` = `accepted_requests`.`task_id`))) group by `accepted_requests`.`user_id` ;

-- --------------------------------------------------------

--
-- Structure for view `scoreboard_helper_extra`
--
DROP TABLE IF EXISTS `scoreboard_helper_extra`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `scoreboard_helper_extra`  AS  select `extra_points`.`user_id` AS `user_id`,sum(`extra_points`.`cost`) AS `extra_points` from `extra_points` group by `extra_points`.`user_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_requests`
--
ALTER TABLE `accepted_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index` (`user_id`,`task_id`);

--
-- Indexes for table `extra_points`
--
ALTER TABLE `extra_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hints`
--
ALTER TABLE `hints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accepted_requests`
--
ALTER TABLE `accepted_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `extra_points`
--
ALTER TABLE `extra_points`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
