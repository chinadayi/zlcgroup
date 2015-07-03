DROP TABLE IF EXISTS `retengcms_form`;
CREATE TABLE `retengcms_form` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `table` varchar(30) NOT NULL,
  `siteid` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_form_fields`;
CREATE TABLE `retengcms_form_fields` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `form` varchar(80) NOT NULL,
  `formid` int(6) NOT NULL,
  `name` varchar(64) NOT NULL,
  `enname` varchar(32) NOT NULL,
  `tips` varchar(80) NOT NULL,
  `unit` varchar(32) NOT NULL,
  `options` text NOT NULL,
  `default` varchar(255) NOT NULL,
  `regex` varchar(80) NOT NULL,
  `css` varchar(32) NOT NULL,
  `length` varchar(8) NOT NULL,
  `orderby` int(6) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `cantdelete` tinyint(1) NOT NULL DEFAULT '0',
  `adminonly` tinyint(1) NOT NULL DEFAULT '0',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `formid` (`formid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;