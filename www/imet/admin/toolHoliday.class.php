<?php
define('TOOL_HOLIDAY','toolholiday');
$GLOBALS['toolClasses'][TOOL_HOLIDAY]='toolHoliday';

class toolHoliday extends projectCommon 
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
		if($this->params[DELETE])
		{
			$sql = 'SELECT day FROM holiday WHERE id_holiday_pk = '.$this->params[DELETE];
			if($this->getOneValueFromSql($sql))
			{
				$sql='DELETE FROM holiday WHERE id_holiday_pk = '.$this->params[DELETE];
				mysql_query($sql);
				$this->redirect($this->getlink(array(PART_ID=>TOOL_HOLIDAY)));
			}
		}
		elseif($this->params[ADD])
		{
			$form=new form('formTexts');
				
			$inp_day=new formSelect($form,'day','','',true,'width:50px;','','border:1px solid red','');
			$days[] = array('key'=>0,'value'=>'');
			for($i=1; $i<=31; $i++)
			{
				$days[] = array('key'=>$i,'value'=>$i);
			}
			
			$inp_day->source=$days;
			$inp_day->init();
			if($form->isSubmitted() and $inp_day->error)
			{
				$inp_day->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			###
			
			$inp_month=new formSelect($form,'month','','',true,'width:140px;','','border:1px solid red','');
			$months[] = array('key'=>0,'value'=>'');
			for($i=1; $i<=12; $i++)
			{
				$months[] = array('key'=>$i,'value'=>date('F', mktime(0, 0, 0, $i+1, 0, 0)));
			}
			$inp_month->source=$months;
			$inp_month->init();
			if($form->isSubmitted() and $inp_month->error)
			{
				$inp_month->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			###
			
			$inp_name=new formInputBox($form,'name','','',true,255,'','adminInput','','');
			$inp_name->init();
			if($form->isSubmitted() && $inp_name->error)
			{
				$inp_name->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			
			if($form->isSubmitted() && $form->isValid())
			{
				$query=new sqlQuery();
				$query->table='holiday';
				$query->addString('name_en', $inp_name->value);
				$query->addInt('day', $inp_day->value);
				$query->addInt('month', $inp_month->value);
				$sql = $query->createInsert();
				mysql_query($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				$this->redirect($this->getlink(array(PART_ID=>TOOL_HOLIDAY)));
			}
			
			return array(
				'new'=>1,
				'form'=>$form->smarty(),
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_HOLIDAY)),
				'template'=>'admin/toolHoliday.tpl',
			);
		}
		elseif($this->params[ID])
		{
			$sql='SELECT * FROM holiday WHERE id_holiday_pk = '.$this->params[ID];
			$page = $this->getOneRowFromSql($sql);
			
			$form=new form('formTexts');
				
			$inp_day=new formSelect($form,'day','',$page['day'],true,'width:50px;','','border:1px solid red','');
			$days[] = array('key'=>0,'value'=>'');
			for($i=1; $i<=31; $i++)
			{
				$days[] = array('key'=>$i,'value'=>$i);
			}
			
			$inp_day->source=$days;
			$inp_day->init();
			if($form->isSubmitted() and $inp_day->error)
			{
				$inp_day->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			###
			
			$inp_month=new formSelect($form,'month','',$page['month'],true,'width:140px;','','border:1px solid red','');
			$months[] = array('key'=>0,'value'=>'');
			for($i=1; $i<=12; $i++)
			{
				$months[] = array('key'=>$i,'value'=>date('F', mktime(0, 0, 0, $i+1, 0, 0)));
			}
			$inp_month->source=$months;
			$inp_month->init();
			if($form->isSubmitted() and $inp_month->error)
			{
				$inp_month->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			###
			
			$inp_name=new formInputBox($form,'name','',$page['name_en'],true,255,'','adminInput','','');
			$inp_name->init();
			if($form->isSubmitted() && $inp_name->error)
			{
				$inp_name->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			
			if($form->isSubmitted() && $form->isValid())
			{
				$query=new sqlQuery();
				$query->table='holiday';
				$query->addInt('day', $inp_day->value);
				$query->addInt('month', $inp_month->value);
				$query->addString('name_en', $inp_name->value);
				$sql = $query->createUpdate('id_holiday_pk = '.$this->params[ID]);
				mysql_query($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_HOLIDAY)));
				else $this->reload();
			}
			
			return array(
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'form'=>$form->smarty(),
				'singleText'=>$page,
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_HOLIDAY)),
				'template'=>'admin/toolHoliday.tpl',
			);
		}
		
		
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
	}

	
	
	
}


?>