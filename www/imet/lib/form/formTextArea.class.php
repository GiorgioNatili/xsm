<?php

class formTextArea extends projectCommon
{
	public $name='';
	public $id='';
	public $required=false;
	public $value='';
	public $cssClass='';
	public $cssStyle='';
	public $errClass='';
	public $errStyle='';
	public $maxlength='0';
	
	public $rows=1;
	public $cols=1;
	
	public $onFocus='';
	public $onBlur='';
	public $onChange='';
		
	public $disabled=false;
	public $readonly=false;
	public $error=0;
	public $errMsg='';
	public $isSubmitted=false;
	
	private $form;
	

	function __construct(&$form,$name,$id,$value,$required,$maxlength,$cssStyle,$cssClass,$errStyle,$errClass)
	{
		$this->name=$name;
		$this->id=$id;
		$this->value=$value;
		$this->required=$required;
		$this->maxlength=intval($maxlength);
		$this->cssClass=$cssClass;
		$this->cssStyle=$cssStyle;
		$this->errClass=$errClass;
		$this->errStyle=$errStyle;
		
		if(!$this->errClass and !$this->errStyle)
		{
			$this->errStyle='border:1px solid red;';
		}
		
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
		if($this->error) $error=1;
		
	}
	
	
	
	
	public function show()
	{
		$html='';
		
		$value=$this->value;
		$value=str_replace('"','&quot;',$value);
		
		$html.='<textarea ';
			if($this->name) $html.='name="'.$this->name.'" ';
			if($this->id) $html.='id="'.$this->id.'" ';
			
			if($this->cols) $html.='cols="'.$this->cols.'" ';
			if($this->rows) $html.='rows="'.$this->rows.'" ';
			
			//if($this->maxlength>0) $html.='maxlength="'.$this->maxlength.'" ';
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
			
			
			if($this->disabled)
			{
				$html.=' disabled="disabled"';
			}
			if($this->readonly)
			{
				$html.=' readonly="readonly"';
			}
		$html.='>';
		$html.=$value;
		$html.='</textarea>';
		return $html;
	}

}






?>