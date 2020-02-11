-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2020 年 02 月 10 日 09:05
-- 伺服器版本： 5.7.29
-- PHP 版本： 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `messageBoard`
--
CREATE DATABASE IF NOT EXISTS `messageBoard` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `messageBoard`;

-- --------------------------------------------------------

--
-- 資料表結構 `context`
--

CREATE TABLE `context` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '暱稱',
  `context` varchar(255) NOT NULL COMMENT '留言內容',
  `other` varchar(255) NOT NULL COMMENT '備用欄位'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `context`
--

INSERT INTO `context` (`id`, `name`, `context`, `other`) VALUES
(1, 'test', 'test', ''),
(2, 'test', 'test2', ''),
(3, 'test', 'test123', ''),
(4, 'ADA', 'TEST', ''),
(5, '123', '123', ''),
(6, 'aa', 'aa', ''),
(7, 'aaa', 'bbb', ''),
(12, 'aaa', 'aaa', ''),
(16, 'aaa', 'cca', ''),
(17, 'AAA', 'AAA', ''),
(19, '我是ada', '1234', ''),
(20, 'aaa', 'aaaaaa', ''),
(21, '123', '123', ''),
(22, 'aaaa', '123', '');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `context`
--
ALTER TABLE `context`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `context`
--
ALTER TABLE `context`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
