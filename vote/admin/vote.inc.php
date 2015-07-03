<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('vote',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	$action=empty($action)?'manage':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/vote.class.php';
	$vote=new vote();
	switch($action)
	{
		case 'manage':
			if(isset($do_submit)) 
			{
				if($vote->vote_editname($votename,$starttime,$endtime,$totalcount))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$vote->votelist();
			include admin_tlp('vote_manage','vote');			
			break;
		case 'vote_add':
			if(isset($do_submit)) 
			{
				if($vote->vote_add($info,$votenote))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('vote_add','vote');			
			break;
		case 'vote_edit':
			if(isset($do_submit)) 
			{
				if($vote->vote_edit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$info=$vote->voteinfo($id);
			include admin_tlp('vote_edit','vote');			
			break;
		case 'vote_delete':
			if($vote->vote_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'vote_view':
			$votestr=$vote->voteview($id);
			include admin_tlp('vote_view','vote');
			break;
	}
?>
