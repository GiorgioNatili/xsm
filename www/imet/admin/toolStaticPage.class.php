<?php
define('TOOL_STATIC','toolpage');
$GLOBALS['toolClasses'][TOOL_STATIC]='toolStaticPage';

class toolStaticPage extends projectCommon 
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
			$sql='SELECT * FROM static_pages WHERE id_static_page_pk = '.$this->params[ID];
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
			
			
			if($form->isSubmitted() && $form->isValid())
			{
				$query=new sqlQuery();
				$query->table='static_pages';
				$query->addString('title', $inp_title->value);
				$query->addString('body', $inp_body->value);
				$sql = $query->createUpdate('id_static_page_pk = '.$this->params[ID]);
				mysql_query($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_STATIC)));
				else $this->reload();
			}
			
			return array(
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'form'=>$form->smarty(),
				'singlePage'=>$page,
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_STATIC)),
				'template'=>'admin/toolStaticPage.tpl',
			);
		}
		
		
		
		
		$pages = array();
		$sql='SELECT * FROM static_pages';
		$res = mysql_query($sql);
		
		while($row = mysql_fetch_assoc($res))
		{
			$pages[] = array(
				'title'=>$this->decode($row['title']),
				'body'=>$this->decode($row['body']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_STATIC, ID=>$row['id_static_page_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'pagesList'=>$pages,
			'template'=>'admin/toolStaticPage.tpl',
		);
	}

	
	
	
}


?>