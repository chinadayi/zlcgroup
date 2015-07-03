DROP TABLE IF EXISTS `retengcms_vote`;
CREATE TABLE `retengcms_vote` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `votename` varchar(50) NOT NULL DEFAULT '',
  `starttime` char(10) NOT NULL,
  `endtime` char(10) NOT NULL,
  `delay` mediumint(8) NOT NULL DEFAULT '0',
  `totalcount` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ismore` tinyint(1) NOT NULL DEFAULT '0',
  `votenote` text,
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_vote` VALUES('1','您觉得ReTengCMS对你有什么帮助？','1357574400','1375804800','24','0','1','<vote id=\"1\" count=\"0\">界面做的还不错 </vote>\n<vote id=\"2\" count=\"0\">功能基本满足我的需求 </vote>\n<vote id=\"3\" count=\"0\">让企业建站更简单</vote>\n<vote id=\"4\" count=\"0\">对我没啥帮助</vote>\n','1');
DROP TABLE IF EXISTS `retengcms_vote_ip`;
CREATE TABLE `retengcms_vote_ip` (
  `voteid` mediumint(8) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `votetime` varchar(10) NOT NULL,
  KEY `voteid` (`voteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;