<?php



class formCheckBoxList extends projectCommon
{
	public $name='';
	public $id='';
	public $required=false;
	public $values=array();
	public $error=0;
	public $errMsg='';
	public $isSubmitted=false;
	
	public $source=array();
	
	public $showLabel=true;
	
	public $cssClass='';
	
	private $form;
	
	function __construct(&$form,$name,$values,$required)
	{
		$this->name=$name;
		$this->values=$values;
		$this->required=$required;
		
		$this->form=$form;
		
		$form->add_component($this);
		
		
	}
	
	function init()
	{
		if($this->form->isSubmitted())
		{
			$this->values=(array)($this->getPOST($this->name));
			if($this->required and !count($this->values))
			{
				$this->error=1;
			}
			$this->isSubmitted=true;
		}

		
		if($this->error) $error=1;
		
	}
	
	function getSourceFromSql($sql,$conn)
	{
		$this->source=array();
		$res=mysql_query($sql,$conn); echo mysql_error();
		while($row=mysql_fetch_row($res))
		{
			$this->source[]=array('key'=>$row[0],'value'=>$this->decode($row[1]));
		}
		mysql_free_result($res);
	}
	
	
	/*
	function show($key,$label=1)
	{
		$html='';
		$html.='<input type="checkbox" ';
			if($this->name) $html.='name="'.$this->name.'[]" ';
			
			$html.='value="'.$this->source[$key]['key'] .'" ';
			if(in_array($this->source[$key]['key'],$this->values))
			{
				$html.='checked';
			}
		$html.='/>';
		if($label)
		{
			$html.='&nbsp;'.$this->source[$key]['value'];
		}
		return $html;
	}
	*/
	
	public function show()
	{
		$fields=array();
		#
		foreach ($this->source as $item)
		{
			$field='<input type="checkbox" ';
				if($this->name) $field.='name="'.$this->name.'[]" ';
				
				$field.='value="'.$item['key'] .'" ';
				if(is_array($this->values) and in_array($item['key'],$this->values))
				{
					$field.='checked="checked"';
				}
				if($this->cssClass) $field.='class="'.$this->cssClass.'" ';
			$field.='/>';
			if($this->showLabel)
			{
				$field.='<label> '.$item['value'].'</label>';
			}
			$fields[]=$field;
		}
		#
		return $fields;
	}
	
	
}






?>