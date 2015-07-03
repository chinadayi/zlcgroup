<?php
/**
	* 支付模块类
*/

class pay
{
	public $pagestring='';
	private $db;
	private $method_table;
	private $cardtype_table;
	private $card_table;
	private $paylog_table;
	private $member_table;
	private $order_table;
	private $shipment_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->method_table=DB_PRE.'pay_method';
		$this->cardtype_table=DB_PRE.'pay_cardtype';
		$this->card_table=DB_PRE.'pay_card';
		$this->paylog_table=DB_PRE.'pay_log';
		$this->member_table=DB_PRE.'member';
		$this->member_cache_table=DB_PRE.'member_cache';
		$this->order_table=DB_PRE.'order';
		$this->shipment_table=DB_PRE.'shipment';
	}

	/*
		支付方式操作
	*/
	function paymethod()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->method_table` ORDER BY `$this->method_table`.`orderby` ASC");
	}

	function enabledpaymethod()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->method_table` WHERE `$this->method_table`.`enabled`=1 ORDER BY `$this->method_table`.`orderby` ASC");
	}

	function paymethodinfo($id)
	{
		$id=intval($id);
		$r = $this->db->fetch_one("SELECT * FROM `$this->method_table` WHERE `$this->method_table`.`id` = $id");

		if(!$r)return array();
		$r['config']=string2array($r['config']);
		return $r;
	}

	function paymentname($id)
	{
		$r=$this->paymethodinfo($id);
		return $r['name'];
	}

	function paymethod_edit($info,$id)
	{
		return $this->db->update($this->method_table,$info,'id='.intval($id));
	}

	function paymethod_enabled($id,$enabled)
	{
		return $this->db->update($this->method_table,array('enabled'=>intval($enabled)),'id='.intval($id));
	}

	/*
		点卡操作
	*/
	
	function cardtype()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->cardtype_table` ORDER BY `$this->cardtype_table`.`orderby` ASC");
	}

	function cardtype_add($info)
	{
		return $this->db->insert($this->cardtype_table,$info,true);
	}

	function cardtype_edit($names,$orderby,$amount,$price)
	{
		if(!$names)return false;
		foreach($names as $id => $name)
		{
			if(trim($names[$id]))$this->db->update($this->cardtype_table,array('name'=>trim($names[$id]),'orderby'=>intval($orderby[$id]),'amount'=>trim($amount[$id]),'price'=>trim($price[$id])),'id='.intval($id));
		}
		return true;
	}

	function cardtype_delete($id)
	{
		$this->db->mysql_delete($this->cardtype_table,intval($id));
		$this->db->mysql_delete($this->card_table,intval($id),'typeid');
		return true;
	}

	function cardtypeinfo($id)
	{
		$id=intval($id);
		return $this->db->fetch_one("SELECT * FROM `$this->cardtype_table` WHERE `$this->cardtype_table`.`id` =$id");
	}

	function card($enabled,$k)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=$enabled?'status='.intval($enabled):1;
		$where.=$k?' AND cardid='.$k:'';
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->card_table,$where,$orderby,$page,$pagesize);
		foreach($result as $key => $_r)
		{
			$r=$this->cardtypeinfo($_r['typeid']);
			$result[$key]['type']=$r['name'];
		}
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function cardinfo($cardid)
	{
		$cardid=preg_replace('/[^a-z0-9_]/i','',trim($cardid));
		return $this->db->fetch_one("SELECT * FROM `$this->card_table` WHERE `$this->card_table`.`cardid` ='$cardid'");
	}

	function delete_card($id)
	{
		$this->db->mysql_delete($this->card_table,array_map('intval',$id));
		return true;
	}

	function create_card($info)
	{
		global $_userid,$_username;
		$info['inputerid']=$_userid;
		$info['inputer']=$_username;
		$info['username']='尚未使用';
		$info['expire']=TIME+$info['todate']*24*3600;
		$info['ip']=IP;

		$cardtypeinfo=$this->cardtypeinfo($info['typeid']);
		$info['price']=$cardtypeinfo['price'];
		$info['amount']=$cardtypeinfo['amount'];
		$info['status']=1;
		
		$info['len']=intval($info['len'])>=15?$info['len']:15;
		$len=$info['len']-strlen($info['pre']);

		for($l=0;$l<$info['number'];$l++)
		{
			$info['cardid']=$info['pre'].get_randstr($len);
			$this->db->insert($this->card_table,$info,true);
		}
		return true;
	}

	/*
		财务日志
	*/
	function loglist($username='',$sn='',$status=0)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=$username?'username="'.$username.'"':1;
		$where.=$sn?' AND sn="'.$sn.'"':'';
		$where.=$status?' AND status='.intval($status):'';
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->paylog_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function log_delete($id)
	{
		$id=is_array($id)?array_map('intval',$id):array(intval($id));
		if(!$id)return false;
		$this->db->mysql_delete($this->paylog_table,$id);
		return true;
	}

	function set_log($info)
	{
		return $this->db->insert($this->paylog_table,$info);
	}

	/*
		会员充值
	*/
	function member_pay($info)
	{
		$ac=array();
		$log=array();
		$log['sn']=date('YmdHis',TIME).get_randstr(5);
		$log['username']=$info['username'];
		$log['ip']=IP;
		$log['manage']=$info['manageid'];
		$log['type']=$info['type'];
		$log['amount']=$info['amount'];
		$log['payment']='后台充值';
		$log['note']='后台会员充值!';
		$log['time']=TIME;
		$log['status']=1;

		$memberinfo=$this->db->fetch_one("SELECT * FROM `$this->member_table` WHERE `$this->member_table`.`username`='".trim($info['username'])."'");
		if($memberinfo)
		{
			if($info['type']=='amount')
			{
				if($info['manageid'])
				{
					$ac['amount']=max(0.00,$memberinfo['amount']+floatval($info['amount']));
				}
				else
				{
					$ac['amount']=max(0.00,$memberinfo['amount']-floatval($info['amount']));
				}
			}
			else
			{
				if($info['manageid'])
				{
					$ac['point']=max(0,$memberinfo['point']+intval($info['amount']));
				}
				else
				{
					$ac['point']=max(0,$memberinfo['point']-intval($info['amount']));
				}
			}

			$this->db->update($this->member_table,$ac,'id='.intval($memberinfo['id']));
			$this->db->update($this->member_cache_table,$ac,'id='.intval($memberinfo['id']));
			/*
				更新财务日志
			*/
			$log['status']=2;
			$this->set_log($log);
			return true;
		}

		$this->set_log($log);
		return false;
	}

	function paybycard($cardid)
	{
		global $member,$_userid,$_username,$_amount;

		$cardinfo=$this->cardinfo(trim($cardid));
		if(!$cardinfo)
		{
			return -1; // 充值卡不存在
		}
		if($cardinfo['status']==2)
		{
			return -2; // 充值卡已使用
		}
		if($cardinfo['expire'] < TIME)
		{
			return -3; // 充值卡已过期
		}
		
		$status=$member->set($_userid,array('amount'=>$_amount+floatval($cardinfo['amount'])));
		
		$this->db->update($this->card_table,array('status'=>2,'username'=>$_username),'cardid="'.$cardid.'"');
		/*
			财务日志
		*/
		$log=array();
		$log['sn']=date('YmdHis',TIME).get_randstr(5);
		$log['username']=$_username;
		$log['ip']=IP;
		$log['manage']=1;
		$log['type']='amount';
		$log['amount']=$cardinfo['amount'];
		$log['payment']='点卡充值';
		$log['note']='点卡充值!';
		$log['time']=TIME;
		$log['status']=$status?2:1;
		$this->set_log($log);
		return $status;
	}

	/*
		订单查询
	*/
	function orderlist($username='',$sn='',$status='all',$userid=0)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=$username?'buyuser="'.$username.'"':1;
		$where.=$sn?' AND sn="'.$sn.'"':'';
		$where.=$status=='all'?'':' AND status='.intval($status);
		$where.=$userid?' AND userid='.intval($userid):'';
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->order_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function order_delete($id)
	{
		$id=is_array($id)?array_map('intval',$id):array(intval($id));
		if(!$id)return false;
		$this->db->mysql_delete($this->order_table,$id);
		return true;
	}

	function order_status($status)
	{
		foreach($status as $id => $s)
		{
			$this->db->update($this->order_table,array('status'=>intval($s)),'id='.$id);
		}
		return true;
	}

	function order_step1($info,$price,$number)
	{
		global $_userid,$_username;
		$totalnum=0;
		$totalamount=0.0;
		$product='';
		$shipmentfee=$this->shipmentinfo(intval($info['shipment']),'fee');
		foreach($price as $key =>$val)
		{
			$totalnum=$totalnum+intval($number[$key]);
			$totalamount=$totalamount+intval($number[$key])*floatval($val);
		}
		
		$totalamount=$totalamount+$shipmentfee;
		$info=array_map('htmlspecialchars',$info);
		$info['product']=$product;
		$info['number']=max(1,$totalnum);
		$info['payment']=intval($info['payment']);
		$info['status']=0;
		$info['datetime']=TIME;
		$info['ip']=IP;
		$info['userid']=$_userid?$_userid:0;
		$info['amount']=$totalamount;
		$info['sn']='SN'.create_sn();
		
		/*
			会员的话记录财务日志
		*/
		if($_userid)
		{
			$log=array();
			$log['sn']=$info['sn'];
			$log['username']=$_username;
			$log['ip']=IP;
			$log['manage']=0;
			$log['type']='amount';
			$log['amount']=$info['amount'];
			$log['payment']=$this->paymentname($info['payment']);
			$log['note']=$info['buymessage'];
			$log['time']=$info['datetime'];
		}
		
		$paymethodinfo=$this->paymethodinfo($info['payment']);

		if(!$paymethodinfo || !$paymethodinfo['enabled'])
		{
			return -1; // 支付方式不存在或者已被禁用
		}
		else
		{
			$this->db->insert($this->order_table,$info);

			if($paymethodinfo['is_online'])
			{
				if($_userid)
				{
					$log['status']=1;
					$this->set_log($log);
				}
				$info['order_amount']=$info['amount']+pay_fee($info['amount'],$paymethodinfo['fee'].'%');
				$_SESSION['order_sign']=md5($info['payment'].$info['sn'].$info['order_amount']);
				return $info;
			}
			else
			{
				if($_userid)
				{
					$log['status']=2;
					$this->set_log($log);
				}
				return true;
			}
		}
	}

	function showmsg($msg,$template='success')
	{
		global $RETENG;
		unset($_SESSION['order_refreash']);
		include template($template,'pay');
		exit();
	}

	function orderinfo($id)
	{
		$id=intval($id);
		$r = $this->db->fetch_one("SELECT * FROM `$this->order_table` WHERE `$this->order_table`.`id` = $id");
		return $r;
	}

	function confirmorder($sn,$userid)
	{
		$sn=preg_replace('/[^0-9a-z]/i','',$sn);
		$userid=intval($userid);
		return $this->db->update($this->order_table,array('status'=>4),"sn='$sn' AND userid=$userid");
	}

	/*
		送货方式配置
	*/

	function shipment()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->shipment_table` ORDER BY `$this->shipment_table`.`id` DESC");
	}

	function shipmentinfo($id,$field='*')
	{
		$id=intval($id);
		$r=$this->db->fetch_one("SELECT * FROM `$this->shipment_table` WHERE `$this->shipment_table`.`id`=$id");
		return $field=='*'?$r:$r[$field];
	}

	function shipment_config($names,$fees,$descs,$ids)
	{
		foreach($names as $id => $name)
		{
			$name=trim($name);

			if(in_array($id,$ids))
			{
				if($name)
				{
					$this->db->update($this->shipment_table,array('name'=>$name,'fee'=>trim($fees[$id]),'desc'=>strip_tags($descs[$id])),'id='.$id);
				}
				else
				{
					$this->db->mysql_delete($this->shipment_table,$id);
				}
			}
			else
			{
				if($name)
				{
					$this->db->insert($this->shipment_table,array('name'=>$name,'fee'=>trim($fees[$id]),'desc'=>strip_tags($descs[$id])));
				}
			}
		}

		return true;
	}
}	
?>
