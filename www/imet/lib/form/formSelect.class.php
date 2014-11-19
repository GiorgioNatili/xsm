<?php




class formSelect extends projectCommon
{
	

	public $name='';
	public $id='';
	public $required=false;
	public $value='';
	public $cssClass='';
	public $cssStyle='';
	public $errClass='';
	public $errStyle='';
	
	public $source=array();
	
	public $error=0;
	public $errMsg='';
	public $isSubmitted=false;
	
	public $onChange='';
	
	public $size=1;
	public $multiple=false;
	
	
	function __construct(&$form,$name,$id,$value,$required,$cssStyle,$cssClass,$errStyle,$errClass)
	{
		if(!$this->errClass and !$this->errStyle)
		{
			$this->errStyle='border:1px solid red;';
		}
		
		$this->name=$name;
		$this->id=$id;
		$this->value=$value;
		$this->required=$required;
		$this->cssClass=$cssClass;
		$this->cssStyle=$cssStyle;
		$this->errClass=$errClass;
		$this->errStyle=$errStyle;
		
		$this->form=$form;
		
		$form->add_component($this);
	}
	
	function init()
	{
		if($this->size==1) $this->multiple=false;
		
		if($this->form->isSubmitted())
		{
			$this->value=($this->getPOST($this->name));
			if($this->multiple)
			{
				if(is_array($this->value))
				{
					if($this->required and count($this->value)==0)
					{
						$this->error=1;
					}
				}
				else 
				{
					if($this->required) $this->error=1;
				}
			}
			else 
			{
				
				if($this->required and !$this->value)
				{
					$this->error=1;
				}
			}
			$this->isSubmitted=true;
		}
	}
	
	function getSourceFromSql($sql,$conn,$firstEmpty=1,$firstValue='')
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
	
	
	function show()
	{
		$html='';
		
		$value=$this->value;
		$value=str_replace('"','&quot;',$value);
		
		$html.='<select ';
			if($this->name) 
			{
				if($this->multiple)
					$html.='name="'.$this->name.'[]" ';
				else
					$html.='name="'.$this->name.'" ';
			}
			if($this->id) $html.='id="'.$this->id.'" ';
			if($this->size>1) 
			{
				$html.='size="'.$this->size.'"';
				if($this->multiple) $html.=' multiple="multiple"';
			}
			if($this->cssStyle or $this->errStyle) 
			{
				$html.='style="';
					if($this->cssStyle) $html.=$this->cssStyle;
					if($this->error and $this->errStyle) $html.=$this->errStyle;
				$html.='" ';
			}
			if($this->cssClass or $this->errClass) 
			{
				$html.='class="';
					if($this->cssClass) $html.=$this->cssClass;
					if($this->error and $this->errClass) 
					{	
						if($this->cssClass) $html.=' ';
						$html.=$this->errClass;
					}
				$html.='" ';
			}
			if($this->onChange)
			{
				$html.=' onchange="'.$this->onChange.'"';
			}
		$html.='>';
		foreach ($this->source as $v) 
		{
			if(isset($v['subitems']) and is_array($v['subitems']))
			{
				$html.='<optgroup label="'.$this->decode($v['value']).'">';
					foreach ($v['subitems'] as $si) 
					{
						if($this->multiple)
						{
							if(is_array($this->value) and in_array($si['key'],$this->value)) $selected='selected="selected"'; else $selected='';
						}
						else 
						{
							if($this->value==$si['key']) $selected='selected="selected"'; else $selected='';
						}
						$html.='<option value="'.$si['key'].'" '.$selected.'>'.$si['value'].'</option>';
					}
				$html.='</optgroup>';
			}
			else 
			{
			
				if($this->multiple)
				{
					if(is_array($this->value) and in_array($v['key'],$this->value)) $selected='selected="selected"'; else $selected='';
				}
				else 
				{
					if($this->value==$v['key']) $selected='selected="selected"'; else $selected='';
				}
				$html.='<option value="'.$v['key'].'" '.$selected.'>'.$v['value'].'</option>';
			}
		}
		
		$html.='</select>';
		return $html;
	}

}






?>