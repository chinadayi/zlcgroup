DROP TABLE IF EXISTS `retengcms_keywords`;
CREATE TABLE `retengcms_keywords` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(30) NOT NULL,
  `weight` smallint(4) NOT NULL DEFAULT '0',
  `counts` mediumint(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`keywords`,`weight`,`counts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
