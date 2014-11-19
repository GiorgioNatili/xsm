<?php
define('TOOL_EXPERIENCED','toolExperienced');
$GLOBALS['toolClasses'][TOOL_EXPERIENCED]='toolExperienced';

	

class toolExperienced extends projectCommon 
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
		/*
		if($this->params[ADD])
		{
			return $this->getOneCard();
		}
		*/
		
		if($this->params[ID])
		{
			return $this->getOneCard($this->params[ID]);
		}
		
		
		$sql = 'SELECT stp.*
				FROM session_tool4_person stp
				ORDER BY stp.id_session_tool4_person_pk
		';
		$res = $this->dbQuery($sql);
		
		$cards = array();
		
		while($row=mysql_fetch_assoc($res))
		{
			if($this->params[DELETE] == $row['id_session_tool4_person_pk'])
			{
				$sql='DELETE FROM session_tool4_person WHERE id_session_tool4_person_pk = '.$this->params[DELETE];
				$this->dbQuery($sql);
				$this->redirect($this->getlink(array(PART_ID=>TOOL_EXPERIENCED)));
			}
			
			$cards[]=array(
				'id'=>$this->decode($row['id_session_tool4_person_pk']),
				'question'=>htmlspecialchars($this->decode($row['question'])),
				'href'=>$this->getlink(array(PART_ID=>TOOL_EXPERIENCED, ID=>$row['id_session_tool4_person_pk'])),
				'delHref'=>$this->getlink(array(PART_ID=>TOOL_EXPERIENCED, DELETE=>$row['id_session_tool4_person_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'cards'=>$cards,
			//'newHref'=>$this->getlink(array(PART_ID=>TOOL_EXPERIENCED, ADD=>1)),
			'template'=>'admin/toolExperienced.tpl',
		);
	}
	
	
	private function getOneCard($edit = null)
	{
		$card = array(
			'question'=>'',
		);
		
		if($edit)
		{
			$sql='SELECT * FROM session_tool4_person WHERE id_session_tool4_person_pk='.$edit;
			if($row=$this->getOneRowFromSql($sql))
			{
				$card['question']  = $this->decode($row['question']);
			}
			else
			{
				$this->redirect($this->getlink(array(PART_ID=>TOOL_EXPERIENCED)));
			}
		}
		
		$form=new form('card');
		
		$inp_question=new formInputBox($form,'question','',$card['question'],true,255,'width:650px;','adminInput','border:1px solid red;width:650px;','');
		$inp_question->init();
		if($form->isSubmitted() && $inp_question->error)
		{
			$inp_question->errMsg=$this->getText('form_pole_obowiazkowe');
		}

		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('session_tool4_person');
			$q->addString('question', $inp_question->value);
			if($edit)
			{
				$sql = $q->createUpdate('id_session_tool4_person_pk ='.$edit);
			}
			/*
			else
			{
				$sql = $q->createInsert();
			}
			*/
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$edit) $this->redirect($this->getlink(array(PART_ID=>TOOL_EXPERIENCED)));
			else $this->reload();
		}
		
		
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'form'=>$form->smarty(),
			'addNew'=>($edit) ? false : true,
			'edit'=>($edit) ? true : false,
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_EXPERIENCED)),
			'template'=>'admin/toolExperienced.tpl',
		);
	}

}


?>