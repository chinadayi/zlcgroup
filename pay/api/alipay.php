<?php
$payment_lang = RETENG_ROOT.'data/lang/'.LANG.'/payment/alipay.php';
if (file_exists($payment_lang))
{
    global $RETENG,$LANG;
    include_once($payment_lang);
}

class alipay
{
    var $pay = '';
	var $err = '';

    function alipay()
    {
    }

    function __construct()
    {
        $this->alipay();
    }

    function get_code($order, $payment)
    {
/*
	0 => '纯担保交易接口 create_partner_trade_by_buyer',
    1 => '标准实物双接口 trade_create_by_buyer',
    2 => '即时到账接口	 create_direct_pay_by_user',
*/
        if ($payment['service_type']==1)
        {
            $service = 'trade_create_by_buyer';
        }
		elseif($payment['service_type']==2)
		{
			$service = 'create_direct_pay_by_user';
		}
        else
        {
            $service = 'create_partner_trade_by_buyer';
        }
        $parameter = array(
            'service'           => $service,
            'partner'           => $payment['alipay_partner'],
            '_input_charset'    => 'utf-8',
            'return_url'        => return_url('alipay'),
            'notify_url'        => return_url('alipay',1),

            /* 业务参数 */
            'subject'           => 'Order SN:'.$order['order_sn'],
            'out_trade_no'      => $order['order_sn'], //
            'price'             => $order['order_amount'],
            'quantity'          => 1,
            'payment_type'      => 1,
			
			/* 物流参数 */
            'logistics_type'    => 'EXPRESS',
            'logistics_fee'     => 0,
            'logistics_payment' => 'BUYER_PAY_AFTER_RECEIVE',

            /* 买卖双方信息 */
            'seller_email'      => $payment['alipay_account']
        );
		if($payment['service_type']==2)
		{
			unset($parameter['logistics_type'],$parameter['logistics_fee'],$parameter['logistics_payment']);
		}

        ksort($parameter);
        reset($parameter);
        $param = '';
        $sign  = '';
        foreach ($parameter AS $key => $val)
        {
            $param .= "$key=$val&";
            $sign  .= "$key=$val&";
        }
        $param = substr($param, 0, -1);
        $sign  = substr($sign, 0, -1). $payment['alipay_key'];
        return 'https://www.alipay.com/cooperate/gateway.do?'.$param. '&sign='.md5($sign).'&sign_type=MD5';
    }

    function respond()
    {
		global $_userid;
        $payment  = get_payment($_GET['code']);
        $seller_email = rawurldecode($_GET['seller_email']);
        $order_sn = str_replace($seller_email.'_', '', $_GET['out_trade_no']);
        $order_sn = trim($order_sn);

        /* 检查数字签名是否正确 */
        ksort($_GET);
        reset($_GET);

        $sign = '';
        foreach ($_GET AS $key=>$val)
        {
            if ($key != 'sign' && $key != 'sign_type' && $key != 'code')
            {
                $sign .= "$key=$val&";
            }
        }

        $sign = substr($sign, 0, -1) . $payment['alipay_key'];
		if (md5($sign) != $_GET['sign'])
        {
			$this->err = '校验失败，若您的确已经在网关处被扣了款项，请及时联系店主，并且请不要再次点击支付按钮(原因：错误的签名)';
            return false;
        }
		
		/*
		WAIT_BUYER_PAY 交建
		WAIT_SELLER_SEND_GOODS 买家付款成功
		WAIT_BUYER_CONFIRM_GOODS 卖家发货成功
		TRADE_FINISHED 交易成功结束
		TRADE_CLOSED 交易关闭
		modify.tradeBase.totalFee 修改交易价格
		*/
        if ( $_GET['trade_status'] == "WAIT_SELLER_SEND_GOODS" || $_GET['trade_status'] == "TRADE_FINISHED" )
        {
            $orderid = $_GET['out_trade_no'];
            $orderid = trim($orderid);
			if($_userid)
			{
				if(changeorder($orderid))
				{
					return true;
				}
				else
				{
					$this->err = '支付已成功, 但会员信息更新失败, 请联系网站管理员!';
					return false;
				}
			}
			else
			{
				changeorder2($orderid);
				return true;
			}
        }
    }
}

?>
