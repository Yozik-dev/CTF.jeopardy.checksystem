CREATE TABLE IF NOT EXISTS `hints` (
`id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Indexes for table `hints`
--
ALTER TABLE `hints`
 ADD PRIMARY KEY (`id`);