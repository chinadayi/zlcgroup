DROP TABLE IF EXISTS `retengcms_link`;
CREATE TABLE `retengcms_link` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` smallint(4) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL,
  `logo` varchar(100) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL,
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `addtime` char(10) NOT NULL,
  `isindex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `orderby` smallint(5) NOT NULL DEFAULT '0',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`typeid`),
  KEY `typeid` (`typeid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_link` VALUES('1','1','热腾网','http://www.reteng.org','','','','0','1357653685','1','1','1');
REPLACE INTO `retengcms_link` VALUES('2','1','热腾论坛','http://bbs.reteng.org','','','','0','1357653699','1','2','1');
REPLACE INTO `retengcms_link` VALUES('3','1','热腾DOC站','http://doc.reteng.org','','','','0','1385782921','1','3','1');
DROP TABLE IF EXISTS `retengcms_linktype`;
CREATE TABLE `retengcms_linktype` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `orderby` smallint(5) NOT NULL,
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `disabled` (`disabled`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_linktype` VALUES('1','友情连接','0','1','1');