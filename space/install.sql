DROP TABLE IF EXISTS `retengcms_space`;
CREATE TABLE `retengcms_space` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL,
  `logo` varchar(100) NOT NULL,
  `banner` varchar(100) NOT NULL,
  `name` varchar(80) NOT NULL,
  `meta_keywords` varchar(100) NOT NULL,
  `meta_description` varchar(250) NOT NULL,
  `template` varchar(40) NOT NULL,
  `opentime` varchar(10) NOT NULL,
  `lock` tinyint(1) NOT NULL DEFAULT '0',
  `syslock` tinyint(1) NOT NULL DEFAULT '0',
  `index` tinyint(1) NOT NULL DEFAULT '0',
  `visits` mediumint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`lock`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_space_comment`;
CREATE TABLE `retengcms_space_comment` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL,
  `guestid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `guestname` varchar(20) NOT NULL,
  `guestface` varchar(100) NOT NULL DEFAULT 'space/images/nophoto.gif',
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`status`,`id`),
  KEY `ip` (`ip`,`status`,`id`),
  KEY `status` (`status`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_space_newvisitor`;
CREATE TABLE `retengcms_space_newvisitor` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) NOT NULL,
  `spaceid` mediumint(8) NOT NULL,
  `spacename` varchar(80) NOT NULL,
  `spacelogo` varchar(200) NOT NULL,
  `visittime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `spaceid` (`spaceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_space_friends`;
CREATE TABLE `retengcms_space_friends` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) NOT NULL,
  `spaceid` mediumint(8) NOT NULL,
  `spacename` varchar(80) NOT NULL,
  `spacelogo` varchar(200) NOT NULL,
  `addtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;