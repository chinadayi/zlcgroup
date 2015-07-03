<?php
/**
* 单页管理类
*/

class page
{
	public $pagestring;
	private $c;
	private $db;
	private $table;
	private $category_table;

	function __construct()
	{
		global $db,$c;
		$this->db=$db;
		$this->c=$c;
		$this->table=DB_PRE.'page';
		$this->category_table=DB_PRE.'category';
	}

	function page()
	{
		$this->__construct();
	}

	function datalist($parentid=0)
	{
		$parentid=intval($parentid);
		$r=$this->db->fetch_all("SELECT id,catid,parentid,pagename,filename,pagedir,ismenu,m,siteid,orderby FROM $this->table WHERE parentid=$parentid ORDER BY orderby ASC");

		if(!$r)
		{
			return false;
		}
		else
		{
			foreach($r as $_r)
			{
				if($_r['siteid']==SITEID)
				{
					echo '<tr>
					<td align="center"><input type="hidden" size="4" name="catid[]" value="'.$_r['catid'].'"/><input type="text" size="4" name="orderby['.$_r['id'].']" value="'.$_r['orderby'].'"/></td>
					<td align="center">'.$_r['catid'].'</td>
					<td align="left">'.str_repeat('&nbsp;',($_r['m']-1)*4).'|-<a href="?file=page&action=edit&id='.$_r['id'].'">'.$_r['pagename'].'</a></td>
					<td align="center"><a title="访问'.$_r['pagename'].'" href="'.str_replace('//','/',RETENG_PATH.$_r['pagedir'].$_r['filename'].HTMLEXT).'" target="_blank">/'.$_r['pagedir'].'</a></td>
					<td align="center">'.($_r['ismenu']?'已启用 | <a href="?file=page&action=setismenu&ismenu=0&id='.$_r['id'].'"><u>禁用</u></a>':'<font color="#666666">已禁用</font> | <a href="?file=page&action=setismenu&ismenu=1&id='.$_r['id'].'"><u>启用</u></a>').'</td>
					<td align="center"><a title="访问'.$_r['pagename'].'" href="'.str_replace('//','/',RETENG_PATH.$_r['pagedir'].$_r['filename'].HTMLEXT).'" target="_blank">访问</a></td>
					<td align="center">
					<a href="?file=page&action=add&parentid='.$_r['id'].'"><u>添加子单页</u></a> |
					<a href="?file=page&action=edit&id='.$_r['id'].'"><u>编辑</u></a> |
					<a href="?file=page&action=delete&id='.$_r['id'].'" onclick="if(!confirm(\'确实要删除单页 '.$_r['pagename'].' 吗?\')){return false;}"><u>删除</u></a>
					</td>
				</tr>';
				}
				$this->datalist($_r['id']);
			}
		}
	}

	function add($info)
	{
		global $RETENG,$hotWord;
		if(!$info['pagename'] || !$info['filename'] || !$info['setting']['template'])return false;

		/*
			设置菜单等级及目录
		*/
		$info['siteid']=SITEID;
		if(intval($info['parentid']))
		{
			$r=$this->pageinfo($info['parentid']);
			$info['m']=$r['m']+1;
			$catparentid=$r['catid'];
		}
		else
		{
			$info['m']=1;
			$catparentid=0;
		}

		$info['pagedir']=str_replace('\\','/',$info['pagedir']);
		$info['pagedir']=substr($info['pagedir'],-1,1)=='/'?$info['pagedir']:$info['pagedir'].'/';
		
		if(file_exists(str_replace('//','/',RETENG_ROOT.$info['pagedir'].$info['filename'].HTMLEXT)))return -1; // 同名文件已存在!

		$setting=$info['setting'];

		/*
			插入单页表
		*/
		$info['setting']=var_export($info['setting'],true);
		$pageid=$this->db->insert($this->table,$info);

		$cat=$info;

		/*
			插入栏目表
		*/
		
		$cat['parentid']=$catparentid;
		$cat['modelid']=0;
		$cat['type']=2; // 单页类型的栏目
		$cat['catname']=$info['pagename']; 
		$cat['domain']='';
		$cat['catdir']=$info['pagedir'];
		$cat['url']=$info['pagedir'].$info['filename'].HTMLEXT;
		$cat['url']=str_replace('//','/',$cat['url']);
		$cat['orderby']=$pageid;
		$cat['ispost']=0;
		
		$catid=$this->db->insert($this->category_table,$cat);
		
		/*
			更新栏目缓存
		*/

		$this->c->cache_category();

		/*
			更新单页表
		*/
		$this->db->update($this->table,array('catid'=>$catid,'orderby'=>$pageid),'id='.$pageid);

		/*
			生成静态文件
		*/
		
		$info=array_merge($info,$setting);
		makedir($info['pagedir']);
		ob_start();
		@extract($info);
		include template($info['template']);
		$content=ob_get_contents();
		ob_clean();
		@file_put_contents(RETENG_ROOT.$info['pagedir'].$info['filename'].HTMLEXT,stripslashes($content));
		return true;
	}

	function edit($info,$id)
	{
		global $RETENG,$hotWord;
		$id=intval($id);
		if(!$info['pagename'] || !$info['filename'] || !$info['setting']['template'] || !$id)return false;

		/*
			设置菜单等级及目录
		*/
		if(intval($info['parentid']))
		{
			$r=$this->pageinfo($info['parentid']);
			$info['m']=$r['m']+1;
			$catparentid=$r['catid'];
		}
		else
		{
			$info['m']=1;
			$catparentid=0;
		}

		$info['pagedir']=str_replace('\\','/',$info['pagedir']);
		$info['pagedir']=substr($info['pagedir'],-1,1)=='/'?$info['pagedir']:$info['pagedir'].'/';

		/**
			检查文件名是否重复
		*/
		if($info['pagedir']!=$info['oldpagedir'] && file_exists(str_replace('//','/',RETENG_ROOT.$info['pagedir'].$info['filename'].HTMLEXT)))return -1;

		/*
			删除旧文件
		*/
		if($info['oldfilename'] && file_exists(RETENG_ROOT.$info['oldpagedir'].$info['oldfilename'].HTMLEXT))
		{
			@unlink(RETENG_ROOT.$info['oldpagedir'].$info['oldfilename'].HTMLEXT);
		}

		/**
			删除空的旧文件夹
		*/
		if(!empty($info['oldpagedir']) && trim($info['oldpagedir'])!='/' && is_dir(RETENG_ROOT.$info['oldpagedir']) && file_exists(RETENG_ROOT.$info['oldpagedir']))
		{
			if(!glob(RETENG_ROOT.$info['oldpagedir'].'*.*'))
			{
				@rmdir(RETENG_ROOT.$info['oldpagedir']);
			}
		}

		$setting=$info['setting'];

		/*
			更新单页表
		*/
		$info['setting']=var_export($info['setting'],true);
		$this->db->update($this->table,$info,'id='.$id);

		$cat=$info;

		/*
			更新栏目表
		*/
		
		$cat['parentid']=$catparentid;
		$cat['catname']=$info['pagename']; 
		$cat['catdir']=$info['pagedir'];
		$cat['url']=$info['pagedir'].$info['filename'].HTMLEXT;
		
		$cat['url']=str_replace('//','/',$cat['url']);
		$catid=$this->db->update($this->category_table,$cat,'id='.intval($info['catid']));
		
		/*
			更新栏目缓存
		*/

		$this->c->cache_category();


		/*
			生成静态文件
		*/
		
		$info=array_merge($info,$setting);
		makedir($info['pagedir']);
		ob_start();
		@extract($info);
		include template($info['template']);
		$content=ob_get_contents();
		ob_clean();
		@file_put_contents(RETENG_ROOT.$info['pagedir'].$info['filename'].HTMLEXT,stripslashes($content));
		return true;
	}

	function delete($id)
	{
		$id=intval($id);
		$base=$this->pageinfo($id);

		if(!$id) return false;

		/*
			删除单页表
		*/

		$rs=$this->db->mysql_delete($this->table,$id);

		if(!$rs) return false;

		/**
			删除静态文件
		*/	

		if(!$base)return false;

		$pagedir=$base['pagedir']=='/'?'':$base['pagedir'];
		if(!empty($base['filename']) && file_exists(RETENG_ROOT.$pagedir.$base['filename'].HTMLEXT))
		{
			@unlink(RETENG_ROOT.$pagedir.$base['filename'].HTMLEXT);
		}

		/**
			删除空的文件夹
		*/
		if(!empty($pagedir) && is_dir(RETENG_ROOT.$pagedir) && file_exists(RETENG_ROOT.$pagedir))
		{
			if(!glob(RETENG_ROOT.$pagedir.'*.*'))
			{
				@rmdir(RETENG_ROOT.$pagedir);
			}
		}

		/*
			更新栏目表
		*/

		$this->db->mysql_delete($this->category_table,intval($base['catid']));

		/**
			递归删除子单页
		*/
		
		$r=$this->db->fetch_all("SELECT `$this->table`.`id` FROM `$this->table` WHERE `$this->table`.`parentid`=$id");
		if($r)
		{
			foreach($r as $_r)
			{
				$this->delete(intval($_r['id']));
			}
		}
		else
		{
			return false;
		}
	}

	function setordeyby($orderby)
	{
		$orderby=array_map('intval',$orderby);
		if(!$orderby)return false;

		if($orderby)
		{
			foreach($orderby as $key => $value)
			{
				$this->db->update($this->table,array('orderby'=>intval($value)),'id='.intval($key));

				/*
					更新栏目表
				*/
				$r=$this->pageinfo(intval($key));
				$this->db->update($this->category_table,array('orderby'=>intval($value)),'id='.intval($r['catid']));		
			}
		}
		else
		{
			return false;
		}

		/*
			更新栏目缓存
		*/
		$this->c->cache_category();
		return true;
	}

	function setismenu($id,$ismenu)
	{
		if(!intval($id))return false;

		/*
			更新page表
		*/
		$this->db->update($this->table,array('ismenu'=>intval($ismenu)),'id='.intval($id));


		/*
			更新category表
		*/
		$r=$this->pageinfo($id);
		$this->db->update($this->category_table,array('ismenu'=>intval($ismenu)),'id='.intval($r['catid']));

		/*
			更新栏目缓存
		*/
		$this->c->cache_category();

		return true;
	}

	function pageinfo($id) // 基本字段信息
	{
		$id=intval($id);
		return $this->db->fetch_one("SELECT `id`,`catid`,`parentid`,`pagename`,`filename`,`pagedir`,`setting`,`ismenu`,`m`,`orderby` FROM `$this->table` WHERE `$this->table`.`id`=$id");
	}

	function pagesetting($id) // 单页配置信息
	{
		$r=$this->pageinfo($id);
		return string2array($r['setting']);
	}

	function pageallinfo($id ,$field='id') // 全部字段信息 带内容
	{
		$id=intval($id);
		return $this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`$field`=$id");
	}
}
?>
