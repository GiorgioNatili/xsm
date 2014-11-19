<?php
define('INPUTBOX_TEXT','text');
define('INPUTBOX_PASSWORD','password');
define('INPUTBOX_HIDDEN','hidden');


class formInputBox extends projectCommon
{
	public $type=INPUTBOX_TEXT;
	public $name='';
	public $id='';
	public $required=false;
	public $value='';
	public $cssClass='';
	public $cssStyle='';
	public $errClass='';
	public $errStyle='';
	public $maxlength='0';
	
	public $onFocus='';
	public $onBlur='';
	public $onChange='';
		
	public $disabled=false;
	public $readOnly=false;
	public $error=0;
	public $errMsg='';
	public $isSubmitted=false;
	
	public $autoComplete;
	
	public $tabIndex=0;
	
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
		
		$this->autoComplete=$this->form->autoComplete;
		
		
		$form->add_component($this);
	}
	
	public function init()
	{
		if($this->form->isSubmitted())
		#if($this->getPOST($this->submit))
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
	
	public function show()
	{
		$html='';
		
		$value=$this->value;
		$value=str_replace('"','&quot;',$value);
		
		$html.='<input type="'.$this->type.'" ';
			if($this->name) $html.='name="'.$this->name.'" ';
			if($this->id) $html.='id="'.$this->id.'" ';
			$html.='value="'.$value.'" ';
			if($this->maxlength>0) $html.='maxlength="'.$this->maxlength.'" ';
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
			if($this->readOnly)
			{
				$html.=' readonly="readonly"';
			}
			if($this->onFocus)
			{
				$html.=' onfocus="'.$this->onFocus.'"';
			}
			
			if($this->onChange)
			{
				$html.=' onchange="'.$this->onChange.'"';
			}
			
			if($this->onBlur)
			{
				$html.=' onblur="'.$this->onBlur.'"';
			}
			if($this->autoComplete==false)
			{
				$html.=' autocomplete="off"';
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