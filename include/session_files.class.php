<?php
/**
* session会话
* $session=new session();;
* session_start();
*/
class session
{
    function session()
    {
		$this->__construct();
    }

	function __construct()
	{
		if(!is_writeable(SESSION_SAVEPATH))exit('缓存目录不可写!');
		ini_set('session.save_handler', 'files');
    	session_save_path(SESSION_SAVEPATH);
	}
}
?>