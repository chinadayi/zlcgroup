<?php
/**
* Mysql数据库类
*/
@ini_set('mysql.trace_mode','Off');
class mysql
{
	public $dblink;
	public $pconnect;
	private $search = array('/union(\s*(\/\*.*\*\/)?\s*)+select/i', '/load_file(\s*(\/\*.*\*\/)?\s*)+\(/i', '/into(\s*(\/\*.*\*\/)?\s*)+outfile/i');
	private $replace = array('union &nbsp; select', 'load_file &nbsp; (', 'into &nbsp; outfile');
	private $rs;

	function connect($hostname,$username,$userpwd,$database,$pconnect=false,$charset='utf8')
	{
		$this->pconnect=$pconnect;
		$this->dblink=$pconnect?mysql_pconnect($hostname,$username,$userpwd):mysql_connect($hostname,$username,$userpwd);
		(!$this->dblink || !is_resource($this->dblink)) && fatal_error("Errno:".mysql_errno()."<br />Error:".mysql_error(),mysql_errno());
		mysql_unbuffered_query("SET names ".$charset);
		if($this->version()>'5.0.1')
		{
			mysql_unbuffered_query("SET character_set_connection=".$charset.",character_set_results=".$charset.",character_set_client=binary,sql_mode = ''");
			@mysql_query("SET sql_mode=''");
		}
		@mysql_select_db($database,$this->dblink) or fatal_error("Errno:".mysql_errno()."<br />Error:".mysql_error(),mysql_errno());
		return $this->dblink;
	}

	function query($sql,$unbuffered=false)
	{
		$this->rs=$unbuffered?mysql_unbuffered_query($sql,$this->dblink):mysql_query($sql,$this->dblink);
		if(!$this->rs)
		{
			fatal_error("Errno:".mysql_errno()."<br />Error:".mysql_error().'<br />SQL:'.$sql,mysql_errno());
		}
		return $this->rs;
	}

	function get_maxfield($filed='id',$table) // 获取$table表中$filed字段的最大值
	{
		$r=$this->fetch_one("SELECT {$table}.{$filed} FROM {$table} ORDER BY {$table}.`{$filed}` DESC LIMIT 0,1");
		return $r[$filed];
	}

	function get_minfield($filed='id',$table) // 获取$table表中$filed字段的最小值
	{
		$r=$this->fetch_one("SELECT {$table}.{$filed} FROM {$table} ORDER BY {$table}.`{$filed}` ASC LIMIT 0,1");
		return $r[$filed];
	}
	
	function fetch_one($sql)
	{
		$this->rs=$this->query($sql);
		return $this->filter_pass(mysql_fetch_array($this->rs,MYSQL_ASSOC));
	}

	function fetch_all($sql)
	{
		$this->rs=$this->query($sql);
		$result=array();
		while($rows=mysql_fetch_array($this->rs,MYSQL_ASSOC))
		{
			$result[]=$this->filter_pass($rows);
		}
		
		mysql_free_result($this->rs);
		return $result; 
	}

	function last_insert_id()
	{
		if(($insertid=mysql_insert_id($this->dblink))>0)return $insertid;
		else //如果 AUTO_INCREMENT 的列的类型是 BIGINT，则 mysql_insert_id() 返回的值将不正确.
		{
			$result=$this->fetch_one('select LAST_INSERT_ID() as insertId');
			return $result['insertId'];
		}
	}

	function insert($tbname,$varray,$replace=false)
	{
		$varray=$this->escape($varray);
		$tb_fields=$this->get_fields($tbname); // 2010-5-15 升级一下，增加判断字段是否存在
		
		foreach($varray as $key => $value)
		{
			if(in_array($key,$tb_fields))
			{
				$fileds[]='`'.$key.'`';
				$values[]=is_string($value)?'\''.$value.'\'':$value;
			}
		}

		if($fileds)
		{
			$fileds=implode(',',$fileds);
			$fileds=str_replace('\'','`',$fileds);
			$values=implode(',',$values);
			$sql=$replace?"replace into {$tbname}({$fileds}) values ({$values})":"insert into {$tbname}({$fileds}) values ({$values})";
			$this->query($sql,true);
			return $this->last_insert_id();
		}
		else return false;
	}

	function update($tbname, $array, $where = '')
	{
		$array=$this->escape($array);
		if($where)
		{
			$tb_fields=$this->get_fields($tbname); // 2010-5-16 升级一下，增加判断字段是否存在
			
			$sql = '';
			foreach($array as $k=>$v)
			{
				if(in_array($k,$tb_fields))
				{
					$k=str_replace('\'','',$k);
					$sql .= ", `$k`='$v'";
				}
			}
			$sql = substr($sql, 1);
			
			if($sql)$sql = "UPDATE $tbname SET $sql WHERE $where";
			else return true;
		}
		else
		{
			$sql = "REPLACE INTO $tbname(`".implode('`,`', array_keys($array))."`) VALUES('".implode("','", $array)."')";
		}
		return $this->query($sql,true);
	}
	
	function mysql_delete($tbname,$idarray,$filedname='id')
	{
		$idwhere=is_array($idarray)?implode(',',$idarray):intval($idarray);
		$where=is_array($idarray)?"{$tbname}.{$filedname} in ({$idwhere})":" {$tbname}.{$filedname}={$idwhere}";
		return $this->query("delete from {$tbname} where {$where}",true);
	}

	function get_fields($table)
	{
		$fields=array();
		$result=$this->fetch_all("SHOW COLUMNS FROM {$table}");
		foreach($result as $val)
		{
			$fields[]=$val['Field'];
		}
		return $fields;
	}

	function get_table_status($database)
	{
		$status=array();
		$r=$this->fetch_all("SHOW TABLE STATUS FROM `".$database."`"); /////// SHOW TABLE STATUS的性质与SHOW TABLE类似，不过，可以提供每个表的大量信息。
		foreach($r as $v)
		{
			$status[]=$v;
		}
		return $status;
	}

	function get_one_table_status($table)
	{
		return $this->fetch_one("SHOW TABLE STATUS LIKE '$table'");
	}

	function create_fields($tbname,$fieldname,$size=0,$type='VARCHAR') // 2010-5-14 修正一下
	{		
		if($size)
		{
			$this->query("ALTER TABLE {$tbname} ADD `$fieldname` {$type}( {$size} )  NOT NULL",true);
		}
		else $this->query("ALTER TABLE {$tbname} ADD `$fieldname` MEDIUMTEXT  NOT NULL",true);
		return true;
	}

	function get_tables() //获取所有表表名
	{
		$tables=array();
		$r=$this->fetch_all("SHOW TABLES");
		foreach($r as $v)
		{
			foreach($v as $v_)
			{
				$tables[]=$v_;
			}
		}
		return $tables;
	}

	function create_model_table($tbname) 
	{
		if(in_array($tbname,$this->get_tables())) return false;
		if($this->query("CREATE TABLE {$tbname} (
`contentid` mediumint(8) NOT NULL ,
`content` mediumtext NOT NULL,
KEY ( `contentid` ) 
) ENGINE = MyISAM DEFAULT charset=utf8",true))return true;
		return false;
	}

	function create_member_table($tbname) 
	{
		if(in_array($tbname,$this->get_tables())) return false;
		if($this->query("CREATE TABLE {$tbname} (
`userid` mediumint(8) NOT NULL ,
KEY ( `userid` ) 
) ENGINE = MyISAM DEFAULT charset=utf8",true))return true;
		return false;
	}

	function escape($str)
	{
		if(!is_array($str)) return str_replace(array('\n', '\r'), array(chr(10), chr(13)),mysql_real_escape_string(preg_replace($this->search,$this->replace, $str), $this->dblink));
		foreach($str as $key=>$val) $str[$key] = $this->escape($val);
		return $str;
	}

	function filter_pass($string,$disabledattributes = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'))
	{
		if(is_array($string))
		{
			foreach($string as $key => $val) $string[$key] = $this->filter_pass($val);
		}
		else
		{
			$string = stripslashes(preg_replace('/\s('.implode('|', $disabledattributes).').*?([\s\>])/', '\\2', preg_replace('/<(.*?)>/ie', "'<'.preg_replace(array('/javascript:[^\"\']*/i', '/(".implode('|', $disabledattributes).")[ \\t\\n]*=[ \\t\\n]*[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", $string)));
		}
		return $string;
	}

	function drop_table($tbname)
	{
		return $this->query("DROP TABLE IF EXISTS {$tbname}",true);
	}

	function version()
	{
		return mysql_get_server_info($this->dblink);
	}

	function close()
	{
		if($this->dblink && is_resource($this->dblink) && !$this->pconnect)
		{
			return mysql_close($this->dblink);
		}
		return true;
	}
}
?>