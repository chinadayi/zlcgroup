<?php
/**
	* 会员点数类
*/

class account
{
	public $pagestring='';
	private $pay_log_table;
	private $member_table;
	private $member_cache_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->pay_log_table=DB_PRE.'pay_log';
		$this->member_table=DB_PRE.'member';
		$this->member_cache_table=DB_PRE.'member_cache';
	}

	function account()
	{
		$this->__construct();
	}

	function buypoint($point)
	{
		global $_userid,$_username,$_point,$_amount,$member,$module,$memlang;
		$point=intval($point)>0?intval($point):0;
		if($_amount < floatval($point*AMOUNTTOPOINT))
		{
			return false;
		}

		/*
			设置会员点数
		*/
		$status=$member->set($_userid,array('point'=>($point+$_point),'amount'=>(floatval($_amount-$point*AMOUNTTOPOINT))));
		
		/*
			财务日志
		*/
		if(!$module->module_disabled('pay'))
		{
			include RETENG_ROOT.'pay/include/pay.class.php';
			$pay=new pay();
			$log=array();
			$log['sn']=date('YmdHis',TIME).get_randstr(5);
			$log['username']=$_username;
			$log['ip']=IP;
			$log['manage']=0;
			$log['type']='amount';
			$log['amount']=$point*AMOUNTTOPOINT;
			$log['payment']=$memlang['buy-point'];
			$log['note']=$memlang['buy-point'];
			$log['time']=TIME;
			$log['status']=$status?2:1;
			$pay->set_log($log);
		}
		return $status;
	}
}
?>
