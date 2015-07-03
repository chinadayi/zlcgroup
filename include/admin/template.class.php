<?php
/**
	* 模管理板类
*/

class template
{
	public $pagestring;
	private $c;

	function __construct()
	{
		global $c;
		$this->c=$c;
	}

	function template()
	{
		$this->__construct();
	}

	function projectlist()
	{
		$result=$results=$files=$alls=array();
		$projectinfo=cache_read('template.inc.php',TPL_ROOT);

		$alls=glob(TPL_ROOT.'*');
		$files=glob(TPL_ROOT.'*.*');
		$results=array_diff($alls,$files);

		if($results)foreach($results as $key => $_results)
		{
			if(basename($_results)!='system')
			{
				$result[$key]['dir']=basename($_results);
				$result[$key]['mtime']=date('Y-m-d H:i:s',filemtime($_results));
				$result[$key]['isdefault']=basename($_results)==TPL_NAME?1:0;
				$result[$key]['name']=isset($projectinfo[basename($_results)])?$projectinfo[basename($_results)]:basename($_results);
			}
		}
		return $result;
	}

	function rename_project($names)
	{
		if(!is_array($names) || !$names) return false;

		$projectinfo=cache_read('template.inc.php',TPL_ROOT);
		foreach($names as $dir => $name)
		{
			$projectinfo[$dir]=$name;
		}
		cache_write('template.inc.php',$projectinfo,TPL_ROOT);
		return true;
	}

	function delete_project($project)
	{
		if(!file_exists(TPL_ROOT.$project))
		{
			return true;
		}

		if($project==TPL_NAME || empty($project))
		{
			return false;
		}
		
		rmdirs(TPL_ROOT.$project);

		$projectinfo=cache_read('template.inc.php',TPL_ROOT);

		if($projectinfo && isset($projectinfo[$project]))
		{
			unset($projectinfo[$project]);
			cache_write('template.inc.php',$projectinfo,TPL_ROOT);
		}
		return true;
	}

	function templatelist($project='',$class='',$page=1,$k='',$pagesize=30)
	{
		$project=$project?$project:TPL_NAME;
		$projectpath=$class?TPL_ROOT.$project.'/'.$class.'/':TPL_ROOT.$project.'/';
		$templateinfo=cache_read('template.inc.php',$projectpath);

		$result=array();
		$templates=glob($projectpath.'*.htm');
		
		if($templates)foreach($templates as $key => $template)
		{
			$result[$key]['name']=isset($templateinfo[basename($template,'.htm')])?$templateinfo[basename($template,'.htm')]:'未知模板';
			$result[$key]['template']=basename($template,'.htm');
			$result[$key]['mtime']=date('Y-m-d H:i:s',filemtime($template));

			if($k && strpos($result[$key]['name'],$k)===FALSE && strpos($result[$key]['template'],$k)===FALSE && strpos($result[$key]['template'],basename($k,'.html'))===FALSE)
			{
				unset($result[$key]);
			}
		}

		$this->pagestring='共 '.count($result).' 条记录，当前第 '.$page.'/'.max(1,ceil(count($result)/$pagesize)).' 页 <a href="?file=template&action=manage&project='.$project.'&class='.$class.'&k='.$k.'">首页</a> <a href="?file=template&action=manage&project='.$project.'&class='.$class.'&page='.max(1,$page-1).'&k='.$k.'">上一页</a> <a href="?file=template&action=manage&project='.$project.'&class='.$class.'&page='.min(max(1,ceil(count($result)/$pagesize)),$page+1).'&k='.$k.'">下一页</a> <a href="?file=template&action=manage&project='.$project.'&class='.$class.'&page='.max(1,ceil(count($result)/$pagesize)).'&k='.$k.'">尾页</a>';
		return array_slice($result,($page-1)*$pagesize,$pagesize);
	}

	function rename_template($names,$project='',$class='')
	{
		if(!is_array($names) || !$names) return false;

		$project=$project?$project:TPL_NAME;
		$projectpath=$class?TPL_ROOT.$project.'/'.$class.'/':TPL_ROOT.$project.'/';
		$templateinfo=cache_read('template.inc.php',$projectpath);

		foreach($names as $template => $name)
		{
			$templateinfo[$template]=$name;
		}
		cache_write('template.inc.php',$templateinfo,$projectpath);
		return true;
	}

	function delete_template($template,$project='',$class='')
	{
		$project=$project?$project:TPL_NAME;
		$projectpath=$class?TPL_ROOT.$project.'/'.$class.'/':TPL_ROOT.$project.'/';
		$templatefile=$projectpath.$template.'.htm';

		if(!$template || !file_exists($templatefile))return false;

		@unlink($templatefile);

		$templateinfo=cache_read('template.inc.php',$projectpath);

		if($templateinfo && isset($templateinfo[$template]))
		{
			unset($templateinfo[$template]);
			cache_write('template.inc.php',$templateinfo,$projectpath);
		}
		
		return true;
	}

	function add_template($info)
	{
		if(!$info) return false;

		$projectpath=TPL_ROOT.$info['project'].'/';
		$templateinfo=cache_read('template.inc.php',$projectpath);
		$templatefile=$projectpath.$info['template'].'.htm';

		/*
			生成静态文件
		*/

		file_put_contents($templatefile,stripslashes(trim($info['content'])));
		
		/*
			更新模板名称缓存
		*/
		$templateinfo[$info['template']]=$info['name'];

		cache_write('template.inc.php',$templateinfo,$projectpath);
		return true;
	}

	function edit_template($info,$template)
	{
		if(!$info || !$template) return false;

		$projectpath=$info['class']?TPL_ROOT.$info['project'].'/'.$info['class'].'/':TPL_ROOT.$info['project'].'/';
		$templateinfo=cache_read('template.inc.php',$projectpath);
		$bakfile=$projectpath.$template.'.bak';
		$templatefile=$projectpath.$template.'.htm';

		/*
			备份模板 2012-01-27 
		*/
		file_put_contents($bakfile,stripslashes(trim($info['bak'])));

		/*
			生成静态文件
		*/

		file_put_contents($templatefile,stripslashes(trim($info['content'])));
		
		/*
			更新模板名称缓存
		*/
		$templateinfo[$template]=$info['name'];

		cache_write('template.inc.php',$templateinfo,$projectpath);
		return true;
	}

	function templateinfo($template,$project='',$class='')
	{
		$result=array();
		$projectpath=$class?TPL_ROOT.$project.'/'.$class.'/':TPL_ROOT.$project.'/';
		$templateinfo=cache_read('template.inc.php',$projectpath);
		$templatefile=$projectpath.$template.'.htm';
		
		if(file_exists($templatefile))
		{
			$result['name']=isset($templateinfo[$template])?$templateinfo[$template]:'未知模板';
			$result['project']=$project;
			$result['class']=$class;
			$result['mtime']=date('Y-m-d H:i:s',filemtime($templatefile));
			$result['content']=htmlspecialchars(file_get_contents($templatefile));
		}
		return $result;
	}

	function check_template($data,$project)
	{
		return file_exists(TPL_ROOT.$project.'/'.$data.'.htm') && !empty($data)?true:false;
	}

	function perview($project='')
	{
		$project=!empty($project)?$project:TPL_NAME;
		set_cookie('project',$project);
		header("Cache-Control: no-cache, must-revalidate");
		header("location:".SITE_URL);
		exit();
	}
}
?>
