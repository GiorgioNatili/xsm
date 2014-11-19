<?php
define('TOOL_PROSANDCONS','toolProsAndCons');
$GLOBALS['toolClasses'][TOOL_PROSANDCONS]='toolProsAndCons';

class toolProsAndCons extends projectCommon 
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
			return $this->getOneCard($this->params[ID]);
		}
		
		if($this->params[ADD])
		{
			return $this->getOneCard();
		}
		
		$sql = 'SELECT stc.*, pts.stimulant
				FROM session_tool3_cards stc
				INNER JOIN pre_tlfb_stimulants pts ON pts.id_pre_tlfb_stimulant_pk = stc.id_stimulant_fk
				ORDER BY id_stimulant_fk, category, label';
		$res = $this->dbQuery($sql);

		$cards=array();
		while($card=mysql_fetch_assoc($res))
		{
			if($this->params[DELETE] == $card['id_session_tool3_card_pk'])
			{
				$sql='DELETE FROM session_tool3_cards WHERE id_session_tool3_card_pk = '.$this->params[DELETE];
				$this->dbQuery($sql);
				$this->redirect($this->getlink(array(PART_ID=>TOOL_PROSANDCONS)));
			}
			$cards[] = array(
				'stimulant'=>$this->decode($card['stimulant']),
				'category'=>$this->decode($card['category']),
				'label'=>$this->decode($card['label']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_PROSANDCONS, ID=>$card['id_session_tool3_card_pk'])),
				'delHref'=>$this->getlink(array(PART_ID=>TOOL_PROSANDCONS, DELETE=>$card['id_session_tool3_card_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'newHref'=>$this->getlink(array(PART_ID=>TOOL_PROSANDCONS, ADD=>1)),
			'cards'=>$cards,
			'template'=>'admin/toolProsAndCons.tpl',
		);
	}
	
	
	private function getOneCard($edit=null)
	{
		$card = array(
			'label'=>'',
			'category'=>'',
			'stimulant'=>'',
		);
		
		
		if($edit)
		{
			$sql='SELECT * FROM session_tool3_cards WHERE id_session_tool3_card_pk='.$edit;
			if($row=$this->getOneRowFromSql($sql))
			{
				$card['label']=$this->decode($row['label']);
				$card['category']=$this->decode($row['category']);
				$card['stimulant']=$this->decode($row['id_stimulant_fk']);
			}
			else
			{
				$this->redirect($this->getlink(array(PART_ID=>TOOL_PROSANDCONS)));
			}
		}
		
		$form=new form('card');
				
		$inp_label=new formInputBox($form,'label','',$card['label'],true,255,'width:300px;','adminInput','border:1px solid red;width:300px;','');
		$inp_label->init();
		if($form->isSubmitted() && $inp_label->error)
		{
			$inp_label->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_type=new formSelect($form,'category','',$card['category'],true,'width:130px;','','width:130px;border:1px solid red','');
		$typesList = array(
			array('key'=>0,'value'=>''),
			array('key'=>'pros','value'=>'pros'),
			array('key'=>'cons','value'=>'cons'),
		);
		$inp_type->source=$typesList;
		$inp_type->init();
		if($form->isSubmitted() and $inp_type->error)
		{
			$inp_type->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_stimulant=new formSelect($form,'stimulant','',$card['stimulant'],true,'width:210px;','','width:210px;border:1px solid red','');
		$stimulantsList = array(array('key'=>0,'value'=>''));
		$sql='SELECT id_pre_tlfb_stimulant_pk,stimulant FROM pre_tlfb_stimulants ORDER BY stimulant';
		$res=$this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$stimulantsList[]=array('key'=>$row['id_pre_tlfb_stimulant_pk'], 'value'=>$this->decode($row['stimulant']));
		}
		$inp_stimulant->source=$stimulantsList;
		$inp_stimulant->init();
		if($form->isSubmitted() and $inp_stimulant->error)
		{
			$inp_stimulant->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('session_tool3_cards');
			$q->addString('label', strip_tags($inp_label->value));
			if(in_array($inp_type->value, array('pros','cons')))
			{
				$q->addString('category', $inp_type->value);
			}
			$q->addInt('id_stimulant_fk', $inp_stimulant->value);
			if($edit)
			{
				$sql = $q->createUpdate('id_session_tool3_card_pk='.$edit);
			}
			else
			{
				$sql = $q->createInsert();
			}
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$edit) $this->redirect($this->getlink(array(PART_ID=>TOOL_PROSANDCONS)));
			else $this->reload();
		}
		
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'form'=>$form->smarty(),
			'edit'=>$edit,
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_PROSANDCONS)),
			'template'=>'admin/toolProsAndCons.tpl',
		);
	}

	
	
	
}


?>