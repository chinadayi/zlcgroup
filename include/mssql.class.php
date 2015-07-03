<?php
class mssql
{
	public $dblink;
	public $pconnect;
	private $rs;
	private $cursor = 0;
	private $querynum = 0;

	function connect($hostname,$username,$userpwd,$database,$pconnect=false)
	{
		$this->pconnect=$pconnect;
		$this->dblink=$pconnect?mssql_pconnect($hostname,$username,$userpwd):mssql_connect($hostname,$username,$userpwd);
		if(!$this->dblink ||!is_resource($this->dblink))
		{
			echo("Can not connect to MsSQL server!");
			return false;
		}
		mssql_query ('SET TEXTSIZE 65536',$this->dblink);
		if(!@mssql_select_db($database,$this->dblink))
		{
			echo("Can not select database!");
			return false;
		}
		return $this->dblink;
	}

	function query($sql)
	{
		$this->querynum++;
		$sql = trim($sql);
		if(preg_match("/^(select.*)limit\s+([0-9]+)(,([0-9]+))?$/i", $sql, $matchs))
		{
			$sql = $matchs[1];
			$offset = $matchs[2];
			$pagesize = $matchs[4];
			if(!$query = mssql_query($sql, $this->dblink))
			{
				echo('MsSQL Query Error'.$sql);
				return false;
			}
			return $this->limit($query, $offset, $pagesize);
		}
		else
		{
			if(!$query = mssql_query($sql, $this->dblink))
			{
				echo('MsSQL Query Error'.$sql);
				return false;
			}
			return $query;
		}
	}

	function fetch_all($sql)
	{
		$this->rs=$this->query($sql);
		$result=array();
		while($rows=$this->fetch_array($this->rs,MSSQL_ASSOC))
		{
			$result[]=$rows;
		}
		
		mssql_free_result($this->rs);
		return $result; 
	}

	function fetch_array($query, $type = MSSQL_ASSOC)
	{
		if(is_resource($query)) return mssql_fetch_array($query, $type);
		if($this->cursor < count($query))
		{ 
			return $query[$this->cursor++]; 
		}
		return false; 
	}

	function limit($query, $offset, $pagesize = 0)
	{
		if($pagesize > 0)
		{
			mssql_data_seek($query, $offset);
		}
		else
		{
			$pagesize = $offset;
		}
		$info = array();

		for($i = 0; $i < $pagesize; $i++)
		{
			$r = $this->fetch_array($query);
			if(!$r) break;
			$info[] = $r;
		}
		$this->free_result($query);
		$this->cursor = 0;
		return $info;
	}

	function free_result($query)
	{
		if(is_resource($query))
		{
			mssql_free_result($query);
		}
	}

	function close()
	{
		if($this->dblink && is_resource($this->dblink) && !$this->pconnect)
		{
			return mssql_close($this->dblink);
		}
		return true;
	}
}