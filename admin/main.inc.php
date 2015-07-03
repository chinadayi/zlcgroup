<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	$action=empty($action)?'main':trim($action);
	switch ($action)
	{
		case 'main':
			include(RETENG_ROOT.'include/admin/admin.class.php');
			$admin=new admin();
			include admin_tlp('main');
			break;
		case 'dict_update':
			/*
				更新词库, 不破坏用户自定义词库
			*/
			set_time_limit(0);
			if(!is_writeable(RETENG_ROOT.'include/dict/cnwords.dict') || !is_writeable(RETENG_ROOT.'include/dict/'))
			{
				exit('<script language="javascript">alert("文件 ./include/dict/cnwords.dict 不可写, 请设置为0777后重试!");</script>');
			}

			$dict=file_get_contents(RETENG_DATA.'patch/cnwords.dict');
			if($dict)
			{
				$olddict=file_get_contents(RETENG_ROOT.'include/dict/cnwords.dict');
				$olddict=$olddict?$olddict:'';
				$olddict=explode("\r\n",$olddict);
				$dict=explode("\r\n",$dict);
				$dict=implode("\r\n",array_unique(array_merge($olddict,$dict)));
				file_put_contents(RETENG_ROOT.'include/dict/cnwords.dict',trim($dict));
				exit('<script language="javascript">alert("词库更新成功!");history.back();</script>');
			}
			else
			{
				exit('<script language="javascript">alert("无法链接升级服务器, 请稍后重试!");</script>');
			}
			break;
	}
?>
