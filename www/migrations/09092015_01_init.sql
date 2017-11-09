CREATE TABLE IF NOT EXISTS `accepted_requests` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `requests` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `created` datetime NOT NULL,
  `result` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `login` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tasks` (
`id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `cost` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '0',
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `login`, `password`, `admin`) VALUES
(1, 'admin', 'admin', 1);

ALTER TABLE `accepted_requests`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `requests`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `tasks`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `accepted_requests`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `requests`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

ALTER TABLE `tasks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;