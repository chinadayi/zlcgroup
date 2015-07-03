<?php
/**
	* 投票管理类
*/

class vote
{
	public $pagestring='';
	private $db;
	private $table;
	private $voteip_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'vote';
		$this->voteip_table=DB_PRE.'vote_ip';
	}

	function votelist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID;
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function vote_add($info,$votenote)
	{
		if(!$info['votename'])return false;

		
		$info['starttime']=strtotime($info['starttime']);
		$info['endtime']=strtotime($info['endtime']);
		
		$info['votenote']='';
		$info['siteid']=SITEID;
		if($info['endtime'] < $info['starttime'])return false;
		foreach($votenote as $k => $v)
		{
			$info['votenote'].='<vote id="'.$k.'" count="0">'.$v.'</vote>'."\n";
		}
		return $this->db->insert($this->table,$info,true);
	}

	function vote_delete($id)
	{
		return $this->db->mysql_delete($this->table,intval($id));
	}

	function vote_editname($votename,$starttime,$endtime,$totalcount)
	{
		$info=array();
		if(!$votename) return false;
		foreach($votename as $id => $name)
		{
			$info['votename']=strip_tags($name);
			$info['starttime']=strtotime($starttime[$id]);
			$info['endtime']=strtotime($endtime[$id]);
			$info['totalcount']=intval($totalcount[$id]);
			$this->db->update($this->table,$info,'id='.intval($id));
		}
		return true;
	}

	function vote_edit($info,$id)
	{
		if(!$info['votename']) return false;
		$info['siteid']=SITEID;
		$info['starttime']=strtotime($info['starttime']);
		$info['endtime']=strtotime($info['endtime']);
		$info['delay']=$info['delay'];
		if($info['endtime'] < $info['starttime'])return false;
		return $this->db->update($this->table,$info,'id='.intval($id));
	}

	function voteinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=".intval($id));
	}

	function dopost($voteitem,$id)
	{
		global $votelang;
		if(!$voteitem)showmsg($votelang['msg-vote-choose']);
		$id=intval($id);
		$ip=array();
		$r=$this->voteinfo($id);
		if(!$r)show404($votelang['msg-vote-none']);
		if($r['endtime'] < TIME)showmsg($votelang['msg-vote-overdue']);
		$t=$this->db->fetch_all("SELECT `$this->voteip_table`.`ip`,`$this->voteip_table`.`votetime` FROM `$this->voteip_table` WHERE `$this->voteip_table`.`voteid`={$id}");

		foreach($t as $_t)
		{
			$ip[$_t['ip']]=$_t['votetime'];
		}
		if(array_key_exists(IP,$ip) && $r['delay']*3600>(TIME-$ip[IP]))showmsg($votelang['msg-vote-repeat']);
		$item=explode("\n",$r['votenote']);
		if($r['ismore'])
		{
			$voteitem=array_map('intval',$voteitem);
			foreach($voteitem as $v)
			{
				foreach($item as $k=>$_item)
				{
					unset($len,$lenreg);
					preg_match('/<vote id="'.$v.'" count="([0-9]+)">(.+?)<\/vote>/i',$_item,$lenreg);
					if($lenreg)
					{
						$len=$lenreg[1]+1;
						$item[$k]=preg_replace('/<vote id="'.$v.'" count="([0-9]+)">(.+?)<\/vote>/i','<vote id="'.$v.'" count="'.$len.'">\\2</vote>',$_item);
					}
				}
			}
			$item=implode("\n",$item);
			$this->db->update($this->table,array('votenote'=>$item,'totalcount'=>intval($r['totalcount'])+sizeof($voteitem)),'id='.$id);
		}
		else
		{
			$voteitem=intval($voteitem);
			foreach($item as $k=>$_item)
			{
				unset($len,$lenreg);
				preg_match('/<vote id="'.$voteitem.'" count="([0-9]+)">(.+?)<\/vote>/i',$_item,$lenreg);
				if($lenreg)
				{
					$len=$lenreg[1]+1;
					$item[$k]=preg_replace('/<vote id="'.$voteitem.'" count="([0-9]+)">(.+?)<\/vote>/i','<vote id="'.$voteitem.'" count="'.$len.'">\\2</vote>',$_item);
				}
			}
			$item=implode("\n",$item);
			$this->db->update($this->table,array('votenote'=>$item,'totalcount'=>intval($r['totalcount'])+1),'id='.$id);
		}
		if(array_key_exists(IP,$ip))
		{
			$this->db->update($this->voteip_table,array('votetime'=>TIME),'voteid='.$id.' AND ip=\''.IP.'\'');
		}
		else
		{
			$this->db->insert($this->voteip_table,array('voteid'=>$id,'ip'=>IP,'votetime'=>TIME),true);
		}
		showmsg($votelang['msg-vote-success'],SITE_URL.'vote/index.php?id='.$id);
	}

	function voteview($id)
	{
		global $votelang;
		$id=intval($id);
		$itemstr=$result='';
		$r=$this->voteinfo($id);
		if(!$r || !$id)return $votelang['msg-vote-none'];

		$item=explode("\n",$r['votenote']);
		$totalitem=$r['totalcount']?$r['totalcount']:sizeof($item);
		if($item)foreach($item as $_item)
		{
			$len=preg_match('/<vote id="([0-9]+)" count="([0-9]+)">(.+?)<\/vote>/i',$_item,$lenreg);

			if($lenreg)
			{
				$len=$lenreg[2];
				$len=min(100,round($len/$totalitem,2)*100);
				$itemstr.=preg_replace('/<vote id="([0-9]+)" count="([0-9]+)">(.+?)<\/vote>/i',"<tr height='30'><td style='border-bottom:1px solid'>\\1、\\3</td><td style='border-bottom:1px solid'>
						
					<table border='0' cellspacing='0' cellpadding='2' title='$len%' width='$len%'><tr><td height='16' style='background-color:#BAD5F1;border:1px solid #666666;font-size:9pt;line-height:110%'>\\2</td></tr></table>
					</td></tr>",$_item);
			}
		}
		$result="<table width='98%' border='0' cellspacing='1' cellpadding='1'>
		<tr><td height=22><strong>".$r['votename']."</strong> </td><td align='right'>".$votelang['span-vote-start'].date('Y-m-d',$r['starttime'])."　 ".$votelang['span-vote-start'].date('Y-m-d',$r['endtime'])." ".$votelang['span-vote-count'].$r['totalcount']."</td></tr>
		<tr height='8'><td width='30%'></td><td></td></tr>".$itemstr."
		<tr><td></td><td></td></tr>
		</table>";

		return $result;
	}
}
?>
