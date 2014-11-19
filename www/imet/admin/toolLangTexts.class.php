<?php
define('TOOL_LANGTEXT','tooltext');
$GLOBALS['toolClasses'][TOOL_LANGTEXT]='toolLangText';

class toolLangText extends projectCommon 
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
			$sql='SELECT * FROM languages_texts WHERE id_text_pk = '.$this->params[ID];
			$page = $this->getOneRowFromSql($sql);
			
			$form=new form('formTexts');
				
			$inp_title=new formInputBox($form,'text','',$page['text_en'],true,255,'','adminInput','','');
			$inp_title->init();
			if($form->isSubmitted() && $inp_title->error)
			{
				$inp_title->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			
			if($form->isSubmitted() && $form->isValid())
			{
				$query=new sqlQuery();
				$query->table='languages_texts';
				$query->addString('text_en', $inp_title->value);
				$sql = $query->createUpdate('id_text_pk = '.$this->params[ID]);
				mysql_query($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_LANGTEXT)));
				else $this->reload();
			}
			
			return array(
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'form'=>$form->smarty(),
				'singleText'=>$page,
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_LANGTEXT)),
				'template'=>'admin/toolLangText.tpl',
			);
		}
		
		
		$texts = array();
		$sql='SELECT * FROM languages_texts';
		$res = mysql_query($sql);
		
		while($row = mysql_fetch_assoc($res))
		{
			$texts[] = array(
				'code'=>$this->decode($row['code']),
				'text'=>$this->decode($row['text_en']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_LANGTEXT, ID=>$row['id_text_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'textsList'=>$texts,
			'template'=>'admin/toolLangText.tpl',
		);
	}

	
	
	
}


?>