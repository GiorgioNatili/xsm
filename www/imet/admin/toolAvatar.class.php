<?php
define('TOOL_AVATAR','toolAvatar');
$GLOBALS['toolClasses'][TOOL_AVATAR]='toolAvatar';

class toolAvatar extends projectCommon 
{
	public $params=array();
	public $conn=null;
	
	public $title='';
	public $lead='';
	public $body='';
	public $link='';
	public $texts=array();
	
	public $navigation=array();
	
	function __construct()
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		$this->navigation = &$GLOBALS['portal']->navigation;
		$this->texts = &$GLOBALS['portal']->texts;
	}
	

	public function content()
	{
		/*
		$texts = array();
		$sql='SELECT * FROM holiday ORDER BY month, day';
		$res = mysql_query($sql);
		
		while($row = mysql_fetch_assoc($res))
		{
			$texts[] = array(
				'date'=>$row['day'].' '.date('F', mktime(0, 0, 0, ($row['month']+1), 0, 0)),
				'text'=>$this->decode($row['name_en']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_HOLIDAY, ID=>$row['id_holiday_pk'])),
				'delHref'=>$this->getlink(array(PART_ID=>TOOL_HOLIDAY, DELETE=>$row['id_holiday_pk'])),
			);
		}
		
		return array(
			'addNewHref'=>$this->getlink(array(PART_ID=>TOOL_HOLIDAY, ADD=>1)),
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'textsList'=>$texts,
			'template'=>'admin/toolHoliday.tpl',
		);
		*/
	}

	
	
	
}


?>