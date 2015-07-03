DROP TABLE IF EXISTS `retengcms_pay_method`;
CREATE TABLE `retengcms_pay_method` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `desc` text NOT NULL,
  `fee` varchar(10) NOT NULL,
  `config` text NOT NULL,
  `is_cod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_online` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `orderby` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `author` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `version` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_pay_method` VALUES('1','alipay','支付宝','支付宝网站(www.alipay.com) 是国内先进的网上支付平台。\r\nReTengCMS联合支付宝推出支付宝接口。','0','array (\n  \'alipay_account\' => \'master@reteng.org\',\n  \'alipay_key\' => \'\',\n  \'alipay_partner\' => \'\',\n  \'service_type\' => \'0\',\n)','0','1','0','1','DayuCMS','http://www.alipay.com','1.0.0');
REPLACE INTO `retengcms_pay_method` VALUES('2','post','邮局汇款','收款人信息：姓名 ××× ；地址 ××× ；邮编 ××× 。\r\n注意事项： 请在汇款单背面的附言中注明您的订单号，只填写后6位即可。','0','array (\n)','0','0','0','1','DayuCMS','','1.0.0');
REPLACE INTO `retengcms_pay_method` VALUES('3','bank','银行汇款/转帐','银行名称\r\n收款人信息：全称 ××× ；帐号或地址 ××× ；开户行 ×××。\r\n注意事项：办理电汇时，请在电汇单“汇款用途”一栏处注明您的订单号。','0','array (\n)','0','0','0','1','DayuCMS','','1.0.0');
DROP TABLE IF EXISTS `retengcms_pay_card`;
CREATE TABLE `retengcms_pay_card` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `cardid` varchar(32) NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(30) NOT NULL DEFAULT 'anonymity',
  `typeid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `inputerid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `inputer` char(30) NOT NULL DEFAULT 'anonymity',
  `expire` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '0.0.0.0',
  `price` varchar(5) NOT NULL DEFAULT '0',
  `amount` varchar(5) NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cardid` (`cardid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_pay_cardtype`;
CREATE TABLE `retengcms_pay_cardtype` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `amount` varchar(5) NOT NULL DEFAULT '0',
  `price` varchar(5) NOT NULL DEFAULT '0',
  `orderby` smallint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_pay_log`;
CREATE TABLE `retengcms_pay_log` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `sn` varchar(32) NOT NULL,
  `username` varchar(30) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `manage` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(10) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `payment` varchar(32) NOT NULL,
  `note` text NOT NULL,
  `time` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`),
  KEY `username` (`username`,`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;