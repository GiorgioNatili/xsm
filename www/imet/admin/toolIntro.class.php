<?php
define('TOOL_INTRO','toolIntro');
$GLOBALS['toolClasses'][TOOL_INTRO]='toolIntro';

	

class toolIntro extends projectCommon 
{
	public $params=array();
	public $conn=null;
	
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
		if($this->params[ADD])
		{
			return $this->getOneCard();
		}
		
		if($this->params[ID])
		{
			return $this->getOneCard($this->params[ID]);
		}
		
		
		$sql = 'SELECT i.*, it.type
				FROM intro i
				INNER JOIN intro_types it ON it.id_intro_type_pk = i.id_intro_type_fk
				ORDER BY i.id_intro_type_fk
		';
		$res = $this->dbQuery($sql);
		
		$cards = array();
		
		while($row=mysql_fetch_assoc($res))
		{
			if($this->params[DELETE] == $row['id_intro_pk'])
			{
				$sql='DELETE FROM intro WHERE id_intro_pk = '.$this->params[DELETE];
				$this->dbQuery($sql);
				$this->redirect($this->getlink(array(PART_ID=>TOOL_INTRO)));
			}
			
			$cards[]=array(
				'type'=>$this->decode($row['type']),
				'uid'=>$this->decode($row['uid']),
				'text'=>strip_tags($this->decode($row['text'])),
				'href'=>$this->getlink(array(PART_ID=>TOOL_INTRO, ID=>$row['id_intro_pk'])),
				'delHref'=>$this->getlink(array(PART_ID=>TOOL_INTRO, DELETE=>$row['id_intro_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'cards'=>$cards,
			'newHref'=>$this->getlink(array(PART_ID=>TOOL_INTRO, ADD=>1)),
			'template'=>'admin/toolIntro.tpl',
		);
	}
	
	
	private function getOneCard($edit = null)
	{
		$card = array(
			'type'=>'',
			'uid'=>'',
			'text'=>'',
		);
		
		if($edit)
		{
			$sql='SELECT * FROM intro WHERE id_intro_pk='.$edit;
			if($row=$this->getOneRowFromSql($sql))
			{
				$card['type']  = $this->decode($row['id_intro_type_fk']);
				$card['uid']  = $this->decode($row['uid']);
				$card['text'] = $this->decode($row['text']);
			}
			else
			{
				$this->redirect($this->getlink(array(PART_ID=>TOOL_INTRO)));
			}
		}
		
		$form=new form('card');
		
		$inp_type=new formSelect($form,'type','typeSelect',$card['type'],true,'width:300px;','','width:300px;border:1px solid red','');
		$typesList = array(array('key'=>0,'value'=>''));
		$sql='SELECT id_intro_type_pk,type FROM intro_types';
		$res=$this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$typesList[] = array('key'=>$row['id_intro_type_pk'], 'value'=>$this->decode($row['type']));
		}
		$inp_type->source=$typesList;
		$inp_type->init();
		if($form->isSubmitted() and $inp_type->error)
		{
			$inp_type->errMsg=$this->getText('form_pole_obowiazkowe');
		}


		$inp_uid=new formInputBox($form,'uid','',$card['uid'],true,255,'width:300px;','adminInput','border:1px solid red;width:300px;','');
		$inp_uid->init();
		if($form->isSubmitted() && $inp_uid->error)
		{
			$inp_uid->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_text=new formTextArea($form,'text','editor1',$card['text'],true,0,'','','','');
		$inp_text->init();
		if($form->isSubmitted() && $inp_text->error)
		{
			$inp_text->errMsg=$this->getText('form_pole_obowiazkowe');
		}

		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('intro');
			$q->addInt('id_intro_type_fk', intval($inp_type->value));
			$q->addString('uid', strip_tags($inp_uid->value));
			$q->addString('text', $inp_text->value);
			if($edit)
			{
				$sql = $q->createUpdate('id_intro_pk ='.$edit);
			}
			else
			{
				$sql = $q->createInsert();
			}
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$edit) $this->redirect($this->getlink(array(PART_ID=>TOOL_INTRO)));
			else $this->reload();
		}
		
		
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'form'=>$form->smarty(),
			'addNew'=>($edit) ? false : true,
			'edit'=>($edit) ? true : false,
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_INTRO)),
			'template'=>'admin/toolIntro.tpl',
		);
	}

}


?>