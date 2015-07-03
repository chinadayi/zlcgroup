DROP TABLE IF EXISTS `retengcms_member`;
CREATE TABLE `retengcms_member` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `touserid` mediumint(8) NOT NULL DEFAULT '0',
  `modelid` int(6) NOT NULL,
  `groupid` int(6) NOT NULL DEFAULT '4',
  `gradeid` int(6) NOT NULL DEFAULT '10',
  `honorid` int(6) NOT NULL DEFAULT '0',
  `areaid` int(6) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `facephoto` varchar(100) NOT NULL DEFAULT 'member/images/nophoto.gif',
  `email` varchar(80) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `message` tinyint(3) NOT NULL DEFAULT '0',
  `amount` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `point` int(6) NOT NULL DEFAULT '5',
  `regtime` varchar(10) NOT NULL DEFAULT '0',
  `logintime` varchar(10) NOT NULL DEFAULT '0',
  `logintimes` int(6) NOT NULL DEFAULT '0',
  `loginip` varchar(20) NOT NULL DEFAULT '0.0.0.0',
  `level` tinyint(1) NOT NULL DEFAULT '1',
  `expire` char(10) NOT NULL,
  `openid` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `modelid` (`modelid`,`groupid`),
  KEY `username` (`username`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_member_cache`;
CREATE TABLE `retengcms_member_cache` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `touserid` mediumint(8) NOT NULL DEFAULT '0',
  `modelid` int(6) NOT NULL,
  `groupid` int(6) NOT NULL,
  `gradeid` int(6) NOT NULL DEFAULT '0',
  `honorid` int(6) NOT NULL DEFAULT '0',
  `areaid` int(6) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `facephoto` varchar(100) NOT NULL DEFAULT 'member/images/nophoto.gif',
  `email` varchar(80) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `message` tinyint(3) NOT NULL DEFAULT '0',
  `amount` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  `point` int(6) NOT NULL DEFAULT '5',
  `regtime` varchar(10) NOT NULL DEFAULT '0',
  `logintime` varchar(10) NOT NULL DEFAULT '0',
  `logintimes` int(6) NOT NULL DEFAULT '0',
  `loginip` varchar(20) NOT NULL DEFAULT '0.0.0.0',
  `level` tinyint(1) NOT NULL DEFAULT '1',
  `expire` char(10) NOT NULL,
  `openid` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`),
  KEY `modelid` (`modelid`,`groupid`),
  KEY `username` (`username`),
  KEY `openid_2` (`openid`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_membermodel`;
CREATE TABLE `retengcms_membermodel` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `table` varchar(30) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `register` tinyint(1) NOT NULL DEFAULT '1',
  `issystem` tinyint(1) NOT NULL DEFAULT '0',
  `module` char(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_membermodel` VALUES('1','普通会员','regular','0','1','1','');
REPLACE INTO `retengcms_membermodel` VALUES('2','企业会员','company','0','1','1','');
DROP TABLE IF EXISTS `retengcms_membergrade`;
CREATE TABLE `retengcms_membergrade` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `point` varchar(10) NOT NULL,
  `issystem` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `info` varchar(255) NOT NULL,
  `postcatid` text NOT NULL,
  `viewcatid` text NOT NULL,
  `module` char(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_membergrade` VALUES('1','普通会员','10','0','0','1','0','一号注册，全站通行。','0','0','9,28,7');
REPLACE INTO `retengcms_membergrade` VALUES('2','高级会员','20','100','100','1','0','一号注册，全站通行。享受更多特权，更多功能模块。','0','0','7,9,10,11,12');
DROP TABLE IF EXISTS `retengcms_membergroup`;
CREATE TABLE `retengcms_membergroup` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `orderby` int(6) NOT NULL,
  `issystem` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `postcatid` text NOT NULL,
  `viewcatid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_membergroup` VALUES('1','管理员','1','1','0','0','0');
REPLACE INTO `retengcms_membergroup` VALUES('2','游客','2','1','0','0','0');
REPLACE INTO `retengcms_membergroup` VALUES('3','待审核','3','1','0','0','0');
REPLACE INTO `retengcms_membergroup` VALUES('4','注册会员','4','1','0','0','0');
DROP TABLE IF EXISTS `retengcms_memberhonor`;
CREATE TABLE `retengcms_memberhonor` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `point` varchar(10) NOT NULL,
  `ico` varchar(10) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_memberhonor` VALUES('1','列兵','100','1','0');
REPLACE INTO `retengcms_memberhonor` VALUES('3','班长','200','2','0');
DROP TABLE IF EXISTS `retengcms_memberdb_fields`;
CREATE TABLE `retengcms_memberdb_fields` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `form` varchar(80) NOT NULL,
  `modelid` int(6) NOT NULL,
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
  PRIMARY KEY (`id`),
  KEY `modelid` (`modelid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_memberdb_fields` VALUES('2','text','1','真实姓名','realname','','','选项值|选项\r\n选项值|选项','','chinese','','30','2','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('5','selectmenu_area','1','所属地区','areaid','','','','31','','','','1','0','1','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('6','selectmenu_area','2','所属地区','areaid','','','','5','','','','1','0','1','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('7','text','2','企业地址','address','','','选项值|选项\r\n选项值|选项','','','','100','5','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('8','fckeditor','2','企业简介','about','','','Basic','','','','255','12','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('9','text','2','公交线路','busroute','','','选项值|选项\r\n选项值|选项','','','','100','7','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('10','text','2','联系电话','phone','','','选项值|选项\r\n选项值|选项','','','','20','2','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('11','text','2','营业时间','openingtime','','','选项值|选项\r\n选项值|选项','8:00-18:00','','','20','8','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('12','image','2','身 份 证','shenfenzheng','','','选项值|选项\r\n选项值|选项','','','','200','9','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('13','image','2','营业执照','zhizhao','','','选项值|选项\r\n选项值|选项','','','','200','10','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('14','text','2','客服QQ','qq','','','选项值|选项\r\n选项值|选项','','qq','','20','4','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('15','images','2','企业图片','pics','','','选项值|选项\r\n选项值|选项','','','','255','11','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('16','text','1','联系电话','dianhua','','','选项值|选项\r\n选项值|选项','','','','30','3','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('17','text','1','客服QQ','qq','','','选项值|选项\r\n选项值|选项','','qq','','30','4','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('18','text','1','详细地址','dizhi','','','选项值|选项\r\n选项值|选项','','','','200','5','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('19','text','2','手机号码','dianhua','','','选项值|选项\r\n选项值|选项','','','','30','3','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('20','text','2','咨询地址','dizhi','','','选项值|选项\r\n选项值|选项','','','','200','6','0','0','0');
REPLACE INTO `retengcms_memberdb_fields` VALUES('21','text','2','联系人','lianxiren','','','选项值|选项\r\n选项值|选项','李先生','chinese','','30','2','0','0','0');
DROP TABLE IF EXISTS `retengcms_message`;
CREATE TABLE `retengcms_message` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `send_from_user` varchar(30) NOT NULL,
  `send_to_user` varchar(30) NOT NULL,
  `folder` enum('all','inbox','outbox') NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `message_time` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` char(200) NOT NULL,
  `content` text NOT NULL,
  `replyid` int(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `msgtoid` (`send_to_user`,`folder`),
  KEY `replyid` (`replyid`),
  KEY `folder` (`send_from_user`,`folder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_collect`;
CREATE TABLE `retengcms_collect` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) NOT NULL DEFAULT '0',
  `title` varchar(160) NOT NULL,
  `url` varchar(100) NOT NULL DEFAULT '',
  `time` varchar(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;