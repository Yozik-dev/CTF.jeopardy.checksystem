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