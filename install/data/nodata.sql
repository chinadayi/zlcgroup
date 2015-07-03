DROP TABLE IF EXISTS `retengcms_admin`;
CREATE TABLE `retengcms_admin` (
  `userid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `logintime` varchar(10) NOT NULL,
  `allowmultilogin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `roleid` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `retengcms_admin_cache`;
CREATE TABLE `retengcms_admin_cache` (
  `userid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `logintime` varchar(10) NOT NULL,
  `allowmultilogin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `roleid` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_appointment`;
CREATE TABLE `retengcms_appointment` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `appdate` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_article`;
CREATE TABLE `retengcms_article` (
  `contentid` mediumint(8) NOT NULL,
  `content` mediumtext NOT NULL,
  `editor` varchar(30) NOT NULL,
  `copyfrom` varchar(100) NOT NULL,
  `video` varchar(255) NOT NULL,
  KEY `contentid` (`contentid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_article` VALUES('1','<p><img src=\"/uploads/image/201410/14139846684007.jpg\" title=\"\"/></p><p><strong>此处的内容可以在 <a href=\"/list/?id=20\" target=\"_blank\" textvalue=\"服务项目\">服务项目</a> 栏目中添加相应的栏目，使用标签调用栏目的描述，可摆脱日后修改内容要修改模板index.htm 文件。在index.htm模板中添加标签是读取栏目ID:20的子栏目，可以省去日后的手动修改。</strong></p>','','热腾工作室','');
REPLACE INTO `retengcms_article` VALUES('2','<p style=\"text-align: center;\"><span style=\"font-size: 18px;\">使用<a href=\"http://cms.reteng.org/\" target=\"_blank\">RTCMS</a>相关作品，凡是保留版权信息的站点，<a href=\"http://cms.reteng.org/html/gbook/\" target=\"_blank\" style=\"font-size: 18px; text-decoration: underline;\">热腾网</a>将为其提供网站上线前技术支持，并接收指导修改。</span></p>','','热腾工作室','');
DROP TABLE IF EXISTS `retengcms_author`;
CREATE TABLE `retengcms_author` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `orderby` int(6) NOT NULL DEFAULT '0',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_badwords`;
CREATE TABLE `retengcms_badwords` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `badwords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_badwords` VALUES('1','');
DROP TABLE IF EXISTS `retengcms_cache`;
CREATE TABLE `retengcms_cache` (
  `name` varchar(32) NOT NULL,
  `value` mediumtext NOT NULL,
  `expire` int(10) unsigned NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_cache` VALUES('5139e47445cbbd9095ba2f1b271d610c','array (\n  0 => \n  array (\n    \'id\' => \'2\',\n    \'modelid\' => \'1\',\n    \'catid\' => \'15\',\n    \'areaid\' => \'0\',\n    \'template\' => \'article_article\',\n    \'title\' => \'关于版权信息声明\',\n    \'style\' => \'\',\n    \'thumb\' => \'\',\n    \'keywords\' => \'\',\n    \'description\' => \'使用RTCMS相关作品，凡是保留版权信息的站点，热腾网将为提供技术支持。\',\n    \'posid\' => \'0\',\n    \'url\' => \'/show/?id=2&page=1&siteid=1\',\n    \'status\' => \'1\',\n    \'point\' => \'0\',\n    \'amount\' => \'0.00\',\n    \'userid\' => \'1\',\n    \'username\' => \'admin\',\n    \'inputtime\' => \'1413986020\',\n    \'updatetime\' => \'1413986020\',\n    \'clicks\' => \'141\',\n    \'comments\' => \'0\',\n    \'islink\' => \'0\',\n    \'password\' => \'\',\n    \'expire\' => \'0\',\n    \'ispage\' => \'1\',\n    \'pagecount\' => \'20000\',\n    \'iscomment\' => \'1\',\n    \'orderby\' => \'2\',\n    \'siteid\' => \'1\',\n    \'navtype\' => \'\',\n    \'support\' => \'0\',\n    \'oppose\' => \'0\',\n  ),\n)','1413987924');
REPLACE INTO `retengcms_cache` VALUES('bc23d48115d6aaa044b70ab078210d78','array (\n  0 => \n  array (\n    \'id\' => \'1\',\n    \'modelid\' => \'1\',\n    \'catid\' => \'16\',\n    \'areaid\' => \'0\',\n    \'template\' => \'article_article\',\n    \'title\' => \'首页修改部位提示。\',\n    \'style\' => \'\',\n    \'thumb\' => \'/uploads/image/201410/14139846684007.jpg\',\n    \'keywords\' => \'修改 部位 提示\',\n    \'description\' => \'此处的内容可以在 服务项目 栏目中添加相应的栏目，使用标签调用栏目的描述，可摆脱日后修改内容要修改模板index.htm 文件。\',\n    \'posid\' => \'0\',\n    \'url\' => \'/show/?id=1&page=1&siteid=1\',\n    \'status\' => \'1\',\n    \'point\' => \'0\',\n    \'amount\' => \'0.00\',\n    \'userid\' => \'1\',\n    \'username\' => \'admin\',\n    \'inputtime\' => \'1413984761\',\n    \'updatetime\' => \'1413984903\',\n    \'clicks\' => \'115\',\n    \'comments\' => \'0\',\n    \'islink\' => \'0\',\n    \'password\' => \'\',\n    \'expire\' => \'0\',\n    \'ispage\' => \'1\',\n    \'pagecount\' => \'20000\',\n    \'iscomment\' => \'1\',\n    \'orderby\' => \'1\',\n    \'siteid\' => \'1\',\n    \'navtype\' => \'\',\n    \'support\' => \'0\',\n    \'oppose\' => \'0\',\n  ),\n)','1413987924');
DROP TABLE IF EXISTS `retengcms_category`;
CREATE TABLE `retengcms_category` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `modelid` int(6) NOT NULL,
  `parentid` int(6) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `catname` varchar(60) NOT NULL,
  `domain` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'images/image128x128.png',
  `catdir` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `setting` text NOT NULL,
  `orderby` int(6) unsigned NOT NULL,
  `ispost` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `m` tinyint(2) NOT NULL DEFAULT '1',
  `expand` text NOT NULL,
  `siteid` smallint(4) unsigned NOT NULL,
  `content` text,
  `navtype` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `modelid` (`modelid`,`parentid`,`type`),
  KEY `catdir` (`catdir`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_category` VALUES('1','0','0','3','会员管理','','images/image128x128.png','member','member/','','1','0','1','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('2','0','0','3','个人空间','','images/image128x128.png','space','','','2','0','0','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('3','0','0','3','友情链接','','images/image128x128.png','link','link/','','3','0','1','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('4','0','0','3','在线投票','','images/image128x128.png','vote','vote/','','4','0','1','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('5','0','0','3','搜索模块','','images/image128x128.png','search','search/','','5','0','1','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('6','0','0','3','广告管理','','images/image128x128.png','adv','','','6','0','0','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('7','0','0','3','文章tag标签','','images/image128x128.png','tags','tags/','','7','0','1','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('8','0','0','3','在线投稿','','images/image128x128.png','post','post/','','8','0','1','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('9','0','0','3','站外链接','','images/image128x128.png','workbox','','','9','0','0','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('10','0','0','3','订单支付','','images/image128x128.png','pay','','','10','0','0','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('11','0','0','3','留言管理','','images/image128x128.png','guestbook','guestbook/','','11','0','1','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('13','0','0','3','diy表单','','images/image128x128.png','form','','','13','0','0','1','','0','','');
REPLACE INTO `retengcms_category` VALUES('14','1','0','1','资讯文章','','images/image128x128.png','/html/news/','/list/?id=14&siteid=1','array (\n  \'catishtml\' => \'0\',\n  \'ishtml\' => \'0\',\n  \'urlrule\' => \'{sitedir}html/news/{Y}{M}{cid}.htm\',\n  \'listurlrule\' => \'{catdir}list_{tid}_{page}.htm\',\n  \'islist\' => \'1\',\n  \'templist\' => \'list_article\',\n  \'temparticle\' => \'article_article\',\n  \'meta_title\' => \'\',\n  \'meta_keywords\' => \'\',\n  \'meta_description\' => \'\',\n)','14','0','1','1','','1','','3');
REPLACE INTO `retengcms_category` VALUES('15','1','14','1','最新动态','','images/image128x128.png','/html/news/new/','/list/?id=15&siteid=1','array (\n  \'catishtml\' => \'0\',\n  \'ishtml\' => \'0\',\n  \'urlrule\' => \'{sitedir}html/news/{Y}{M}{cid}.htm\',\n  \'listurlrule\' => \'{catdir}list_{tid}_{page}.htm\',\n  \'islist\' => \'1\',\n  \'templist\' => \'list_article\',\n  \'temparticle\' => \'article_article\',\n  \'meta_title\' => \'\',\n  \'meta_keywords\' => \'\',\n  \'meta_description\' => \'\',\n)','15','1','1','2','','1','','3');
REPLACE INTO `retengcms_category` VALUES('16','1','14','1','常见问题','','images/image128x128.png','/html/news/wt/','/list/?id=16&siteid=1','array (\n  \'catishtml\' => \'0\',\n  \'ishtml\' => \'0\',\n  \'urlrule\' => \'{sitedir}html/news/{Y}{M}{cid}.htm\',\n  \'listurlrule\' => \'{catdir}list_{tid}_{page}.htm\',\n  \'islist\' => \'1\',\n  \'templist\' => \'list_article\',\n  \'temparticle\' => \'article_article\',\n  \'meta_title\' => \'\',\n  \'meta_keywords\' => \'\',\n  \'meta_description\' => \'\',\n)','16','1','1','2','','1','','3');
REPLACE INTO `retengcms_category` VALUES('17','1','0','1','案例展示','','images/image128x128.png','/html/case/','/list/?id=17&siteid=1','array (\n  \'catishtml\' => \'0\',\n  \'ishtml\' => \'0\',\n  \'urlrule\' => \'{sitedir}html/case/{Y}{M}{cid}.htm\',\n  \'listurlrule\' => \'{catdir}list_{tid}_{page}.htm\',\n  \'islist\' => \'1\',\n  \'templist\' => \'list_case\',\n  \'temparticle\' => \'article_case\',\n  \'meta_title\' => \'\',\n  \'meta_keywords\' => \'\',\n  \'meta_description\' => \'\',\n)','17','1','1','1','','1','','2,3');
REPLACE INTO `retengcms_category` VALUES('18','-1','0','2','关于我们','','images/image128x128.png','/html/about/','/list/?id=18&siteid=1','array (\n  \'catishtml\' => \'0\',\n  \'listurlrule\' => \'{catdir}list_{tid}_{page}.htm\',\n  \'islist\' => \'1\',\n  \'templist\' => \'single_about\',\n  \'meta_title\' => \'\',\n  \'meta_keywords\' => \'\',\n  \'meta_description\' => \'\',\n)','13','1','1','1','','1','','2,3');
REPLACE INTO `retengcms_category` VALUES('19','-1','0','2','联系我们','','images/image128x128.png','/html/contact/','/list/?id=19&siteid=1','array (\n  \'catishtml\' => \'0\',\n  \'listurlrule\' => \'{catdir}list_{tid}_{page}.htm\',\n  \'islist\' => \'1\',\n  \'templist\' => \'single_contact\',\n  \'meta_title\' => \'\',\n  \'meta_keywords\' => \'\',\n  \'meta_description\' => \'\',\n)','50','1','1','1','','1','<p>我们的工作从周一到周五<br/>(09:00am - 18:00pm) <br/>欢迎咨询我们！<br/><br/>你可以随时通过电话与邮件与我们联系，或把你的需求提交给我们</p>','2,3');
REPLACE INTO `retengcms_category` VALUES('20','-1','0','2','服务项目','','images/image128x128.png','/html/service/','/list/?id=20&siteid=1','array (\n  \'catishtml\' => \'0\',\n  \'listurlrule\' => \'{catdir}list_{tid}_{page}.htm\',\n  \'islist\' => \'1\',\n  \'templist\' => \'single_service\',\n  \'meta_title\' => \'\',\n  \'meta_keywords\' => \'\',\n  \'meta_description\' => \'\',\n)','20','1','1','1','','1','<p><img src=\"/uploads/image/201410/14139843624331.jpg\" title=\"\"/></p><p style=\"text-align: center;\"><strong><span style=\"font-size: 20px;\"><br/></span></strong></p><p><strong><span style=\"font-size: 20px;\"><br/></span></strong></p><p><span style=\"color: rgb(255, 0, 0);\"><strong><span style=\"font-size: 20px;\">修改这里的显示暂时请按照上图修改，或自行修改模板添加 {if } 控制流程语句。</span></strong></span></p><p><span style=\"color: rgb(255, 0, 0);\"><strong><span style=\"font-size: 20px;\"><br/></span></strong></span></p><p><span style=\"color: rgb(255, 0, 0);\"><strong><span style=\"font-size: 20px;\"><br/></span></strong></span></p>','2,3');
REPLACE INTO `retengcms_category` VALUES('21','-1','20','2','网站建设','','images/image128x128.png','/service/web/','/list/?id=21&siteid=1','array (\n  \'catishtml\' => \'0\',\n  \'listurlrule\' => \'{catdir}list_{tid}_{page}.htm\',\n  \'islist\' => \'1\',\n  \'templist\' => \'single_service\',\n  \'meta_title\' => \'\',\n  \'meta_keywords\' => \'\',\n  \'meta_description\' => \'\',\n)','21','1','1','2','array (\n  \'encatname\' => \'Website\',\n)','1','','1,2,3');
REPLACE INTO `retengcms_category` VALUES('22','-1','20','2','安防监控','','images/image128x128.png','/service/monitoring/','/list/?id=22&siteid=1','array (\n  \'catishtml\' => \'0\',\n  \'listurlrule\' => \'{catdir}list_{tid}_{page}.htm\',\n  \'islist\' => \'1\',\n  \'templist\' => \'single_service\',\n  \'meta_title\' => \'\',\n  \'meta_keywords\' => \'\',\n  \'meta_description\' => \'\',\n)','22','1','1','2','array (\n  \'encatname\' => \'Monitoring\',\n)','1','','1,2,3');
DROP TABLE IF EXISTS `retengcms_category_roleid`;
CREATE TABLE `retengcms_category_roleid` (
  `adminid` int(8) NOT NULL,
  `catid` varchar(100) NOT NULL,
  UNIQUE KEY `roleid` (`adminid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_category_roleid` VALUES('1','22,19,20,21,30');
DROP TABLE IF EXISTS `retengcms_collect`;
CREATE TABLE `retengcms_collect` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) NOT NULL DEFAULT '0',
  `title` varchar(160) NOT NULL,
  `url` varchar(100) NOT NULL DEFAULT '',
  `time` varchar(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_comment`;
CREATE TABLE `retengcms_comment` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` mediumint(8) unsigned NOT NULL,
  `contentid` mediumint(8) NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL,
  `userface` varchar(100) NOT NULL,
  `support` smallint(5) unsigned NOT NULL DEFAULT '0',
  `against` smallint(5) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `addtime` varchar(10) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`status`,`id`,`contentid`),
  KEY `status` (`status`,`contentid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_company`;
CREATE TABLE `retengcms_company` (
  `userid` mediumint(8) NOT NULL,
  `address` varchar(100) NOT NULL,
  `about` mediumtext NOT NULL,
  `busroute` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `openingtime` varchar(20) NOT NULL,
  `shenfenzheng` varchar(200) NOT NULL,
  `zhizhao` varchar(200) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `pics` mediumtext NOT NULL,
  `dianhua` varchar(30) NOT NULL,
  `dizhi` varchar(200) NOT NULL,
  `lianxiren` varchar(30) NOT NULL,
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_config`;
CREATE TABLE `retengcms_config` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` smallint(6) NOT NULL DEFAULT '1',
  `varname` varchar(20) NOT NULL DEFAULT '',
  `desc` varchar(100) NOT NULL DEFAULT '',
  `alt` varchar(100) NOT NULL DEFAULT '',
  `type` varchar(10) NOT NULL DEFAULT 'string',
  `value` text,
  `system` tinyint(1) NOT NULL DEFAULT '0',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_config` VALUES('1','1','site_name','网站名称','','string','热腾工作室','1','1');
REPLACE INTO `retengcms_config` VALUES('2','1','childsite_url','网站地址','请填写完整URL地址，以\"/\"结尾','string','http://127.0.0.1/','1','1');
REPLACE INTO `retengcms_config` VALUES('3','1','tpl_name','默认模板','','string','gzs','1','1');
REPLACE INTO `retengcms_config` VALUES('4','1','meta_title','网站副标题','','string','用不同于大众的形式来服务企业或个人客户','1','1');
REPLACE INTO `retengcms_config` VALUES('5','1','meta_keywords','网站关键字','设置Meta标签的关键字，用英文逗号分隔','string','','1','1');
REPLACE INTO `retengcms_config` VALUES('6','1','meta_description','网站描述','设置Meta标签的描述信息','bstring','','1','1');
REPLACE INTO `retengcms_config` VALUES('7','1','separator','导航分隔符','如：网站首页 > 新闻','string','>','1','1');
REPLACE INTO `retengcms_config` VALUES('8','1','htmlext','HTML后缀','HTML后缀不要经常修改!修改后请更新内容。','string','.htm','1','1');
REPLACE INTO `retengcms_config` VALUES('9','1','iscity','只读取默认地区数据','开启后, 将自动读取默认地区数据，其他地区数据将不显示在前台。','bool','0','1','1');
REPLACE INTO `retengcms_config` VALUES('10','1','city','默认地区名','','string','615','1','1');
REPLACE INTO `retengcms_config` VALUES('11','1','map','地图精准定位','','string','120.1888,30.249800','1','1');
REPLACE INTO `retengcms_config` VALUES('12','1','ishtml','首页是否静态化','','string','0','1','1');
REPLACE INTO `retengcms_config` VALUES('13','1','copyright','版权信息','','string','CopyRight © 2014 <a href=\"http://www.reteng.org\" target=\"_blank\" style=\"text-decoration:none;\">热腾网</a> RETENG.Org, All Rights Reserved.','1','1');
REPLACE INTO `retengcms_config` VALUES('14','1','icpno','网站ICP备案序号','','string','','1','1');
REPLACE INTO `retengcms_config` VALUES('15','1','logo','网站logo','','image','/images/logo.png','1','1');
REPLACE INTO `retengcms_config` VALUES('16','1','telphone_one','电话一','','string','0311-12345678','0','1');
REPLACE INTO `retengcms_config` VALUES('17','1','telphone_two','电话二','','string','0311-87654321','0','1');
REPLACE INTO `retengcms_config` VALUES('18','1','mobile_phone','手机号','','number','13800138000','0','1');
REPLACE INTO `retengcms_config` VALUES('19','1','company_address','公司地址','','string','石家庄新华区中华北大街50号军创园702室','0','1');
REPLACE INTO `retengcms_config` VALUES('20','1','company_email','公司邮箱','','string','master@reteng.org','0','1');
REPLACE INTO `retengcms_config` VALUES('21','1','contact_qq','联系QQ','','number','363764756','0','1');
DROP TABLE IF EXISTS `retengcms_content`;
CREATE TABLE `retengcms_content` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `modelid` int(6) NOT NULL,
  `catid` int(6) unsigned NOT NULL DEFAULT '0',
  `areaid` smallint(6) NOT NULL,
  `template` char(100) NOT NULL,
  `title` char(160) NOT NULL,
  `style` char(30) NOT NULL,
  `thumb` char(100) NOT NULL DEFAULT '',
  `keywords` char(100) NOT NULL,
  `description` char(255) NOT NULL,
  `posid` tinyint(1) NOT NULL DEFAULT '0',
  `url` char(100) NOT NULL DEFAULT 'http://',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '99',
  `point` smallint(5) NOT NULL DEFAULT '0',
  `amount` decimal(8,2) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(80) NOT NULL,
  `inputtime` char(10) NOT NULL,
  `updatetime` char(10) NOT NULL,
  `clicks` int(5) unsigned NOT NULL DEFAULT '0',
  `comments` int(5) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL,
  `expire` int(4) NOT NULL DEFAULT '0',
  `ispage` tinyint(1) NOT NULL DEFAULT '0',
  `pagecount` int(4) NOT NULL DEFAULT '5000',
  `iscomment` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `orderby` mediumint(8) NOT NULL DEFAULT '0',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `navtype` varchar(100) NOT NULL,
  `support` int(11) NOT NULL DEFAULT '0',
  `oppose` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `catid` (`catid`,`status`,`id`,`areaid`),
  KEY `status` (`status`,`id`),
  KEY `userid` (`userid`),
  KEY `modelid` (`modelid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_content` VALUES('1','1','16','0','article_article','首页修改部位提示。','','/uploads/image/201410/14139846684007.jpg','修改 部位 提示','此处的内容可以在 服务项目 栏目中添加相应的栏目，使用标签调用栏目的描述，可摆脱日后修改内容要修改模板index.htm 文件。','0','/show/?id=1&page=1&siteid=1','1','0','0.00','1','admin','1413984761','1413984903','115','0','0','','0','1','20000','1','1','1','','0','0');
REPLACE INTO `retengcms_content` VALUES('2','1','15','0','article_article','关于版权信息声明','','','','使用RTCMS相关作品，凡是保留版权信息的站点，热腾网将为提供技术支持。','0','/show/?id=2&page=1&siteid=1','1','0','0.00','1','admin','1413986020','1413986215','141','0','0','','0','1','20000','1','2','1','','0','0');
DROP TABLE IF EXISTS `retengcms_content_posid`;
CREATE TABLE `retengcms_content_posid` (
  `contentid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `posid` smallint(5) unsigned NOT NULL DEFAULT '0',
  KEY `posid` (`posid`),
  KEY `contentid` (`contentid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_copyfrom`;
CREATE TABLE `retengcms_copyfrom` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT 'http://',
  `orderby` int(6) NOT NULL DEFAULT '0',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_copyfrom` VALUES('1','本站原创','http://','0','1');
DROP TABLE IF EXISTS `retengcms_counts`;
CREATE TABLE `retengcms_counts` (
  `id` char(32) NOT NULL DEFAULT '',
  `count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_form`;
CREATE TABLE `retengcms_form` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `table` varchar(30) NOT NULL,
  `siteid` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
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
DROP TABLE IF EXISTS `retengcms_gather`;
CREATE TABLE `retengcms_gather` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `modelid` smallint(4) NOT NULL,
  `cotime` char(10) NOT NULL,
  `addtime` char(10) NOT NULL,
  `code` varchar(10) NOT NULL,
  `urlcounts` mediumint(8) NOT NULL,
  `listsetting` text NOT NULL,
  `itemsetting` text NOT NULL,
  `istask` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_gather_tmp`;
CREATE TABLE `retengcms_gather_tmp` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `nodeid` mediumint(8) NOT NULL,
  `title` varchar(80) NOT NULL,
  `url` varchar(160) NOT NULL,
  `content` mediumtext NOT NULL,
  `ispost` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_guestbook`;
CREATE TABLE `retengcms_guestbook` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `title` char(200) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `content` text NOT NULL,
  `reply` text NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL,
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `passed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `replyer` char(20) NOT NULL,
  `replytime` int(10) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `hidden` (`hidden`,`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_keywords`;
CREATE TABLE `retengcms_keywords` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(30) NOT NULL,
  `weight` smallint(4) NOT NULL DEFAULT '0',
  `counts` mediumint(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`keywords`,`weight`,`counts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_link` VALUES('1','1','热腾网','http://www.reteng.org','','','','0','1357653685','1','1','1');
REPLACE INTO `retengcms_link` VALUES('4','1','RTCMS','http://cms.reteng.org','','','','0','1406125267','1','4','1');
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
DROP TABLE IF EXISTS `retengcms_log`;
CREATE TABLE `retengcms_log` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `admin` char(64) NOT NULL DEFAULT '',
  `method` char(10) NOT NULL DEFAULT '',
  `query` char(200) NOT NULL DEFAULT '',
  `comeurl` varchar(200) NOT NULL,
  `ip` char(15) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=512 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_log` VALUES('1','游客','GET','file=login','http://localhost/admin.php','127.0.0.1','1406125216');
REPLACE INTO `retengcms_log` VALUES('2','游客','POST','file=login','http://localhost/admin.php?file=login','127.0.0.1','1406125220');
REPLACE INTO `retengcms_log` VALUES('3','123','GET','file=top','http://localhost/admin.php','127.0.0.1','1406125222');
REPLACE INTO `retengcms_log` VALUES('4','123','GET','file=main','http://localhost/admin.php','127.0.0.1','1406125222');
REPLACE INTO `retengcms_log` VALUES('5','123','GET','file=module&action=manage','http://localhost/admin.php?file=left&menu=module','127.0.0.1','1406125227');
REPLACE INTO `retengcms_log` VALUES('6','123','POST','file=module&action=delete','http://localhost/admin.php?file=module&action=manage','127.0.0.1','1406125231');
REPLACE INTO `retengcms_log` VALUES('7','123','GET','file=module&action=manage','http://localhost/admin.php?file=left&menu=module','127.0.0.1','1406125232');
REPLACE INTO `retengcms_log` VALUES('8','123','GET','file=module&action=manage','http://localhost/admin.php?file=left&menu=module','127.0.0.1','1406125232');
REPLACE INTO `retengcms_log` VALUES('9','123','GET','file=module&action=set&id=1','http://localhost/admin.php?file=module&action=manage','127.0.0.1','1406125235');
REPLACE INTO `retengcms_log` VALUES('10','123','POST','file=module&action=set&id=1','http://localhost/admin.php?file=module&action=set&id=1','127.0.0.1','1406125238');
REPLACE INTO `retengcms_log` VALUES('11','123','GET','file=module&action=set&id=1','http://localhost/admin.php?file=module&action=manage','127.0.0.1','1406125239');
REPLACE INTO `retengcms_log` VALUES('12','123','GET','file=module&action=manage','http://localhost/admin.php?file=left&menu=module','127.0.0.1','1406125241');
REPLACE INTO `retengcms_log` VALUES('13','123','GET','file=module&action=set&id=6','http://localhost/admin.php?file=module&action=manage','127.0.0.1','1406125244');
REPLACE INTO `retengcms_log` VALUES('14','123','POST','file=module&action=set&id=6','http://localhost/admin.php?file=module&action=set&id=6','127.0.0.1','1406125247');
REPLACE INTO `retengcms_log` VALUES('15','123','GET','file=module&action=set&id=6','http://localhost/admin.php?file=module&action=manage','127.0.0.1','1406125248');
REPLACE INTO `retengcms_log` VALUES('16','123','GET','file=main','http://localhost/admin.php','127.0.0.1','1406125250');
REPLACE INTO `retengcms_log` VALUES('17','123','GET','mod=link&file=link&action=type','http://localhost/admin.php?file=left&menu=other','127.0.0.1','1406125255');
REPLACE INTO `retengcms_log` VALUES('18','123','GET','mod=link&file=link&action=manage&typeid=1','http://localhost/admin.php?mod=link&file=link&action=type','127.0.0.1','1406125256');
REPLACE INTO `retengcms_log` VALUES('19','123','GET','mod=link&file=link&action=add&typeid=1','http://localhost/admin.php?mod=link&file=link&action=manage&typeid=1','127.0.0.1','1406125258');
REPLACE INTO `retengcms_log` VALUES('20','123','POST','mod=link&file=link&action=add&typeid=1','http://localhost/admin.php?mod=link&file=link&action=add&typeid=1','127.0.0.1','1406125267');
REPLACE INTO `retengcms_log` VALUES('21','123','GET','mod=link&file=link&action=add&typeid=1','http://localhost/admin.php?mod=link&file=link&action=manage&typeid=1','127.0.0.1','1406125268');
REPLACE INTO `retengcms_log` VALUES('22','123','GET','file=main','http://localhost/admin.php','127.0.0.1','1406125274');
REPLACE INTO `retengcms_log` VALUES('23','123','GET','file=top','http://localhost/admin.php','127.0.0.1','1406125278');
REPLACE INTO `retengcms_log` VALUES('24','123','GET','file=main','http://localhost/admin.php','127.0.0.1','1406125278');
REPLACE INTO `retengcms_log` VALUES('25','123','GET','file=db&action=export','http://localhost/admin.php?file=left','127.0.0.1','1406125285');
REPLACE INTO `retengcms_log` VALUES('26','123','GET','file=db&action=import','http://localhost/admin.php?file=db&action=export','127.0.0.1','1406125297');
REPLACE INTO `retengcms_log` VALUES('27','123','GET','file=db&action=repair','http://localhost/admin.php?file=db&action=import','127.0.0.1','1406125298');
REPLACE INTO `retengcms_log` VALUES('28','123','POST','file=db&action=repair','http://localhost/admin.php?file=db&action=repair','127.0.0.1','1406125302');
REPLACE INTO `retengcms_log` VALUES('29','123','GET','file=db&action=repair','http://localhost/admin.php?file=db&action=import','127.0.0.1','1406125303');
REPLACE INTO `retengcms_log` VALUES('30','123','GET','file=db&action=repair','http://localhost/admin.php?file=left','127.0.0.1','1406125305');
REPLACE INTO `retengcms_log` VALUES('31','123','POST','file=db&action=repair','http://localhost/admin.php?file=db&action=repair','127.0.0.1','1406125307');
REPLACE INTO `retengcms_log` VALUES('32','123','GET','file=db&action=repair','http://localhost/admin.php?file=left','127.0.0.1','1406125309');
REPLACE INTO `retengcms_log` VALUES('33','123','GET','file=db&action=export','http://localhost/admin.php?file=left','127.0.0.1','1406125311');
REPLACE INTO `retengcms_log` VALUES('34','123','POST','file=db&action=export','http://localhost/admin.php?file=db&action=export','127.0.0.1','1406125314');
REPLACE INTO `retengcms_log` VALUES('35','游客','GET','file=login','http://127.0.0.1/admin.php','127.0.0.1','1413878036');
REPLACE INTO `retengcms_log` VALUES('36','游客','POST','file=login','http://127.0.0.1/admin.php?file=login','127.0.0.1','1413878048');
REPLACE INTO `retengcms_log` VALUES('37','admin','GET','file=top','http://127.0.0.1/admin.php','127.0.0.1','1413878051');
REPLACE INTO `retengcms_log` VALUES('38','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413878052');
REPLACE INTO `retengcms_log` VALUES('39','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878064');
REPLACE INTO `retengcms_log` VALUES('40','admin','POST','file=category&action=add','http://127.0.0.1/admin.php?file=category&action=add','127.0.0.1','1413878107');
REPLACE INTO `retengcms_log` VALUES('41','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878109');
REPLACE INTO `retengcms_log` VALUES('42','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878114');
REPLACE INTO `retengcms_log` VALUES('43','admin','POST','file=category&action=add','http://127.0.0.1/admin.php?file=category&action=add','127.0.0.1','1413878144');
REPLACE INTO `retengcms_log` VALUES('44','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878146');
REPLACE INTO `retengcms_log` VALUES('45','admin','POST','file=category&action=add','http://127.0.0.1/admin.php?file=category&action=add','127.0.0.1','1413878164');
REPLACE INTO `retengcms_log` VALUES('46','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878166');
REPLACE INTO `retengcms_log` VALUES('47','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878168');
REPLACE INTO `retengcms_log` VALUES('48','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878170');
REPLACE INTO `retengcms_log` VALUES('49','admin','POST','file=category&action=add','http://127.0.0.1/admin.php?file=category&action=add','127.0.0.1','1413878280');
REPLACE INTO `retengcms_log` VALUES('50','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878282');
REPLACE INTO `retengcms_log` VALUES('51','admin','POST','file=category&action=add','http://127.0.0.1/admin.php?file=category&action=add','127.0.0.1','1413878310');
REPLACE INTO `retengcms_log` VALUES('52','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878312');
REPLACE INTO `retengcms_log` VALUES('53','admin','POST','file=category&action=add','http://127.0.0.1/admin.php?file=category&action=add','127.0.0.1','1413878327');
REPLACE INTO `retengcms_log` VALUES('54','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878329');
REPLACE INTO `retengcms_log` VALUES('55','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878367');
REPLACE INTO `retengcms_log` VALUES('56','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878372');
REPLACE INTO `retengcms_log` VALUES('57','admin','POST','file=category&action=add','http://127.0.0.1/admin.php?file=category&action=add','127.0.0.1','1413878386');
REPLACE INTO `retengcms_log` VALUES('58','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878388');
REPLACE INTO `retengcms_log` VALUES('59','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878400');
REPLACE INTO `retengcms_log` VALUES('60','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878404');
REPLACE INTO `retengcms_log` VALUES('61','admin','POST','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=edit&id=20','127.0.0.1','1413878409');
REPLACE INTO `retengcms_log` VALUES('62','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878412');
REPLACE INTO `retengcms_log` VALUES('63','admin','POST','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=edit&id=20','127.0.0.1','1413878429');
REPLACE INTO `retengcms_log` VALUES('64','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878431');
REPLACE INTO `retengcms_log` VALUES('65','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878433');
REPLACE INTO `retengcms_log` VALUES('66','admin','GET','file=category&action=edit&id=14','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878436');
REPLACE INTO `retengcms_log` VALUES('67','admin','POST','file=category&action=edit&id=14','http://127.0.0.1/admin.php?file=category&action=edit&id=14','127.0.0.1','1413878452');
REPLACE INTO `retengcms_log` VALUES('68','admin','GET','file=category&action=edit&id=14','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878455');
REPLACE INTO `retengcms_log` VALUES('69','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878458');
REPLACE INTO `retengcms_log` VALUES('70','admin','GET','file=category&action=edit&id=17','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878464');
REPLACE INTO `retengcms_log` VALUES('71','admin','POST','file=category&action=edit&id=17','http://127.0.0.1/admin.php?file=category&action=edit&id=17','127.0.0.1','1413878478');
REPLACE INTO `retengcms_log` VALUES('72','admin','GET','file=category&action=edit&id=17','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878481');
REPLACE INTO `retengcms_log` VALUES('73','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878485');
REPLACE INTO `retengcms_log` VALUES('74','admin','GET','file=category&action=edit&id=18','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878489');
REPLACE INTO `retengcms_log` VALUES('75','admin','POST','file=category&action=edit&id=18','http://127.0.0.1/admin.php?file=category&action=edit&id=18','127.0.0.1','1413878500');
REPLACE INTO `retengcms_log` VALUES('76','admin','GET','file=category&action=edit&id=18','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878502');
REPLACE INTO `retengcms_log` VALUES('77','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413878505');
REPLACE INTO `retengcms_log` VALUES('78','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878508');
REPLACE INTO `retengcms_log` VALUES('79','admin','POST','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=edit&id=19','127.0.0.1','1413878535');
REPLACE INTO `retengcms_log` VALUES('80','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413878537');
REPLACE INTO `retengcms_log` VALUES('81','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413879887');
REPLACE INTO `retengcms_log` VALUES('82','admin','POST','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=config&action=config&tab=1','127.0.0.1','1413879894');
REPLACE INTO `retengcms_log` VALUES('83','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413879897');
REPLACE INTO `retengcms_log` VALUES('84','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413882789');
REPLACE INTO `retengcms_log` VALUES('85','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413882893');
REPLACE INTO `retengcms_log` VALUES('86','admin','GET','file=content&action=manage&catid=15','http://127.0.0.1/admin.php?file=left&menu=content','127.0.0.1','1413882937');
REPLACE INTO `retengcms_log` VALUES('87','admin','GET','file=content&action=manage&catid=16','http://127.0.0.1/admin.php?file=left&menu=content','127.0.0.1','1413882939');
REPLACE INTO `retengcms_log` VALUES('88','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413882941');
REPLACE INTO `retengcms_log` VALUES('89','admin','GET','file=content&action=manage','http://127.0.0.1/admin.php?file=left&module=index','127.0.0.1','1413882943');
REPLACE INTO `retengcms_log` VALUES('90','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&module=index','127.0.0.1','1413882947');
REPLACE INTO `retengcms_log` VALUES('91','admin','GET','file=content&action=manage','http://127.0.0.1/admin.php?file=left&module=index','127.0.0.1','1413882951');
REPLACE INTO `retengcms_log` VALUES('92','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413883001');
REPLACE INTO `retengcms_log` VALUES('93','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413883327');
REPLACE INTO `retengcms_log` VALUES('94','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413884225');
REPLACE INTO `retengcms_log` VALUES('95','admin','GET','file=category&action=edit&id=18','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413884229');
REPLACE INTO `retengcms_log` VALUES('96','admin','POST','file=category&action=edit&id=18','http://127.0.0.1/admin.php?file=category&action=edit&id=18','127.0.0.1','1413884237');
REPLACE INTO `retengcms_log` VALUES('97','admin','GET','file=category&action=edit&id=18','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413884240');
REPLACE INTO `retengcms_log` VALUES('98','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413884412');
REPLACE INTO `retengcms_log` VALUES('99','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413884417');
REPLACE INTO `retengcms_log` VALUES('100','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413884434');
REPLACE INTO `retengcms_log` VALUES('101','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413884438');
REPLACE INTO `retengcms_log` VALUES('102','admin','POST','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=edit&id=19','127.0.0.1','1413884445');
REPLACE INTO `retengcms_log` VALUES('103','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413884447');
REPLACE INTO `retengcms_log` VALUES('104','admin','POST','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=edit&id=19','127.0.0.1','1413884616');
REPLACE INTO `retengcms_log` VALUES('105','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413884618');
REPLACE INTO `retengcms_log` VALUES('106','admin','GET','file=content&action=manage&catid=15','http://127.0.0.1/admin.php?file=left&menu=content','127.0.0.1','1413885103');
REPLACE INTO `retengcms_log` VALUES('107','admin','GET','file=content&action=add&catid=15','http://127.0.0.1/admin.php?file=content&action=manage&catid=15','127.0.0.1','1413885106');
REPLACE INTO `retengcms_log` VALUES('108','admin','GET','file=top','http://127.0.0.1/admin.php','127.0.0.1','1413888993');
REPLACE INTO `retengcms_log` VALUES('109','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413888996');
REPLACE INTO `retengcms_log` VALUES('110','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413889005');
REPLACE INTO `retengcms_log` VALUES('111','admin','POST','file=category&action=manage','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413889022');
REPLACE INTO `retengcms_log` VALUES('112','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413889025');
REPLACE INTO `retengcms_log` VALUES('113','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413889123');
REPLACE INTO `retengcms_log` VALUES('114','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413889420');
REPLACE INTO `retengcms_log` VALUES('115','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413889429');
REPLACE INTO `retengcms_log` VALUES('116','admin','POST','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=edit&id=20','127.0.0.1','1413889437');
REPLACE INTO `retengcms_log` VALUES('117','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413889439');
REPLACE INTO `retengcms_log` VALUES('118','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413890134');
REPLACE INTO `retengcms_log` VALUES('119','admin','GET','file=category&action=add','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413890137');
REPLACE INTO `retengcms_log` VALUES('120','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413890336');
REPLACE INTO `retengcms_log` VALUES('121','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413893851');
REPLACE INTO `retengcms_log` VALUES('122','admin','GET','file=category&action=add&parentid=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413893860');
REPLACE INTO `retengcms_log` VALUES('123','admin','POST','file=category&action=add&parentid=20','http://127.0.0.1/admin.php?file=category&action=add&parentid=20','127.0.0.1','1413893930');
REPLACE INTO `retengcms_log` VALUES('124','admin','GET','file=category&action=add&parentid=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413893933');
REPLACE INTO `retengcms_log` VALUES('125','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413894005');
REPLACE INTO `retengcms_log` VALUES('126','admin','GET','file=category&action=add&parentid=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413894055');
REPLACE INTO `retengcms_log` VALUES('127','admin','POST','file=category&action=add&parentid=20','http://127.0.0.1/admin.php?file=category&action=add&parentid=20','127.0.0.1','1413894094');
REPLACE INTO `retengcms_log` VALUES('128','admin','GET','file=category&action=add&parentid=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413894097');
REPLACE INTO `retengcms_log` VALUES('129','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413894118');
REPLACE INTO `retengcms_log` VALUES('130','admin','GET','file=category&action=edit&id=21','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413894122');
REPLACE INTO `retengcms_log` VALUES('131','admin','POST','file=category&action=edit&id=21','http://127.0.0.1/admin.php?file=category&action=edit&id=21','127.0.0.1','1413894135');
REPLACE INTO `retengcms_log` VALUES('132','admin','GET','file=category&action=edit&id=21','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413894137');
REPLACE INTO `retengcms_log` VALUES('133','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413894754');
REPLACE INTO `retengcms_log` VALUES('134','admin','GET','file=db&action=export','http://127.0.0.1/admin.php?file=left&module=index','127.0.0.1','1413894755');
REPLACE INTO `retengcms_log` VALUES('135','admin','POST','file=db&action=export','http://127.0.0.1/admin.php?file=db&action=export','127.0.0.1','1413894762');
REPLACE INTO `retengcms_log` VALUES('136','admin','GET','file=db&action=export&do_submit=1&tableid=68&page=2&rand=72676&sizelimit=2048&start=5','http://127.0.0.1/admin.php?file=db&action=export','127.0.0.1','1413894766');
REPLACE INTO `retengcms_log` VALUES('137','admin','GET','file=db&action=export','http://127.0.0.1/admin.php?file=db&action=export&do_submit=1&tableid=68&page=2&rand=72676&sizelimit=2048&start=5','127.0.0.1','1413894768');
REPLACE INTO `retengcms_log` VALUES('138','admin','GET','file=db&action=export','http://127.0.0.1/admin.php?file=db&action=export&do_submit=1&tableid=68&page=2&rand=72676&sizelimit=2048&start=5','127.0.0.1','1413894769');
REPLACE INTO `retengcms_log` VALUES('139','游客','GET','file=login','http://127.0.0.1/admin.php?file=db&action=export','127.0.0.1','1413894804');
REPLACE INTO `retengcms_log` VALUES('140','游客','POST','file=login','http://127.0.0.1/admin.php?file=login','127.0.0.1','1413894816');
REPLACE INTO `retengcms_log` VALUES('141','admin','GET','file=top','http://127.0.0.1/admin.php','127.0.0.1','1413894820');
REPLACE INTO `retengcms_log` VALUES('142','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413894821');
REPLACE INTO `retengcms_log` VALUES('143','admin','GET','file=db&action=export','http://127.0.0.1/admin.php?file=left','127.0.0.1','1413894825');
REPLACE INTO `retengcms_log` VALUES('144','admin','POST','file=db&action=export','http://127.0.0.1/admin.php?file=db&action=export','127.0.0.1','1413894829');
REPLACE INTO `retengcms_log` VALUES('145','admin','GET','file=db&action=import&do_submit=1&mytime=20141021&volume=92037&no=2','http://127.0.0.1/admin.php?file=db&action=import&do_submit=1&mytime=20141021&volume=92037&no=1','127.0.0.1','1413897347');
REPLACE INTO `retengcms_log` VALUES('146','admin','GET','file=db&action=import','http://127.0.0.1/admin.php?file=db&action=import&do_submit=1&mytime=20141021&volume=92037&no=2','127.0.0.1','1413897350');
REPLACE INTO `retengcms_log` VALUES('147','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413897522');
REPLACE INTO `retengcms_log` VALUES('148','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config&tab=1','127.0.0.1','1413897531');
REPLACE INTO `retengcms_log` VALUES('149','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=config&action=config_add','127.0.0.1','1413897532');
REPLACE INTO `retengcms_log` VALUES('150','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config&tab=1','127.0.0.1','1413897540');
REPLACE INTO `retengcms_log` VALUES('151','admin','POST','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config_add','127.0.0.1','1413897570');
REPLACE INTO `retengcms_log` VALUES('152','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config&tab=1','127.0.0.1','1413897572');
REPLACE INTO `retengcms_log` VALUES('153','admin','POST','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config_add','127.0.0.1','1413897590');
REPLACE INTO `retengcms_log` VALUES('154','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config&tab=1','127.0.0.1','1413897592');
REPLACE INTO `retengcms_log` VALUES('155','admin','POST','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config_add','127.0.0.1','1413897611');
REPLACE INTO `retengcms_log` VALUES('156','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config&tab=1','127.0.0.1','1413897613');
REPLACE INTO `retengcms_log` VALUES('157','admin','POST','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config_add','127.0.0.1','1413897624');
REPLACE INTO `retengcms_log` VALUES('158','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config&tab=1','127.0.0.1','1413897627');
REPLACE INTO `retengcms_log` VALUES('159','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413897631');
REPLACE INTO `retengcms_log` VALUES('160','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413897880');
REPLACE INTO `retengcms_log` VALUES('161','admin','GET','mod=member&file=member&action=group','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897919');
REPLACE INTO `retengcms_log` VALUES('162','admin','GET','mod=member&file=member&action=setting','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897921');
REPLACE INTO `retengcms_log` VALUES('163','admin','GET','mod=member&file=member&action=cache','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897939');
REPLACE INTO `retengcms_log` VALUES('164','admin','GET','mod=member&file=member&action=setting','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897942');
REPLACE INTO `retengcms_log` VALUES('165','admin','GET','mod=member&file=member&action=setting','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897943');
REPLACE INTO `retengcms_log` VALUES('166','admin','GET','mod=member&file=member&action=message','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897945');
REPLACE INTO `retengcms_log` VALUES('167','admin','GET','mod=member&file=member&action=model','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897949');
REPLACE INTO `retengcms_log` VALUES('168','admin','GET','mod=member&file=member&action=honor','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897952');
REPLACE INTO `retengcms_log` VALUES('169','admin','GET','mod=member&file=member&action=grade','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897954');
REPLACE INTO `retengcms_log` VALUES('170','admin','GET','mod=member&file=member&action=group','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897958');
REPLACE INTO `retengcms_log` VALUES('171','admin','GET','mod=member&file=member&action=manage','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413897961');
REPLACE INTO `retengcms_log` VALUES('172','admin','GET','mod=member&file=member&action=member_edit&id=1','http://127.0.0.1/admin.php?mod=member&file=member&action=manage','127.0.0.1','1413897964');
REPLACE INTO `retengcms_log` VALUES('173','admin','GET','mod=workbox&file=workbox&action=workbox','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413898001');
REPLACE INTO `retengcms_log` VALUES('174','admin','GET','mod=workbox&file=workbox&action=tag','http://127.0.0.1/admin.php?mod=workbox&file=workbox&action=workbox','127.0.0.1','1413898005');
REPLACE INTO `retengcms_log` VALUES('175','admin','GET','mod=form&file=form&action=manage','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413898013');
REPLACE INTO `retengcms_log` VALUES('176','admin','GET','mod=link&file=link&action=tag','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413898016');
REPLACE INTO `retengcms_log` VALUES('177','admin','GET','mod=member&file=member&action=model','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413898023');
REPLACE INTO `retengcms_log` VALUES('178','admin','GET','mod=member&file=member&action=manage','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413898033');
REPLACE INTO `retengcms_log` VALUES('179','admin','GET','mod=member&file=member&action=setting','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413898037');
REPLACE INTO `retengcms_log` VALUES('180','admin','GET','mod=member&file=member&action=setting','http://127.0.0.1/admin.php?file=left&menu=other','127.0.0.1','1413898046');
REPLACE INTO `retengcms_log` VALUES('181','admin','GET','file=config&action=config&tab=3','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413898053');
REPLACE INTO `retengcms_log` VALUES('182','admin','GET','file=admin&action=role','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413898058');
REPLACE INTO `retengcms_log` VALUES('183','admin','GET','file=admin&action=manage','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413898061');
REPLACE INTO `retengcms_log` VALUES('184','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413898066');
REPLACE INTO `retengcms_log` VALUES('185','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413898136');
REPLACE INTO `retengcms_log` VALUES('186','admin','POST','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config_add','127.0.0.1','1413898159');
REPLACE INTO `retengcms_log` VALUES('187','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413898162');
REPLACE INTO `retengcms_log` VALUES('188','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=left&menu=content','127.0.0.1','1413898445');
REPLACE INTO `retengcms_log` VALUES('189','admin','POST','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=edit&id=19','127.0.0.1','1413898456');
REPLACE INTO `retengcms_log` VALUES('190','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=left&menu=content','127.0.0.1','1413898459');
REPLACE INTO `retengcms_log` VALUES('191','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413898595');
REPLACE INTO `retengcms_log` VALUES('192','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413898599');
REPLACE INTO `retengcms_log` VALUES('193','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413898807');
REPLACE INTO `retengcms_log` VALUES('194','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413898808');
REPLACE INTO `retengcms_log` VALUES('195','admin','POST','file=config&action=config_add','http://127.0.0.1/admin.php?file=config&action=config_add','127.0.0.1','1413898833');
REPLACE INTO `retengcms_log` VALUES('196','admin','GET','file=config&action=config_add','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413898835');
REPLACE INTO `retengcms_log` VALUES('197','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413899027');
REPLACE INTO `retengcms_log` VALUES('198','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413899028');
REPLACE INTO `retengcms_log` VALUES('199','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413900965');
REPLACE INTO `retengcms_log` VALUES('200','admin','GET','file=category&action=edit&id=17','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413900970');
REPLACE INTO `retengcms_log` VALUES('201','admin','POST','file=category&action=edit&id=17','http://127.0.0.1/admin.php?file=category&action=edit&id=17','127.0.0.1','1413900983');
REPLACE INTO `retengcms_log` VALUES('202','游客','GET','file=login','http://127.0.0.1/admin.php','127.0.0.1','1413900989');
REPLACE INTO `retengcms_log` VALUES('203','游客','POST','file=login','http://127.0.0.1/admin.php?file=login','127.0.0.1','1413901032');
REPLACE INTO `retengcms_log` VALUES('204','admin','GET','file=top','http://127.0.0.1/admin.php','127.0.0.1','1413901035');
REPLACE INTO `retengcms_log` VALUES('205','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413901037');
REPLACE INTO `retengcms_log` VALUES('206','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413901963');
REPLACE INTO `retengcms_log` VALUES('207','admin','GET','file=db&action=export','http://127.0.0.1/admin.php?file=left&module=index','127.0.0.1','1413901965');
REPLACE INTO `retengcms_log` VALUES('208','admin','GET','file=db&action=export','http://127.0.0.1/admin.php?file=left&module=index','127.0.0.1','1413901966');
REPLACE INTO `retengcms_log` VALUES('209','admin','POST','file=db&action=export','http://127.0.0.1/admin.php?file=db&action=export','127.0.0.1','1413901970');
REPLACE INTO `retengcms_log` VALUES('210','游客','GET','file=login','http://vip.reteng.org/admin.php','120.1.150.186','1413904114');
REPLACE INTO `retengcms_log` VALUES('211','游客','POST','file=login','http://vip.reteng.org/admin.php?file=login','120.1.150.186','1413904125');
REPLACE INTO `retengcms_log` VALUES('212','admin','GET','file=top','http://vip.reteng.org/admin.php','120.1.150.186','1413904129');
REPLACE INTO `retengcms_log` VALUES('213','admin','GET','file=main','http://vip.reteng.org/admin.php','120.1.150.186','1413904129');
REPLACE INTO `retengcms_log` VALUES('214','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left&menu=system','120.1.150.186','1413904142');
REPLACE INTO `retengcms_log` VALUES('215','admin','POST','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=config&action=config&tab=1','120.1.150.186','1413904231');
REPLACE INTO `retengcms_log` VALUES('216','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left&menu=system','120.1.150.186','1413904234');
REPLACE INTO `retengcms_log` VALUES('217','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904278');
REPLACE INTO `retengcms_log` VALUES('218','admin','GET','file=category&action=edit&id=18','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904283');
REPLACE INTO `retengcms_log` VALUES('219','admin','POST','file=category&action=edit&id=18','http://vip.reteng.org/admin.php?file=category&action=edit&id=18','120.1.150.186','1413904320');
REPLACE INTO `retengcms_log` VALUES('220','admin','GET','file=category&action=edit&id=18','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904322');
REPLACE INTO `retengcms_log` VALUES('221','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904325');
REPLACE INTO `retengcms_log` VALUES('222','admin','GET','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904328');
REPLACE INTO `retengcms_log` VALUES('223','admin','POST','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=edit&id=14','120.1.150.186','1413904348');
REPLACE INTO `retengcms_log` VALUES('224','admin','GET','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904351');
REPLACE INTO `retengcms_log` VALUES('225','admin','GET','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904351');
REPLACE INTO `retengcms_log` VALUES('226','admin','POST','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=edit&id=14','120.1.150.186','1413904358');
REPLACE INTO `retengcms_log` VALUES('227','admin','GET','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904361');
REPLACE INTO `retengcms_log` VALUES('228','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904365');
REPLACE INTO `retengcms_log` VALUES('229','admin','GET','file=category&action=edit&id=15','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904367');
REPLACE INTO `retengcms_log` VALUES('230','游客','GET','file=login','','180.153.206.31','1413904382');
REPLACE INTO `retengcms_log` VALUES('231','admin','POST','file=category&action=edit&id=15','http://vip.reteng.org/admin.php?file=category&action=edit&id=15','120.1.150.186','1413904404');
REPLACE INTO `retengcms_log` VALUES('232','admin','GET','file=category&action=edit&id=15','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904407');
REPLACE INTO `retengcms_log` VALUES('233','admin','POST','file=category&action=edit&id=15','http://vip.reteng.org/admin.php?file=category&action=edit&id=15','120.1.150.186','1413904425');
REPLACE INTO `retengcms_log` VALUES('234','admin','GET','file=category&action=edit&id=15','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904427');
REPLACE INTO `retengcms_log` VALUES('235','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904432');
REPLACE INTO `retengcms_log` VALUES('236','admin','GET','file=category&action=edit&id=15','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904435');
REPLACE INTO `retengcms_log` VALUES('237','admin','POST','file=category&action=edit&id=15','http://vip.reteng.org/admin.php?file=category&action=edit&id=15','120.1.150.186','1413904467');
REPLACE INTO `retengcms_log` VALUES('238','admin','GET','file=category&action=edit&id=15','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904469');
REPLACE INTO `retengcms_log` VALUES('239','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904476');
REPLACE INTO `retengcms_log` VALUES('240','admin','GET','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904479');
REPLACE INTO `retengcms_log` VALUES('241','admin','POST','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=edit&id=14','120.1.150.186','1413904497');
REPLACE INTO `retengcms_log` VALUES('242','admin','GET','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904500');
REPLACE INTO `retengcms_log` VALUES('243','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904502');
REPLACE INTO `retengcms_log` VALUES('244','admin','GET','file=category&action=edit&id=16','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904508');
REPLACE INTO `retengcms_log` VALUES('245','admin','POST','file=category&action=edit&id=16','http://vip.reteng.org/admin.php?file=category&action=edit&id=16','120.1.150.186','1413904546');
REPLACE INTO `retengcms_log` VALUES('246','admin','GET','file=category&action=edit&id=16','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904549');
REPLACE INTO `retengcms_log` VALUES('247','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904551');
REPLACE INTO `retengcms_log` VALUES('248','admin','GET','file=category&action=edit&id=18','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904556');
REPLACE INTO `retengcms_log` VALUES('249','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904563');
REPLACE INTO `retengcms_log` VALUES('250','admin','GET','file=category&action=edit&id=17','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904566');
REPLACE INTO `retengcms_log` VALUES('251','admin','POST','file=category&action=edit&id=17','http://vip.reteng.org/admin.php?file=category&action=edit&id=17','120.1.150.186','1413904591');
REPLACE INTO `retengcms_log` VALUES('252','admin','GET','file=category&action=edit&id=17','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904594');
REPLACE INTO `retengcms_log` VALUES('253','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904599');
REPLACE INTO `retengcms_log` VALUES('254','admin','GET','file=category&action=edit&id=20','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904603');
REPLACE INTO `retengcms_log` VALUES('255','admin','POST','file=category&action=edit&id=20','http://vip.reteng.org/admin.php?file=category&action=edit&id=20','120.1.150.186','1413904616');
REPLACE INTO `retengcms_log` VALUES('256','admin','GET','file=category&action=edit&id=20','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904618');
REPLACE INTO `retengcms_log` VALUES('257','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904622');
REPLACE INTO `retengcms_log` VALUES('258','admin','GET','file=category&action=edit&id=21','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904626');
REPLACE INTO `retengcms_log` VALUES('259','admin','POST','file=category&action=edit&id=21','http://vip.reteng.org/admin.php?file=category&action=edit&id=21','120.1.150.186','1413904651');
REPLACE INTO `retengcms_log` VALUES('260','admin','GET','file=category&action=edit&id=21','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904653');
REPLACE INTO `retengcms_log` VALUES('261','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904655');
REPLACE INTO `retengcms_log` VALUES('262','admin','GET','file=category&action=edit&id=22','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904659');
REPLACE INTO `retengcms_log` VALUES('263','admin','POST','file=category&action=edit&id=22','http://vip.reteng.org/admin.php?file=category&action=edit&id=22','120.1.150.186','1413904710');
REPLACE INTO `retengcms_log` VALUES('264','admin','GET','file=category&action=edit&id=22','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904713');
REPLACE INTO `retengcms_log` VALUES('265','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904734');
REPLACE INTO `retengcms_log` VALUES('266','admin','GET','file=category&action=edit&id=19','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904738');
REPLACE INTO `retengcms_log` VALUES('267','admin','POST','file=category&action=edit&id=19','http://vip.reteng.org/admin.php?file=category&action=edit&id=19','120.1.150.186','1413904753');
REPLACE INTO `retengcms_log` VALUES('268','admin','GET','file=category&action=edit&id=19','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904755');
REPLACE INTO `retengcms_log` VALUES('269','admin','POST','file=category&action=edit&id=19','http://vip.reteng.org/admin.php?file=category&action=edit&id=19','120.1.150.186','1413904759');
REPLACE INTO `retengcms_log` VALUES('270','admin','GET','file=category&action=edit&id=19','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904761');
REPLACE INTO `retengcms_log` VALUES('271','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904774');
REPLACE INTO `retengcms_log` VALUES('272','admin','GET','file=category&action=edit&id=20','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904784');
REPLACE INTO `retengcms_log` VALUES('273','admin','POST','file=category&action=edit&id=20','http://vip.reteng.org/admin.php?file=category&action=edit&id=20','120.1.150.186','1413904788');
REPLACE INTO `retengcms_log` VALUES('274','admin','GET','file=category&action=edit&id=20','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904790');
REPLACE INTO `retengcms_log` VALUES('275','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904798');
REPLACE INTO `retengcms_log` VALUES('276','admin','GET','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904806');
REPLACE INTO `retengcms_log` VALUES('277','admin','POST','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=edit&id=14','120.1.150.186','1413904811');
REPLACE INTO `retengcms_log` VALUES('278','admin','GET','file=category&action=edit&id=14','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904814');
REPLACE INTO `retengcms_log` VALUES('279','游客','GET','file=login','','180.153.206.19','1413904820');
REPLACE INTO `retengcms_log` VALUES('280','admin','GET','file=category&action=manage','http://vip.reteng.org/admin.php?file=left&menu=category','120.1.150.186','1413904840');
REPLACE INTO `retengcms_log` VALUES('281','admin','GET','file=category&action=edit&id=18','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904843');
REPLACE INTO `retengcms_log` VALUES('282','admin','POST','file=category&action=edit&id=18','http://vip.reteng.org/admin.php?file=category&action=edit&id=18','120.1.150.186','1413904847');
REPLACE INTO `retengcms_log` VALUES('283','admin','GET','file=category&action=edit&id=18','http://vip.reteng.org/admin.php?file=category&action=manage','120.1.150.186','1413904849');
REPLACE INTO `retengcms_log` VALUES('284','游客','GET','file=login','','101.226.65.104','1413904873');
REPLACE INTO `retengcms_log` VALUES('285','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left&menu=system','120.1.150.186','1413904889');
REPLACE INTO `retengcms_log` VALUES('286','游客','GET','file=login','','101.226.66.192','1413904895');
REPLACE INTO `retengcms_log` VALUES('287','admin','POST','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=config&action=config&tab=1','120.1.150.186','1413905157');
REPLACE INTO `retengcms_log` VALUES('288','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left&menu=system','120.1.150.186','1413905159');
REPLACE INTO `retengcms_log` VALUES('289','admin','GET','file=html&action=all','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413905164');
REPLACE INTO `retengcms_log` VALUES('290','admin','GET','file=html&action=cache','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413905168');
REPLACE INTO `retengcms_log` VALUES('291','admin','GET','file=html&action=all','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413905171');
REPLACE INTO `retengcms_log` VALUES('292','admin','POST','file=html&action=all','http://vip.reteng.org/admin.php?file=html&action=all','120.1.150.186','1413905172');
REPLACE INTO `retengcms_log` VALUES('293','admin','GET','file=html&action=cache&job=cache','http://vip.reteng.org/admin.php?file=html&action=all','120.1.150.186','1413905174');
REPLACE INTO `retengcms_log` VALUES('294','admin','GET','file=html&action=index&job=index','http://vip.reteng.org/admin.php?file=html&action=cache&job=cache','120.1.150.186','1413905176');
REPLACE INTO `retengcms_log` VALUES('295','admin','GET','file=html&action=category&do_submit=1&job=cat&catid=1','http://vip.reteng.org/admin.php?file=html&action=index&job=index','120.1.150.186','1413905177');
REPLACE INTO `retengcms_log` VALUES('296','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat&catid=1','120.1.150.186','1413905178');
REPLACE INTO `retengcms_log` VALUES('297','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413905179');
REPLACE INTO `retengcms_log` VALUES('298','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413905179');
REPLACE INTO `retengcms_log` VALUES('299','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413905180');
REPLACE INTO `retengcms_log` VALUES('300','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413905181');
REPLACE INTO `retengcms_log` VALUES('301','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413905181');
REPLACE INTO `retengcms_log` VALUES('302','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413905182');
REPLACE INTO `retengcms_log` VALUES('303','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413905183');
REPLACE INTO `retengcms_log` VALUES('304','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413905183');
REPLACE INTO `retengcms_log` VALUES('305','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413905184');
REPLACE INTO `retengcms_log` VALUES('306','admin','GET','file=html&action=content&do_submit=1&job=con&catid=1&type=all&pagesize=50','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413905185');
REPLACE INTO `retengcms_log` VALUES('307','admin','GET','file=html&action=content&do_submit=1&inlink=0&count=0&pagesize=50&job=con','http://vip.reteng.org/admin.php?file=html&action=content&do_submit=1&job=con&catid=1&type=all&pagesize=50','120.1.150.186','1413905186');
REPLACE INTO `retengcms_log` VALUES('308','admin','GET','file=html&action=rss&job=rss','http://vip.reteng.org/admin.php?file=html&action=content&do_submit=1&inlink=0&count=0&pagesize=50&job=con','120.1.150.186','1413905188');
REPLACE INTO `retengcms_log` VALUES('309','admin','GET','file=html&action=all','http://vip.reteng.org/admin.php?file=html&action=rss&job=rss','120.1.150.186','1413905189');
REPLACE INTO `retengcms_log` VALUES('310','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left&menu=system','120.1.150.186','1413905222');
REPLACE INTO `retengcms_log` VALUES('311','admin','POST','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=config&action=config&tab=1','120.1.150.186','1413905227');
REPLACE INTO `retengcms_log` VALUES('312','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left&menu=system','120.1.150.186','1413905229');
REPLACE INTO `retengcms_log` VALUES('313','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413905277');
REPLACE INTO `retengcms_log` VALUES('314','admin','POST','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413905279');
REPLACE INTO `retengcms_log` VALUES('315','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413905280');
REPLACE INTO `retengcms_log` VALUES('316','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905281');
REPLACE INTO `retengcms_log` VALUES('317','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905281');
REPLACE INTO `retengcms_log` VALUES('318','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905283');
REPLACE INTO `retengcms_log` VALUES('319','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905284');
REPLACE INTO `retengcms_log` VALUES('320','游客','GET','file=login','','101.226.65.105','1413905285');
REPLACE INTO `retengcms_log` VALUES('321','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905285');
REPLACE INTO `retengcms_log` VALUES('322','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905286');
REPLACE INTO `retengcms_log` VALUES('323','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905287');
REPLACE INTO `retengcms_log` VALUES('324','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905288');
REPLACE INTO `retengcms_log` VALUES('325','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905289');
REPLACE INTO `retengcms_log` VALUES('326','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905291');
REPLACE INTO `retengcms_log` VALUES('327','admin','POST','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413905301');
REPLACE INTO `retengcms_log` VALUES('328','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413905302');
REPLACE INTO `retengcms_log` VALUES('329','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905303');
REPLACE INTO `retengcms_log` VALUES('330','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413905305');
REPLACE INTO `retengcms_log` VALUES('331','游客','GET','file=login','','101.226.33.218','1413905315');
REPLACE INTO `retengcms_log` VALUES('332','游客','GET','file=login','','101.226.33.218','1413905426');
REPLACE INTO `retengcms_log` VALUES('333','游客','GET','file=login','','112.64.235.250','1413905860');
REPLACE INTO `retengcms_log` VALUES('334','admin','GET','file=top','http://vip.reteng.org/admin.php','120.1.150.186','1413906218');
REPLACE INTO `retengcms_log` VALUES('335','admin','GET','file=main','http://vip.reteng.org/admin.php','120.1.150.186','1413906219');
REPLACE INTO `retengcms_log` VALUES('336','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left','120.1.150.186','1413906223');
REPLACE INTO `retengcms_log` VALUES('337','admin','POST','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=config&action=config&tab=1','120.1.150.186','1413906232');
REPLACE INTO `retengcms_log` VALUES('338','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left','120.1.150.186','1413906234');
REPLACE INTO `retengcms_log` VALUES('339','admin','GET','file=main','http://vip.reteng.org/admin.php','120.1.150.186','1413906242');
REPLACE INTO `retengcms_log` VALUES('340','admin','GET','file=top','http://vip.reteng.org/admin.php','120.1.150.186','1413906242');
REPLACE INTO `retengcms_log` VALUES('341','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413906248');
REPLACE INTO `retengcms_log` VALUES('342','admin','POST','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413906250');
REPLACE INTO `retengcms_log` VALUES('343','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413906252');
REPLACE INTO `retengcms_log` VALUES('344','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413906253');
REPLACE INTO `retengcms_log` VALUES('345','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413906256');
REPLACE INTO `retengcms_log` VALUES('346','admin','GET','file=html&action=index','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413906258');
REPLACE INTO `retengcms_log` VALUES('347','游客','GET','file=login','','112.64.235.89','1413906292');
REPLACE INTO `retengcms_log` VALUES('348','游客','GET','file=login','','180.153.206.37','1413906305');
REPLACE INTO `retengcms_log` VALUES('349','游客','GET','file=login','','180.153.201.214','1413906434');
REPLACE INTO `retengcms_log` VALUES('350','游客','GET','file=login','','101.226.33.238','1413906447');
REPLACE INTO `retengcms_log` VALUES('351','游客','GET','file=login&action=logout','http://vip.reteng.org/admin.php?file=top','180.153.206.35','1413906454');
REPLACE INTO `retengcms_log` VALUES('352','游客','GET','file=login&action=logout','http://vip.reteng.org/admin.php?file=top','120.1.150.186','1413906454');
REPLACE INTO `retengcms_log` VALUES('353','游客','GET','file=login','http://vip.reteng.org/admin.php?file=login&action=logout','120.1.150.186','1413906456');
REPLACE INTO `retengcms_log` VALUES('354','游客','GET','file=login','','180.153.206.35','1413906468');
REPLACE INTO `retengcms_log` VALUES('355','游客','GET','file=login','','101.226.51.227','1413906522');
REPLACE INTO `retengcms_log` VALUES('356','游客','GET','file=login','','180.153.163.187','1413907048');
REPLACE INTO `retengcms_log` VALUES('357','游客','GET','file=login','http://vip.reteng.org/admin.php?file=left&menu=system','120.1.150.186','1413908080');
REPLACE INTO `retengcms_log` VALUES('358','游客','POST','file=login','http://vip.reteng.org/admin.php?file=login','120.1.150.186','1413908089');
REPLACE INTO `retengcms_log` VALUES('359','admin','GET','file=top','http://vip.reteng.org/admin.php','120.1.150.186','1413908091');
REPLACE INTO `retengcms_log` VALUES('360','admin','GET','file=main','http://vip.reteng.org/admin.php','120.1.150.186','1413908092');
REPLACE INTO `retengcms_log` VALUES('361','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left','120.1.150.186','1413908094');
REPLACE INTO `retengcms_log` VALUES('362','admin','POST','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=config&action=config&tab=1','120.1.150.186','1413908103');
REPLACE INTO `retengcms_log` VALUES('363','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left','120.1.150.186','1413908122');
REPLACE INTO `retengcms_log` VALUES('364','admin','POST','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=config&action=config&tab=1','120.1.150.186','1413908150');
REPLACE INTO `retengcms_log` VALUES('365','admin','GET','file=config&action=config&tab=1','http://vip.reteng.org/admin.php?file=left','120.1.150.186','1413908154');
REPLACE INTO `retengcms_log` VALUES('366','admin','GET','file=html&action=cache','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413908170');
REPLACE INTO `retengcms_log` VALUES('367','admin','GET','file=html&action=all','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413908172');
REPLACE INTO `retengcms_log` VALUES('368','admin','POST','file=html&action=all','http://vip.reteng.org/admin.php?file=html&action=all','120.1.150.186','1413908174');
REPLACE INTO `retengcms_log` VALUES('369','admin','GET','file=html&action=cache&job=cache','http://vip.reteng.org/admin.php?file=html&action=all','120.1.150.186','1413908175');
REPLACE INTO `retengcms_log` VALUES('370','admin','GET','file=html&action=index&job=index','http://vip.reteng.org/admin.php?file=html&action=cache&job=cache','120.1.150.186','1413908176');
REPLACE INTO `retengcms_log` VALUES('371','admin','GET','file=html&action=category&do_submit=1&job=cat&catid=1','http://vip.reteng.org/admin.php?file=html&action=index&job=index','120.1.150.186','1413908177');
REPLACE INTO `retengcms_log` VALUES('372','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat&catid=1','120.1.150.186','1413908179');
REPLACE INTO `retengcms_log` VALUES('373','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413908180');
REPLACE INTO `retengcms_log` VALUES('374','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413908181');
REPLACE INTO `retengcms_log` VALUES('375','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413908182');
REPLACE INTO `retengcms_log` VALUES('376','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413908183');
REPLACE INTO `retengcms_log` VALUES('377','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413908184');
REPLACE INTO `retengcms_log` VALUES('378','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413908185');
REPLACE INTO `retengcms_log` VALUES('379','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413908186');
REPLACE INTO `retengcms_log` VALUES('380','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413908187');
REPLACE INTO `retengcms_log` VALUES('381','admin','GET','file=html&action=category&do_submit=1&job=cat','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413908190');
REPLACE INTO `retengcms_log` VALUES('382','admin','GET','file=html&action=content&do_submit=1&job=con&catid=1&type=all&pagesize=50','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=cat','120.1.150.186','1413908192');
REPLACE INTO `retengcms_log` VALUES('383','admin','GET','file=html&action=content&do_submit=1&inlink=0&count=0&pagesize=50&job=con','http://vip.reteng.org/admin.php?file=html&action=content&do_submit=1&job=con&catid=1&type=all&pagesize=50','120.1.150.186','1413908193');
REPLACE INTO `retengcms_log` VALUES('384','admin','GET','file=html&action=rss&job=rss','http://vip.reteng.org/admin.php?file=html&action=content&do_submit=1&inlink=0&count=0&pagesize=50&job=con','120.1.150.186','1413908195');
REPLACE INTO `retengcms_log` VALUES('385','admin','GET','file=html&action=all','http://vip.reteng.org/admin.php?file=html&action=rss&job=rss','120.1.150.186','1413908197');
REPLACE INTO `retengcms_log` VALUES('386','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413908289');
REPLACE INTO `retengcms_log` VALUES('387','admin','POST','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413908296');
REPLACE INTO `retengcms_log` VALUES('388','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413908297');
REPLACE INTO `retengcms_log` VALUES('389','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413908298');
REPLACE INTO `retengcms_log` VALUES('390','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413908300');
REPLACE INTO `retengcms_log` VALUES('391','admin','POST','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413908302');
REPLACE INTO `retengcms_log` VALUES('392','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413908303');
REPLACE INTO `retengcms_log` VALUES('393','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413908303');
REPLACE INTO `retengcms_log` VALUES('394','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413908305');
REPLACE INTO `retengcms_log` VALUES('395','admin','GET','file=html&action=index','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413908306');
REPLACE INTO `retengcms_log` VALUES('396','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=left&menu=html','120.1.150.186','1413908354');
REPLACE INTO `retengcms_log` VALUES('397','admin','POST','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413908357');
REPLACE INTO `retengcms_log` VALUES('398','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413908358');
REPLACE INTO `retengcms_log` VALUES('399','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413908359');
REPLACE INTO `retengcms_log` VALUES('400','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413908361');
REPLACE INTO `retengcms_log` VALUES('401','admin','POST','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413908444');
REPLACE INTO `retengcms_log` VALUES('402','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category','120.1.150.186','1413908444');
REPLACE INTO `retengcms_log` VALUES('403','admin','GET','file=html&action=category&do_submit=1&job=','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413908445');
REPLACE INTO `retengcms_log` VALUES('404','admin','GET','file=html&action=category','http://vip.reteng.org/admin.php?file=html&action=category&do_submit=1&job=','120.1.150.186','1413908446');
REPLACE INTO `retengcms_log` VALUES('405','游客','GET','file=login','','101.226.66.181','1413909377');
REPLACE INTO `retengcms_log` VALUES('406','游客','GET','file=login','http://vip.reteng.org/admin.php','120.1.150.186','1413977931');
REPLACE INTO `retengcms_log` VALUES('407','游客','POST','file=login','http://vip.reteng.org/admin.php?file=login','120.1.150.186','1413977942');
REPLACE INTO `retengcms_log` VALUES('408','admin','GET','file=top','http://vip.reteng.org/admin.php','120.1.150.186','1413977945');
REPLACE INTO `retengcms_log` VALUES('409','admin','GET','file=main','http://vip.reteng.org/admin.php','120.1.150.186','1413977946');
REPLACE INTO `retengcms_log` VALUES('410','admin','GET','file=db&action=export','http://vip.reteng.org/admin.php?file=left','120.1.150.186','1413977968');
REPLACE INTO `retengcms_log` VALUES('411','admin','POST','file=db&action=export','http://vip.reteng.org/admin.php?file=db&action=export','120.1.150.186','1413977973');
REPLACE INTO `retengcms_log` VALUES('412','游客','GET','file=login','http://127.0.0.1/admin.php','127.0.0.1','1413983667');
REPLACE INTO `retengcms_log` VALUES('413','游客','POST','file=login','http://127.0.0.1/admin.php?file=login','127.0.0.1','1413983674');
REPLACE INTO `retengcms_log` VALUES('414','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413983678');
REPLACE INTO `retengcms_log` VALUES('415','admin','GET','file=top','http://127.0.0.1/admin.php','127.0.0.1','1413983679');
REPLACE INTO `retengcms_log` VALUES('416','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983685');
REPLACE INTO `retengcms_log` VALUES('417','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413983690');
REPLACE INTO `retengcms_log` VALUES('418','admin','POST','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=config&action=config&tab=1','127.0.0.1','1413983709');
REPLACE INTO `retengcms_log` VALUES('419','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413983712');
REPLACE INTO `retengcms_log` VALUES('420','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983719');
REPLACE INTO `retengcms_log` VALUES('421','admin','GET','file=category&action=edit&id=18','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983722');
REPLACE INTO `retengcms_log` VALUES('422','admin','GET','file=category&action=edit&id=18','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983723');
REPLACE INTO `retengcms_log` VALUES('423','admin','POST','file=category&action=edit&id=18','http://127.0.0.1/admin.php?file=category&action=edit&id=18','127.0.0.1','1413983729');
REPLACE INTO `retengcms_log` VALUES('424','admin','GET','file=category&action=edit&id=18','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983732');
REPLACE INTO `retengcms_log` VALUES('425','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983734');
REPLACE INTO `retengcms_log` VALUES('426','admin','GET','file=category&action=edit&id=14','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983738');
REPLACE INTO `retengcms_log` VALUES('427','admin','POST','file=category&action=edit&id=14','http://127.0.0.1/admin.php?file=category&action=edit&id=14','127.0.0.1','1413983745');
REPLACE INTO `retengcms_log` VALUES('428','admin','GET','file=category&action=edit&id=14','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983748');
REPLACE INTO `retengcms_log` VALUES('429','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983750');
REPLACE INTO `retengcms_log` VALUES('430','admin','GET','file=category&action=edit&id=15','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983753');
REPLACE INTO `retengcms_log` VALUES('431','admin','POST','file=category&action=edit&id=15','http://127.0.0.1/admin.php?file=category&action=edit&id=15','127.0.0.1','1413983761');
REPLACE INTO `retengcms_log` VALUES('432','admin','GET','file=category&action=edit&id=15','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983763');
REPLACE INTO `retengcms_log` VALUES('433','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983766');
REPLACE INTO `retengcms_log` VALUES('434','admin','GET','file=category&action=edit&id=16','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983769');
REPLACE INTO `retengcms_log` VALUES('435','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983774');
REPLACE INTO `retengcms_log` VALUES('436','admin','GET','file=category&action=edit&id=17','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983778');
REPLACE INTO `retengcms_log` VALUES('437','admin','POST','file=category&action=edit&id=17','http://127.0.0.1/admin.php?file=category&action=edit&id=17','127.0.0.1','1413983785');
REPLACE INTO `retengcms_log` VALUES('438','admin','GET','file=category&action=edit&id=17','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983787');
REPLACE INTO `retengcms_log` VALUES('439','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983789');
REPLACE INTO `retengcms_log` VALUES('440','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983793');
REPLACE INTO `retengcms_log` VALUES('441','admin','POST','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=edit&id=20','127.0.0.1','1413983806');
REPLACE INTO `retengcms_log` VALUES('442','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983809');
REPLACE INTO `retengcms_log` VALUES('443','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983813');
REPLACE INTO `retengcms_log` VALUES('444','admin','GET','file=category&action=edit&id=21','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983817');
REPLACE INTO `retengcms_log` VALUES('445','admin','POST','file=category&action=edit&id=21','http://127.0.0.1/admin.php?file=category&action=edit&id=21','127.0.0.1','1413983822');
REPLACE INTO `retengcms_log` VALUES('446','admin','GET','file=category&action=edit&id=21','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983824');
REPLACE INTO `retengcms_log` VALUES('447','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983853');
REPLACE INTO `retengcms_log` VALUES('448','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983854');
REPLACE INTO `retengcms_log` VALUES('449','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983857');
REPLACE INTO `retengcms_log` VALUES('450','admin','POST','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=edit&id=19','127.0.0.1','1413983863');
REPLACE INTO `retengcms_log` VALUES('451','admin','GET','file=category&action=edit&id=19','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983866');
REPLACE INTO `retengcms_log` VALUES('452','admin','GET','file=html&action=cache','http://127.0.0.1/admin.php?file=left&menu=html','127.0.0.1','1413983903');
REPLACE INTO `retengcms_log` VALUES('453','admin','GET','file=html&action=cache_template','http://127.0.0.1/admin.php?file=left&menu=html','127.0.0.1','1413983905');
REPLACE INTO `retengcms_log` VALUES('454','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983936');
REPLACE INTO `retengcms_log` VALUES('455','admin','GET','file=category&action=edit&id=21','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983941');
REPLACE INTO `retengcms_log` VALUES('456','admin','POST','file=category&action=edit&id=21','http://127.0.0.1/admin.php?file=category&action=edit&id=21','127.0.0.1','1413983946');
REPLACE INTO `retengcms_log` VALUES('457','admin','GET','file=category&action=edit&id=21','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983949');
REPLACE INTO `retengcms_log` VALUES('458','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413983951');
REPLACE INTO `retengcms_log` VALUES('459','admin','GET','file=category&action=edit&id=22','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983955');
REPLACE INTO `retengcms_log` VALUES('460','admin','POST','file=category&action=edit&id=22','http://127.0.0.1/admin.php?file=category&action=edit&id=22','127.0.0.1','1413983960');
REPLACE INTO `retengcms_log` VALUES('461','admin','GET','file=category&action=edit&id=22','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413983962');
REPLACE INTO `retengcms_log` VALUES('462','admin','GET','file=html&action=cache','http://127.0.0.1/admin.php?file=left&menu=html','127.0.0.1','1413983966');
REPLACE INTO `retengcms_log` VALUES('463','admin','GET','file=html&action=cache_template','http://127.0.0.1/admin.php?file=left&menu=html','127.0.0.1','1413983968');
REPLACE INTO `retengcms_log` VALUES('464','admin','GET','file=html&action=cache_tag','http://127.0.0.1/admin.php?file=left&menu=html','127.0.0.1','1413983970');
REPLACE INTO `retengcms_log` VALUES('465','admin','GET','file=html&action=cache_tag','http://127.0.0.1/admin.php?file=left&menu=html','127.0.0.1','1413984006');
REPLACE INTO `retengcms_log` VALUES('466','admin','GET','file=html&action=cache','http://127.0.0.1/admin.php?file=left&menu=html','127.0.0.1','1413984008');
REPLACE INTO `retengcms_log` VALUES('467','admin','GET','file=html&action=cache','http://127.0.0.1/admin.php?file=left&menu=html','127.0.0.1','1413984011');
REPLACE INTO `retengcms_log` VALUES('468','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413984114');
REPLACE INTO `retengcms_log` VALUES('469','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413984147');
REPLACE INTO `retengcms_log` VALUES('470','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413984202');
REPLACE INTO `retengcms_log` VALUES('471','admin','POST','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=config&action=config&tab=1','127.0.0.1','1413984212');
REPLACE INTO `retengcms_log` VALUES('472','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413984214');
REPLACE INTO `retengcms_log` VALUES('473','admin','GET','file=category&action=manage','http://127.0.0.1/admin.php?file=left&menu=category','127.0.0.1','1413984284');
REPLACE INTO `retengcms_log` VALUES('474','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413984342');
REPLACE INTO `retengcms_log` VALUES('475','admin','POST','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=edit&id=20','127.0.0.1','1413984476');
REPLACE INTO `retengcms_log` VALUES('476','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413984479');
REPLACE INTO `retengcms_log` VALUES('477','admin','POST','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=edit&id=20','127.0.0.1','1413984493');
REPLACE INTO `retengcms_log` VALUES('478','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413984497');
REPLACE INTO `retengcms_log` VALUES('479','admin','POST','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=edit&id=20','127.0.0.1','1413984515');
REPLACE INTO `retengcms_log` VALUES('480','admin','GET','file=category&action=edit&id=20','http://127.0.0.1/admin.php?file=category&action=manage','127.0.0.1','1413984517');
REPLACE INTO `retengcms_log` VALUES('481','admin','GET','file=content&action=manage&catid=16','http://127.0.0.1/admin.php?file=left&menu=content','127.0.0.1','1413984620');
REPLACE INTO `retengcms_log` VALUES('482','admin','GET','file=content&action=add&catid=16','http://127.0.0.1/admin.php?file=content&action=manage&catid=16','127.0.0.1','1413984622');
REPLACE INTO `retengcms_log` VALUES('483','admin','POST','file=content&action=add','http://127.0.0.1/admin.php?file=content&action=add&catid=16','127.0.0.1','1413984761');
REPLACE INTO `retengcms_log` VALUES('484','admin','GET','file=content&action=add&catid=16','http://127.0.0.1/admin.php?file=content&action=add','127.0.0.1','1413984763');
REPLACE INTO `retengcms_log` VALUES('485','admin','GET','file=content&action=manage&catid=16','http://127.0.0.1/admin.php?file=left&menu=content','127.0.0.1','1413984778');
REPLACE INTO `retengcms_log` VALUES('486','admin','GET','file=content&action=edit&catid=16&id=1','http://127.0.0.1/admin.php?file=content&action=manage&catid=16','127.0.0.1','1413984781');
REPLACE INTO `retengcms_log` VALUES('487','admin','POST','file=content&action=edit','http://127.0.0.1/admin.php?file=content&action=edit&catid=16&id=1','127.0.0.1','1413984795');
REPLACE INTO `retengcms_log` VALUES('488','admin','GET','file=content&action=manage&catid=16','http://127.0.0.1/admin.php?file=content&action=edit','127.0.0.1','1413984798');
REPLACE INTO `retengcms_log` VALUES('489','admin','GET','file=content&action=edit&catid=16&id=1','http://127.0.0.1/admin.php?file=content&action=manage&catid=16','127.0.0.1','1413984808');
REPLACE INTO `retengcms_log` VALUES('490','admin','POST','file=content&action=edit','http://127.0.0.1/admin.php?file=content&action=edit&catid=16&id=1','127.0.0.1','1413984903');
REPLACE INTO `retengcms_log` VALUES('491','admin','GET','file=content&action=manage&catid=16','http://127.0.0.1/admin.php?file=content&action=edit','127.0.0.1','1413984905');
REPLACE INTO `retengcms_log` VALUES('492','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413985372');
REPLACE INTO `retengcms_log` VALUES('493','admin','POST','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=config&action=config&tab=1','127.0.0.1','1413985384');
REPLACE INTO `retengcms_log` VALUES('494','admin','GET','file=config&action=config&tab=1','http://127.0.0.1/admin.php?file=left&menu=system','127.0.0.1','1413985386');
REPLACE INTO `retengcms_log` VALUES('495','admin','GET','file=content&action=manage&catid=15','http://127.0.0.1/admin.php?file=left&menu=content','127.0.0.1','1413985879');
REPLACE INTO `retengcms_log` VALUES('496','admin','GET','file=content&action=add&catid=15','http://127.0.0.1/admin.php?file=content&action=manage&catid=15','127.0.0.1','1413985882');
REPLACE INTO `retengcms_log` VALUES('497','admin','POST','file=content&action=add','http://127.0.0.1/admin.php?file=content&action=add&catid=15','127.0.0.1','1413986020');
REPLACE INTO `retengcms_log` VALUES('498','admin','GET','file=content&action=add&catid=15','http://127.0.0.1/admin.php?file=content&action=add','127.0.0.1','1413986022');
REPLACE INTO `retengcms_log` VALUES('499','admin','GET','file=content&action=manage&catid=15','http://127.0.0.1/admin.php?file=left&menu=content','127.0.0.1','1413986044');
REPLACE INTO `retengcms_log` VALUES('500','admin','GET','file=content&action=edit&catid=15&id=2','http://127.0.0.1/admin.php?file=content&action=manage&catid=15','127.0.0.1','1413986047');
REPLACE INTO `retengcms_log` VALUES('501','admin','POST','file=content&action=edit','http://127.0.0.1/admin.php?file=content&action=edit&catid=15&id=2','127.0.0.1','1413986097');
REPLACE INTO `retengcms_log` VALUES('502','admin','GET','file=content&action=manage&catid=15','http://127.0.0.1/admin.php?file=content&action=edit','127.0.0.1','1413986101');
REPLACE INTO `retengcms_log` VALUES('503','admin','GET','file=content&action=edit&catid=15&id=2','http://127.0.0.1/admin.php?file=content&action=manage&catid=15','127.0.0.1','1413986107');
REPLACE INTO `retengcms_log` VALUES('504','admin','POST','file=content&action=edit','http://127.0.0.1/admin.php?file=content&action=edit&catid=15&id=2','127.0.0.1','1413986139');
REPLACE INTO `retengcms_log` VALUES('505','admin','GET','file=content&action=manage&catid=15','http://127.0.0.1/admin.php?file=content&action=edit','127.0.0.1','1413986143');
REPLACE INTO `retengcms_log` VALUES('506','admin','GET','file=content&action=edit&catid=15&id=2','http://127.0.0.1/admin.php?file=content&action=manage&catid=15','127.0.0.1','1413986160');
REPLACE INTO `retengcms_log` VALUES('507','admin','POST','file=content&action=edit','http://127.0.0.1/admin.php?file=content&action=edit&catid=15&id=2','127.0.0.1','1413986215');
REPLACE INTO `retengcms_log` VALUES('508','admin','GET','file=content&action=manage&catid=15','http://127.0.0.1/admin.php?file=content&action=edit','127.0.0.1','1413986217');
REPLACE INTO `retengcms_log` VALUES('509','admin','GET','file=main','http://127.0.0.1/admin.php','127.0.0.1','1413986300');
REPLACE INTO `retengcms_log` VALUES('510','admin','GET','file=db&action=export','http://127.0.0.1/admin.php?file=left&module=index','127.0.0.1','1413986307');
REPLACE INTO `retengcms_log` VALUES('511','admin','POST','file=db&action=export','http://127.0.0.1/admin.php?file=db&action=export','127.0.0.1','1413986312');
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_member` VALUES('1','0','1','1','10','0','0','admin','a51a2412d417886b4dc37c6d150f305f','member/images/nophoto.gif','master@reteng.org','','0','0.00','5','1413983644','1413983644','0','127.0.0.1','1','0','');
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_memberhonor` VALUES('1','列兵','100','1','0');
REPLACE INTO `retengcms_memberhonor` VALUES('2','班长','200','2','0');
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
DROP TABLE IF EXISTS `retengcms_model`;
CREATE TABLE `retengcms_model` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `table` varchar(32) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `issystem` tinyint(1) NOT NULL DEFAULT '0',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `table` (`table`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_model` VALUES('1','文章','article','0','1','1');
DROP TABLE IF EXISTS `retengcms_model_fields`;
CREATE TABLE `retengcms_model_fields` (
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
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `modelid` (`modelid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_model_fields` VALUES('1','title','1','文章标题','title','','','','','','','','1','0','1','1','1');
REPLACE INTO `retengcms_model_fields` VALUES('2','style','1','字体颜色','style','','','','','','','','2','1','1','3','1');
REPLACE INTO `retengcms_model_fields` VALUES('3','thumb','1','封面图片','thumb','','','','','','','','3','0','1','2','1');
REPLACE INTO `retengcms_model_fields` VALUES('4','keywords','1','关键字','keywords','','','','','','','','11','0','1','1','1');
REPLACE INTO `retengcms_model_fields` VALUES('5','selectmenu_area','1','所属地区','areaid','','','','327','','','','101','1','1','1','1');
REPLACE INTO `retengcms_model_fields` VALUES('6','description','1','内容简介','description','','','','','','','','8','0','1','1','1');
REPLACE INTO `retengcms_model_fields` VALUES('7','posid','1','推荐位','posid','','','','','','','','9','0','1','3','1');
REPLACE INTO `retengcms_model_fields` VALUES('8','content','1','内容','content','','','','','','','','10','0','1','1','1');
REPLACE INTO `retengcms_model_fields` VALUES('9','status','1','发布状态','status','','','','1','','','8','100','0','1','3','1');
REPLACE INTO `retengcms_model_fields` VALUES('10','iscomment','1','评论状态','iscomment','','','','1','','','','96','0','1','3','1');
REPLACE INTO `retengcms_model_fields` VALUES('11','point','1','阅读点数','point','','点','','0','','','','97','1','1','2','1');
REPLACE INTO `retengcms_model_fields` VALUES('12','amount','1','阅读钱数','amount','','元','','0.0','','','','98','1','1','2','1');
REPLACE INTO `retengcms_model_fields` VALUES('13','author','1','责任编辑','editor','','','选项值|选项\r\n选项值|选项','','','','30','79','0','0','1','1');
REPLACE INTO `retengcms_model_fields` VALUES('14','copyfrom','1','稿件来源','copyfrom','','','选项值|选项\r\n选项值|选项','','','','100','80','0','0','2','1');
REPLACE INTO `retengcms_model_fields` VALUES('15','password','1','信息删除密码','password','针对游客有效，留空为屏蔽此功能!','','','','','','98','10','1','1','2','1');
REPLACE INTO `retengcms_model_fields` VALUES('16','expire','1','信息有效期','expire','0为不限!','天','','0','','','','99','1','1','2','1');
DROP TABLE IF EXISTS `retengcms_module`;
CREATE TABLE `retengcms_module` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `folder` varchar(10) NOT NULL,
  `author` varchar(60) NOT NULL,
  `site` varchar(100) NOT NULL,
  `version` varchar(10) NOT NULL,
  `tables` varchar(255) NOT NULL,
  `menu_admin` text NOT NULL,
  `menu_member` text NOT NULL,
  `agreement` mediumtext NOT NULL,
  `roleid` varchar(60) NOT NULL,
  `modelid` varchar(60) NOT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '0',
  `adminmenu` tinyint(1) NOT NULL DEFAULT '0',
  `adminonly` tinyint(1) NOT NULL DEFAULT '1',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `orderby` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `folder` (`folder`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_module` VALUES('1','会员管理','member','ReTengCMS内容管理系统','http://www.reteng.org/','1.0','retengcms_member,retengcms_member_cache,retengcms_membermodel,retengcms_membergrade,retengcms_membergroup,retengcms_memberhonor,retengcms_memberdb_fields,retengcms_message,retengcms_collect','?mod=member&file=member&action=cache|更新缓存\r\n?mod=member&file=member&action=setting|配置选项\r\n?mod=member&file=member&action=manage|会员管理\r\n?mod=member&file=member&action=group|会 员 组\r\n?mod=member&file=member&action=grade|会员级别\r\n?mod=member&file=member&action=honor|会员头衔\r\n?mod=member&file=member&action=model|会员模型\r\n?mod=member&file=member&action=message|系统信息','','本软件为自由软件, 你可以自由修改并使用。','1,2,3,4,5','1,2','1','0','1','0','本模块是由ReTengCMS官方开发的一款会员管理模块,可以实现会员注册等功能','1');
REPLACE INTO `retengcms_module` VALUES('2','个人空间','space','ReTengCMS内容管理系统','http://www.reteng.org/','1.0','retengcms_space,retengcms_space_comment,retengcms_space_newvisitor,retengcms_space_friends','?mod=space&file=space&action=manage|空间管理\r\n?mod=space&file=space&action=tagspace|空间调用\r\n?mod=space&file=space&action=tag|留言调用','member/index.php?mod=space&file=space&action=view|刷新空间\r\nmember/index.php?mod=space&file=space&action=info|空间设置\r\nmember/index.php?mod=space&file=space&action=template|模板样式\r\nmember/index.php?mod=space&file=space&action=guestbook|留言管理','本软件为自由软件, 你可以自由修改并使用。','1,2','1,2','0','0','0','0','本模块是由ReTengCMS内容管理系统开发的一款个人空间功能模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!\r\n网址:http://www.reteng.org/','9');
REPLACE INTO `retengcms_module` VALUES('3','友情链接','link','ReTengCMS内容管理系统','http://www.reteng.org/','1.0','retengcms_linktype,retengcms_link','?mod=link&file=link&action=cache|更新缓存\r\n?mod=link&file=link&action=type|友链类型\r\n?mod=link&file=link&action=type_add|添加类型\r\n?mod=link&file=link&action=tag|模板调用','','本软件为自由软件, 你可以自由修改并使用。','1,2','','1','0','1','0','本模块是由ReTengCMS内容管理系统开发的友情链接管理模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!\r\n网址:http://www.reteng.org/','5');
REPLACE INTO `retengcms_module` VALUES('4','在线投票','vote','ReTengCMS内容管理系统','http://www.reteng.org/','1.0','retengcms_vote,retengcms_vote_ip','?mod=vote&file=vote&action=manage|投票管理\r\n?mod=vote&file=vote&action=vote_add|添加投票','','本软件为自由软件, 你可以自由修改并使用。','1,2,3,4,5','','1','0','1','0','本模块是由ReTengCMS内容管理系统开发的一款在线投票模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!\r\n网址:http://www.reteng.org/','7');
REPLACE INTO `retengcms_module` VALUES('5','搜索模块','search','ReTengCMS内容管理系统','http://www.reteng.org/','1.0','retengcms_keywords','?mod=search&file=search&action=keywords|关键字管理','','本软件为自由软件, 你可以自由修改并使用。','1,2,3,4,5','1,2','1','0','1','0','本模块是由ReTengCMS内容管理系统开发的一款搜索功能模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!\r\n网址:http://www.reteng.org/','10');
REPLACE INTO `retengcms_module` VALUES('6','广告管理','adv','ReTengCMS内容管理系统','http://www.reteng.org/','1.0','retengcms_ads,retengcms_adspos','?mod=adv&file=ads&action=cache|更新缓存\r\n?mod=adv&file=ads&action=adspos|常规广告位\r\n?mod=adv&file=ads&action=adspos_add|添加广告位','','本软件为自由软件, 你可以自由修改并使用。','1,2,5','','0','0','1','0','本模块是由ReTengCMS内容管理系统开发的广告管理模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!\r\n网址:http://www.reteng.org/','4');
REPLACE INTO `retengcms_module` VALUES('7','文章tag标签','tags','热腾网','http://www.reteng.org/','1.0','retengcms_taglist,retengcms_tagindex','','','本软件为自由软件, 你可以自由修改并使用。','1,2,3,4,5','1,2','1','0','0','0','本模块是由ReTeng开发的一款ReTengCMS内容管理系统功能模块,感谢您的下载使用.本模块主要是方便网站tag提取，增强网站优化等作用\r\n网址:http://www.reteng.org/','8');
REPLACE INTO `retengcms_module` VALUES('8','在线投稿','post','ReTengCMS内容管理系统','http://www.reteng.org/','1.0','','?mod=post&file=post&action=config|配置选项','','本软件为自由软件, 你可以自由修改并使用。','1,2,3,4,5','1,2','1','0','1','0','本模块是由热腾内容管理系统开发的一款ReTengCMS内容管理系统功能模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!\r\n网址:http://www.reteng.org/','14');
REPLACE INTO `retengcms_module` VALUES('9','站外链接','workbox','热腾网','http://www.reteng.org','1.0','retengcms_workbox,retengcms_tools','?mod=workbox&file=workbox&action=workbox|工具管理\r\n?mod=workbox&file=workbox&action=tag|模板调用','','本软件为自由软件, 你可以自由修改并使用。','1,2,3,4,5','1,2','0','0','0','0','本模块可以是实现站内内容与设定的关键词相关联。从而有效的实现网站SEO外链增加！','12');
REPLACE INTO `retengcms_module` VALUES('10','订单支付','pay','热腾官方','http://www.reteng.org/','1.0','retengcms_pay_method,retengcms_pay_card,retengcms_pay_cardtype,retengcms_pay_log','?mod=pay&file=pay&action=paymethod|支付配置\r\n?mod=pay&file=pay&action=card|点卡管理\r\n?mod=pay&file=pay&action=cardtype|点卡类型\r\n?mod=pay&file=pay&action=log|财务日志\r\n?mod=pay&file=pay&action=member|会员充值\r\n?mod=pay&file=pay&action=order|订单查询\r\n?mod=pay&file=pay&action=paymethod_button|支付按钮','member/index.php?mod=pay&file=pay&action=online|在线充值\r\nmember/index.php?mod=pay&file=pay&action=card|点卡充值\r\nmember/index.php?mod=pay&file=pay&action=log|财务日志\r\nmember/index.php?mod=pay&file=pay&action=order|订单查询','本软件为自由软件, 你可以自由修改并使用。','1,5','1,2','0','0','0','0','本模块是由ReTengCMS官方开发支付功能模块，启用以后可以在模版中实现商品在线交易等功能','2');
REPLACE INTO `retengcms_module` VALUES('11','留言管理','guestbook','ReTengCMS内容管理系统','http://www.reteng.org/','1.0','retengcms_guestbook','?mod=guestbook&file=guestbook&action=manage&passed=1|已审留言\r\n?mod=guestbook&file=guestbook&action=manage&passed=0|待审留言','','本软件为自由软件, 你可以自由修改并使用。','1,2,3,4,5','','1','0','1','0','本模块是由ReTengCMS内容管理系统开发的一款留言管理模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!\r\n网址:http://www.reteng.org/','6');
REPLACE INTO `retengcms_module` VALUES('13','diy表单','form','热腾内容管理系统','http://www.reteng.org/','1.0','retengcms_form,retengcms_form_fields','?mod=form&file=form&action=manage|自定义表单\r\n?mod=form&file=form&action=add|添加表单','','本软件为自由软件, 你可以自由修改并使用。','1,2,3,4,5','1,2','0','0','1','0','本模块是由可以实现自定义表单数据，增强网站功能，例如：意见反馈，在线报名等功能！','16');
DROP TABLE IF EXISTS `retengcms_mood`;
CREATE TABLE `retengcms_mood` (
  `contentid` mediumint(8) NOT NULL,
  `surprise` mediumint(8) NOT NULL DEFAULT '0',
  `batting` mediumint(8) NOT NULL DEFAULT '0',
  `support` mediumint(8) NOT NULL DEFAULT '0',
  `great` mediumint(8) NOT NULL DEFAULT '0',
  `anger` mediumint(8) NOT NULL DEFAULT '0',
  `funny` mediumint(8) NOT NULL DEFAULT '0',
  `nausea` mediumint(8) NOT NULL DEFAULT '0',
  `puzzled` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_onlinereg`;
CREATE TABLE `retengcms_onlinereg` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_onlinereg` VALUES('1','张三');
DROP TABLE IF EXISTS `retengcms_order`;
CREATE TABLE `retengcms_order` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `sn` char(32) NOT NULL,
  `product` varchar(200) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `number` varchar(20) NOT NULL,
  `payment` smallint(4) NOT NULL,
  `shipment` smallint(4) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `buyuser` varchar(60) NOT NULL,
  `buyemail` varchar(60) NOT NULL,
  `buyphone` varchar(20) NOT NULL,
  `buyaddress` varchar(200) NOT NULL,
  `buymessage` text NOT NULL,
  `receiveuser` varchar(60) NOT NULL,
  `receivephone` varchar(20) NOT NULL,
  `receiveaddress` varchar(200) NOT NULL,
  `datetime` char(10) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `userid` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
REPLACE INTO `retengcms_pay_method` VALUES('1','alipay','支付宝','支付宝网站(www.alipay.com) 是国内先进的网上支付平台。\r\nReTengCMS联合支付宝推出支付宝接口。','0','array (\n  \'alipay_account\' => \'master@reteng.org\',\n  \'alipay_key\' => \'\',\n  \'alipay_partner\' => \'\',\n  \'service_type\' => \'0\',\n)','0','1','0','1','ReTengCMS','http://www.alipay.com','1.0.0');
REPLACE INTO `retengcms_pay_method` VALUES('2','post','邮局汇款','收款人信息：姓名 ××× ；地址 ××× ；邮编 ××× 。\r\n注意事项： 请在汇款单背面的附言中注明您的订单号，只填写后6位即可。','0','array (\n)','0','0','0','1','ReTengCMS','','1.0.0');
REPLACE INTO `retengcms_pay_method` VALUES('3','bank','银行汇款/转帐','银行名称\r\n收款人信息：全称 ××× ；帐号或地址 ××× ；开户行 ×××。\r\n注意事项：办理电汇时，请在电汇单“汇款用途”一栏处注明您的订单号。','0','array (\n)','0','0','0','1','ReTengCMS','','1.0.0');
DROP TABLE IF EXISTS `retengcms_permission`;
CREATE TABLE `retengcms_permission` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `parentid` smallint(6) NOT NULL,
  `name` varchar(60) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `roleid` varchar(80) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_permission` VALUES('1','0','系统配置','1','1,2,3');
REPLACE INTO `retengcms_permission` VALUES('2','1','网站配置','1','1,2');
REPLACE INTO `retengcms_permission` VALUES('3','1','管理员','1','1');
REPLACE INTO `retengcms_permission` VALUES('4','1','数据备份','1','1');
REPLACE INTO `retengcms_permission` VALUES('5','6','级联菜单','1','1,2,3');
REPLACE INTO `retengcms_permission` VALUES('6','0','栏目内容','1','1,2,3');
REPLACE INTO `retengcms_permission` VALUES('7','6','栏目单页','1','1,2,3,4');
REPLACE INTO `retengcms_permission` VALUES('8','0','更新网站','1','1,2,3,4');
REPLACE INTO `retengcms_permission` VALUES('9','0','内容管理','1','1,2,3');
REPLACE INTO `retengcms_permission` VALUES('10','0','模板管理','1','1,4');
REPLACE INTO `retengcms_permission` VALUES('11','10','模板方案','1','1,4');
REPLACE INTO `retengcms_permission` VALUES('12','10','内容调用','1','1,4');
REPLACE INTO `retengcms_permission` VALUES('13','0','模块插件','1','1,2,3');
REPLACE INTO `retengcms_permission` VALUES('14','13','功能模块','1','1,2,3');
REPLACE INTO `retengcms_permission` VALUES('15','13','插件管理','1','1,2,3');
REPLACE INTO `retengcms_permission` VALUES('16','13','内容模型','1','1,2,3');
DROP TABLE IF EXISTS `retengcms_posid`;
CREATE TABLE `retengcms_posid` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `orderby` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_posid` VALUES('1','首页头条','1');
REPLACE INTO `retengcms_posid` VALUES('2','栏目页推荐','2');
REPLACE INTO `retengcms_posid` VALUES('3','内容页推荐','3');
REPLACE INTO `retengcms_posid` VALUES('4','置顶信息','4');
REPLACE INTO `retengcms_posid` VALUES('5','切换焦点图','5');
DROP TABLE IF EXISTS `retengcms_regular`;
CREATE TABLE `retengcms_regular` (
  `userid` mediumint(8) NOT NULL,
  `realname` varchar(30) NOT NULL,
  `dianhua` varchar(30) NOT NULL,
  `qq` varchar(30) NOT NULL,
  `dizhi` varchar(200) NOT NULL,
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_regular` VALUES('1','','','','');
REPLACE INTO `retengcms_regular` VALUES('2','','','','');
REPLACE INTO `retengcms_regular` VALUES('1','','','','');
REPLACE INTO `retengcms_regular` VALUES('1','','','','');
REPLACE INTO `retengcms_regular` VALUES('1','','','','');
REPLACE INTO `retengcms_regular` VALUES('1','','','','');
REPLACE INTO `retengcms_regular` VALUES('1','','','','');
REPLACE INTO `retengcms_regular` VALUES('1','','','','');
REPLACE INTO `retengcms_regular` VALUES('1','','','','');
DROP TABLE IF EXISTS `retengcms_role`;
CREATE TABLE `retengcms_role` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `orderby` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `issystem` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_role` VALUES('1','超级管理员','1','1','0');
REPLACE INTO `retengcms_role` VALUES('2','网站总编','2','1','0');
REPLACE INTO `retengcms_role` VALUES('3','栏目编辑','3','1','0');
REPLACE INTO `retengcms_role` VALUES('4','美工设计师','4','1','0');
REPLACE INTO `retengcms_role` VALUES('5','会计人员','5','1','0');
DROP TABLE IF EXISTS `retengcms_server_task`;
CREATE TABLE `retengcms_server_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET gbk NOT NULL,
  `url` varchar(200) CHARACTER SET gbk NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `count` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
DROP TABLE IF EXISTS `retengcms_session`;
CREATE TABLE `retengcms_session` (
  `sessionid` char(32) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  `data` char(255) NOT NULL,
  PRIMARY KEY (`sessionid`),
  KEY `lastvisit` (`lastvisit`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_session` VALUES('b3977bg2n49e2in5h8ka9iaoa1','0','127.0.0.1','1413986222','');
REPLACE INTO `retengcms_session` VALUES('6ao8fak45ntrgebfp41rf0f8r1','1','127.0.0.1','1413986307','is_admin|b:1;admin_id|i:1;');
DROP TABLE IF EXISTS `retengcms_shipment`;
CREATE TABLE `retengcms_shipment` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `desc` text NOT NULL,
  `fee` varchar(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_sitecrowd`;
CREATE TABLE `retengcms_sitecrowd` (
  `id` mediumint(4) unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(200) NOT NULL,
  `site_url` varchar(200) NOT NULL,
  `site_dir` varchar(30) NOT NULL,
  `issueid` text NOT NULL,
  `tlp_name` varchar(80) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_description` varchar(255) NOT NULL,
  `seo_keywords` varchar(255) NOT NULL,
  `separator` varchar(8) NOT NULL DEFAULT '>',
  `htmlext` varchar(8) NOT NULL DEFAULT '.htm',
  `iscity` tinyint(1) NOT NULL DEFAULT '0',
  `city` mediumint(8) NOT NULL,
  `map` varchar(32) NOT NULL,
  `ishtml` tinyint(1) NOT NULL DEFAULT '0',
  `copyright` text NOT NULL,
  `icpno` varchar(32) NOT NULL,
  `system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_sitecrowd` VALUES('1','默认站点','http://127.0.0.1/','/','','gzs','用不同于大众的形式来服务企业或个人客户','','','>','.htm','0','0','','0','CopyRight © 2014 <a href=\"http://www.reteng.org\" target=\"_blank\" style=\"text-decoration:none;\">热腾网</a> RETENG.Org, All Rights Reserved.','','1');
DROP TABLE IF EXISTS `retengcms_sitecrowdissue`;
CREATE TABLE `retengcms_sitecrowdissue` (
  `issueid` mediumint(4) unsigned NOT NULL AUTO_INCREMENT,
  `issuename` varchar(80) NOT NULL,
  `ftphost` varchar(32) NOT NULL,
  `ftpport` varchar(4) NOT NULL,
  `ftpuser` varchar(64) NOT NULL,
  `ftppwd` varchar(64) NOT NULL,
  `ftpdir` varchar(80) NOT NULL,
  `ftpssl` tinyint(1) NOT NULL DEFAULT '0',
  `ftppasv` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`issueid`),
  UNIQUE KEY `ftphost` (`ftphost`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
DROP TABLE IF EXISTS `retengcms_stepselect`;
CREATE TABLE `retengcms_stepselect` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `table` varchar(30) NOT NULL,
  `issystem` tinyint(1) NOT NULL DEFAULT '0',
  `siteid` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `table` (`table`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_stepselect` VALUES('1','地区区域','area','0','1');
DROP TABLE IF EXISTS `retengcms_stepselect_enum`;
CREATE TABLE `retengcms_stepselect_enum` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `selectid` int(6) NOT NULL,
  `name` varchar(60) NOT NULL,
  `parentid` int(8) NOT NULL,
  `orderby` int(8) NOT NULL,
  `evalue` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `evalue` (`evalue`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_stepselect_enum` VALUES('1','1','石家庄市','0','25500','25500');
REPLACE INTO `retengcms_stepselect_enum` VALUES('2','1','鹿泉市','1','25501','25501');
REPLACE INTO `retengcms_stepselect_enum` VALUES('3','1','辛集市','1','25502','25502');
DROP TABLE IF EXISTS `retengcms_tagindex`;
CREATE TABLE `retengcms_tagindex` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` char(12) NOT NULL DEFAULT '',
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `total` int(10) unsigned NOT NULL DEFAULT '0',
  `uptime` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_tagindex` VALUES('9','提示','0','1','0','1413984903','1413984903','1');
REPLACE INTO `retengcms_tagindex` VALUES('8','部位','0','1','0','1413984903','1413984903','1');
REPLACE INTO `retengcms_tagindex` VALUES('7','修改','0','1','0','1413984903','1413984903','1');
DROP TABLE IF EXISTS `retengcms_taglist`;
CREATE TABLE `retengcms_taglist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contentid` int(10) unsigned NOT NULL DEFAULT '0',
  `orderby` smallint(6) NOT NULL DEFAULT '0',
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(12) NOT NULL DEFAULT '',
  `siteid` smallint(4) NOT NULL,
  PRIMARY KEY (`id`,`contentid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
REPLACE INTO `retengcms_taglist` VALUES('9','1','0','16','提示','1');
REPLACE INTO `retengcms_taglist` VALUES('8','1','0','16','部位','1');
REPLACE INTO `retengcms_taglist` VALUES('7','1','0','16','修改','1');
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `retengcms_vipread`;
CREATE TABLE `retengcms_vipread` (
  `contentid` mediumint(8) NOT NULL,
  `userid` mediumint(8) NOT NULL,
  KEY `contentid` (`contentid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
DROP TABLE IF EXISTS `retengcms_workbox`;
CREATE TABLE `retengcms_workbox` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `inlink` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
