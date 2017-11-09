DROP TABLE IF EXISTS `scoreboard`;
DROP VIEW IF EXISTS `scoreboard`;
DROP TABLE IF EXISTS `scoreboard_helper_accepted`;
DROP VIEW IF EXISTS `scoreboard_helper_accepted`;
DROP TABLE IF EXISTS `scoreboard_helper_extra`;
DROP VIEW IF EXISTS `scoreboard_helper_extra`;

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
	IFNULL(`extra`.`extra_points`,0) + IFNULL(`accept`.`tasks_points`,0) AS `result`,
	`users`.`university` AS `university`,
	`users`.`city` AS `city`, `users`.`logo` AS `logo`
	FROM( `users` LEFT JOIN scoreboard_helper_accepted AS accept on (`users`.`id` = `accept`.`user_id`) LEFT JOIN scoreboard_helper_extra as extra on (`users`.`id` = `extra`.`user_id`) ) where (`users`.`admin` = 0);
