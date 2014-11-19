<?php



class formCheckBox extends projectCommon
{

	public $name='';
	public $id='';
	public $required=false;
	public $checked=0;
	
	public $error=0;
	public $isSubmitted=false;
	
	public $errMsg='';
	
	public $cssClass='';
	public $cssStyle='';
	
	
	var $onClick='';
	
	function __construct(&$form,$name,$id,$checked,$required)
	{
		$this->name=$name;
		$this->id=$id;
		$this->checked=$checked;
		$this->required=$required;
		
		$this->form=$form;
		$form->add_component($this);
	}
	
	public function init()
	{
		if($this->form->isSubmitted())
		{
			$value=trim($this->getPOST($this->name));
			if($value=='on')
				$this->checked=1;
			else 
				$this->checked=0;
			
			if($this->required and !$this->checked)
			{
				$this->error=1;
			}
			$this->isSubmitted=true;
		}
		
		if($this->error) $error=1;
	}
	
	public function show()
	{
		$html='';
		$html.='<input type="checkbox" ';
			if($this->name) $html.='name="'.$this->name.'" ';
			if($this->id) $html.='id="'.$this->id.'" ';
			if($this->checked) $html.='checked="checked" ';
			if($this->onClick) $html.='onclick="'.$this->onClick.'" ';
			
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
		return $html;
	}

}






?>