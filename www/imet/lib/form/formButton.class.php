<?php
class formButton extends projectCommon
{
	public $name='';
	public $id='';
	public $value='';
	public $cssClass='';
	public $cssStyle='';

	public $submit=true;
	public $onClick='';
	
	public $errMsg='';
	
	public $disabled=false;
	public $clicked=false;
	
	public $tabIndex=0;
	
	public $error=0;
	
	private $form;
	
	function __construct(&$form,$name,$id,$value,$cssStyle,$cssClass)
	{
		$this->name=$name;
		$this->id=$id;
		$this->value=$value;
		$this->cssClass=$cssClass;
		$this->cssStyle=$cssStyle;
		
		
		
		$this->form=$form;
		
		$form->add_component($this);
	}
	
	public function init()
	{
		if($this->form->isSubmitted())
		{
			if($this->getPOST($this->name))
			{
				$this->clicked=true;
			}
		}
		
		
		
		
	}
	
	public function show()
	{
		$html='';
		
		$value=$this->value;
		$value=str_replace('"','&quot;',$value);
		
		if($this->submit)
			$type='submit';
		else 
			$type='button';
		
		$html.='<input type="'.$type.'" ';
			if($this->name) $html.='name="'.$this->name.'" ';
			if($this->id) $html.='id="'.$this->id.'" ';
			$html.='value="'.$value.'" ';
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
			if($this->disabled)
			{
				$html.=' disabled="disabled"';
			}
			
			if($this->onClick)
			{
				$html.=' onclick="'.$this->onClick.'"';
			}
			if($this->tabIndex)
			{
				$html.=' tabindex="'.$this->tabIndex.'"';
			}
		$html.='/>';
		return $html;
	}

}






?>