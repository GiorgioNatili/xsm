<?php
define('TOOL_STIMULANTS','toolStimulants');
$GLOBALS['toolClasses'][TOOL_STIMULANTS]='toolStimulants';

	

class toolStimulants extends projectCommon 
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
		if($this->params[ID])
		{
			return $this->getOneCard($this->params[ID]);
		}
		
		
		$sql = 'SELECT *
				FROM pre_tlfb_stimulants
				ORDER BY stimulant
		';
		$res = $this->dbQuery($sql);
		
		$cards = array();
		
		while($row=mysql_fetch_assoc($res))
		{
			$cards[]=array(
				'stimulant'=>$this->decode($row['stimulant']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_STIMULANTS, ID=>$row['id_pre_tlfb_stimulant_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'cards'=>$cards,
			'template'=>'admin/toolStimulants.tpl',
		);
	}
	
	
	private function getOneCard($edit = null)
	{
		$card = array(
			'stimulant'=>'',
		);
		
		if($edit)
		{
			$sql='SELECT * FROM pre_tlfb_stimulants WHERE id_pre_tlfb_stimulant_pk='.$edit;
			if($row=$this->getOneRowFromSql($sql))
			{
				$card['stimulant']  = $this->decode($row['stimulant']);
			}
			else
			{
				$this->redirect($this->getlink(array(PART_ID=>TOOL_STIMULANTS)));
			}
		}
		
		$form=new form('card');
		
		$inp_stimulant=new formInputBox($form,'stimulant','',$card['stimulant'],true,255,'width:650px;','adminInput','border:1px solid red;width:650px;','');
		$inp_stimulant->init();
		if($form->isSubmitted() && $inp_stimulant->error)
		{
			$inp_stimulant->errMsg=$this->getText('form_pole_obowiazkowe');
		}

		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('pre_tlfb_stimulants');
			$q->addString('stimulant', $inp_stimulant->value);
			if($edit)
			{
				$sql = $q->createUpdate('id_pre_tlfb_stimulant_pk ='.$edit);
			}
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$edit) $this->redirect($this->getlink(array(PART_ID=>TOOL_STIMULANTS)));
			else $this->reload();
		}
		
		
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'form'=>$form->smarty(),
			'edit'=>($edit) ? true : false,
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_STIMULANTS)),
			'template'=>'admin/toolStimulants.tpl',
		);
	}

}


?>