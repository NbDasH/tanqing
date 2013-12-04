-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013-12-04 17:14:41
-- 服务器版本: 5.6.11
-- PHP 版本: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `tq_post`
--
CREATE DATABASE IF NOT EXISTS `tq_post` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tq_post`;

-- --------------------------------------------------------

--
-- 表的结构 `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `banners`
--

INSERT INTO `banners` (`id`, `link`) VALUES
(1, 'dd32.com'),
(2, '321'),
(3, 'baidu.com');

-- --------------------------------------------------------

--
-- 表的结构 `contents`
--

CREATE TABLE IF NOT EXISTS `contents` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `time` int(10) NOT NULL,
  `user_id` int(12) NOT NULL,
  `key_words` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- 表的结构 `global_config`
--

CREATE TABLE IF NOT EXISTS `global_config` (
  `config_name` varchar(50) NOT NULL,
  `config_value` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `global_config`
--

INSERT INTO `global_config` (`config_name`, `config_value`) VALUES
('page_limit', '5'),
('page_footer', 'aaa2'),
('ad_visible', '0'),
('weibo_btn', '0');

-- --------------------------------------------------------

--
-- 表的结构 `key_words`
--

CREATE TABLE IF NOT EXISTS `key_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_word` varchar(50) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- 表的结构 `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `time` int(10) NOT NULL,
  `message` varchar(11) NOT NULL,
  `user_id` int(12) DEFAULT NULL,
  `content_id` int(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_nick_name` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_event` int(1) NOT NULL DEFAULT '1',
  `user_photo` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_nick_name`, `user_password`, `user_event`, `user_photo`) VALUES
(1, 'admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 3, '');

--
-- 限制导出的表
--

--
-- 限制表 `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
