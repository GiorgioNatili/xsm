<?php
define('TOOL_CSBIRT_LINKS','toolCsbirtLinks');
$GLOBALS['toolClasses'][TOOL_CSBIRT_LINKS]='toolCsbirtLinks';

	

class toolCsbirtLinks extends projectCommon 
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
		
		
		$sql = 'SELECT * FROM cSBIRT_links';
		$res = $this->dbQuery($sql);
		
		$cards = array();
		
		while($row=mysql_fetch_assoc($res))
		{
			$cards[]=array(
				'link'=>$row['link'],
				'href'=>$this->getlink(array(PART_ID=>TOOL_CSBIRT_LINKS, ID=>$row['id_csbirt_link_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'cards'=>$cards,
			'template'=>'admin/toolCsbirtLinks.tpl',
		);
	}
	
	
	private function getOneCard($edit = null)
	{
		$card = array(
			'link'=>'',
		);
		
		if($edit)
		{
			$sql='SELECT * FROM cSBIRT_links WHERE id_csbirt_link_pk='.$edit;
			if($row=$this->getOneRowFromSql($sql))
			{
				$card['link']  = $row['link'];
			}
			else
			{
				$this->redirect($this->getlink(array(PART_ID=>TOOL_CSBIRT_LINKS)));
			}
		}
		
		$form=new form('card');

		$inp_link=new formInputBox($form,'link','',$card['link'],true,255,'width:600px;','adminInput','border:1px solid red;width:600px;','');
		$inp_link->init();
		if($form->isSubmitted() && $inp_link->error)
		{
			$inp_link->errMsg=$this->getText('form_pole_obowiazkowe');
		}

		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('cSBIRT_links');
			$q->addString('link', strip_tags($inp_link->value));
			$sql = $q->createUpdate('id_csbirt_link_pk ='.$edit);
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$edit) $this->redirect($this->getlink(array(PART_ID=>TOOL_CSBIRT_LINKS)));
			else $this->reload();
		}
		
		
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'form'=>$form->smarty(),
			'card'=>$card,
			'edit'=>($edit) ? true : false,
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_CSBIRT_LINKS)),
			'template'=>'admin/toolCsbirtLinks.tpl',
		);
	}

}


?>