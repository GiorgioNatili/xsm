<?php

class formRadio extends projectCommon
{
	public $name='';
	public $id='';
	public $required=false;
	public $value='';
	
	public $error=0;
	public $errMsg='';
	public $isSubmitted=false;
	
	public $cssClass='';
	public $cssStyle='';
	
	
	
	public $source=array();
	
	private $form;
	
	
	public function __construct(&$form,$name,$value,$required)
	{
		$this->name=$name;
		$this->value=$value;
		$this->required=$required;
		
		$this->form=$form;
		
		$form->add_component($this);
		
	}
	
	public function init()
	{
		if($this->form->isSubmitted())
		{
			$this->value=trim(stripslashes($this->getPOST($this->name)));
			if($this->required and !$this->value)
			{
				$this->error=1;
			}
			$this->isSubmitted=true;
		}
		
		
		if($this->error) 
		{
			$error=1; 
		}
		
		
	}
	
	public function getSourceFromSql($sql,$conn,$firstEmpty=1,$firstValue='')
	{
		$this->source=array();
		if($firstEmpty)
		{
			$this->source[]=array('key'=>0,'value'=>'');
		}
		$res=mysql_query($sql,$conn); #echo mysql_error();
		while($row=mysql_fetch_assoc($res))
		{
			$this->source[]=array('key'=>$row['key'],'value'=>$this->decode($row['value']));
		}
	}
	
	public function show($key='')
	{
		
		if(is_numeric($key))
		{
			$html='';
			$html.='<input type="radio" ';
				if($this->name) $html.='name="'.$this->name.'" ';
				
				$html.='value="'.$this->source[$key]['key'] .'" ';
				if($this->value!='' or $this->value===0)
				{
					if($this->source[$key]['key']==$this->value) $html.='checked';
				}
				if($this->cssStyle) 
				{
					$html.='style="';
						if($this->cssStyle) $html.=$this->cssStyle;
					$html.='" ';
				}
				if($this->cssClass) 
				{
					$html.='class="';
						if($this->cssClass) $html.=$this->cssClass;
					$html.='" ';
				}
			$html.='/>';
			$html.='&nbsp;'.$this->source[$key]['value'];
			return $html;
		}
		else 
		{
			$values=array();
			foreach ($this->source as $k=>$v)
			{
				$values[]=$this->show($k);
			}
			return $values;
		}
		
	}

}






?>