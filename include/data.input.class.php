<?php
/**
    数据输入验证类
	@author reteng
*/

error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);
class data_input
{
	public $modelid;
	private $db;
	private $fields;

	function __construct($modelid,$type="content")
	{
		global $db;
		$this->db=$db;
		$this->modelid=$modelid;

		if($type=='content')
		{
			$r=cache_read('model'.$this->modelid.'_fields.cache.php',RETENG_ROOT.'data/c/');
		}
		else if($type=='member')
		{
			$r=cache_read('model'.$this->modelid.'_fields.cache.php',RETENG_ROOT.'data/cache_module/');
		}
		if($r)foreach($r as $_r)
		{
			$t[$_r['enname']]=$_r;
		}
		$this->fields=$t;
	}

	function data_input($modelid)
	{
		$this->__construct($modelid);
	}

	function filter($data)
	{
		global $_roleid,$ftpobj,$_userid,$baselang;

		$r=$this->fields;
		if(!$data)return $data;
		
		foreach($data as $key => $value)
		{
			if(!isset($r[$key]) || !isset($r[$key]['form']) )continue;

			/*	
				检查是否是管理员才能访问的字段
				
			if($r[$key]['adminonly']==3 && !$_roleid)
			{		
				showmsg('Access Denied!');
			}

			if($r[$key]['adminonly']==2 && !$_userid && !$_roleid)
			{		
				showmsg('Access Denied!');
			}
*/ 
			/*	
				过滤特殊字符
			*/	

			if($r[$key]['form']=='baidueditor' || $r[$key]['form']=='content' || $r[$key]['form']=='copyfrom' || $r[$key]['form']=='simpleueditor')
			{
				//$data[$key]=filterhtml(str_replace(array('<div','</div>','<DIV','</DIV>','<br />','<br>','<BR />','<BR>'),array('<p','</p>','<p','</p>','</p><p>','</p><p>','</p><p>','</p><p>'),$value),4);
				$data[$key]=filterhtml($value,4);
				if($r[$key]['form']!='content')continue;
			}
			else
			{
				$data[$key]=retengcms_htmlspecialchars($value);
			}

			/*
				多选项
			*/
			if($r[$key]['form']=='more')
			{
				$t=array();
				$descs=$_POST['more_'.$r[$key]['enname'].'_des'];
				$urls=$_POST['more_'.$r[$key]['enname'].'_url'];
				if($urls)
				{
					foreach($urls as $_key => $url)
					{
						$t[]=str_replace(array('`','|'),'',$descs[$_key]).'|'.$url;
					}
					$data[$key]=implode('`',$t);
				}
				continue;
			}
			
			/*
				内容字段设置 (无需验证正则)
			*/
			if($r[$key]['form']=='content')
			{
				$data['content']=isset($data['content'])?stripslashes($data['content']):'';
				$data['content']=str_replace('<p style="page-break-after: always"><span style="display: none">&nbsp;</span></p>','<div style="page-break-after: always"><span style="display: none">&nbsp;</span></div>',$data['content']);
				if(AUTOWYC) // 开启伪原创
				{
					$dict=file_get_contents(RETENG_ROOT.'include/dict/pseudo.dict');
					$_yc=explode("\r\n",$dict);
					foreach($_yc as $w)
					{
						$_w=explode(",",$w);
						$data['content']=str_replace($_w[0],$_w[1],$data['content']);
					}
				}
		
				$data['thumb']=isset($data['thumb']) && is_image($data['thumb']) && preg_match('/[\x20-\x7f]+/i',$data['thumb'])?$data['thumb']:'';

				// 自动读取远程图片到本地
				if(isset($_POST['auto_image']) && $_POST['auto_image']==1)
				{
					$imgs=get_images($data['content']);
					if($imgs)foreach($imgs as $imgkey => $_imgs)
					{
						if(substr(strtolower($_imgs),0,7)=='http://') // 非本地图片
						{
							$localimg=createthumb($_imgs,0);
							$data['content']=str_replace($_imgs,$localimg,$data['content']);
							$imgs[$imgkey]=$localimg;
						}
					}
				}

				// 截取内容前255字符作为摘要
				if(isset($_POST['auto_description']) && $_POST['auto_description']==1)
				{
					$data['description']=isset($data['description']) && $data['description']?sub_string($data['description'],255):sub_string(trim(strip_tags($data['content'])),255);
					$data['description']=filterhtml($data['description'],2);
				}

				// 自动给图片加 ALT 标签
				if(isset($_POST['auto_alt']) && $_POST['auto_alt']==1)
				{
					$data['content']=add_alt($data['content'],strip_tags($data['title']));
				}

				// 自动获取内容图片作为标题图片
				if(isset($_POST['auto_thumb']) && $_POST['auto_thumb']==1 && !$data['thumb'])
				{
					$imgs=get_images($data['content']);
					if($imgs)
					{
						$imgindex=isset($_POST['imgindex'])?min(sizeof($imgs)-1,max(0,intval($_POST['imgindex']-1))):0;
						$data['thumb']=$imgs[$imgindex];
					}
				}
				continue;
			}

			/*
				特殊字段值格式化
			*/

			/**
				多选按钮 (无需验证正则)
			*/
			if($r[$key]['form']=='checkbox')
			{
				$data[$key]=implode(',', $value);
				continue;
			}

			/**
				多张图片 (无需验证正则)
			*/
			if($r[$key]['form']=='images' && isset($_POST['urlimgs_'.$r[$key]['enname']]))
			{
				$urlimgs=$_POST['urlimgs_'.$r[$key]['enname']];
				$deleteimgs=$_POST['deleteimgs_'.$r[$key]['enname']];
				$nameimgs=$_POST['nameimgs_'.$r[$key]['enname']];
				$t=array();

				if($urlimgs)
				{
					foreach($urlimgs as $keyimgs => $url)
					{
		
						if(!empty($url) &&  is_image($url))
						{
							if(!isset($deleteimgs[$keyimgs]) || $deleteimgs[$keyimgs])
							{
								if(!FTP)
								{
									@unlink(RETENG_ROOT.$url);
								}
								else
								{
									$ftpobj->ftp_delete(FTP_DIR.'/'.str_replace(FTP_URL.'/','',$url));
								}
							}
							else
							{
								$t[]=str_replace(array('`','|'),'',$nameimgs[$keyimgs]).'|'.$url;
							}
						}
					}
					$data[$key]=implode('`',$t);
				}
				continue;
			}

			/**
				附件下载 (无需验证正则)
			*/

			if($r[$key]['form']=='attachment' && isset($_POST['urlattches_fieldid'.$r[$key]['enname']]))
			{
				$urlattches=$_POST['urlattches_fieldid'.$r[$key]['enname']];
				$deleteattches=$_POST['deleteattches_fieldid'.$r[$key]['enname']];
				$nameattches=$_POST['nameattches_fieldid'.$r[$key]['enname']];
				$t=array();
				if($urlattches)
				{
					foreach($urlattches as $keyattches => $url)
					{
						$url=preg_replace('/[^a-z0-9\.]/i','',$url);
						if(!empty($url) && file_exists(RETENG_ROOT.'/data/attached/'.$url) && in_array(get_fileext($url),array('zip','rar','gz','pdf','doc','docx','xls','xlsx','txt')))
						{
							if(!isset($deleteattches[$keyattches]) || $deleteattches[$keyattches])
							{
								@unlink(RETENG_ROOT.'/data/attached/'.$url);
							}
							else
							{
								$t[]=htmlspecialchars(str_replace(array('`','|'),'',$nameattches[$keyattches])).'|'.'/data/attached/'.$url;
							}
						}
					}
					$data[$key]=implode('`',$t);
				}
				continue;
			}

			/**
				级联菜单 (无需验证正则)
			*/

			if(substr($r[$key]['form'],0,11)=='selectmenu_')
			{
				$menu_top_select=isset($_POST[$r[$key]['enname'].'_top_select'])?$_POST[$r[$key]['enname'].'_top_select']:'';
				$menu_self_select=isset($_POST[$r[$key]['enname'].'_self_select'])?$_POST[$r[$key]['enname'].'_self_select']:'';
				$menu_son_select=isset($_POST[$r[$key]['enname'].'_son_select'])?$_POST[$r[$key]['enname'].'_son_select']:'';
			
				if(isset($menu_son_select) && $menu_son_select)
				{
					$data[$key]=htmlspecialchars($menu_son_select);
				}
				else if(isset($menu_self_select) && $menu_self_select)
				{
					$data[$key]=htmlspecialchars($menu_self_select);
				}
				else if(isset($menu_top_select) && $menu_top_select)
				{
					$data[$key]=htmlspecialchars($menu_top_select);
				}
				continue;
			}
			
			/*
				根据表单限制检查是否符合要求
			*/
			if($r[$key]['regex']=='limit3_50')
			{
				$len=strlen($value);
				if($len>50)showmsg($r[$key]['name'].$baselang['max-50']);
				if($len<3)showmsg($r[$key]['name'].$baselang['min-3']);
			}
			else if($r[$key]['regex']=='email' && !preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i',$value) && $value)
			{
				showmsg($baselang['err-email']);
			}
			else if($r[$key]['regex']=='url' && !preg_match('/^http:\/\/[A-Za-z0-9]+\.?[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/i',$value) &&$value)
			{
				showmsg($baselang['err-url']);
			}
			else if($r[$key]['regex']=='phone' && !preg_match('/^[0-9\-\(\)\.]+$/i',$value) &&$value)
			{
				showmsg($baselang['err-phone']);
			}
			else if($r[$key]['regex']=='number' && !preg_match('/^[\d\.]*$/i',$value) &&$value)
			{
				showmsg($r[$key]['name'].$baselang['float-0-9']);
			}
			else if(strtolower($r[$key]['regex'])=='username' && !preg_match('/^[\x80-\xff_a-zA-Z0-9]{1,60}$/i',$value))
			{
				showmsg($baselang['err-username']);
			}
			else if(strtolower($r[$key]['regex'])=='usepsw' && !preg_match('/^[0-9a-z_]{3,30}$/i',$value))
			{
				showmsg($baselang['err-pwd']);
			}
			else if(strtolower($r[$key]['regex'])=='integer' && !preg_match('/^[0-9]+$/',$value) &&$value)
			{
				showmsg($r[$key]['name'].$baselang['integer-0-9']);
			}
			else if(strtolower($r[$key]['regex'])=='english' && !preg_match('/^[a-z0-9_]+$/i',$value) &&$value)
			{
				showmsg($r[$key]['name'].$baselang['err-a0_']);
			}
			else if(strtolower($r[$key]['regex'])=='qq' && !preg_match('/^[0-9]{3,15}$/i',$value) &&$value)
			{
				showmsg($baselang['err-qq']);
			}
			else if(strtolower($r[$key]['regex'])=='mobile' && !preg_match('/^[01][0-9_]{10,14}$/i',$value) &&$value)
			{
				showmsg($baselang['err-telephone']);
			}
			else if(strtolower($r[$key]['regex'])=='ip' && !preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/i',$value) &&$value)
			{
				showmsg($baselang['err-ip']);
			}
			else if(strtolower($r[$key]['regex'])=='chinese' && !preg_match('/^[\x80-\xff_a-zA-Z0-9]+$/i',$value) &&$value)
			{
				showmsg($r[$key]['name'].$baselang['err-a0_']);
			}
		}
		return $data;
	}
}
?>