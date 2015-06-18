-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2015-06-16 04:40:50
-- 伺服器版本: 5.6.24
-- PHP 版本： 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `test_market`
--

-- --------------------------------------------------------

--
-- 資料表結構 `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `uid` int(11) NOT NULL,
  `username` char(80) COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL,
  `title` text COLLATE utf8_bin,
  `root` tinyint(1) NOT NULL,
  `stats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `goodlist`
--

CREATE TABLE IF NOT EXISTS `goodlist` (
  `lid` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `starttime` date NOT NULL,
  `endtime` date NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `goodlist_accountgroup`
--

CREATE TABLE IF NOT EXISTS `goodlist_accountgroup` (
  `lid` int(11) NOT NULL,
  `gpid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `goodlist_goodstable`
--

CREATE TABLE IF NOT EXISTS `goodlist_goodstable` (
  `lid` int(11) NOT NULL,
  `gid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `gid` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `type` text COLLATE utf8_bin NOT NULL,
  `price` int(11) NOT NULL,
  `defaultnum` int(11) NOT NULL,
  `maxnum` int(11) NOT NULL,
  `description` text COLLATE utf8_bin,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `goods_image`
--

CREATE TABLE IF NOT EXISTS `goods_image` (
  `gid` int(11) NOT NULL,
  `imgid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `imgid` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `realname` char(200) COLLATE utf8_bin NOT NULL DEFAULT '',
  `hashname` char(50) COLLATE utf8_bin NOT NULL,
  `title` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `orderlist`
--

CREATE TABLE IF NOT EXISTS `orderlist` (
  `odid` int(11) NOT NULL,
  `suid` int(11) NOT NULL,
  `gpid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `orderhash` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `orderlist_detail`
--

CREATE TABLE IF NOT EXISTS `orderlist_detail` (
  `odid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `bust` int(11) NOT NULL DEFAULT '0',
  `waistline` int(11) NOT NULL DEFAULT '0',
  `lpants` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `saccount_group`
--

CREATE TABLE IF NOT EXISTS `saccount_group` (
  `gpid` int(11) NOT NULL,
  `title` char(80) COLLATE utf8_bin NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `student_account`
--

CREATE TABLE IF NOT EXISTS `student_account` (
  `suid` int(11) NOT NULL,
  `username` char(80) COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL,
  `gpid` int(11) NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `syslog`
--

CREATE TABLE IF NOT EXISTS `syslog` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `namespace` varchar(60) COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 資料表結構 `system`
--

CREATE TABLE IF NOT EXISTS `system` (
  `id` char(60) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- 資料表索引 `goodlist`
--
ALTER TABLE `goodlist`
  ADD PRIMARY KEY (`lid`),
  ADD KEY `lid` (`lid`),
  ADD KEY `owner` (`owner`);

--
-- 資料表索引 `goodlist_accountgroup`
--
ALTER TABLE `goodlist_accountgroup`
  ADD UNIQUE KEY `lid` (`lid`,`gpid`),
  ADD KEY `goodlist_accountgroup_ibfk_2` (`gpid`);

--
-- 資料表索引 `goodlist_goodstable`
--
ALTER TABLE `goodlist_goodstable`
  ADD UNIQUE KEY `lid` (`lid`,`gid`),
  ADD KEY `lid_2` (`lid`),
  ADD KEY `gid` (`gid`);

--
-- 資料表索引 `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`gid`),
  ADD KEY `owner` (`owner`);

--
-- 資料表索引 `goods_image`
--
ALTER TABLE `goods_image`
  ADD UNIQUE KEY `lid` (`gid`,`imgid`),
  ADD KEY `goodlist_image_ibfk_2` (`imgid`);

--
-- 資料表索引 `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`imgid`);

--
-- 資料表索引 `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`odid`),
  ADD UNIQUE KEY `odid` (`odid`),
  ADD UNIQUE KEY `suid_2` (`suid`,`lid`);

--
-- 資料表索引 `orderlist_detail`
--
ALTER TABLE `orderlist_detail`
  ADD UNIQUE KEY `odid` (`odid`,`lid`,`gid`);

--
-- 資料表索引 `saccount_group`
--
ALTER TABLE `saccount_group`
  ADD PRIMARY KEY (`gpid`),
  ADD UNIQUE KEY `title` (`title`);

--
-- 資料表索引 `student_account`
--
ALTER TABLE `student_account`
  ADD PRIMARY KEY (`suid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `gpid` (`gpid`),
  ADD KEY `username_2` (`username`),
  ADD KEY `suid` (`suid`);

--
-- 資料表索引 `syslog`
--
ALTER TABLE `syslog`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `system`
--
ALTER TABLE `system`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `index` (`id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `account`
--
ALTER TABLE `account`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `goodlist`
--
ALTER TABLE `goodlist`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `image`
--
ALTER TABLE `image`
  MODIFY `imgid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `odid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `saccount_group`
--
ALTER TABLE `saccount_group`
  MODIFY `gpid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `student_account`
--
ALTER TABLE `student_account`
  MODIFY `suid` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `syslog`
--
ALTER TABLE `syslog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `goodlist`
--
ALTER TABLE `goodlist`
  ADD CONSTRAINT `goodlist_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `account` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `goodlist_accountgroup`
--
ALTER TABLE `goodlist_accountgroup`
  ADD CONSTRAINT `goodlist_accountgroup_ibfk_1` FOREIGN KEY (`lid`) REFERENCES `goodlist` (`lid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goodlist_accountgroup_ibfk_2` FOREIGN KEY (`gpid`) REFERENCES `saccount_group` (`gpid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `goodlist_goodstable`
--
ALTER TABLE `goodlist_goodstable`
  ADD CONSTRAINT `goodlist_goodstable_ibfk_1` FOREIGN KEY (`lid`) REFERENCES `goodlist` (`lid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goodlist_goodstable_ibfk_2` FOREIGN KEY (`gid`) REFERENCES `goods` (`gid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `goods`
--
ALTER TABLE `goods`
  ADD CONSTRAINT `goods_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `account` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `goods_image`
--
ALTER TABLE `goods_image`
  ADD CONSTRAINT `goods_image_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `goods` (`gid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goods_image_ibfk_2` FOREIGN KEY (`imgid`) REFERENCES `image` (`imgid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `orderlist_detail`
--
ALTER TABLE `orderlist_detail`
  ADD CONSTRAINT `orderlist_detail_ibfk_1` FOREIGN KEY (`odid`) REFERENCES `orderlist` (`odid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `student_account`
--
ALTER TABLE `student_account`
  ADD CONSTRAINT `student_account_ibfk_1` FOREIGN KEY (`gpid`) REFERENCES `saccount_group` (`gpid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
