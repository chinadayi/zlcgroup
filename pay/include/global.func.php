<?php
/**
	* 支付公共函数
*/

function create_sn()
{
	return date("YmdHis").str_pad( mt_rand(1,99999 ),5,"0",STR_PAD_LEFT);
}

function pay_fee($amount,$fee)
{
    $pay_fee=0;
    if (strpos($fee,'%')!==false)
    {
        $val=floatval($fee)/100;
        $pay_fee=$val>0?$amount*$val:0;
    }
    else
    {
        $pay_fee=floatval($fee);
    }
    return round($pay_fee,2);
}

function get_payment($code)
{
	global $db;
    $sql="SELECT * FROM " .DB_PRE."pay_method WHERE `code` = '$code' AND `enabled` = '1'";
    $info=$db->fetch_one($sql);
	$cfg=$info['config'];
    if(is_string($cfg) )
    {
        $arr=string2array($cfg);
        $config=array();

        foreach($arr as $key =>$val)
        {
            $config[$key] = trim($val);
        }
        return $config;
    }
    else
    {
        return false;
    }

}

function return_url($code,$is_api=0)
{
	global $RETENG;
	if($is_api)
	{
		return $RETENG['site_url'].'pay/api/AutoReceive.'.$code.'.php';
	}
	else
	{
		return $RETENG['site_url'].'pay/respond.php?code='.$code;
	}
}

function changeorder($sn)
{
	global $db;
    $sn = trim($sn);
    $row = $db->fetch_one("SELECT * FROM ".DB_PRE."pay_log WHERE `sn` = '$sn' AND `status` = 2");
    if(!$row)
    {
	    if($db->query("UPDATE ".DB_PRE."pay_log SET `status` = 2, `time` =".TIME." WHERE `sn` = '$sn'"))
        {
            $r = $db->fetch_one("SELECT * FROM ".DB_PRE."pay_log WHERE `sn` = '$sn' AND `status` = 2");
			$username=trim($r['username']);
			if($r['type']=='amount')
			{
				$amount=floatval($r['amount']);
				$db->query("UPDATE `".DB_PRE."member` SET `".DB_PRE."member`.`amount`=`".DB_PRE."member`.`amount`+{$amount} WHERE `".DB_PRE."member`.`username`='{$username}'");
				$db->query("UPDATE `".DB_PRE."member_cache` SET `".DB_PRE."member_cache`.`amount`=`".DB_PRE."member_cache`.`amount`+{$amount} WHERE `".DB_PRE."member_cache`.`username`='{$username}'");
			}
			else
			{	
				$point=intval($r['amount']);
				$db->query("UPDATE `".DB_PRE."member` SET `".DB_PRE."member`.`point`=`".DB_PRE."member`.`point`+{$point} WHERE `".DB_PRE."member`.`username`='{$username}'");
				$db->query("UPDATE `".DB_PRE."member_cache` SET `".DB_PRE."member_cache`.`point`=`".DB_PRE."member_cache`.`point`+{$point} WHERE `".DB_PRE."member_cache`.`username`='{$username}'");
			}

			$row = $db->fetch_one("SELECT * FROM ".DB_PRE."order WHERE `sn` = '$sn' AND `status` = 1");
			if(!$row)
			{
				$db->query("UPDATE ".DB_PRE."order SET `status` = 1 WHERE `sn` = '$sn'");
			}
			return true;
        }
    }
    else
    {
        return false;
    }
}

function changeorder2($sn)
{
	global $db;
    $sn = trim($sn);
    $row = $db->fetch_one("SELECT * FROM ".DB_PRE."order WHERE `sn` = '$sn' AND `status` = 1");
    if(!$row)
    {
		if($db->query("UPDATE ".DB_PRE."order SET `status` = 1 WHERE `sn` = '$sn'"))
        {
			$row = $db->fetch_one("SELECT * FROM ".DB_PRE."pay_log WHERE `sn` = '$sn' AND `status` = 2");
			if(!$row)
			{
				$db->query("UPDATE ".DB_PRE."pay_log SET `status` = 2, `time` =".TIME." WHERE `sn` = '$sn'");
			}
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}
?>
