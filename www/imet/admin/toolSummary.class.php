<?php
define('TOOL_SUMMARY','toolSummary');
$GLOBALS['toolClasses'][TOOL_SUMMARY]='toolSummary';

class toolSummary extends projectCommon 
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
		if($this->params[ID])
		{
			$sql='SELECT * FROM summary WHERE id_summary_pk = '.$this->params[ID];
			$page = $this->getOneRowFromSql($sql);
			
			$form=new form('formSummary');
				
			$inp_title=new formInputBox($form,'event','',$page['event'],true,255,'','adminInput','','');
			$inp_title->init();
			if($form->isSubmitted() && $inp_title->error)
			{
				$inp_title->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			###
			
			$inp_description=new formInputBox($form,'description','',$page['description'],true,255,'','adminInput','','');
			$inp_description->init();
			if($form->isSubmitted() && $inp_description->error)
			{
				$inp_description->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			
			if($form->isSubmitted() && $form->isValid())
			{
				$query=new sqlQuery('summary');
				$query->addString('event', strip_tags($inp_title->value));
				$query->addString('description', strip_tags($inp_description->value));
				$sql = $query->createUpdate('id_summary_pk = '.$this->params[ID]);
				$this->dbQuery($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_SUMMARY)));
				else $this->reload();
			}
			
			return array(
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'form'=>$form->smarty(),
				'singleText'=>$page,
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_SUMMARY)),
				'template'=>'admin/toolSummary.tpl',
			);
		}
		
		
		$texts = array();
		$sql='SELECT * FROM summary ORDER BY id_summary_pk';
		$res = $this->dbQuery($sql);
		
		while($row = mysql_fetch_assoc($res))
		{
			$texts[] = array(
				'event'=>$this->decode($row['event']),
				'description'=>$this->decode($row['description']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_SUMMARY, ID=>$row['id_summary_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'textsList'=>$texts,
			'template'=>'admin/toolSummary.tpl',
		);
	}

	
	
	
}


?>