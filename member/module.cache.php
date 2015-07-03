<?php
//2014-07-23 22:20:38
return array (
  'name' => '会员管理',
  'folder' => 'member',
  'author' => 'ReTengCMS内容管理系统',
  'site' => 'http://www.reteng.org/',
  'version' => '1.0',
  'tables' => 'retengcms_member,retengcms_member_cache,retengcms_membermodel,retengcms_membergrade,retengcms_membergroup,retengcms_memberhonor,retengcms_memberdb_fields,retengcms_message,retengcms_collect',
  'menu_admin' => '?mod=member&file=member&action=cache|更新缓存
?mod=member&file=member&action=setting|配置选项
?mod=member&file=member&action=manage|会员管理
?mod=member&file=member&action=group|会 员 组
?mod=member&file=member&action=grade|会员级别
?mod=member&file=member&action=honor|会员头衔
?mod=member&file=member&action=model|会员模型
?mod=member&file=member&action=message|系统信息',
  'menu_member' => '',
  'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
  'roleid' => '1,2,3,4,5',
  'modelid' => '1,2',
  'menu' => '1',
  'adminmenu' => '0',
  'adminonly' => '1',
  'disabled' => '0',
  'description' => '本模块是由ReTengCMS官方开发的一款会员管理模块,可以实现会员注册等功能',
  'orderby' => '1',
);
?>