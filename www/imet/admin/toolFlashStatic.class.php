<?php
define('TOOL_FLASHSTATIC','toolflashpage');
$GLOBALS['toolClasses'][TOOL_FLASHSTATIC]='toolFlashStatic';

class toolFlashStatic extends projectCommon 
{
	public $params=array();
	public $conn=null;
	
	public $title='';
	public $lead='';
	public $body='';
	public $body2='';
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
			$sql='SELECT * FROM session_static WHERE id_session_static_pk = '.$this->params[ID];
			$page = $this->getOneRowFromSql($sql);
			
			$form=new form('formStatic');
				
			$inp_title=new formInputBox($form,'title','',$page['title'],true,255,'','adminInput','','');
			$inp_title->init();
			if($form->isSubmitted() && $inp_title->error)
			{
				$inp_title->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			$inp_body=new formTextArea($form,'body','editor1',$page['body'],true,0,'','','','');
			$inp_body->init();
			if($form->isSubmitted() && $inp_body->error)
			{
				$inp_body->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			$inp_body2=new formTextArea($form,'body2','editor2',$page['body2'],false,0,'','','','');
			$inp_body2->init();
			if($form->isSubmitted() && $inp_body2->error)
			{
				$inp_body2->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			
			if($form->isSubmitted() && $form->isValid())
			{
				$query=new sqlQuery();
				$query->table='session_static';
				$query->addString('title', $inp_title->value);
				$query->addString('body', $inp_body->value);
				$query->addString('body2', $inp_body2->value);
				$sql = $query->createUpdate('id_session_static_pk = '.$this->params[ID]);
				mysql_query($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_FLASHSTATIC)));
				else $this->reload();
			}
			
			return array(
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'form'=>$form->smarty(),
				'singlePage'=>$page,
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_FLASHSTATIC)),
				'template'=>'admin/toolFlashStatic.tpl',
			);
		}
		
		
		
		
		$pages = array();
		$sql='SELECT * FROM session_static';
		$res = mysql_query($sql);
		
		while($row = mysql_fetch_assoc($res))
		{
			$pages[] = array(
				'title'=>$this->decode($row['title']),
				'body'=>$this->decode($row['body']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_FLASHSTATIC, ID=>$row['id_session_static_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'pagesList'=>$pages,
			'template'=>'admin/toolFlashStatic.tpl',
		);
	}

	
	
	
}


?>