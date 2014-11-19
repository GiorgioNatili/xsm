<?php
define('TOOL_TAKE2','toolTake2');
$GLOBALS['toolClasses'][TOOL_TAKE2]='toolTake2';

	define('TAKE2_SET', 'set');
	define('TAKE2_INTROCARDS', 'introcards');

class toolTake2 extends projectCommon 
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
		if($this->params[SUBPART_ID]==TAKE2_INTROCARDS)
		{
			if($this->params[ID])
			{
				return $this->getSingleIntroCard($this->params[ID]);
			}
			return $this->getIntroCards();
		}
		elseif($this->params[SUBPART_ID]==TAKE2_SET)
		{
			if($this->params[ID])
			{
				return $this->getSingleSet($this->params[ID]);
			}
			return $this->getSets();
		}
		
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
			return $this->getSingleCoupon($this->params[CATEGORY]);
		}
		
		
		
		
		if($this->params[ADD])
		{
			return $this->getSingleCoupon();
		}
		
		
		
		
		$coupons = array();
		
		$sql = 'SELECT stc.*, sts.name, stcs.set
				FROM session_tool7_coupons stc
				INNER JOIN session_tool7_coupons_set stcs ON stcs.id_session_tool7_coupon_set_pk = stc.id_session_tool7_coupon_set_fk
				INNER JOIN session_tool7_substances sts ON sts.id_session_tool7_substance_pk = stc.id_session_tool7_substance_fk
				ORDER BY stcs.set, sts.name, stc.id_session_tool7_substance_fk
		';
		$res = $this->dbQuery($sql);
		
		while($row=mysql_fetch_assoc($res))
		{
			if($this->params[DELETE] == $row['id_session_tool7_coupon_pk'])
			{
				$sql='DELETE FROM session_tool7_coupons WHERE id_session_tool7_coupon_pk = '.$this->params[DELETE];
				$this->dbQuery($sql);
				$this->redirect($this->getlink(array(PART_ID=>TOOL_TAKE2)));
			}
			$coupons[]=array(
				'text'=>$this->decode($row['text']),
				'substance'=>$row['name'],
				'set'=>$row['set'],
				'href'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, CATEGORY=>$row['id_session_tool7_coupon_pk'])),
				'delHref'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, DELETE=>$row['id_session_tool7_coupon_pk'])),
			);
		}
		
		return array(
			'newHref'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, ADD=>1)),
			'coupons'=>$coupons,
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'template'=>'admin/toolTake2.tpl',
		);
	}
	
	
	
	private function getSingleCoupon($id=null)
	{
		$answers = array();
		
		if($id)
		{
			$sql = 'SELECT * FROM session_tool7_coupons WHERE id_session_tool7_coupon_pk = '.$id;
			$coupon = $this->getOneRowFromSql($sql);
			if(!$coupon) $this->redirect($this->getlink(array(PART_ID=>TOOL_TAKE2)));
			
			$sql = 'SELECT * FROM session_tool7_answers WHERE id_session_tool7_coupon_fk = '.$id;
			$res = $this->dbQuery($sql);
			
			while($row=mysql_fetch_assoc($res))
			{
				if($this->params[DELETE] == $row['id_session_tool7_answer_pk'])
				{
					$sql='DELETE FROM session_tool7_answers WHERE id_session_tool7_answer_pk = '.$this->params[DELETE];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>TOOL_TAKE2, CATEGORY=>$id)));
				}
				
				$answers[]=array(
					'answer'=>$this->decode($row['text']),
					'input'=>$row['input_mode'] ? 'True' : 'False',
					'href'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, CATEGORY=>$id, ID=>$row['id_session_tool7_answer_pk'])),
					'delHref'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, CATEGORY=>$id, DELETE=>$row['id_session_tool7_answer_pk'])),
				);
			}
		}
		else
		{
			$coupon=array('text'=>'','id_session_tool7_substance_fk'=>'','id_session_tool7_coupon_set_fk'=>'');
		}
		
		
		
		$form=new form('singleCoupon');
			
		$inp_coupon=new formInputBox($form,'coupon','',$coupon['text'],true,255,'width:700px;','adminInput','border:1px solid red;width:700px;','');
		$inp_coupon->init();
		if($form->isSubmitted() && $inp_coupon->error)
		{
			$inp_coupon->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_type=new formSelect($form,'type','optionsType',$coupon['id_session_tool7_substance_fk'],true,'width:120px;','','border:1px solid red','');
		$inp_type->source=array(
			array('key'=>0,'value'=>''),
			array('key'=>'1','value'=>'Tobacco'),
			array('key'=>'2','value'=>'Other'),
		);
		$inp_type->init();
		if($form->isSubmitted() and $inp_type->error)
		{
			$inp_type->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_set=new formSelect($form,'set','optionsType',$coupon['id_session_tool7_coupon_set_fk'],true,'width:120px;','','border:1px solid red','');
		$inp_set->source=array(array('key'=>0,'value'=>''));
		$sql = 'SELECT * FROM session_tool7_coupons_set';
		$res=$this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$inp_set->source[] = array('key'=>$row['id_session_tool7_coupon_set_pk'],'value'=>$row['set']);
		}
		$inp_set->init();
		if($form->isSubmitted() and $inp_type->error)
		{
			$inp_set->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		
		if($form->isSubmitted() && $form->isValid())
		{
			$q=new sqlQuery('session_tool7_coupons');
			$q->addInt('id_session_tool7_substance_fk', $inp_type->value);
			$q->addInt('id_session_tool7_coupon_set_fk', $inp_set->value);
			$q->addString('text', $inp_coupon->value);
			if($id)
			{
				$sql=$q->createUpdate('id_session_tool7_coupon_pk = '.$id);
			}
			else
			{
				$sql=$q->createInsert();
			}
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$id) $this->redirect($this->getlink(array(PART_ID=>TOOL_TAKE2)));
			else $this->reload();
		}
		
		return array(
			'singleCoupon'=>1,
			'addSingleCoupon'=>!$id,
			'answers'=>$answers,
			'form'=>$form->smarty(),
			'newHref'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, CATEGORY=>$id, ADD=>1)),
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAKE2)),
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'template'=>'admin/toolTake2.tpl',
		);
	}
	
	
	
	private function getSingleAnswer($id_answer=null, $id_category)
	{
		if($id_answer)
		{
			$sql = 'SELECT * FROM session_tool7_answers WHERE id_session_tool7_answer_pk = '.$id_answer.' AND id_session_tool7_coupon_fk = '.$id_category;
			$answer = $this->getOneRowFromSql($sql);
			if(!$answer) $this->redirect($this->getlink(array(PART_ID=>TOOL_TAKE2, CATEGORY=>$id_category)));
		}
		else
		{
			$answer=array('text'=>'','input_mode'=>'');
		}
		
		$form=new form('singleAnswer');
			
		$inp_answer=new formInputBox($form,'text','',$answer['text'],true,255,'width:700px;','adminInput','border:1px solid red;width:700px;','');
		$inp_answer->init();
		if($form->isSubmitted() && $inp_answer->error)
		{
			$inp_answer->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_inputmode=new formCheckBox($form,'inputmode','inputmode',$answer['input_mode'],false);
		$inp_inputmode->init();
		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('session_tool7_answers');
			$q->addString('text', strip_tags($inp_answer->value));
			$q->addInt('input_mode', $inp_inputmode->checked);
			if($id_answer)
			{
				$sql = $q->createUpdate('id_session_tool7_answer_pk = '.$id_answer);
			}
			else
			{
				$q->addInt('id_session_tool7_coupon_fk', $id_category);
				$sql = $q->createInsert();
			}
			
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$id_answer) $this->redirect($this->getlink(array(PART_ID=>TOOL_TAKE2, CATEGORY=>$id_category)));
			else $this->reload();
		}
		
		
		return array(
			'singleAnswer'=>1,
			'form'=>$form->smarty(),
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, CATEGORY=>$id_category)),
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'template'=>'admin/toolTake2.tpl',
		);
	}
	
	
	private function getIntroCards()
	{
		$cards = array();
		
		$sql = 'SELECT * FROM session_tool7_introcard ORDER BY session, id';
		$res = $this->dbQuery($sql);
		while($row = mysql_fetch_assoc($res))
		{
			$cards[] = array(
				'name'=>$row['cardClass'],
				'info'=>$this->decode($row['info']),
				'session'=>$row['session'],
				'href'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, SUBPART_ID=>TAKE2_INTROCARDS, ID=>$row['id_session_tool7_introcard_pk'])),
			);
		}
		
		return array(
			'cards'=>$cards,
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'template'=>'admin/toolTake2IntroCards.tpl',
		);
	}
	
	
	private function getSingleIntroCard($id_card)
	{
		$sql  = 'SELECT * FROM session_tool7_introcard WHERE id_session_tool7_introcard_pk = '.$id_card;
		$card = $this->getOneRowFromSql($sql);
		
		$form=new form('singleCard');
			
		$inp_card=new formInputBox($form,'card','',$card['cardClass'],true,255,'width:700px;','adminInput','border:1px solid red;width:700px;','');
		$inp_card->init();
		if($form->isSubmitted() && $inp_card->error)
		{
			$inp_card->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_info=new formInputBox($form,'info','',$card['info'],false,255,'width:700px;','adminInput','border:1px solid red;width:700px;','');
		$inp_info->init();
		if($form->isSubmitted() && $inp_info->error)
		{
			$inp_info->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_comment=new formInputBox($form,'comment','',$card['comment'],false,255,'width:700px;','adminInput','border:1px solid red;width:700px;','');
		$inp_comment->init();
		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('session_tool7_introcard');
			$q->addString('cardClass', strip_tags($inp_card->value));
			$q->addString('info', $inp_info->value);
			$q->addString('comment', $inp_comment->value);
			$sql = $q->createUpdate('id_session_tool7_introcard_pk = '.$id_card);
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_TAKE2, SUBPART_ID=>TAKE2_INTROCARDS)));
			else $this->reload();
		}
		
		return array(
			'singleCard'=>1,
			'form'=>$form->smarty(),
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, SUBPART_ID=>TAKE2_INTROCARDS)),
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'template'=>'admin/toolTake2IntroCards.tpl',
		);
	}
	
	
	
	
	
	private function getSets()
	{
		$sets = array();
		
		$sql = 'SELECT * FROM session_tool7_coupons_set ORDER BY id_session_tool7_coupon_set_pk';
		$res = $this->dbQuery($sql);
		while($row = mysql_fetch_assoc($res))
		{
			$sets[] = array(
				'set'=>$row['set'],
				'info'=>$this->decode($row['info']),
				'href'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, SUBPART_ID=>TAKE2_SET, ID=>$row['id_session_tool7_coupon_set_pk'])),
			);
		}
		
		return array(
			'sets'=>$sets,
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'template'=>'admin/toolTake2Sets.tpl',
		);
	}
	
	
	private function getSingleSet($id_set)
	{
		$sql  = 'SELECT * FROM session_tool7_coupons_set WHERE id_session_tool7_coupon_set_pk = '.$id_set;
		$card = $this->getOneRowFromSql($sql);
		
		$form=new form('singleCard');
			
		$inp_card=new formInputBox($form,'card','',$card['set'],true,255,'width:700px;','adminInput','border:1px solid red;width:700px;','');
		$inp_card->init();
		if($form->isSubmitted() && $inp_card->error)
		{
			$inp_card->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_info=new formInputBox($form,'info','',$card['info'],false,255,'width:700px;','adminInput','border:1px solid red;width:700px;','');
		$inp_info->init();
		if($form->isSubmitted() && $inp_info->error)
		{
			$inp_info->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('session_tool7_coupons_set');
			$q->addString('set', strip_tags($inp_card->value));
			$q->addString('info', strip_tags($inp_info->value));
			$sql = $q->createUpdate('id_session_tool7_coupon_set_pk = '.$id_set);
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList')) $this->redirect($this->getlink(array(PART_ID=>TOOL_TAKE2, SUBPART_ID=>TAKE2_SET)));
			else $this->reload();
		}
		
		return array(
			'singleCard'=>1,
			'form'=>$form->smarty(),
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, SUBPART_ID=>TAKE2_SET)),
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'template'=>'admin/toolTake2Sets.tpl',
		);
	}
	
	
}


?>