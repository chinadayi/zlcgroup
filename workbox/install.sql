DROP TABLE IF EXISTS `retengcms_workbox`;
CREATE TABLE `retengcms_workbox` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `inlink` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_tools`;
CREATE TABLE `retengcms_tools` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `boxid` mediumint(8) NOT NULL,
  `name` varchar(100) NOT NULL,
  `style` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `orderby` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `boxid` (`boxid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;