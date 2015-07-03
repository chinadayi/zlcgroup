<?php
//2015-06-30 16:10:27
return array (
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
);
?>