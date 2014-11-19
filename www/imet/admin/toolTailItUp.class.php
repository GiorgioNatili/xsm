<?php
define('TOOL_TAILITUP','toolTailItUp');
$GLOBALS['toolClasses'][TOOL_TAILITUP]='toolTailItUp';

	define('TAILITUP_STUFFS','stuffs');

class toolTailItUp extends projectCommon 
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
		if($this->params[SUBPART_ID] == TAILITUP_STUFFS)
		{
			if($this->params[ADD])
			{
				return $this->singleStuff();
			}
			elseif($this->params[ID])
			{
				return $this->singleStuff($this->params[ID]);
			}
			
			$stuffs = array();
			
			$sql = 'SELECT * FROM calculator_stuffs';
			$res = $this->dbQuery($sql);
			
			while($row=mysql_fetch_assoc($res))
			{
				if($this->params[DELETE] == $row['id_calculator_stuff_pk'])
				{
					$sql='DELETE FROM calculator_stuffs WHERE id_calculator_stuff_pk = '.$this->params[DELETE];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, SUBPART_ID=>TAILITUP_STUFFS)));
				}
				
				$stuffs[] = array(
					'text'=>$this->decode($row['text']),
					'value'=>$this->decode($row['value']),
					'href'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, SUBPART_ID=>TAILITUP_STUFFS, ID=>$row['id_calculator_stuff_pk'])),
					'delHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, SUBPART_ID=>TAILITUP_STUFFS, DELETE=>$row['id_calculator_stuff_pk'])),
				);
			}
			
			return array(
				'newHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, SUBPART_ID=>TAILITUP_STUFFS, ADD=>1)),
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'stuffs'=>$stuffs,
				'template'=>'admin/toolTailItUpStuffs.tpl',
			);
		}
		
		
		if($this->params[CATEGORY])
		{
			$sql='SELECT * FROM pre_tlfb_stimulants WHERE id_pre_tlfb_stimulant_pk = '.$this->params[CATEGORY];
			if($stimulant=$this->getOneRowFromSql($sql))
			{
				if($this->params[ID])
				{
					$sql = 'SELECT * FROM calculator_types WHERE id_pre_tlfb_stimulant_fk = '.$this->params[CATEGORY].' AND id_calculator_type_pk = '.$this->params[ID];
					if($calType = $this->getOneRowFromSql($sql))
					{
						if($this->params[ID2])
						{
							$sql = 'SELECT * FROM calculator_options WHERE id_calculator_option_pk = '.$this->params[ID2];
							if($calOption = $this->getOneRowFromSql($sql))
							{
								return $this->getOptionValues($stimulant, $calType, $calOption);
							}
						}
						
						return $this->getTypeOptions($stimulant, $calType);
					}
				}
				
				return $this->getStimulantTypes($stimulant);
			}
		}
		
		
		$stimulants = array();
		$sql='SELECT * FROM pre_tlfb_stimulants';
		$res = mysql_query($sql);
		
		while($row = mysql_fetch_assoc($res))
		{
			$stimulants[] = array(
				'name'=>$this->decode($row['stimulant']),
				'label'=>$this->decode($row['box_label']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$row['id_pre_tlfb_stimulant_pk'])),
			);
		}
		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'stimulants'=>$stimulants,
			'template'=>'admin/toolTailItUp.tpl',
		);
	}
	
	
	private function singleStuff($edit_id = null)
	{
		$stuff = array('text'=>'', 'value'=>'');
		
		if($edit_id)
		{
			$sql = 'SELECT * FROM calculator_stuffs WHERE id_calculator_stuff_pk = '.$edit_id;
			if($row = $this->getOneRowFromSql($sql))
			{
				$stuff['text']  = $this->decode($row['text']);
				$stuff['value'] = $this->decode($row['value']);
			}
			else
			{
				$this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, SUBPART_ID=>TAILITUP_STUFFS)));
			}
		}
		
		$form=new form('stuffs');
			
		$inp_text=new formInputBox($form,'text','',$stuff['text'],true,255,'width:300px;','adminInput','border:1px solid red;width:300px;','');
		$inp_text->init();
		if($form->isSubmitted() && $inp_text->error)
		{
			$inp_text->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_value=new formInputBox($form,'value','',$stuff['value'],true,255,'width:300px;','adminInput','border:1px solid red;width:300px;','');
		$inp_value->init();
		if($form->isSubmitted() && $inp_value->error)
		{
			$inp_value->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('calculator_stuffs');
			$q->addString('text', strip_tags($inp_text->value));
			$q->addString('value', strip_tags($inp_value->value));
			if($edit_id)
			{
				$sql = $q->createUpdate('id_calculator_stuff_pk = '.$edit_id);
			}
			else
			{
				$sql = $q->createInsert();
			}
			
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$edit_id) $this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, SUBPART_ID=>TAILITUP_STUFFS)));
			else $this->reload();
		}
		
		
		return array(
			'edit'=>$edit_id,
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, SUBPART_ID=>TAILITUP_STUFFS)),
			'form'=>$form->smarty(),
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'template'=>'admin/toolTailItUpStuffs.tpl',
		);
	}
	
	
	private function getOptionValues($stimulant, $calType, $calOption)
	{
		$sql = 'SELECT cov.*
				FROM calculator_option_values cov
				WHERE id_calculator_option_fk = '.$calOption['id_calculator_option_pk'].'
		';
		$res = $this->dbQuery($sql);
		
		$values = array();
		
		while($value = mysql_fetch_assoc($res))
		{
			$values[] = array(
				'id'=>$value['id_calculator_option_value_pk'],
				'data'=>$this->decode($value['data']),
				'label'=>$this->decode($value['label']),
			);
		}
	
		$form=new form('formOptions');
			
		$inp_label=new formInputBox($form,'label','',$calOption['label'],true,255,'width:300px;','adminInput','border:1px solid red;width:300px;','');
		$inp_label->init();
		if($form->isSubmitted() && $inp_label->error)
		{
			$inp_label->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		
		$calTypesActive = 0;
		switch($calOption['type'])
		{
			case 'input':
				$calTypesActive=1;
			break;
			case 'list':
				$calTypesActive=2;
			break;
		}
		
		$inp_type=new formSelect($form,'type','optionsType',$calTypesActive,true,'','','border:1px solid red','');
		$calTypesList = array(
			array('key'=>0,'value'=>''),
			array('key'=>1,'value'=>'input'),
			array('key'=>2,'value'=>'list'),
		);
		$inp_type->source=$calTypesList;
		$inp_type->init();
		if($form->isSubmitted() and $inp_type->error)
		{
			$inp_type->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		
		if($form->isSubmitted() && $form->isValid())
		{
			$q=new sqlQuery('calculator_options');
			$q->addString('label', $inp_label->value);
			switch($inp_type->value)
			{
				case 1:
					$q->addString('type', 'input');
				break;
				case 2:
					$q->addString('type', 'list');
				break;
			}
			$sql = $q->createUpdate('id_calculator_option_pk = '.$this->params[ID2]);
			$this->dbQuery($sql);
			
			// usuwam wszystkie wiersze z wartosciami
			$sql='DELETE FROM calculator_option_values WHERE id_calculator_option_fk = '.$this->params[ID2];
			$this->dbQuery($sql);
			
			// jesli wybrano liste, pobieram wartosci i wrzucam
			if($inp_type->value == 2)
			{
				foreach($_POST as $key => $value)
				{
					if(strstr($key, 'label_') && $value)
					{
						$id = end(explode('_', $key));
						if($this->getPOST('data_'.$id))
						{
							$q=new sqlQuery('calculator_option_values');
							$q->addInt('id_calculator_option_fk', $this->params[ID2]);
							$q->addString('data', strip_tags($this->getPOST('data_'.$id)));
							$q->addString('label', strip_tags($value));
							$sql = $q->createInsert();
							$this->dbQuery($sql);
						}
					}
				}
			}
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID])));
			else $this->reload();
		}
	

		
		return array(
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID])),
			'stimulantName'=>$stimulant['stimulant'],
			'typeName'=>$calType['type'],
			'calOption'=>$calOption,
			'values'=>$values,
			'form'=>$form->smarty(),
			'template'=>'admin/toolTailItUp.tpl',
		);
	}
	
	
	private function getTypeOptions($stimulant, $calType)
	{
		if($this->params[ADD])
		{
			$form=new form('formOptions');
				
			$inp_label=new formInputBox($form,'label','','',true,255,'width:300px;','adminInput','border:1px solid red;width:300px;','');
			$inp_label->init();
			if($form->isSubmitted() && $inp_label->error)
			{
				$inp_label->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			
			$inp_type=new formSelect($form,'type','','',true,'','','border:1px solid red','');
			$calTypesList = array(
				array('key'=>0,'value'=>''),
				array('key'=>1,'value'=>'input'),
				array('key'=>2,'value'=>'list'),
			);
			$inp_type->source=$calTypesList;
			$inp_type->init();
			if($form->isSubmitted() and $inp_type->error)
			{
				$inp_type->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			
			if($form->isSubmitted() && $form->isValid())
			{
				$q = new sqlQuery('calculator_options');
				$q->addInt('id_calculator_type_fk', $this->params[ID]);
				$q->addString('label', strip_tags($inp_label->value));
				switch($inp_type->value)
				{
					case 1:
						$q->addString('type', 'input');
					break;
					case 2:
						$q->addString('type', 'list');
					break;
				}
				$sql = $q->createInsert();
				$this->dbQuery($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				$this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID])));
			}
			
			
			return array(
				'addNew'=>2,
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID])),
				'stimulant'=>$stimulant,
				'typeName'=>$calType['type'],
				'form'=>$form->smarty(),
				'template'=>'admin/toolTailItUp.tpl',
			);
		}
		elseif($this->params[ADD2])
		{
			$form=new form('formStuffs');
			
			$inp_stuff=new formSelect($form,'stuff','','',true,'','','border:1px solid red','');
			$stuffsList = array();
			$stuffsList[] = array('key'=>0,'value'=>'');
			
			$sql = 'SELECT id_calculator_stuff_fk
					FROM calculator_types_stuffs
					WHERE id_calculator_type_fk = '.$this->params[ID].'
			';
			$res = $this->dbQuery($sql);
			$used = array();
			while($row=mysql_fetch_assoc($res))
			{
				$used[]=$row['id_calculator_stuff_fk'];
			}
			
			$sql_used = count($used) ? 'AND id_calculator_stuff_pk NOT IN ('.implode(',', $used).')' : null;
			$sql = 'SELECT * FROM calculator_stuffs
					WHERE 1 '.$sql_used.'
					ORDER BY text
			';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$stuffsList[] = array(
					'key'=>$row['id_calculator_stuff_pk'],
					'value'=>$this->decode($row['text']),
				);
			}

			$inp_stuff->source=$stuffsList;
			$inp_stuff->init();
			if($form->isSubmitted() and $inp_stuff->error)
			{
				$inp_stuff->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			
			if($form->isSubmitted() && $form->isValid())
			{
				$q = new sqlQuery('calculator_types_stuffs');
				$q->addInt('id_calculator_type_fk', $this->params[ID]);
				$q->addInt('id_calculator_stuff_fk', intval($inp_stuff->value));
				$this->dbQuery($q->createInsert());
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				$this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID])));
			}
			
			
			return array(
				'addNew'=>3,
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID])),
				'stimulant'=>$stimulant,
				'typeName'=>$calType['type'],
				'form'=>$form->smarty(),
				'template'=>'admin/toolTailItUp.tpl',
			);
		}
		else
		{
			$sql = 'SELECT * FROM calculator_options WHERE id_calculator_type_fk = '.$this->params[ID];
			$res = $this->dbQuery($sql);
			
			$types = array();
			while($type=mysql_fetch_assoc($res))
			{
				if($this->params[DELETE] == $type['id_calculator_option_pk'])
				{
					$sql = 'DELETE FROM calculator_options WHERE id_calculator_option_pk = '.$this->params[DELETE];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID])));
				}
				
				$types[]=array(
					'label'=>$this->decode($type['label']),
					'type'=>$this->decode($type['type']),
					'href'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID], ID2=>$type['id_calculator_option_pk'])),
					'delHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID], DELETE=>$type['id_calculator_option_pk'])),
				);
			}
			
			###
			
			$sql = 'SELECT cts.*, cs.text
					FROM calculator_types_stuffs cts
					INNER JOIN calculator_stuffs cs ON cs.id_calculator_stuff_pk = cts.id_calculator_stuff_fk
					WHERE id_calculator_type_fk = '.$this->params[ID].'
			';
			$res = $this->dbQuery($sql);
			
			$stuffs = array();
			while($row=mysql_fetch_assoc($res))
			{
				if($this->params[DELETE2] == $row['id_calculator_type_stuff_pk'])
				{
					$sql = 'DELETE FROM calculator_types_stuffs WHERE id_calculator_type_stuff_pk = '.$this->params[DELETE2];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID])));
				}
				
				$stuffs[] = array(
					'name'=>$this->decode($row['text']),
					'delHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID], DELETE2=>$row['id_calculator_type_stuff_pk'])),
				);
			}
			
			/***** DOKONCZYC *****/
			
			###
			
			$form=new form('formOptions');
				
			$inp_info1=new formInputBox($form,'info1','',$calType['calculator_info_text'],true,255,'','adminInput','','');
			$inp_info1->init();
			if($form->isSubmitted() && $inp_info1->error)
			{
				$inp_info1->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			$inp_info2=new formInputBox($form,'info2','',$calType['stuff_info_text'],true,255,'','adminInput','','');
			$inp_info2->init();
			if($form->isSubmitted() && $inp_info2->error)
			{
				$inp_info2->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			$calTypesActive = 0;
			switch($calType['type'])
			{
				case 'time':
					$calTypesActive=1;
				break;
				case 'calories':
					$calTypesActive=2;
				break;
				case 'money':
					$calTypesActive=3;
				break;
			}
			
			$inp_type=new formSelect($form,'type','',$calTypesActive,true,'','','border:1px solid red','');
			$calTypesList = array(
				array('key'=>0,'value'=>''),
				array('key'=>1,'value'=>'time'),
				array('key'=>2,'value'=>'calories'),
				array('key'=>3,'value'=>'money')
			);
			$inp_type->source=$calTypesList;
			$inp_type->init();
			if($form->isSubmitted() and $inp_type->error)
			{
				$inp_type->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			if($form->isSubmitted() && $form->isValid())
			{
				$query=new sqlQuery();
				$query->table='calculator_types';
				$query->addString('calculator_info_text', $inp_info1->value);
				$query->addString('stuff_info_text', $inp_info2->value);
				switch($inp_type->value)
				{
					case 1:
						$query->addString('type', 'time');
					break;
					case 2:
						$query->addString('type', 'calories');
					break;
					case 3:
						$query->addString('type', 'money');
					break;
				}
				$sql = $query->createUpdate('id_calculator_type_pk = '.$this->params[ID]);
				mysql_query($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY])));
				else $this->reload();
			}
			
			return array(
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY])),
				'newHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID], ADD=>1)),
				'stimulantName'=>$stimulant['stimulant'],
				'stuffs'=>$stuffs,
				'newStuffHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$this->params[ID], ADD2=>1)),
				'types'=>$types,
				'isTypes'=>true,
				'typeName'=>$calType['type'],
				'form'=>$form->smarty(),
				'template'=>'admin/toolTailItUp.tpl',
			);
		}
	}
	
	
	private function getStimulantTypes($stimulant)
	{
		if($this->params[ADD])
		{
			$form=new form('newTypes');
				
			$inp_text1=new formInputBox($form,'info1','','',true,255,'','adminInput','','');
			$inp_text1->init();
			if($form->isSubmitted() && $inp_text1->error)
			{
				$inp_text1->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			$inp_text2=new formInputBox($form,'info2','','',true,255,'','adminInput','','');
			$inp_text2->init();
			if($form->isSubmitted() && $inp_text2->error)
			{
				$inp_text2->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			$inp_type=new formSelect($form,'type','','',true,'','','border:1px solid red','');
			$calTypesList = array(
				array('key'=>0,'value'=>''),
				array('key'=>1,'value'=>'time'),
				array('key'=>2,'value'=>'calories'),
				array('key'=>3,'value'=>'money')
			);
			$inp_type->source=$calTypesList;
			$inp_type->init();
			if($form->isSubmitted() and $inp_type->error)
			{
				$inp_type->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			
			if($form->isSubmitted() && $form->isValid())
			{
				$q=new sqlQuery('calculator_types');
				$q->addInt('id_pre_tlfb_stimulant_fk', $this->params[CATEGORY]);
				$q->addString('calculator_info_text', strip_tags($inp_text1->value));
				$q->addString('stuff_info_text', strip_tags($inp_text2->value));
				switch($inp_type->value)
				{
					case 1:
						$q->addString('type', 'time');
					break;
					case 2:
						$q->addString('type', 'calories');
					break;
					case 3:
						$q->addString('type', 'money');
					break;
				}
				$sql = $q->createInsert();
				$this->dbQuery($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
			
				$this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY])));
			}
			
			
			return array(
				'addNew'=>1,
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY])),
				'stimulant'=>$stimulant,
				'form'=>$form->smarty(),
				'template'=>'admin/toolTailItUp.tpl',
			);
		}
		else
		{
			$sql = 'SELECT * FROM calculator_types WHERE id_pre_tlfb_stimulant_fk = '.$stimulant['id_pre_tlfb_stimulant_pk'];
			$res = $this->dbQuery($sql);
			
			$types=array();
			while($type = mysql_fetch_assoc($res))
			{
				if($this->params[DELETE] == $type['id_calculator_type_pk'])
				{
					$sql='DELETE FROM calculator_types WHERE id_calculator_type_pk = '.$this->params[DELETE];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY])));
				}
				
				$types[] = array(
					'calculator_info'=>$this->decode($type['calculator_info_text']),
					'stuff_info'=>$this->decode($type['stuff_info_text']),
					'type'=>$this->decode($type['type']),
					'href'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ID=>$type['id_calculator_type_pk'])),
					'delHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], DELETE=>$type['id_calculator_type_pk'])),
				);
			}
			
			$form=new form('formBoxLabel');
				
			$inp_label=new formInputBox($form,'label','',$stimulant['box_label'],true,255,'','adminInput','','');
			$inp_label->init();
			if($form->isSubmitted() && $inp_label->error)
			{
				$inp_label->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			
			if($form->isSubmitted() && $form->isValid())
			{
				$query=new sqlQuery();
				$query->table='pre_tlfb_stimulants';
				$query->addString('box_label', $inp_label->value);
				$sql = $query->createUpdate('id_pre_tlfb_stimulant_pk = '.$this->params[CATEGORY]);
				mysql_query($sql);
				
				$this->setSessionMessage('toolSaved','Successfully saved');
				
				if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_TAILITUP)));
				else $this->reload();
			}
			
			return array(
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP)),
				'newHref'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, CATEGORY=>$this->params[CATEGORY], ADD=>1)),
				'stimulant'=>$stimulant,
				'types'=>$types,
				'form'=>$form->smarty(),
				'template'=>'admin/toolTailItUp.tpl',
			);
		}
	}
}


?>