<?php
$db = mysqli_connect(
    getenv("MYSQL_HOST"),
getenv("SQL_USER"),
getenv("MYSQL_PASSWORD"),
getenv("MYSQL_DATABASE"))
    or die('Error connecting to database');
/*
SQL to create needed table

CREATE TABLE `authUsers` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `authUsers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

ALTER TABLE `authUsers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
 */