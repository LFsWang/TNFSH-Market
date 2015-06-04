-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2015-06-04 04:04:35
-- 伺服器版本: 5.6.24
-- PHP 版本： 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
  `stats` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `account`
--

INSERT INTO `account` (`uid`, `username`, `password`, `stats`) VALUES
(1, 'admin', '$2y$10$xfd7IERfvsxIxi4bwJRCUOQi7DjA9Bw/v3mftyfIcnis2bpG9nrje', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `goodlist`
--

INSERT INTO `goodlist` (`lid`, `owner`, `name`, `starttime`, `endtime`, `description`, `status`) VALUES
(1, 1, 'test', '2015-05-09', '2015-05-15', '<p>xsa</p>', 1),
(2, 1, 'test2', '2015-06-04', '2015-06-19', '<p>s</p>', 1),
(3, 1, 'test3', '2015-06-04', '2015-06-04', '', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `goodlist_goodstable`
--

CREATE TABLE IF NOT EXISTS `goodlist_goodstable` (
  `lid` int(11) NOT NULL,
  `gid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `goodlist_goodstable`
--

INSERT INTO `goodlist_goodstable` (`lid`, `gid`) VALUES
(3, 2),
(3, 3),
(3, 6);

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
  `image` text COLLATE utf8_bin,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `goods`
--

INSERT INTO `goods` (`gid`, `owner`, `name`, `type`, `price`, `defaultnum`, `maxnum`, `description`, `image`, `status`) VALUES
(1, 1, 'å†¬å­£åˆ¶æœss', 'colthe', 300, 15, 15, '<div class="h4 item-title">[è¨“è‚²çµ„] å…¬å‘Šæœ¬æ ¡104å­¸å¹´åº¦æ–°ç”Ÿå§‹æ¥­è¼”å°Žæ™‚é–“ï¼Œå§‹æ¥­è¼”å°ŽæœŸé–“è«‹ç©¿è‘—åœ‹ä¸­é‹å‹•æœåƒåŠ ï¼</div>\r\n<ul>\r\n<li>æ­¡è¿Žå„ä½ä¸€ä¸­æ–°é®®äººï¼104å­¸å¹´åº¦æ–°ç”Ÿå§‹æ¥­è¼”å°Žæ™‚é–“ç‚º104å¹´8æœˆ24æ—¥è‡³25æ—¥ã€‚</li>\r\n<li>æ–°ç”Ÿå§‹æ¥­è¼”å°Žæ™‚ï¼Œè«‹ç©¿è‘—ã€åœ‹ä¸­é‹å‹•æœã€‘åƒåŠ ï¼</li>\r\n<li>æœ¬æ ¡åˆ»æ­£æ“¬è¨‚æ–°ç”Ÿå§‹æ¥­è¼”å°Žä½œæ¯æµç¨‹ï¼Œè«‹å¯†åˆ‡æ³¨æ„æ–°ç”Ÿå°ˆå€ï¼</li>\r\n</ul>', 'a:12:{i:0;i:20;i:1;i:12;i:2;i:13;i:3;i:14;i:4;i:15;i:5;i:16;i:6;i:17;i:7;i:18;i:8;i:19;i:9;i:9;i:10;i:10;i:11;i:11;}', 0),
(2, 1, 'å¤å­£åˆ¶æœ', 'normal', 25, 1, 10, '', '', 1),
(3, 1, 'é¢¨æ™¯ç•«', 'normal', 888, 3, 10, '', '', 1),
(4, 1, '26+5', 'colthe', 250, 2, 4, '<p>m<strong>kl</strong></p>', '', 1),
(5, 1, 'èŠ±æœµ', 'normal', 165, 165, 10, '', '', 0),
(6, 1, 'test1', 'normal', 1000, 1, 10, '', '', 0),
(8, 1, 'å†¬å­£åˆ¶æœs', 'colthe', 300, 0, 15, '', 'a:3:{i:0;i:21;i:1;i:22;i:2;i:23;}', 0),
(9, 1, 'Shaymin', 'normal', 198, 15, 156, '', 'a:7:{i:0;i:7;i:1;i:8;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;}', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `image`
--

INSERT INTO `image` (`imgid`, `owner`, `timestamp`, `realname`, `hashname`, `title`, `description`) VALUES
(1, 1, '2015-05-25 01:09:10', '', '4b18da2b62c46655ea6a519da46e8bad.png', '', ''),
(2, 1, '2015-05-25 01:20:11', '', '1c08fb35d10d494ab333552d3eb13947.png', '', ''),
(3, 1, '2015-05-25 01:20:11', '', 'f3915884d67efc619be56db1d240efd8.png', '', ''),
(4, 1, '2015-05-25 01:20:11', '', '236c3f64ff0646bb290ffae28de1b002.jpg', 'LALALAL', 'LALALAL'),
(5, 1, '2015-05-25 01:20:11', '', '6c0e3303dc7b902aaa21947bd377806c.jpg', '', ''),
(6, 1, '2015-05-25 01:20:11', '', '7d171b10d87c65e01255b427f83e589f.jpg', '', ''),
(7, 1, '2015-05-25 01:22:08', '', '914ec8a2ee7717d8a1b7259bf1366180.jpg', '', ''),
(8, 1, '2015-05-25 01:22:08', '', '55e6c5a32002ea4940c84abdd3cab278.jpg', '', ''),
(9, 1, '2015-05-25 02:14:49', '', 'b68308d64dc68c70432886dd3ed9d7ff.jpg', '', ''),
(10, 1, '2015-05-25 02:14:49', '', 'dc74fc74e65b3a2879512e5d42810dbe.jpg', '', ''),
(11, 1, '2015-05-25 02:14:49', '', 'e5448449e5e1b0b0fddc55589228a334.jpg', '', ''),
(12, 1, '2015-05-25 02:18:21', '', 'e7021575eb8f9271dee1cf3ef571ad6b.jpg', '', ''),
(13, 1, '2015-05-25 02:18:21', '', '57b03b9ce1ccdf8e3560a53cb4265e7a.png', '', ''),
(14, 1, '2015-05-25 02:18:21', '', '5344a16ea49a9b7f3d599b747aaaf935.png', '', ''),
(15, 1, '2015-05-25 02:18:21', '', '980bcff3d975cdc38777bf3c1179a80c.png', '', ''),
(16, 1, '2015-05-25 02:18:21', '', '95b17fc6b0ad271b7f18ef8ea280bbc4.png', '', ''),
(17, 1, '2015-05-25 02:18:22', '', '46dfb351a7f5de9a002c008986eff925.jpg', '', ''),
(18, 1, '2015-05-25 02:18:22', '', '728bb71e568aafd9fd3f1fdf56c05cdf.png', '', ''),
(19, 1, '2015-05-25 02:18:22', '', 'd03b1b308799b6653873c039ca3c06c0.png', '', ''),
(20, 1, '2015-05-25 07:58:29', '', '092224a5b492cf8d43cb9a67a01114b3.jpg', '', ''),
(21, 1, '2015-05-26 02:25:43', '49584740_p1_master1200.jpg', 'b598c6dec87d0ee78632bae3504de492.jpg', '', '49584740_p1_master1200.jpg'),
(22, 1, '2015-05-26 02:25:43', '49584740_p3_master1200.jpg', 'fd230e96ed1a79eea3f54f3dfff54a8e.jpg', '', '49584740_p3_master1200.jpg'),
(23, 1, '2015-05-26 02:25:43', '49584740_p5_master1200.jpg', 'af2f68619d6604ae140005a28fa7ed9a.jpg', '', '49584740_p5_master1200.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `student_account`
--

CREATE TABLE IF NOT EXISTS `student_account` (
  `uid` int(11) NOT NULL,
  `username` char(80) COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL,
  `account_group` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `student_account`
--

INSERT INTO `student_account` (`uid`, `username`, `password`, `account_group`) VALUES
(1, '00000', '$2y$10$xfd7IERfvsxIxi4bwJRCUOQi7DjA9Bw/v3mftyfIcnis2bpG9nrje', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `syslog`
--

CREATE TABLE IF NOT EXISTS `syslog` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `namespace` varchar(60) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `syslog`
--

INSERT INTO `syslog` (`id`, `timestamp`, `namespace`, `description`) VALUES
(1, '2015-05-25 06:37:21', 'SQL execute', 'Unknown column ''owner'' in ''where clause'''),
(2, '2015-06-04 01:33:03', 'SQL execute', 'Unknown column ''goods'' in ''field list'''),
(3, '2015-06-04 01:35:34', 'SQL execute', 'Column ''owner'' cannot be null'),
(4, '2015-06-04 01:36:26', 'SQL execute', 'Column ''owner'' cannot be null');

-- --------------------------------------------------------

--
-- 資料表結構 `system`
--

CREATE TABLE IF NOT EXISTS `system` (
  `id` char(60) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 資料表的匯出資料 `system`
--

INSERT INTO `system` (`id`, `value`) VALUES
('system_announcement', '<ul>\r\n<li>\r\n<div>\r\n<div>æœ¬æ ¡åé¡2å,è«‹æ–¼5æœˆ11æ—¥ä¸­åˆå‰å°‡å ±åè³‡æ–™äº¤è‡³è¨“è‚²çµ„,</div>\r\n<div>æ´»å‹•æ™‚é–“:7æœˆ4æ—¥~7æœˆ9æ—¥.</div>\r\n<div>èª²ç¨‹å…§å®¹è«‹åƒé–±é™„ä»¶</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>æ•™è‚²éƒ¨é«˜ç´šä¸­ç­‰å­¸æ ¡å­¸ç”Ÿæ–°ä¸–ç´€é ˜å°Žäººæ‰åŸ¹è‚²è¨ˆç•«</div>\r\n<div>101 å¹´ 7 æœˆ 5 æ—¥æ•™ä¸­ï¼ˆå››ï¼‰å­—ç¬¬ 1010577537 è™Ÿæ›¸å‡½ä¿®æ­£é ’å¸ƒ</div>\r\n<div>&nbsp;</div>\r\n<div>104 å¹´ 3 æœˆ 25 æ—¥è‡ºæ•™åœ‹ç½²å­¸å­—ç¬¬ 1040029735 è™Ÿæ›¸å‡½ä¿®æ­£é ’å¸ƒ</div>\r\n<div>å£¹ã€ç›®æ¨™</div>\r\n<div>ä¸€ã€ æä¾›å¤šå…ƒå­¸ç¿’æ©Ÿæœƒï¼Œé€éŽèª²ç¨‹ç ”ç¿’ï¼Œä½¿å­¸ç”Ÿåœ¨å…¨äººåŒ–çš„æ•™è‚²ç†å¿µä¸­ç²å¾—å……åˆ†ç™¼å±•ï¼Œä»¥ åŸ¹é¤Šç©æ¥µé€²å–çš„äººç”Ÿæ…‹åº¦èˆ‡çµ‚èº«å­¸ç¿’çš„ç¿’æ…£ã€‚</div>\r\n<div>äºŒã€ åŸ¹é¤Šå­¸ç”Ÿåˆ†äº«ã€äº’åŠ©ã€åˆ©ä»–çš„è§€å¿µï¼Œæ“´å¤§å…¶å­¸ç¿’è¦–é‡Žï¼Œä»¥åŸ¹è‚²å…·å‚™å®è§€é¡˜æ™¯ä¹‹æ–°ä¸–ç´€ é’å¹´ã€‚</div>\r\n<div>ä¸‰ã€ å¼·åŒ–å­¸ç”Ÿé ˜å°ŽçŸ¥èƒ½è¨“ç·´ï¼Œä»¥å”åŠ©å­¸æ ¡å­¸ç”Ÿäº‹å‹™ä¹‹æŽ¨å±•ï¼Œä¸¦åŸ¹è‚²é’å¹´é ˜å°Žäººæ‰åŠå»ºç«‹äºº æ‰è³‡æ–™åº«ã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>è²³ã€å¯¦æ–½ç­–ç•¥</div>\r\n<div>ä¸€ã€ è¾¦ç†ç¨®å­æ•™å¸«ç ”ç¿’ï¼Œå¼•å°Žå­¸æ ¡åŸ¹è‚²å­¸ç”Ÿå¤šå…ƒèƒ½åŠ›ã€‚ äºŒã€ å»ºç«‹å­¸ç¿’ç¸¾æ•ˆèªè­‰ï¼Œé‡è¦–è‡ªæˆ‘èƒ½åŠ›æª¢å®šåŠæå‡ã€‚</div>\r\n<div>ä¸‰ã€ è¾¦ç†å›žé¥‹å­¸å“¡ç ”ç¿’ï¼Œæä¾›è¾¦ç†å­¸æ ¡äººåŠ›è³‡æºï¼Œå»ºç«‹é«˜éšŽçµè¨“å­¸å“¡å›žé¥‹æœå‹™åˆ¶åº¦ï¼Œä½¿å…¶ è¿”å›žåˆ°ç‡ŸéšŠæœå‹™åŠæä¾›å¯¦(è¦‹)ç¿’æ©Ÿæœƒï¼Œä»¥å¯¦è­‰ç†è«–èˆ‡å¯¦å‹™ã€‚</div>\r\n<div>å››ã€ è¾¦ç†æœ¬è¨ˆç•«èªªæ˜Žæœƒï¼Œè«–è¿°è¨ˆç•«ç†å¿µç²¾ç¥žï¼Œå¸ç´å„æ ¡å„ªç§€äººæ‰åƒèˆ‡ã€‚ äº”ã€ æˆç«‹è¡Œå‹•ç ”ç©¶å°çµ„ï¼Œåˆ†çµ„ç ”æ“¬èª²ç¨‹æž¶æ§‹åŠç¸¾æ•ˆæŒ‡æ¨™ã€‚</div>\r\n<div>å…­ã€ çµåˆç¤¾æœƒè³‡æºç¶²è·¯ï¼Œæ“´å¤§å„æ ¡è¾¦ç†ã€‚</div>\r\n<div>ä¸ƒã€ æŽ¡è¿½è¹¤ä¿®è¨‚çš„æ–¹å¼é€²è¡Œç¸¾æ•ˆè©•ä¼°åŠå‹•æ…‹ä¿®æ­£ã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>å‚ã€çµ„ç¹”</div>\r\n<div>ä¸‹è¨­ä¸‰çµ„ï¼Œåˆ†åˆ¥ç‚ºèª²ç¨‹è¦åŠƒçµ„ã€è¡Œå‹•ç ”ç©¶çµ„åŠå­¸ç”Ÿé´é¸çµ„ï¼Œå”åŠ©è™•ç†ç›¸é—œäº‹å‹™ã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>è‚†ã€è¾¦ç†å–®ä½</div>\r\n<div>ä¸€ã€ ä¸»è¾¦å–®ä½ï¼šæ•™è‚²éƒ¨åœ‹æ°‘åŠå­¸å‰æ•™è‚²ç½²ï¼ˆä»¥ä¸‹ç°¡ç¨±æœ¬ç½²ï¼‰ äºŒã€ æ‰¿è¾¦å–®ä½ï¼šç”±è½„å±¬å­¸æ ¡è¾¦ç†</div>\r\n<div>ï¼ˆä¸€ï¼‰åˆéšŽï¼šåˆ†åŒ—ã€ä¸­ã€å—å„ä¸‰å€è¾¦ç†</div>\r\n<div>ï¼ˆäºŒï¼‰ä¸­éšŽï¼šåˆ†åŒ—ã€ä¸­ã€å—ä¸‰å€è¾¦ç†</div>\r\n<div>ï¼ˆä¸‰ï¼‰é«˜éšŽï¼šæ“‡ä¸€å€è¾¦ç†</div>\r\n<div>ï¼ˆå››ï¼‰å›žé¥‹å­¸å“¡ç ”ç¿’ï¼šé´é¸å­¸æ ¡è¾¦ç†</div>\r\n<div>ï¼ˆäº”ï¼‰åœ‹å¤–åƒè¨ªï¼šé´é¸å­¸æ ¡è¾¦ç†</div>\r\n<div>&nbsp;</div>\r\n<div>ä¼ã€åŸ¹è‚²å°è±¡ã€æ–¹å¼åŠæ™‚ç¨‹</div>\r\n<div>ä¸€ã€ å°è±¡ï¼šå…¨åœ‹é«˜ç´šä¸­ç­‰å­¸æ ¡å­¸ç”Ÿã€‚</div>\r\n<div>äºŒã€ æ–¹å¼ï¼šæŽ¡å–é€²éšŽæ–¹å¼åˆ†åˆéšŽã€ä¸­éšŽã€é«˜éšŽç­‰ä¸‰éšŽæ®µè¾¦ç†ï¼Œå…¶æ¯éšŽæ®µæ—¥æ•¸å‡ä»¥</div>\r\n<div>ï¼šæŽ¡å–é€²éšŽæ–¹å¼åˆ†åˆéšŽã€ä¸­éšŽã€é«˜éšŽç­‰ä¸‰éšŽæ®µè¾¦ç†ï¼Œå…¶æ¯éšŽæ®µæ—¥æ•¸å‡ä»¥ 6 å¤© 5</div>\r\n<div>å¤œç‚ºåŽŸå‰‡ã€‚</div>\r\n<div>ä¸‰ã€ æ™‚ç¨‹ï¼š</div>\r\n<div>(ä¸€)åˆéšŽï¼šé«˜ä¸€å‡é«˜äºŒå­¸ç”Ÿ(é«˜ä¸€æš‘å‡å¯¦æ–½)ã€‚</div>\r\n<div>(äºŒ)ä¸­éšŽï¼šå®ŒæˆåˆéšŽèª²ç¨‹ç ”ç¿’ä¹‹é«˜äºŒå­¸ç”Ÿ(é«˜äºŒå¯’å‡å¯¦æ–½)ã€‚ (ä¸‰)é«˜éšŽï¼šå®Œæˆä¸­éšŽèª²ç¨‹ç ”ç¿’ä¹‹é«˜äºŒå‡é«˜ä¸‰å­¸ç”Ÿ(é«˜äºŒæš‘å‡å¯¦æ–½)ã€‚ (å››)å›žé¥‹å­¸å“¡ç ”ç¿’ï¼šå®Œæˆé«˜éšŽèª²ç¨‹çµè¨“ä¹‹å­¸ç”Ÿ(é å®šæ¯å¹´ 5 æœˆåº•å‰å¯¦æ–½)ã€‚</div>\r\n<div>(äº”)åœ‹å¤–åƒè¨ªï¼šå®Œæˆé€²éšŽåˆ†äº«æœƒä¹‹ç•¶å±†ç•¢æ¥­å­¸ç”Ÿ(é å®šæ¯å¹´ 7 æœˆåº•å‰å¯¦æ–½)ã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>é™¸ã€åŸ¹è‚²äººæ•¸</div>\r\n<div>ä¸€ã€ åˆéšŽå…¨åœ‹è¨ˆåˆ† 9 å€ï¼Œåˆ†åŒ—ä¸€ã€åŒ—äºŒã€åŒ—ä¸‰ã€ä¸­ä¸€ã€ä¸­äºŒã€ä¸­ä¸‰ã€å—ä¸€ã€å—äºŒã€å—ä¸‰ç­‰ å€ï¼Œæ¯å€ 80 äººï¼Œåˆè¨ˆ 720 äººã€‚</div>\r\n<div>äºŒã€ ä¸­éšŽå°±å„åœ°å€ä¹‹æ­¸å±¬æ•´ä½µç‚ºåŒ—(åŽŸåŒ—ä¸€ã€åŒ—äºŒã€åŒ—ä¸‰å€)ã€ä¸­(åŽŸä¸­ä¸€ã€ä¸­äºŒã€ä¸­ä¸‰å€)ã€ å—(åŽŸå—ä¸€ã€å—äºŒã€å—ä¸‰å€)å…±ä¸‰å€èˆ‰è¡Œï¼Œæ¯å€ 80 äººï¼Œåˆè¨ˆ 240 äººã€‚</div>\r\n<div>ä¸‰ã€ é«˜éšŽå…¨åœ‹ä¸€å€ï¼Œå°±åŽŸä¸­éšŽ 240 äººä¾åœ°å€æ­¸å±¬å¹³å‡æ“‡å„ªé´é¸å…± 80 äººåƒåŠ ã€‚è‡³é«˜éšŽçµè¨“</div>\r\n<div>å¾Œåœ‹å¤–åƒè¨ªè¡Œç¨‹ï¼Œä»¥åŽŸé«˜éšŽ 80 äººä¸­é´å„ª 20 äººç‚ºåŽŸå‰‡ã€‚æœ¬è¨ˆç•«åŸ¹è‚²äººæ•¸å¦‚ä¸‹åœ–ç¤ºã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>æŸ’ã€é´é¸æ–¹å¼åŠåˆéšŽè³‡æ ¼</div>\r\n<div>ä¸€ã€ åˆéšŽç”±å­¸æ ¡æˆç«‹é´é¸å°çµ„ä¸¦èˆ‰è¡Œæ ¡å…§é´é¸èªªæ˜Žæœƒï¼Œä¾åˆéšŽè³‡æ ¼åƒè€ƒè¡¨(é™„ä»¶ 1)æ‰€ç¤ºè‡ª è¡Œè¨‚å®šé´é¸æ¢ä»¶ï¼Œé´é¸å…·æœ‰é ˜å°Žç‰¹è³ªåŠæ½›èƒ½ä¹‹å­¸ç”ŸåƒåŠ åŸ¹è‚²ç ”ç¿’ã€‚(æŽ¨è–¦è¡¨å¦‚é™„ä»¶ 2)ã€‚</div>\r\n<div>äºŒã€ ä¸­éšŽã€é«˜éšŽå­¸ç”Ÿä¹‹é´é¸ä»¥ç¶“ç¸¾æ•ˆèªè­‰åˆæ ¼ä¸¦è‡ªé¡˜ç”³è«‹åƒåŠ ç ”ç¿’ä¹‹å­¸ç”Ÿç‚ºé™ï¼Œç”±æœ¬ç½²å§” è«‹å­¸è€…å°ˆå®¶åŠç›¸é—œäººå“¡çµ„æˆå­¸ç”Ÿé´é¸çµ„ï¼Œä¾åˆã€ä¸­éšŽç ”ç¿’å­¸ç¿’æˆå°±æŒ‡æ¨™åŠç›¸é—œä½œæ¥­å®Œ&nbsp;</div>\r\n<div>æˆç¸¾æ•ˆæŒ‡æ¨™é´é¸ï¼ˆå­¸ç”Ÿç ”ç¿’æ™‚å…¬å‘Šç›¸é—œæŒ‡æ¨™ï¼‰ã€‚</div>\r\n<div>ä¸‰ã€ é«˜éšŽçµè¨“å­¸å“¡å¾—åƒèˆ‡å›žé¥‹å­¸å“¡ç ”ç¿’ã€‚</div>\r\n<div>å››ã€ åœ‹å¤–åƒè¨ªå­¸å“¡é´é¸ï¼Œç”±æœ¬ç½²å§”è«‹æ‰¿è¾¦å­¸æ ¡çµ„æˆé´é¸å°çµ„æŽ¡ç­†è©¦åŠå£è©¦ç­‰å¤šå…ƒæ–¹å¼é´å„ªç”¢ç”Ÿã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>æŒã€èª²ç¨‹é ˜åŸŸç¶±è¦ ä¸€ã€åˆéšŽã€ä¸­éšŽã€é«˜éšŽç­‰ä¸‰éšŽæ®µèª²ç¨‹ä»¥ç™¼å±•æ€§åŠèžºæ—‹æ€§è§€é»žè¦–ç ”ç¿’éŽç¨‹åŠå…¶ç¸¾æ•ˆï¼Œéš¨æ™‚ä¿®</div>\r\n<div>è¨‚ï¼Œå…¶èª²ç¨‹ç¾¤çµ„ä¾å…±åŒæ ¸å¿ƒèª²ç¨‹è¦åŠƒï¼Œé‡é»žå¦‚ä¸‹ï¼š ç¾¤çµ„ä¸€ï¼šè®Šé·èˆ‡å­¸ç¿’ï¼Œç¾¤çµ„ä¹‹å…§æ¶µèˆ‡é‡é»žç‚ºï¼šäººç”Ÿå“²å­¸ã€ç¶“æ¿Ÿèˆ‡ç¤¾æœƒå•é¡Œåˆ†æžåŠå¤šå…ƒ</div>\r\n<div>æ–‡åŒ–ç†è§£èˆ‡æŽ¢ç´¢ã€‚ ç¾¤çµ„äºŒï¼šé ˜å°Žç‰¹è³ªèˆ‡èƒ½åŠ›ï¼Œç¾¤çµ„ä¹‹å…§æ¶µèˆ‡é‡é»žç‚ºï¼šå•é¡Œè§£æ±ºèˆ‡æŽ¢ç©¶ã€è‡ªæˆ‘æŽ¢ç´¢èˆ‡äººéš›</div>\r\n<div>æºé€šã€é ˜å°Žå“²å­¸åŠåœ‹éš›éžç‡Ÿåˆ©åŠéžæ”¿åºœçµ„ç¹”ã€‚ ç¾¤çµ„ä¸‰ï¼šç§‘æŠ€èˆ‡æ–‡åŒ–ï¼Œç¾¤çµ„ä¹‹å…§æ¶µèˆ‡é‡é»žç‚ºï¼šå¿ƒç†èˆ‡äººç”Ÿã€ç¤¾æœƒé—œæ‡·èˆ‡æœå‹™åŠåœ‹éš›é‡</div>\r\n<div>å¤§è­°é¡Œ(å«ç¦®å„€)ã€‚ äºŒã€æ‰¿è¾¦å­¸æ ¡å¾—ä¾å„æ ¡ç‰¹è‰²è¦åŠƒå½ˆæ€§èª²ç¨‹ã€‚</div>\r\n<div>ä¸‰ã€æ‰¿è¾¦å­¸æ ¡è¦åŠƒä¹‹èª²ç¨‹æ‡‰ç¶“èª²ç¨‹è¦åŠƒçµ„å¯©æ ¸å¾Œå¯¦æ–½ã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>çŽ–ã€é…åˆäº‹é …</div>\r\n<div>ä¸€ã€ å……åˆ†åˆ©ç”¨ç¤¾æœƒè³‡æºåŠç¾æœ‰è»Ÿç¡¬é«”è¨­æ–½ï¼Œä¸¦çµåˆç›¸é—œå°ˆæ¥­ä¼æ¥­ã€å‚‘å‡ºæ ¡å‹ã€å‚‘å‡ºçµè¨“å­¸ å“¡åœ˜é«”å…±åŒè¾¦ç†ã€‚</div>\r\n<div>äºŒã€ èª²ç¨‹è¦åŠƒé‡è¦–å­¸å“¡è‡ªæˆ‘ç®¡ç†èƒ½åŠ›ã€å‰µæ–°è¦åŠƒã€é ˜å°Žæºé€šã€ç¶“é©—åˆ†äº«åŠå£“åŠ›èª¿é©ç­‰å¤šå…ƒ èƒ½åŠ›ä¹‹å»ºæ§‹ã€‚</div>\r\n<div>ä¸‰ã€ å„éšŽèª²ç¨‹æ‡‰å…¼é¡§æ€§åˆ¥å¹³ç­‰æ•™è‚²ä¹‹ç²¾ç¥žï¼Œä¸¦é©æ™‚èžå…¥ç”Ÿå‘½æ•™è‚²ã€æ³•æ²»æ•™è‚²ã€äººæ¬Šæ•™è‚²ã€ ç’°ä¿æ•™è‚²å¯¦è¸ä¸¦çµåˆé«”é©èƒ½ã€å¥åº·ä¿ƒé€²ç­‰æ´»å‹•ã€‚</div>\r\n<div>å››ã€ é´é¸æ•™å¸«åƒåŠ ç¨®å­æ•™å¸«ç ”ç¿’ï¼Œæ‡‰è¦–å…¶æ„é¡˜åŠç†±å¿±ï¼Œä¸¦å…·æœ‰ç©æ¥µå®è§€è¦–é‡Žã€å¤šå…ƒå°ˆæ¥­èƒ½ åŠ›ã€æºé€šå”èª¿ã€çµ±æ•´ç­‰ç‰¹è³ªï¼Œä¸¦ä¾æœå‹™ç¸¾æ•ˆè¡¨ç¾åŠåƒèˆ‡å¹´è³‡ç­‰ç¶œåˆè€ƒé‡ï¼Œé€æ­¥å»ºç«‹å…· å¸«å¾’ç²¾ç¥žä¹‹è¼”å°Žè€å¸«è³‡æ­·åˆ¶ã€‚</div>\r\n<div>äº”ã€ é´é¸å›žé¥‹å­¸å“¡åƒåŠ è¿”ç‡Ÿæœå‹™ï¼Œé ˆè¦–å­¸å“¡ç†±å¿±ã€ç©æ¥µåº¦ã€å¤šå…ƒå°ˆæ¥­åº¦ç­‰ï¼Œåšå¯¦éš›è¿”ç‡Ÿä¾ æ“šï¼Œä¸”è¿”ç‡Ÿæœå‹™å­¸å“¡çš†é ˆåƒèˆ‡ç•¶å¹´åº¦å›žé¥‹å­¸å“¡ç ”ç¿’ã€‚</div>\r\n<div>å…­ã€ æ‰¿è¾¦å­¸æ ¡å°±å„éšŽæ´»å‹•æˆæžœåŠä½œæ¥­ç­‰å¤šå…ƒè¡¨ç¾æ‡‰é´å„ªé›†çµæˆå†Šï¼Œä»¥è¡ŒéŠ·æŽ¨å»£æœ¬è¨ˆç•«ä¹‹åŸ· è¡Œæˆæžœã€‚</div>\r\n<div>ä¸ƒã€ è¼”å°Žè€å¸«æ‡‰å…¨ç¨‹åƒåŠ è¡Œå‰ç ”ç¿’ã€‚</div>\r\n<div>å…«ã€ çµ„å°ˆæ¡ˆå°çµ„éŒ„è£½å„éšŽç ”ç¿’éŽç¨‹ï¼Œå¯©æŸ¥é€šéŽå¾Œè£½æˆå…‰ç¢Ÿä¾›å„æ ¡åƒè€ƒã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>æ‹¾ã€è¼”å°Žèˆ‡é‹ç”¨</div>\r\n<div>ä¸€ã€ å„æ ¡å°ç ”ç¿’çµæ¥­ä¹‹å­¸ç”Ÿï¼Œæ‡‰æä¾›å¯¦ç¿’åŠæœå‹™ä¹‹æ©Ÿæœƒã€‚</div>\r\n<div>äºŒã€ å°å„çµæ¥­å­¸å“¡çš„å­¸æ ¡ï¼Œè«‹æ±‚å°‡è©²å­¸å“¡ä¹‹åäººè¨ªè«‡ç´€éŒ„åŠå¿ƒå¾—ï¼ŒåˆŠç™»è‡³å°ˆåˆŠæˆ–å°ˆå±¬ç¶²ç«™ ä¸­ï¼Œè—‰ä»¥æé«˜å­¸å“¡è¡¨ç¾ç¸¾æ•ˆï¼Œå¸å¼•æ›´å¤šå„ªç§€å­¸ç”ŸåƒåŠ æœ¬è¨ˆç•«ã€‚</div>\r\n<div>ä¸‰ã€ å„è¾¦ç†å–®ä½æ‡‰å»ºç«‹å„ªç§€é’å¹´é ˜å°Žäººæ‰å„²è¨“åŠé‹ç”¨ä¹‹æ©Ÿåˆ¶ï¼ˆå¦‚å¿—å·¥åœ˜ ã€æœå‹™æ€§ç¤¾åœ˜æˆ– äººæ‰åº«&hellip;ç­‰ï¼‰æä¾›å„éšŽæ®µé ˜å°Žäººæ‰å¯¦ç¿’ã€å‰µä½œã€æœå‹™åŠæ´»å‹•ä¹‹æ©Ÿæœƒï¼Œä»¥åŸ¹é¤Šå­¸ç”Ÿé€²éšŽ èƒ½åŠ›ã€‚</div>\r\n<div>å››ã€ é«˜éšŽçµè¨“å­¸å“¡è¿”ç‡Ÿå›žé¥‹ç ”ç¿’æœƒæ¦‚åˆ†äºŒéšŽæ®µè¾¦ç†ï¼Œç¬¬ä¸€éšŽæ®µ(ä¸ŠåŠæ—¥)ç”±æ‰¿è¾¦å­¸æ ¡çµ±ç±Œè¦ åŠƒï¼Œç¬¬äºŒéšŽæ®µ(ä¸‹åŠæ—¥)å¾—é‚€æ­·å±†é«˜éšŽçµè¨“å›žé¥‹å­¸å“¡ä»£è¡¨æ“¬å®šä¸¦é…åˆå¯¦æ–½ã€‚</div>\r\n<div>äº”ã€ å§”è¨—ç ”ç©¶å–®ä½æˆ–å­¸æ ¡é€²è¡Œæœ¬è¨ˆç•«èª²ç¨‹ã€è¼”å°Žç­‰åŸ·è¡Œç¸¾æ•ˆç›¸é—œè­°é¡Œä¹‹å°ˆæ¡ˆç ”ç©¶åŠç¶²ç«™å»º ç½®ï¼Œä¸¦è¯ç¹«è¿½è¹¤å­¸å“¡å­¸ç¿’è¡¨ç¾ï¼Œä»¥å»ºç«‹å…¶å­¸ç¿’è¡¨ç¾è³‡æ–™åº«ã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>æ‹¾å£¹ã€ç¸¾æ•ˆè©•ä¼°ï¼šç”±æœ¬ç½²å§”ç”±è¡Œå‹•ç ”ç©¶çµ„æˆå“¡ï¼Œè©•ä¼°å¯¦æ–½æˆæ•ˆï¼Œä¸¦æå‡ºæ”¹é€²æŽªæ–½ã€‚ æ‹¾è²³ã€ç¶“è²»ï¼šè¾¦ç†æœ¬è¨ˆç•«æ‰€éœ€å„é …ç¶“è²»ï¼Œç”±æœ¬ç½²å°ˆæ¡ˆè£œåŠ©ã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>æ‹¾å‚ã€çŽå‹µ</div>\r\n<div>ä¸€ã€ ç¶“æœ¬è¨ˆç•«åŸ¹è‚²é‹ç”¨ä¹‹å„éšŽæ®µé’å¹´é ˜å°Žäººæ‰ï¼Œå„å­¸æ ¡è¦–å…¶ç¸¾æ•ˆäºˆä»¥çŽå‹µã€‚</div>\r\n<div>äºŒã€ æ‰¿è¾¦å„éšŽèª²ç¨‹ä¹‹å­¸æ ¡ï¼Œé™¤æ ¡é•·ç”±æœ¬ç½²å¦æ¡ˆç°½è«‹æ•˜çŽå¤–ï¼Œå…¶ä»–æ ¡å…§ç›¸é—œå·¥ä½œäººå“¡ï¼Œä¾ç›¸ é—œè¦å®šå¾žå„ªæ•˜çŽã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>æ‹¾åƒã€æœ¬è¨ˆç•«ç¶“æ ¸å®šå¾Œæ–½è¡Œï¼Œä¿®æ­£æ™‚äº¦åŒã€‚</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n</div>\r\n<p>ps.1.æœ‰èˆˆè¶£åƒåŠ çš„åŒå­¸å¯å°‡å ±åè¡¨ç¹³äº¤è‡³è¨“è‚²çµ„. 2.å—å€åç¢ºçš„æ™‚ç¨‹å°šæœªæŽ¥ç²,åŒå­¸å€‘å¯ä»¥å…ˆå°‡å ±åç›¸é—œè³‡æ–™å…ˆè¡Œæº–å‚™.å±†æ™‚æœƒå†é€šçŸ¥.</p>\r\n</li>\r\n</ul>');

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
-- 資料表索引 `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`imgid`);

--
-- 資料表索引 `student_account`
--
ALTER TABLE `student_account`
  ADD PRIMARY KEY (`uid`);

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
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `goodlist`
--
ALTER TABLE `goodlist`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- 使用資料表 AUTO_INCREMENT `image`
--
ALTER TABLE `image`
  MODIFY `imgid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- 使用資料表 AUTO_INCREMENT `student_account`
--
ALTER TABLE `student_account`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `syslog`
--
ALTER TABLE `syslog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `goodlist`
--
ALTER TABLE `goodlist`
  ADD CONSTRAINT `goodlist_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `account` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
