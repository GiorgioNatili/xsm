<?php

class projectCommon
{
	public $params=array();
	public $conn;
	public $texts;

	public $mimes=array(
			'all'=>array(
				'ext'=>array('jpg','gif','png','pdf','doc','docx','odt','JPG','GIF','PNG','PDF','DOC','DOCX','ODT'),
				'mime'=>array('image/jpeg','image/pjpeg','image/gif','image/png','application/pdf','application/msword','application/octet-stream','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.oasis.opendocument.text'),
			),
			'img'=>array(
				'ext'=>array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG'),
				'mime'=>array('image/jpeg','image/pjpeg','image/gif','image/png'),
			),
		);

	function __construct()
	{
		$this->conn=&$GLOBALS['portal']->conn;
		$this->params=&$GLOBALS['portal']->params;
		$this->texts=&$GLOBALS['portal']->texts;
	}

	function logInjection($type,$field,$value)
	{
		$forbidden=array('select','delete','insert','update','create','drop','truncate','alter','rename','replace');
		foreach ($forbidden as $taboo)
		{
			if(strstr($value,$taboo))
			{
				$params=array();
				$params['query_string']=mysql_real_escape_string($_SERVER['QUERY_STRING']);
				$params['type']=mysql_real_escape_string($type);
				$params['field']=mysql_real_escape_string($field);
				$params['value']=mysql_real_escape_string($value);
				if($id_user=$this->isLoggedIn())
					$params['id_user_fk']=intval($id_user);
				else
					$params['id_user_fk']='funct:null';
				$params['ip']=$_SERVER['REMOTE_ADDR'];
				$params['date_time']='funct:now()';
				
				$query = new sqlQuery();
				$sql=$query->createQuery('admin_abuse',$params,1);
				mysql_query($sql,$this->conn);
				
				return true;
				break;
			}
		}
		return false;
	}

	function getParams()
	{
		$this->params=array();

		foreach ($_POST as $key=>$value)
		{
			if(!is_array($value))
			{
				if(!get_magic_quotes_gpc())
				{
					$_POST[$key]=addslashes($value);
				}
				$this->logInjection('POST',$key,$value);
			}
			else
			{
				foreach ($value as $key2=>$value2)
				{
					if(!get_magic_quotes_gpc())
					{
						$_POST[$key][$key2]=addslashes($value2);
					}
					$this->logInjection('POST',$key,$value2);
				}
			}
		}


		foreach ($_GET as $key=>$value)
		{
			if(get_magic_quotes_gpc())
			{
				$_GET[$key]=mysql_real_escape_string(stripslashes($value));
			}
			else
			{
				$_GET[$key]=mysql_real_escape_string($value);
			}
			$this->logInjection('GET',$key,$value);
		}

		$this->params[LANG]=LANG_EN;
		
		# dzial
		if(isset($_GET[PART_ID]))
			$this->params[PART_ID]=$_GET[PART_ID];
		else
			$this->params[PART_ID]= PART_MAIN;
		#poddzial
		if(isset($_GET[SUBPART_ID]))
			$this->params[SUBPART_ID]=$_GET[SUBPART_ID];
		else
			$this->params[SUBPART_ID]= null;

		# id
		if(isset($_GET[ID]))
			$this->params[ID]=intval($_GET[ID]);
		else
			$this->params[ID]=null;

		#id2
		if(isset($_GET[ID2]))
			$this->params[ID2]=intval($_GET[ID2]);
		else
			$this->params[ID2]=null;
		#
		if(isset($_GET[TOKEN]))
			$this->params[TOKEN]=$_GET[TOKEN];
		else
			$this->params[TOKEN]=null;
		#


		if(isset($_GET[SEARCH_TOKEN]))
		{
			$this->params[SEARCH_TOKEN]=$_GET[SEARCH_TOKEN];
		}
		else
		{
			$this->params[SEARCH_TOKEN]=null;
		}
		
		if(isset($_GET[TAB]))
		{
			$this->params[TAB]=intval($_GET[TAB]);
		}
		else
		{
			$this->params[TAB]=null;
		}
		
		#
		if(isset($_GET[PAGE_ID]))
			$this->params[PAGE_ID]=intval($_GET[PAGE_ID]);
		else
			$this->params[PAGE_ID]=1;
		#
		if(isset($_GET[PRINTER]))
			$this->params[PRINTER]=intval($_GET[PRINTER]);
		else
			$this->params[PRINTER]=null;
		#
		if(isset($_GET[FULLPAGE]))
			$this->params[FULLPAGE]=intval($_GET[FULLPAGE]);
		else
			$this->params[FULLPAGE]=null;
		#
		if(isset($_GET[ACTIVATE]))
			$this->params[ACTIVATE]=intval($_GET[ACTIVATE]);
		else
			$this->params[ACTIVATE]=null;
		#
		if(isset($_GET[EDIT]))
			$this->params[EDIT]=intval($_GET[EDIT]);
		else
			$this->params[EDIT]=null;
		#
		if(isset($_GET[ADD]))
			$this->params[ADD]=intval($_GET[ADD]);
		else
			$this->params[ADD]=null;
		#
		if(isset($_GET[ADD2]))
			$this->params[ADD2]=intval($_GET[ADD2]);
		else
			$this->params[ADD2]=null;
		#
		if(isset($_GET[DELETE]))
			$this->params[DELETE]=intval($_GET[DELETE]);
		else
			$this->params[DELETE]=null;
		#
		if(isset($_GET[DELETE2]))
			$this->params[DELETE2]=intval($_GET[DELETE2]);
		else
			$this->params[DELETE2]=null;
		#
		if(isset($_GET[COMMENT]))
			$this->params[COMMENT]=intval($_GET[COMMENT]);
		else
			$this->params[COMMENT]=null;
		#
		if(isset($_GET[COMMENTS]))
			$this->params[COMMENTS]=intval($_GET[COMMENTS]);
		else
			$this->params[COMMENTS]=null;
		#
		if(isset($_GET[ID_COMMENT]))
			$this->params[ID_COMMENT]=intval($_GET[ID_COMMENT]);
		else
			$this->params[ID_COMMENT]=null;
		#
		if(isset($_GET[INFO]))
			$this->params[INFO]=intval($_GET[INFO]);
		else
			$this->params[INFO]=null;
		#
		
		
		if(isset($_GET[QUERY]))
			$this->params[QUERY]=$_GET[QUERY];
		else
			$this->params[QUERY]=null;

		if(isset($_GET[GRADE]))
			$this->params[GRADE]=intval($_GET[GRADE]);
		else
			$this->params[GRADE]=null;

		if(isset($_GET[ORDER]))
			$this->params[ORDER]=intval($_GET[ORDER]);
		else
			$this->params[ORDER]=null;

		if(isset($_GET[SHOW_ALL]))
			$this->params[SHOW_ALL]=intval($_GET[SHOW_ALL]);
		else
			$this->params[SHOW_ALL]=0;

		if(isset($_GET[CATEGORY]))
			$this->params[CATEGORY]=intval($_GET[CATEGORY]);
		else
			$this->params[CATEGORY]=0;
		
		if(isset($_GET[USER]))
			$this->params[USER]=intval($_GET[USER]);
		else
			$this->params[USER]=0;

		if(isset($_GET[SUBSCRIBE]))
			$this->params[SUBSCRIBE]=intval($_GET[SUBSCRIBE]);
		else
			$this->params[SUBSCRIBE]=0;

		if(isset($_GET[REQUEST]))
			$this->params[REQUEST]=intval($_GET[REQUEST]);
		else
			$this->params[REQUEST]=0;

		if(isset($_GET[LETTER]))
		{
			if(strlen($_GET[LETTER])>0)
				$this->params[LETTER]=$_GET[LETTER];
			else
				$this->params[LETTER]=null;
		}
		else
		{
			$this->params[LETTER]=null;
		}
		################################

		if(isset($_GET[ORDER]))
			$this->params[ORDER]=intval($_GET[ORDER]);
		else
			$this->params[ORDER]=null;

		
		if(isset($_GET[ANNOUNCES]))
			$this->params[ANNOUNCES]=intval($_GET[ANNOUNCES]);
		else
			$this->params[ANNOUNCES]=null;
		################################

		if(isset($_GET[SEARCH]))
			$this->params[SEARCH]=intval($_GET[SEARCH]);
		else
			$this->params[SEARCH]=null;
		//		
		if(isset($_GET[SEARCH_NAME]))
			$this->params[SEARCH_NAME]=$_GET[SEARCH_NAME];
		else
			$this->params[SEARCH_NAME]=null;
		//
		
		if(isset($_GET[SEARCH_YEAR]))
			$this->params[SEARCH_YEAR]=intval($_GET[SEARCH_YEAR]);
		else
			$this->params[SEARCH_YEAR]=null;
		//
		if(isset($_GET[APPROVE]))
			$this->params[APPROVE]=intval($_GET[APPROVE]);
		else
			$this->params[APPROVE]=null;
		//
	}





	function getlink($params=array(),$showdomain=1,$rewrite=0)
	{
		$href='';

		if($params[PART_ID]==PART_MAIN)
		{
			$params[PART_ID]=null;

			//return ROOTURL;
		}

		unset($params[LANG]);
		
		
		if(isset($params[PAGE_ID]) and $params[PAGE_ID]==1) $params[PAGE_ID]=null;
		

		$rewriteURL='';
		

		$first=1;
		while (list($klucz, $wartosc) = each($params))
		{
			if($wartosc)
			{
				if(!$first) $href.='&amp;';
				$href.=$klucz.'='.$wartosc;
				$first=0;
			}
		}

		#if($rewriteURL) $href.='&amp;rewrite='.$rewriteURL;

		if($showdomain)
			$url=SERVICE_WWW;
		else
			$url=SERVICE_ROOT;
		if($rewriteURL)
			$url.=$rewriteURL;
		if($href)
			$url.='?'.$href;

		return $url;

		/*
		if($href)
		{
			if($showdomain)
				$href=ROOTURL.'?'.$href;
			else
				$href=ROOT.'?'.$href;
		}

		return $href;
		*/
	}

	

	
	
	function showDateTime($datetime)
	{
		$dt='';
		$datetime=explode(' ',$datetime);
		if(isset($datetime[0]) and $datetime[0]!='0000-00-00')
		{
			$dt=$this->showDate($datetime[0]);
			if(isset($datetime[1]))
			{
				$dt.=', '.$this->showTime($datetime[1]);
			}
		}
		return $dt;

	}

	function showDate($data)
	{
		$kiedy=split(' ',$data);
		$data=split('-',$kiedy[0]);
		if (count($data)==3)
		{
			if (intval($data[0])>0 and intval($data[1])>0 and intval($data[2])>0)
				return "$data[2]-$data[1]-$data[0]";
			elseif (intval($data[0])>0 and intval($data[1])==0 and intval($data[2])==0)
				return "rok $data[0]";
			elseif (intval($data[0])>0 and intval($data[1])>0 and intval($data[2])==0)
				return $this->Miesiac($data[1]) .' '. $data[0];
		}
	}

	function showTime($czas)
	{
		$kiedy=split(':',$czas);
		$godzina='';
		if (count($kiedy)>1)
		{
			$godzina=intval($kiedy[0]).':';
			if(intval($kiedy[1])<10) $godzina.='0';
			$godzina.=intval($kiedy[1]);

			return $godzina;
		}
	}


	function isDate($data)
	{
		$error=0;
		$dt=explode('-',$data);
		if(count($dt)==3)
		{
			return checkdate($dt[1], $dt[2], $dt[0]);
		}
		else
			return 0;


	}

	function isTime($time)
	{
		if($time and $time!='00:00:00')
			return 1;
		else
			return 0;
	}


	protected function isEmail($email)
    {
        if (version_compare(PHP_VERSION, '5.2.0') >= 0)
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL))
                return 1;
            return 0;
        }
        else
        {
            if (ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $email))
                return 1;
            return 0;
        }
    }




	function Miesiac($miesiac,$tryb=0)
	{
		switch($miesiac)
		{
			case 1:
				if ($tryb==0) return 'styczeń'; else return 'styczniu';
			break;
			case 2:
				if ($tryb==0) return 'luty'; else return 'lutym';
			break;
			case 3:
				if ($tryb==0) return 'marzec'; else return 'marcu';
			break;
			case 4:
				if ($tryb==0) return 'kwiecień'; else return 'kwietniu';
			break;
			case 5:
				if ($tryb==0) return 'maj'; else return 'maju';
			break;
			case 6:
				if ($tryb==0) return 'czerwiec'; else return 'czerwcu';
			break;
			case 7:
				if ($tryb==0) return 'lipiec'; else return 'lipcu';
			break;
			case 8:
				if ($tryb==0) return 'sierpień'; else return 'sierpniu';
			break;
			case 9:
				if ($tryb==0) return 'wrzesień'; else return 'wrześniu';
			break;
			case 10:
				if ($tryb==0) return 'październik'; else return 'październiku';
			break;
			case 11:
				if ($tryb==0) return 'listopad'; else return 'listopadzie';
			break;
			case 12:
				if ($tryb==0) return 'grudzień'; else return 'grudniu';
			break;
			default:
		}
	}




	

	




	

	function errStyle()
	{
		return 'style="border:solid RED 1px;"';
	}


	function errMsg($msg)
	{
		if($msg)
			return '<span style="color:red;"> '.$msg.'</span>';
		else
			return '';
	}

	function goodMsg($msg)
	{
		if($msg)
			return '<span style="color:green;"> '.$msg.'</span>';
		else
			return '';
	}
	
	
	protected function redirect($href,$convertAmp=1)
	{
		if($href)
		{
			if($convertAmp) $href=str_replace('&amp;','&',$href);
			header("Location: $href");
			exit();
		}
	}

	function reload()
	{
		$params=$this->params;
		$href=$this->getlink($params);
		$this->redirect($href);
	}
	
	
	
	


	function errSpan($text)
	{
		return '<span style="color:red;">'.$text.'</span>';
	}
	
	
	
	
	
	
	
	
	
	
	

	public function emailExists($email,$id_user=0)
	{
		$sql="select id_user_pk from users where email='$email'";
		if($id_user) $sql.=" and id_user_pk<>$id_user";
		return intval($this->getOneValueFromSql($sql));
	}
	
	
	
	
	
	
	
	protected function getConfigValue($code)
	{
		$code=mysql_real_escape_string($code);
		$sql="select * from config where code='$code'";
		if($row=$this->getOneRowFromSql($sql))
		{
			switch ($row['type'])
			{
				case 'int':
					return intval($this->getDBText($row,'value'));
				break;
				case 'float':
					return floatval($this->getDBText($row,'value'));
				break;
				case 'money':
					return round(floatval($this->getDBText($row,'value')),2);
				break;
				case 'string':
					return $this->getDBText($row,'value');
				break;
			}
		}
	}
	
	
	protected function getPOST($postname)
	{
		$value='';
		if (isset($_POST[$postname]))
		{
			$value=$_POST[$postname];
		}
		return $value;
	}

	protected function getGET($postname)
	{
		$value='';
		if (isset($_GET[$postname]))
		{
			$value=$_GET[$postname];
		}
		return $value;
	}
	
	
	protected function setSession($key,$value)
	{
		$_SESSION[SESSION_PREFIX.'_'.$key]=$value;
	}

	protected function getSession($key)
	{
		if(isset($_SESSION[SESSION_PREFIX.'_'.$key]))
		{
			return $_SESSION[SESSION_PREFIX.'_'.$key];
		}
		return null;
	}

	protected function getSessionKeyName($key)
	{
		return SESSION_PREFIX.'_'.$key;
	}
	
	protected function unsetSession($key)
	{
		if(isset($_SESSION[SESSION_PREFIX.'_'.$key]))
		{
			unset($_SESSION[SESSION_PREFIX.'_'.$key]);
		}
		return null;
	}

	protected function destroySession()
	{
		foreach($_SESSION as $session_key => $session_value)
		{
			if(substr($session_key,0,strlen(SESSION_PREFIX)) == SESSION_PREFIX)
			{
				#echo $session_key.'<br/>';
				unset($_SESSION[$session_key]);
			}
		}
		#exit();
	}
	
	
	protected function connectDB()
	{
		//echo DB_NAME;
		if($conn=mysql_connect(DB_SERV,DB_USER,DB_PASS))
		{
			if(mysql_select_db(DB_NAME,$conn))
			{
				mysql_query('set names utf8',$conn);
				return $conn;
			}
			else
			{
				echo 'db select failed';
				exit();
			}
		}
		else 
		{
			echo 'db connect failed';
			exit();
		}
	}
	
	
	

	protected function closeDB()
	{
		mysql_close($this->conn);
	}
	
	protected function count_records($sql)
	{
		if(strstr('select * ',$sql))
		{
			$sql=str_replace('select * ','select count(*) ',$sql);
			if($res=$this->dbQuery($sql))
			{
				if($row=mysql_fetch_row($res))
				{
					return $row[0];
				}
			}
		}
		else
		{
			if($res=$this->dbQuery($sql))
			{
				return mysql_num_rows($res);
			}
		}
		#echo mysql_error();
		return 0;
	}

	
	
	protected function getOneValueFromSqlTable($table,$field,$condition)
	{
		$sql="
			select $field
			from $table
			where $condition
		";
		return $this->getOneValueFromSql($sql);
	}

	protected function getOneValueFromSql($sql)
	{
		if($res=$this->dbQuery($sql))
		{
			if($row=mysql_fetch_row($res))
			{
				mysql_free_result($res);
				return $row[0];
			}
		}
		if(mysql_errno())
		{
			#echo $sql;
			#echo mysql_error();
		}
		return null;
	}

	
	protected function getAllRowsFromSql($sql)
	{
		$rows=array();
		if($res=$this->dbQuery($sql))
		{
			while ($row=mysql_fetch_assoc($res))
			{
				$rows[]=$row;
			}
			mysql_free_result($res);
			return $rows;
		}
		#echo mysql_error();
		return null;
	}
	
	protected function getOneRowFromSql($sql)
	{
		if($res=$this->dbQuery($sql))
		{
			if($row=mysql_fetch_array($res))
			{
				mysql_free_result($res);
				return $row;
			}
		}
		#echo mysql_error();
		return null;
	}

	protected function getOneRowFromSqlTable($table,$condition)
	{
		$sql="
			select *
			from $table
			where $condition
		";
		return $this->getOneRowFromSql($sql);
	}


	protected function dbQuery($sql)
	{
		$res=mysql_query($sql,$this->conn);
		
		if(mysql_errno($this->conn))
		{
			if($file=fopen(CACHE_DIR.'sqlErrors-'.date('Y-m-d').'.txt', 'a+'))
			{
				$log='';
				$log.=date('Y-m-d H:i')."\n\r";
				$log.=$sql."\n\r";
				$log.=mysql_error($this->conn)."\n\r";
				$log.="-------------------------------------------------------------------------\n\r";
				fwrite($file, $log);
				fclose($file);
			}
		}
		
		return $res;
	}

	protected function decode($str,$convert_enters=0)
	{
		$str=trim(stripslashes($str));
		if($convert_enters)
		{
			//$str=str_replace("\n",'<br />',$str);
			$str=nl2br($str);
		}
		return $str;
	}
	
	protected function isMainPage()
	{
		if($this->params[PART_ID]==PART_MAIN or ! $this->params[PART_ID])
			return true;
		else
			return false;
	}

	protected function linkMainPage()
	{
		return ROOTURL;
	}

	protected function setSessionMessage($id,$text)
	{
		$this->setSession('session_msg_'.$id,$text);
	}

	protected function getSessionMessage($id)
	{
		$text=$this->getSession('session_msg_'.$id);
		$this->unsetSession('session_msg_'.$id);
		return $text;
	}
	
	protected function create_token($key='')
	{
		if(!$key)$key=rand(1,100000);
		return md5(microtime().$key);
	}
	
	protected function isLoggedIn()
	{
		$user = $this->getSession(DOCTOR);
		$admin = $this->getSession(ADMIN);
		
		if((isset($user['user_id']) && $user['user_id'] > 0) || (isset($admin['admin_id']) && $admin['admin_id'] > 0))
			return true;
		else
			return false;
	}
	
	protected function isAdmin()
	{
		$user = $this->getSession(ADMIN);
		if(isset($user['admin_id']) && $user['admin_id'] > 0)
			return true;
		else
			return false;
	}
	
	public function getTexts()
	{
		$sql="
			select lt.code,text_en
			from languages_texts as lt
		";
		$res=mysql_query($sql,$this->conn);
		while ($row=mysql_fetch_assoc($res))
		{
			$code=$row['code'];
			$this->texts[ $code ]=array();
			//foreach ($langs as $key=>$value)
			{
				$this->texts[ $code ][ 'en' ]=$this->decode($row['text_en']);
			}
		}
	}
	
	public function getText($text, $lang = 'en')
	{
		if(isset($this->texts[$text][ $lang ]) and $this->texts[$text][ $lang ])
		{
			return $this->texts[$text][ $lang ];
		}
		elseif(isset($this->texts[$text][LANG_EN]) and $this->texts[$text][LANG_EN])
		{
			return $this->texts[$text][LANG_EN];
		}
		else 
		{
			return $this->texts[$text][LANG_PL];
		}
		return 'LNG_ERROR';
	}
	
	
	function getDBText($row,$field,$convert_enters=0)
	{
		if(isset($row[ $field.'_'.$this->params[LANG] ]) and $row[ $field.'_'.$this->params[LANG] ]!='')
		{
			return $this->decode($row[ $field.'_'.$this->params[LANG] ],$convert_enters);
		}
		elseif(isset($row[ $field.'_en' ]) and $row[ $field.'_en' ]!='')
		{
			return $this->decode($row[ $field.'_en' ],$convert_enters);
		}
		else
		{
			return $this->decode($row[ $field.'_pl' ],$convert_enters);
		}
		return 'DB_TEXT_ERROR';
	}
	
	
	public function getTextSmarty()
	{
		$smarty=array();
		foreach (array_keys ($this->texts) as $key)
		{
			$smarty[$key]=$this->getText($key);
		}
		return $smarty;
	}
	
	
	protected function getPregValue($pattern,$string)
	{
		$par=array();
		preg_match($pattern,$string,$par);
		if(isset($par[0]) and $par[0]!='')
			return $par[0];
		else
			return '';
	}
	
	
	
	protected function getCMSFileInfo($id_file)
	{
		$info=array();

		$plik=array();
		if(isset($GLOBALS['admin_files'][$id_file]))
		{
			$plik=array();
			$plik['id_file_pk']=$id_file;
			$plik['folderpath']=$GLOBALS['admin_files'][$id_file]['folderpath'];
			$plik['file']=$GLOBALS['admin_files'][$id_file]['file'];
		}
		else
		{
			$sql="
				select f.id_file_pk,f.file,f.folderpath
				from admin_files as f
				where f.id_file_pk=$id_file
				limit 0,1
			";
			
			$res=mysql_query($sql,$this->conn);  #echo mysql_error();
			if($plik=mysql_fetch_assoc($res))
			{
				$GLOBALS['admin_files'][$plik['id_file_pk']]=array(
					'folderpath'=>$plik['folderpath'],
					'file'=>$plik['file']
				);
				
			}
			else
			{
				return $info;
			}
		}
		#var_dump($plik);
		#echo count($plik);

		if(count($plik)>0)
		{
			$filepath=FILE_DIR.$plik['folderpath'].'/'.$plik['file'];
			//echo ">>".$filepath."<<";
			if(file_exists($filepath))
			{
				$ext=$this->getFileExtension($plik['file']);
				switch($ext)
				{
					case 'pdf':
						$info=array();
						$info['id_file']=$plik['id_file_pk'];
						$info['file_name']=$plik['file'];
						$info['file_path']=$filepath;
						$info['folder_path']=$plik['folderpath'];
						$info['www_path']=FILE_WWW.$plik['folderpath'].'/'.$plik['file'];
						$info['x']=800;
						$info['y']=600;
						$info['size']=filesize($filepath);
						$info['mime']='application/pdf';
						$info['ext']=$ext;
						break;
					default:
						$info=array();
						$fileinfo=getimagesize($filepath);
						$info['id_file']=$plik['id_file_pk'];
						$info['file_name']=$plik['file'];
						$info['file_path']=$filepath;
						$info['folder_path']=$plik['folderpath'];
						$info['www_path']=FILE_WWW.$plik['folderpath'].'/'.$plik['file'];
						$info['x']=$fileinfo[0];
						$info['y']=$fileinfo[1];
						$info['size']=filesize($filepath);
						$info['mime']=$fileinfo['mime'];
						$info['ext']=$ext;
				}
				return $info;
			}

		}
		return false;
	}
	
	
	protected function getFileExtension($filename)
	{
		$p=explode('.',$filename);
		if(count($p))
			return $p[count($p)-1];
		else
			return '';
	}
	
	
	public function sendNewEmailNotification($mail_to, $id_notification)
	{
		$sql = 'SELECT text FROM notifications WHERE id_notification_pk = '.intval($id_notification);
		if($body = $this->getOneValueFromSql($sql))
		{
			$mail=new sendmail();
			$mail->fromName=SERVICE_NAME;
			$mail->from=MAIL_SERVER_USER;
			$mail->to=$mail_to;
			$mail->subject='[iMet] New message';
			$mail->smarty_template='default/emailDefault.tpl';
			
			$mail->smarty_assigns=array(
				'mainPageLink'=>$this->getlink(array(PART_ID=>PART_MAIN)),
				'logo'=>SERVICE_WWW.'templates/default/images/logomail.png',
				'emailBody'=>$body,
			);
			$mail->attachNotCmsImages=false;
			
			// przez firewall!
			return true;
			
			if($mail->send())
			{
				return true;
			}
			else
			{
				$f = fopen(CACHE_DIR.'mailsend_err_'.date('Y_m_d_H_i_s'), 'w');
				fwrite($f, 'mail error - projectCommon'."\n");
				fclose($f);
				return false;
			}
		}
		return false;
	}
	
	
	protected function getLocalFileInfo($filePath)
	{
		$filePath=str_replace('..', '', $filePath);
		
		$info=array();

		$file=array();
		if(isset($GLOBALS['local_files'][$filePath]))
		{
			$file['file']=$filePath;
			$file['folderpath']=$GLOBALS['local_files'][$filePath]['folderpath'];
			$file['file']=$GLOBALS['local_files'][$filePath]['file'];
		}
		else
		{
			if(file_exists(FILE_DIR.$filePath))
			{
				$arr_folder=explode('/',$filePath);
				$filename=array_pop($arr_folder);
				
				$GLOBALS['local_files'][$filePath]=array(
					'folderpath'=>implode('/',$arr_folder),
					'file'=>$filename
				);
				
				$file['filepath']=$filePath;
				$file['folderpath']=$GLOBALS['local_files'][$filePath]['folderpath'];
				$file['file']=$GLOBALS['local_files'][$filePath]['file'];
			}
			else 
			{
				return $info;
			}
			

		}
		#var_dump($plik);
		#echo count($plik);

		if(count($file)>0)
		{
			$localPath=FILE_DIR.$file['folderpath'].'/'.$file['file'];

			//echo ">>".$filepath."<<";
			if(file_exists($localPath))
			{
				$ext=$this->getFileExtension($file['file']);
				switch($ext)
				{
					case 'pdf':
						$info=array();
						$info['id_file']=0;
						$info['file_name']=$file['file'];
						$info['file_path']=$localPath;
						$info['www_path']=FILE_WWW.$file['folderpath'].'/'.$file['file'];
						$info['x']=800;
						$info['y']=600;
						$info['size']=filesize($localPath);
						$info['mime']='application/pdf';
						$info['ext']=$ext;
						break;
					default:
						$info=array();
						$fileinfo=getimagesize($localPath);
						$info['id_file']=0;
						$info['file_name']=$file['file'];
						$info['file_path']=$localPath;
						$info['www_path']=FILE_WWW.$file['folderpath'].'/'.$file['file'];
						$info['x']=$fileinfo[0];
						$info['y']=$fileinfo[1];
						$info['size']=filesize($localPath);
						$info['mime']=$fileinfo['mime'];
						$info['ext']=$ext;
				}
				return $info;
			}

		}
		return false;
	}
	
	
	public function getDoctorsPatients($id_doctor)
	{
		// site-y lekarza
		$sites = array();
		$sql = 'SELECT DISTINCT(id_site_fk) FROM sites_doctors WHERE id_doctor_fk = '.$id_doctor;
		$res = $this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$sites[] = $row['id_site_fk'];
		}
		
		// pacjenci
		$patients = array();
		$sql = 'SELECT id_patient_pk FROM patients WHERE id_site_fk IN ('.implode(',', $sites).')';
		$res = $this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$patients[] = $row['id_patient_pk'];
		}
		
		return $patients;
	}
	
	
	public function getSiteDoctors($id_site, $idOnly=true)
	{
		$id_doctors = array();
		$list = array();
		
		$sql = 'SELECT DISTINCT(id_doctor_fk) FROM sites_doctors WHERE id_site_fk = '.$id_site;
		$res = $this->dbQuery($sql);
		while($row = mysql_fetch_assoc($res))
		{
			$id_doctors[] = $row['id_doctor_fk'];
		}
		if($idOnly || !count($id_doctors)) return $id_doctors;
		
		$sql = 'SELECT * FROM doctors WHERE id_doctor_pk IN ('.implode(',', $id_doctors).')';
		$res = $this->dbQuery($sql);
		while($row = mysql_fetch_assoc($res))
		{
			$list[] = $row;
		}
		
		return $list;
	}
	
	
}


?>
