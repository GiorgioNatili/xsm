<?php
define('TOOL_DRAWTHELINE','toolDrawTheLine');
$GLOBALS['toolClasses'][TOOL_DRAWTHELINE]='toolDrawTheLine';

class toolDrawTheLine extends projectCommon 
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
		if($this->params[CATEGORY])
		{
			if($this->params[ID])
			{
				return $this->getSingleAnswer($this->params[ID], $this->params[CATEGORY]);
			}
			elseif($this->params[ADD])
			{
				return $this->getSingleAnswer(null, $this->params[CATEGORY]);
			}
			return $this->getSingleQuestion($this->params[CATEGORY]);
		}
		
		
		$questions = array();
		
		$sql = 'SELECT * FROM session_tool6_questions';
		$res = $this->dbQuery($sql);
		
		while($row=mysql_fetch_assoc($res))
		{
			$questions[]=array(
				'question'=>$this->decode($row['question']),
				'state'=>$row['state'],
				'digits'=>$row['digits'],
				'href'=>$this->getlink(array(PART_ID=>TOOL_DRAWTHELINE, CATEGORY=>$row['id_session_tool6_question_pk'])),
			);
		}
		
		return array(
			'questions'=>$questions,
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'template'=>'admin/toolDrawTheLine.tpl',
		);
	}
	
	
	private function getSingleQuestion($id)
	{
		$sql = 'SELECT * FROM session_tool6_questions WHERE id_session_tool6_question_pk = '.$id;
		$question = $this->getOneRowFromSql($sql);
		
		if($question)
		{
			$answers = array();
			
			$sql = 'SELECT * FROM session_tool6_answers WHERE id_session_tool6_question_fk = '.$id;
			$res = $this->dbQuery($sql);
			
			while($row=mysql_fetch_assoc($res))
			{
				if($this->params[DELETE] == $row['id_session_tool6_answer_pk'])
				{
					$sql='DELETE FROM session_tool6_answers WHERE id_session_tool6_answer_pk = '.$this->params[DELETE];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>TOOL_DRAWTHELINE, CATEGORY=>$id)));
				}
				
				$answers[]=array(
					'answer'=>$this->decode($row['answer']),
					'type'=>$this->decode($row['type']),
					'href'=>$this->getlink(array(PART_ID=>TOOL_DRAWTHELINE, CATEGORY=>$id, ID=>$row['id_session_tool6_answer_pk'])),
					'delHref'=>$this->getlink(array(PART_ID=>TOOL_DRAWTHELINE, CATEGORY=>$id, DELETE=>$row['id_session_tool6_answer_pk'])),
				);
			}
			
			$form=new form('singleQuestion');
				
			$inp_question=new formInputBox($form,'question','',$question['question'],true,255,'width:700px;','adminInput','border:1px solid red;width:700px;','');
			$inp_question->init();
			if($form->isSubmitted() && $inp_question->error)
			{
				$inp_question->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			$inp_doctor=new formInputBox($form,'doctor','',$question['doctor_feedback'],true,255,'width:700px;','adminInput','border:1px solid red;width:700px;','');
			$inp_doctor->init();
			if($form->isSubmitted() && $inp_doctor->error)
			{
				$inp_doctor->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			$inp_digits=new formInputBox($form,'digits','',$question['digits'],true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
			$inp_digits->init();
			if($form->isSubmitted() && $inp_digits->error)
			{
				if($inp_digits->value==='0')
				{
					$inp_digits->error = 0;
				}
				else
				{
					$inp_digits->errMsg=$this->getText('form_pole_obowiazkowe');
				}
			}
			
			if($form->isSubmitted() && $form->isValid())
			{
				$q = new sqlQuery('session_tool6_questions');
				$q->addString('question', $inp_question->value);
				$q->addString('doctor_feedback', $inp_doctor->value);
				$q->addString('digits', $inp_digits->value);
				$this->dbQuery($q->createUpdate('id_session_tool6_question_pk = '.$this->params[CATEGORY]));
				
				$this->setSessionMessage('toolSaved','Successfully saved');
			
				if($this->getPOST('backToList') || !$id_answer) $this->redirect($this->getlink(array(PART_ID=>TOOL_DRAWTHELINE, CATEGORY=>$id_category)));
				else $this->reload();
			}
			
			
			return array(
				'singleQuestion'=>1,
				'answers'=>$answers,
				'form'=>$form->smarty(),
				'newHref'=>$this->getlink(array(PART_ID=>TOOL_DRAWTHELINE, CATEGORY=>$id, ADD=>1)),
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_DRAWTHELINE)),
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'template'=>'admin/toolDrawTheLine.tpl',
			);
		}
	}
	
	
	
	private function getSingleAnswer($id_answer=null, $id_category)
	{
		if($id_answer)
		{
			$sql = 'SELECT * FROM session_tool6_answers WHERE id_session_tool6_answer_pk = '.$id_answer.' AND id_session_tool6_question_fk = '.$id_category;
			$answer = $this->getOneRowFromSql($sql);
			if(!$answer) $this->redirect($this->getlink(array(PART_ID=>TOOL_DRAWTHELINE, CATEGORY=>$id_category)));
		}
		else
		{
			$answer=array('answer'=>'','type'=>'');
		}
		
		
		$form=new form('singleAnswer');
			
		$inp_answer=new formInputBox($form,'answer','',$answer['answer'],true,255,'width:700px;','adminInput','border:1px solid red;width:700px;','');
		$inp_answer->init();
		if($form->isSubmitted() && $inp_answer->error)
		{
			$inp_answer->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_type=new formSelect($form,'type','optionsType',$answer['type'],true,'width:120px;','','border:1px solid red','');
		$inp_type->source=array(
			array('key'=>0,'value'=>''),
			array('key'=>'normal','value'=>'normal'),
			array('key'=>'input','value'=>'input'),
		);
		$inp_type->init();
		if($form->isSubmitted() and $inp_type->error)
		{
			$inp_type->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('session_tool6_answers');
			$q->addString('answer', strip_tags($inp_answer->value));
			$q->addString('type', strip_tags($inp_type->value));
			if($id_answer)
			{
				$sql = $q->createUpdate('id_session_tool6_answer_pk = '.$id_answer);
			}
			else
			{
				$q->addInt('id_session_tool6_question_fk', $id_category);
				$sql = $q->createInsert();
			}
			
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$id_answer) $this->redirect($this->getlink(array(PART_ID=>TOOL_DRAWTHELINE, CATEGORY=>$id_category)));
			else $this->reload();
		}
		
		
		return array(
			'singleAnswer'=>1,
			'form'=>$form->smarty(),
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_DRAWTHELINE, CATEGORY=>$id_category)),
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'template'=>'admin/toolDrawTheLine.tpl',
		);
	}
	
	
	
	
}


?>