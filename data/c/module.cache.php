<?php
//2015-06-30 16:10:27
return array (
  0 => 
  array (
    'id' => '1',
    'name' => '会员管理',
    'folder' => 'member',
    'author' => 'ReTengCMS内容管理系统',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => 'zlc_member,zlc_member_cache,zlc_membermodel,zlc_membergrade,zlc_membergroup,zlc_memberhonor,zlc_memberdb_fields,zlc_message,zlc_collect',
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
  ),
  1 => 
  array (
    'id' => '10',
    'name' => '订单支付',
    'folder' => 'pay',
    'author' => '热腾官方',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => 'zlc_pay_method,zlc_pay_card,zlc_pay_cardtype,zlc_pay_log',
    'menu_admin' => '?mod=pay&file=pay&action=paymethod|支付配置
?mod=pay&file=pay&action=card|点卡管理
?mod=pay&file=pay&action=cardtype|点卡类型
?mod=pay&file=pay&action=log|财务日志
?mod=pay&file=pay&action=member|会员充值
?mod=pay&file=pay&action=order|订单查询
?mod=pay&file=pay&action=paymethod_button|支付按钮',
    'menu_member' => 'member/index.php?mod=pay&file=pay&action=online|在线充值
member/index.php?mod=pay&file=pay&action=card|点卡充值
member/index.php?mod=pay&file=pay&action=log|财务日志
member/index.php?mod=pay&file=pay&action=order|订单查询',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,5',
    'modelid' => '1,2',
    'menu' => '0',
    'adminmenu' => '0',
    'adminonly' => '0',
    'disabled' => '0',
    'description' => '本模块是由ReTengCMS官方开发支付功能模块，启用以后可以在模版中实现商品在线交易等功能',
    'orderby' => '2',
  ),
  2 => 
  array (
    'id' => '6',
    'name' => '广告管理',
    'folder' => 'adv',
    'author' => 'ReTengCMS内容管理系统',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => 'zlc_ads,zlc_adspos',
    'menu_admin' => '?mod=adv&file=ads&action=cache|更新缓存
?mod=adv&file=ads&action=adspos|常规广告位
?mod=adv&file=ads&action=adspos_add|添加广告位',
    'menu_member' => '',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,2,5',
    'modelid' => '',
    'menu' => '0',
    'adminmenu' => '0',
    'adminonly' => '1',
    'disabled' => '0',
    'description' => '本模块是由ReTengCMS内容管理系统开发的广告管理模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!
网址:http://www.reteng.org/',
    'orderby' => '4',
  ),
  3 => 
  array (
    'id' => '3',
    'name' => '友情链接',
    'folder' => 'link',
    'author' => 'ReTengCMS内容管理系统',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => 'zlc_linktype,zlc_link',
    'menu_admin' => '?mod=link&file=link&action=cache|更新缓存
?mod=link&file=link&action=type|友链类型
?mod=link&file=link&action=type_add|添加类型
?mod=link&file=link&action=tag|模板调用',
    'menu_member' => '',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,2',
    'modelid' => '',
    'menu' => '1',
    'adminmenu' => '0',
    'adminonly' => '1',
    'disabled' => '0',
    'description' => '本模块是由ReTengCMS内容管理系统开发的友情链接管理模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!
网址:http://www.reteng.org/',
    'orderby' => '5',
  ),
  4 => 
  array (
    'id' => '11',
    'name' => '留言管理',
    'folder' => 'guestbook',
    'author' => 'ReTengCMS内容管理系统',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => 'zlc_guestbook',
    'menu_admin' => '?mod=guestbook&file=guestbook&action=manage&passed=1|已审留言
?mod=guestbook&file=guestbook&action=manage&passed=0|待审留言',
    'menu_member' => '',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,2,3,4,5',
    'modelid' => '',
    'menu' => '1',
    'adminmenu' => '0',
    'adminonly' => '1',
    'disabled' => '0',
    'description' => '本模块是由ReTengCMS内容管理系统开发的一款留言管理模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!
网址:http://www.reteng.org/',
    'orderby' => '6',
  ),
  5 => 
  array (
    'id' => '4',
    'name' => '在线投票',
    'folder' => 'vote',
    'author' => 'ReTengCMS内容管理系统',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => 'zlc_vote,zlc_vote_ip',
    'menu_admin' => '?mod=vote&file=vote&action=manage|投票管理
?mod=vote&file=vote&action=vote_add|添加投票',
    'menu_member' => '',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,2,3,4,5',
    'modelid' => '',
    'menu' => '1',
    'adminmenu' => '0',
    'adminonly' => '1',
    'disabled' => '0',
    'description' => '本模块是由ReTengCMS内容管理系统开发的一款在线投票模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!
网址:http://www.reteng.org/',
    'orderby' => '7',
  ),
  6 => 
  array (
    'id' => '7',
    'name' => '文章tag标签',
    'folder' => 'tags',
    'author' => '热腾网',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => 'zlc_taglist,zlc_tagindex',
    'menu_admin' => '',
    'menu_member' => '',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,2,3,4,5',
    'modelid' => '1,2',
    'menu' => '1',
    'adminmenu' => '0',
    'adminonly' => '0',
    'disabled' => '0',
    'description' => '本模块是由ReTeng开发的一款ReTengCMS内容管理系统功能模块,感谢您的下载使用.本模块主要是方便网站tag提取，增强网站优化等作用
网址:http://www.reteng.org/',
    'orderby' => '8',
  ),
  7 => 
  array (
    'id' => '2',
    'name' => '个人空间',
    'folder' => 'space',
    'author' => 'ReTengCMS内容管理系统',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => 'zlc_space,zlc_space_comment,zlc_space_newvisitor,zlc_space_friends',
    'menu_admin' => '?mod=space&file=space&action=manage|空间管理
?mod=space&file=space&action=tagspace|空间调用
?mod=space&file=space&action=tag|留言调用',
    'menu_member' => 'member/index.php?mod=space&file=space&action=view|刷新空间
member/index.php?mod=space&file=space&action=info|空间设置
member/index.php?mod=space&file=space&action=template|模板样式
member/index.php?mod=space&file=space&action=guestbook|留言管理',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,2',
    'modelid' => '1,2',
    'menu' => '0',
    'adminmenu' => '0',
    'adminonly' => '0',
    'disabled' => '0',
    'description' => '本模块是由ReTengCMS内容管理系统开发的一款个人空间功能模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!
网址:http://www.reteng.org/',
    'orderby' => '9',
  ),
  8 => 
  array (
    'id' => '5',
    'name' => '搜索模块',
    'folder' => 'search',
    'author' => 'ReTengCMS内容管理系统',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => 'zlc_keywords',
    'menu_admin' => '?mod=search&file=search&action=keywords|关键字管理',
    'menu_member' => '',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,2,3,4,5',
    'modelid' => '1,2',
    'menu' => '1',
    'adminmenu' => '0',
    'adminonly' => '1',
    'disabled' => '0',
    'description' => '本模块是由ReTengCMS内容管理系统开发的一款搜索功能模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!
网址:http://www.reteng.org/',
    'orderby' => '10',
  ),
  9 => 
  array (
    'id' => '9',
    'name' => '站外链接',
    'folder' => 'workbox',
    'author' => '热腾网',
    'site' => 'http://www.reteng.org',
    'version' => '1.0',
    'tables' => 'zlc_workbox,zlc_tools',
    'menu_admin' => '?mod=workbox&file=workbox&action=workbox|工具管理
?mod=workbox&file=workbox&action=tag|模板调用',
    'menu_member' => '',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,2,3,4,5',
    'modelid' => '1,2',
    'menu' => '0',
    'adminmenu' => '0',
    'adminonly' => '0',
    'disabled' => '0',
    'description' => '本模块可以是实现站内内容与设定的关键词相关联。从而有效的实现网站SEO外链增加！',
    'orderby' => '12',
  ),
  10 => 
  array (
    'id' => '8',
    'name' => '在线投稿',
    'folder' => 'post',
    'author' => 'ReTengCMS内容管理系统',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => '',
    'menu_admin' => '?mod=post&file=post&action=config|配置选项',
    'menu_member' => '',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,2,3,4,5',
    'modelid' => '1,2',
    'menu' => '1',
    'adminmenu' => '0',
    'adminonly' => '1',
    'disabled' => '0',
    'description' => '本模块是由热腾内容管理系统开发的一款ReTengCMS内容管理系统功能模块,感谢您的下载使用.如有任何问题可到我们的官方网址咨询!
网址:http://www.reteng.org/',
    'orderby' => '14',
  ),
  11 => 
  array (
    'id' => '13',
    'name' => 'diy表单',
    'folder' => 'form',
    'author' => '热腾内容管理系统',
    'site' => 'http://www.reteng.org/',
    'version' => '1.0',
    'tables' => 'zlc_form,zlc_form_fields',
    'menu_admin' => '?mod=form&file=form&action=manage|自定义表单
?mod=form&file=form&action=add|添加表单',
    'menu_member' => '',
    'agreement' => '本软件为自由软件, 你可以自由修改并使用。',
    'roleid' => '1,2,3,4,5',
    'modelid' => '1,2',
    'menu' => '0',
    'adminmenu' => '0',
    'adminonly' => '1',
    'disabled' => '0',
    'description' => '本模块是由可以实现自定义表单数据，增强网站功能，例如：意见反馈，在线报名等功能！',
    'orderby' => '16',
  ),
);
?>