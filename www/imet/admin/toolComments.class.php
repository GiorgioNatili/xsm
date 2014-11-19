<?php
define('TOOL_COMMENTS','toolComments');
$GLOBALS['toolClasses'][TOOL_COMMENTS]='toolComments';

	

class toolComments extends projectCommon 
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
		
		
		$sql = 'SELECT sc.*, st.title as tool, st.number
				FROM session_comments sc
				INNER JOIN session_tools st ON st.id_session_tool_pk = sc.id_session_tool_fk
				ORDER BY st.id_session_tool_pk
		';
		$res = $this->dbQuery($sql);
		
		$cards = array();
		
		while($row=mysql_fetch_assoc($res))
		{
			if($this->params[DELETE] == $row['id_session_comment_pk'])
			{
				$sql='DELETE FROM session_comments WHERE id_session_comment_pk = '.$this->params[DELETE];
				$this->dbQuery($sql);
				$this->redirect($this->getlink(array(PART_ID=>TOOL_COMMENTS)));
			}
			
			$cards[]=array(
				'tool'=>$this->decode($row['tool']),
				'number'=>$this->decode($row['number']),
				'name'=>$this->decode($row['name']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_COMMENTS, ID=>$row['id_session_comment_pk'])),
				'delHref'=>$this->getlink(array(PART_ID=>TOOL_COMMENTS, DELETE=>$row['id_session_comment_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'cards'=>$cards,
			'newHref'=>$this->getlink(array(PART_ID=>TOOL_COMMENTS, ADD=>1)),
			'template'=>'admin/toolComments.tpl',
		);
	}
	
	
	private function getOneCard($edit = null)
	{
		$card = array(
			'tool'=>'',
			'name'=>'',
			'value'=>'',
		);
		
		if($edit)
		{
			$sql='SELECT * FROM session_comments WHERE id_session_comment_pk='.$edit;
			if($row=$this->getOneRowFromSql($sql))
			{
				$card['tool']  = $this->decode($row['id_session_tool_fk']);
				$card['name']  = $this->decode($row['name']);
				$card['value'] = $this->decode($row['value']);
			}
			else
			{
				$this->redirect($this->getlink(array(PART_ID=>TOOL_COMMENTS)));
			}
		}
		
		$form=new form('card');
		
		$inp_tool=new formSelect($form,'tool','typeSelect',$card['tool'],true,'width:300px;','','width:300px;border:1px solid red','');
		$typesList = array(array('key'=>0,'value'=>''));
		$sql='SELECT id_session_tool_pk,title,number FROM session_tools';
		$res=$this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$typesList[] = array('key'=>$row['id_session_tool_pk'], 'value'=>$this->decode($row['title']).' (Session '.$row['number'].')');
		}
		$inp_tool->source=$typesList;
		$inp_tool->init();
		if($form->isSubmitted() and $inp_tool->error)
		{
			$inp_tool->errMsg=$this->getText('form_pole_obowiazkowe');
		}


		$inp_name=new formInputBox($form,'name','',$card['name'],true,255,'width:300px;','adminInput','border:1px solid red;width:300px;','');
		$inp_name->init();
		if($form->isSubmitted() && $inp_name->error)
		{
			$inp_name->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		
		$inp_value=new formInputBox($form,'value','',$card['value'],true,255,'width:650px;','adminInput','','');
		$inp_value->init();
		if($form->isSubmitted() && $inp_value->error)
		{
			$inp_value->errMsg=$this->getText('form_pole_obowiazkowe');
		}

		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('session_comments');
			$q->addInt('id_session_tool_fk', intval($inp_tool->value));
			$q->addString('name', strip_tags($inp_name->value));
			$q->addString('value', strip_tags($inp_value->value));
			if($edit)
			{
				$sql = $q->createUpdate('id_session_comment_pk ='.$edit);
			}
			else
			{
				$sql = $q->createInsert();
			}
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$edit) $this->redirect($this->getlink(array(PART_ID=>TOOL_COMMENTS)));
			else $this->reload();
		}
		
		
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'form'=>$form->smarty(),
			'addNew'=>($edit) ? false : true,
			'edit'=>($edit) ? true : false,
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_COMMENTS)),
			'template'=>'admin/toolComments.tpl',
		);
	}

}


?>