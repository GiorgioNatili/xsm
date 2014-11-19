<?php
define('TOOL_NOTIFICATIONS','toolNotifications');
$GLOBALS['toolClasses'][TOOL_NOTIFICATIONS]='toolNotifications';

class toolNotifications extends projectCommon 
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
			$sql='SELECT * FROM notifications WHERE id_notification_pk = '.$this->params[ID];
			$page = $this->getOneRowFromSql($sql);
			
			$form=new form('formNotifications');
				
			$inp_body=new formTextArea($form,'body','editor1',$page['text'],true,0,'','','','');
			$inp_body->init();
			if($form->isSubmitted() && $inp_body->error)
			{
				$inp_body->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			
			if($form->isSubmitted() && $form->isValid())
			{
				$query=new sqlQuery('notifications');
				$query->addString('text', $inp_body->value);
				$sql = $query->createUpdate('id_notification_pk = '.$this->params[ID]);
				$this->dbQuery($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_NOTIFICATIONS)));
				else $this->reload();
			}
			
			return array(
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'form'=>$form->smarty(),
				'singleText'=>$page,
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_NOTIFICATIONS)),
				'template'=>'admin/toolNotifications.tpl',
			);
		}
		
		
		$texts = array();
		$sql='SELECT * FROM notifications ORDER BY id_notification_pk';
		$res = $this->dbQuery($sql);
		
		while($row = mysql_fetch_assoc($res))
		{
			$texts[] = array(
				'text'=>strip_tags($row['text']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_NOTIFICATIONS, ID=>$row['id_notification_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'textsList'=>$texts,
			'template'=>'admin/toolNotifications.tpl',
		);
	}

	
	
	
}


?>