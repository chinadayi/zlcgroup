DROP TABLE IF EXISTS `retengcms_ads`;
CREATE TABLE `retengcms_ads` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT 'name',
  `introduce` varchar(255) DEFAULT NULL,
  `adsposid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL,
  `linkurl` varchar(100) NOT NULL DEFAULT 'http://',
  `imageurl` varchar(100) NOT NULL DEFAULT 'http://',
  `alt` varchar(80) NOT NULL DEFAULT 'http://www.reteng.org',
  `flashurl` varchar(100) NOT NULL DEFAULT 'http://',
  `wmode` varchar(20) DEFAULT NULL,
  `text` text,
  `text_link` varchar(100) NOT NULL DEFAULT 'http://',
  `code` text,
  `fromdate` varchar(20) NOT NULL DEFAULT '0',
  `todate` varchar(20) NOT NULL DEFAULT '0',
  `addtime` varchar(20) NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `clicks` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ispassed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fromdate` (`fromdate`,`todate`),
  KEY `adsposid` (`adsposid`,`ispassed`,`fromdate`,`todate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_adspos`;
CREATE TABLE `retengcms_adspos` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `template` char(30) NOT NULL DEFAULT '0',
  `introduce` char(100) DEFAULT NULL,
  `price` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `width` smallint(4) unsigned NOT NULL DEFAULT '0',
  `number` tinyint(2) NOT NULL DEFAULT '0',
  `height` smallint(4) unsigned NOT NULL DEFAULT '0',
  `ispassed` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `option` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
