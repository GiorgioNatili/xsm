<?php
define('TOOL_HERE','toolHere');
$GLOBALS['toolClasses'][TOOL_HERE]='toolHere';

	

class toolHere extends projectCommon 
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
				FROM session_tool8_tools
		';
		$res = $this->dbQuery($sql);
		
		$cards = array();
		
		while($row=mysql_fetch_assoc($res))
		{
			$cards[]=array(
				'tool'=>$this->decode($row['tool']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_HERE, ID=>$row['id_session_tool8_tools_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'cards'=>$cards,
			'template'=>'admin/toolHere.tpl',
		);
	}
	
	
	private function getOneCard($edit = null)
	{
		$card = array(
			'comment'=>'',
		);
		
		if($edit)
		{
			$sql='SELECT * FROM session_tool8_tools WHERE id_session_tool8_tools_pk='.$edit;
			if($row=$this->getOneRowFromSql($sql))
			{
				$card['comment']  = $this->decode($row['comment']);
				$toolName = $row['tool'];
			}
			else
			{
				$this->redirect($this->getlink(array(PART_ID=>TOOL_HERE)));
			}
		}
		
		$form=new form('card');
		
		$inp_comment=new formInputBox($form,'comment','',$card['comment'],true,255,'width:650px;','adminInput','border:1px solid red;width:650px;','');
		$inp_comment->init();
		if($form->isSubmitted() && $inp_comment->error)
		{
			$inp_comment->errMsg=$this->getText('form_pole_obowiazkowe');
		}

		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('session_tool8_tools');
			$q->addString('comment', $inp_comment->value);
			if($edit)
			{
				$sql = $q->createUpdate('id_session_tool8_tools_pk ='.$edit);
			}
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$edit) $this->redirect($this->getlink(array(PART_ID=>TOOL_HERE)));
			else $this->reload();
		}
		
		
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'toolName'=>$toolName,
			'form'=>$form->smarty(),
			'edit'=>($edit) ? true : false,
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_HERE)),
			'template'=>'admin/toolHere.tpl',
		);
	}

}


?>