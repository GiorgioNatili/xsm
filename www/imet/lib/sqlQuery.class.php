<?php
if(!defined('DB_ENGINE'))
{
	define('DB_ENGINE','mysql');
}


/**
 * Generowanie zapytań INSERT i UPDATE w SQL
 *
 */
class sqlQuery
{
	private $insertKeys='';
	private $insertValues='';
	private $updateParams='';
	
	public $table;
	
	function __construct($table='')
	{
		$this->table=$table;
	}



	public function addInt($field,$value)
	{
		$this->addInsertKey("`$field`");
		$this->addInsertValue(intval($value));
		$this->addUpdateParam("`$field`",intval($value));
		
	}

	public function addFloat($field,$value)
	{
		$this->addInsertKey("`$field`");
		$this->addInsertValue(floatval($value));
		$this->addUpdateParam("`$field`",floatval($value));
	}
	
	public function addString($field,$value)
	{
		$field=strip_tags($field);
		$this->addInsertKey("`$field`");
		$this->addInsertValue("'".mysql_real_escape_string($value)."'");
		$this->addUpdateParam("`$field`","'".mysql_real_escape_string($value)."'");
	}

	public function addHtml($field,$value)
	{
		$this->addInsertKey("`$field`");
		$this->addInsertValue("'".addslashes($value)."'");
		$this->addUpdateParam("`$field`","'".addslashes($value)."'");
	}
	
	public function addFunction($field,$function)
	{
		$this->addInsertKey("`$field`");
		$this->addInsertValue($function);
		$this->addUpdateParam("`$field`",$function);
	}
	
	public function addNull($field)
	{
		$this->addInsertKey("`$field`");
		$this->addInsertValue('null');
		$this->addUpdateParam("`$field`",'null');
	}
	
	public function addCurrentDate($field)
	{
		switch(DB_ENGINE)
		{
			case 'mysql':
			default:
				$this->addInsertKey("`$field`");
				$this->addInsertValue('curdate()');
				$this->addUpdateParam("`$field`",'curdate()');
		}
	}
	
	public function addCurrentDateTime($field)
	{
		switch(DB_ENGINE)
		{
			case 'mysql':
			default:
				$this->addInsertKey("`$field`");
				$this->addInsertValue('now()');
				$this->addUpdateParam("`$field`",'now()');
		}
	}
	
	public function addCurrentIP($field)
	{
		switch(DB_ENGINE)
		{
			case 'mysql':
			default:
				$this->addInsertKey("`$field`");
				$this->addInsertValue("'".$_SERVER['REMOTE_ADDR']."'");
				$this->addUpdateParam("`$field`","'".$_SERVER['REMOTE_ADDR']."'");
		}
	}
	
	public function createInsert($delayed=0)
	{
		if($this->table)
		{
			if($delayed and DB_ENGINE=='mysql')
				return "insert delayed into {$this->table} ({$this->insertKeys})values({$this->insertValues})";
			else 
				return "insert into {$this->table} ({$this->insertKeys})values({$this->insertValues})";
		}
	}
	
	public function createReplace()
	{
		if($this->table)
		{
			return "replace into {$this->table} ({$this->insertKeys})values({$this->insertValues})";
		}
	}
	
	public function createUpdate($condition)
	{
		if($this->table)
		{
			return "update {$this->table} set {$this->updateParams} where $condition";
		}
	}

	
	private function addInsertKey($key)
	{
		if($this->insertKeys) $this->insertKeys.=',';
		$this->insertKeys.=$key;
	}
	
	private function addInsertValue($value)
	{
		if($this->insertValues) $this->insertValues.=',';
		$this->insertValues.=$value;
	}
	private function addUpdateParam($key,$value)
	{
		if($this->updateParams) $this->updateParams.=',';
		$this->updateParams.=$key.'='.$value;
	}
	
	public function isReady()
	{
		if($this->updateParams)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function createQuery($table,$params,$insert,$wheres='')
	{
		#var_dump($params);exit();
		$fields=''; $values=''; $sets='';
		
		$first=1;
		while (list($klucz, $wartosc) = each($params)) 
		{
			if (!$first)
			{
				$fields.=',';
				$values.=',';
				$sets.=",";	
			}
			else
				$first=0;
			
			$fields.=$klucz;
			#phpinfo();
			
			$typ=gettype($wartosc);
			#echo "typ $typ <br>";
			switch($typ)
			{
				#
				case 'bool':
				case 'bolean':
					$numeric=1;
					if($wartosc=true) $wartosc=1; else $wartosc=0;
				break;
				#
				case 'object':
				case 'array':
				case 'resource':
					$numeric=1;
					$wartosc='null';
				break;
				#
				case 'integer';
				case 'int':
				case 'double':
				case 'float':
					$numeric=1;
				break;
				case 'NULL':
					$numeric=1;
					$wartosc='null';
				break;
				#
				case 'string':
				default:
					$numeric=0;
				#
			}
			
			
			if ($numeric)
			{
				$values.=$wartosc;
				$sets.="$klucz=$wartosc";
			}
			elseif(substr($wartosc,0,6)=='funct:')
			{
				$wartosc=str_replace('funct:','',$wartosc);
				$values.="$wartosc";
				$sets.="$klucz=$wartosc";
			}
			else
			{
				$values.="'$wartosc'";
				$sets.="$klucz='$wartosc'";
			}
		}	
		if ($insert==1)
		{
			$query="insert into $table ($fields)values($values)";
		}
		else
		{
			if ($wheres!='')
			{
				$query="update $table set $sets where $wheres";	
			}	
		}
	return $query;
	}
	
}





?>