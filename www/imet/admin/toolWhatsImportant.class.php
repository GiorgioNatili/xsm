<?php
define('TOOL_WHATS_IMPORTANT','toolWhatsImportant');
$GLOBALS['toolClasses'][TOOL_WHATS_IMPORTANT]='toolWhatsImportant';

	

class toolWhatsImportant extends projectCommon 
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
		
		
		$sql = 'SELECT stc.*, stt.type
				FROM session_tool2_cards stc
				INNER JOIN session_tool2_types stt ON stt.id_session_tool2_type_pk = stc.id_session_tool2_type_fk
				ORDER BY stc.id_session_tool2_type_fk
		';
		$res = $this->dbQuery($sql);
		
		$cards = array();
		
		while($row=mysql_fetch_assoc($res))
		{
			if($this->params[DELETE] == $row['id_session_tool2_card_pk'])
			{
				$sql='DELETE FROM session_tool2_cards WHERE id_session_tool2_card_pk = '.$this->params[DELETE];
				$this->dbQuery($sql);
				$this->redirect($this->getlink(array(PART_ID=>TOOL_WHATS_IMPORTANT)));
			}
			
			$cards[]=array(
				'label'=>$this->decode($row['label1']),
				'type'=>$this->decode($row['type']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_WHATS_IMPORTANT, ID=>$row['id_session_tool2_card_pk'])),
				'delHref'=>$this->getlink(array(PART_ID=>TOOL_WHATS_IMPORTANT, DELETE=>$row['id_session_tool2_card_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'cards'=>$cards,
			'newHref'=>$this->getlink(array(PART_ID=>TOOL_WHATS_IMPORTANT, ADD=>1)),
			'template'=>'admin/toolWhatsImportant.tpl',
		);
	}
	
	
	private function getOneCard($edit = null)
	{
		$card = array(
			'background'=>'',
			'type'=>'',
			'label1'=>'',
			'label2'=>'',
		);
		
		if($edit)
		{
			$sql='SELECT * FROM session_tool2_cards WHERE id_session_tool2_card_pk='.$edit;
			if($row=$this->getOneRowFromSql($sql))
			{
				$card['background']=substr($this->decode($row['background']), 2, strlen($this->decode($row['background']))-2);
				$card['type']=$this->decode($row['id_session_tool2_type_fk']);
				$card['label1']=$this->decode($row['label1']);
				$card['label2']=$this->decode($row['label2']);
			}
			else
			{
				$this->redirect($this->getlink(array(PART_ID=>TOOL_WHATS_IMPORTANT)));
			}
		}
		
		$form=new form('card');
		
		$inp_type=new formSelect($form,'type','typeSelect',$card['type'],true,'width:130px;','','width:130px;border:1px solid red','');
		$typesList = array(array('key'=>0,'value'=>''));
		$sql='SELECT id_session_tool2_type_pk,type FROM session_tool2_types';
		$res=$this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$typesList[] = array('key'=>$row['id_session_tool2_type_pk'], 'value'=>$this->decode($row['type']));
		}
		$inp_type->source=$typesList;
		$inp_type->init();
		if($form->isSubmitted() and $inp_type->error)
		{
			$inp_type->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		
		$inp_background=new formInputBox($form,'background','background',$card['background'],true,255,'width:100px;','adminInput','border:1px solid red;width:100px;','');
		$inp_background->autoComplete=false;
		$inp_background->init();
		if($form->isSubmitted() && $inp_background->error)
		{
			$inp_background->errMsg=$this->getText('form_pole_obowiazkowe');
		}


		$inp_label1=new formInputBox($form,'label1','',$card['label1'],true,255,'width:300px;','adminInput','border:1px solid red;width:300px;','');
		$inp_label1->init();
		if($form->isSubmitted() && $inp_label1->error)
		{
			$inp_label1->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		
		$inp_label2=new formInputBox($form,'label2','',$card['label2'],false,255,'width:300px;','adminInput','','');
		$inp_label2->init();
		if($form->isSubmitted() && $inp_label2->error)
		{
			$inp_label2->errMsg=$this->getText('form_pole_obowiazkowe');
		}

		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('session_tool2_cards');
			$q->addInt('id_session_tool2_type_fk', intval($inp_type->value));
			$q->addString('label1', strip_tags($inp_label1->value));
			if((intval($inp_type->value) == 2 || intval($inp_type->value) == 3) && strip_tags($inp_label2->value))
			{
				$q->addString('label2', strip_tags($inp_label2->value));
			}
			$q->addString('background', '0x'.strip_tags($inp_background->value));
			
			if($edit)
			{
				$sql = $q->createUpdate('id_session_tool2_card_pk ='.$edit);
			}
			else
			{
				$sql = $q->createInsert();
			}
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$edit) $this->redirect($this->getlink(array(PART_ID=>TOOL_WHATS_IMPORTANT)));
			else $this->reload();
		}
		
		
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'form'=>$form->smarty(),
			'addNew'=>($edit) ? false : true,
			'edit'=>($edit) ? true : false,
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_WHATS_IMPORTANT)),
			'template'=>'admin/toolWhatsImportant.tpl',
		);
	}

}


?>