-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-10-08 15:58:15
-- 服务器版本： 5.6.49-log
-- PHP 版本： 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `weather_loli_ren`
--

-- --------------------------------------------------------

--
-- 表的结构 `weather_city_base`
--

CREATE TABLE `weather_city_base` (
  `add_date` int(11) NOT NULL,
  `city` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `weather_city_data`
--

CREATE TABLE `weather_city_data` (
  `add_date` int(11) NOT NULL,
  `city` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `weather_users`
--

CREATE TABLE `weather_users` (
  `id` int(11) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `add_date` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `enabled` int(11) NOT NULL,
  `verifyCode` text NOT NULL,
  `last_login_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `weather_users_token`
--

CREATE TABLE `weather_users_token` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `add_date` int(11) NOT NULL,
  `up_date` int(11) NOT NULL,
  `token` text NOT NULL,
  `note` text NOT NULL,
  `city` text NOT NULL,
  `last_use_date` int(11) NOT NULL,
  `enabled` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `weather_city_base`
--
ALTER TABLE `weather_city_base`
  ADD KEY `add_date` (`add_date`);

--
-- 表的索引 `weather_city_data`
--
ALTER TABLE `weather_city_data`
  ADD KEY `add_date` (`add_date`);

--
-- 表的索引 `weather_users`
--
ALTER TABLE `weather_users`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `weather_users_token`
--
ALTER TABLE `weather_users_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `userid` (`userid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `weather_users`
--
ALTER TABLE `weather_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `weather_users_token`
--
ALTER TABLE `weather_users_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
