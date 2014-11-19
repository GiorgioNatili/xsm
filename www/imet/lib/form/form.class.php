<?php

require_once('formButton.class.php');
require_once('formInputBox.class.php');
require_once('formCheckBox.class.php');
require_once('formSelect.class.php');
require_once('formTextArea.class.php');
#require_once('formRadio.class.php');
require_once('formCheckBoxList.class.php');
require_once('formFile.class.php');



class form extends projectCommon
{
	public $action='';
	public $method='post';
	public $upload=false;
	public $cssclass='';
	
	public $autoComplete=true;
	
	private $components=array();
	private $name;
	private $id;

	var $submit=''; //text lub tablica

	var $error=0;



	public function __construct($name,$id='')
	{
		$this->name=$name;
		$this->id=$id;

		
	}


	public function open()
	{
		$html='';
			$html.='<form action="'.$this->action.'" method="'.$this->method.'"';
			if($this->upload) $html.=' enctype="multipart/form-data"';
			if($this->name) $html.=' name="'.$this->name.'"';
			if($this->id) $html.=' id="'.$this->id.'"';
			if($this->cssclass) $html.=' class="'.$this->cssclass.'"';
			$html.='>';
		return $html;
	}

	public function close()
	{
		$html='';
		$html.='<ins><input type="hidden" name="'.$this->name.'" value="clicked" /></ins>';
		$html.='</form>';
		return $html;
	}

	public function add_component(&$component)
	{
		$this->components[$component->name]=$component;
	}


	public function isSubmitted()
	{
		if($this->getPOST($this->name))
			return true;
		else
			return false;
	}


	public function isValid()
	{
		$valid=1;
		if($this->error) $valid = 0;
		else
		{
			foreach ($this->components as $component)
			{
				if($component->error)
				{
					$valid=0;
				}
			}
		}
		return $valid;
	}

	
	public function smarty()
	{
		$form=array();
		$form['open']=$this->open();
		$form['close']=$this->close();
		$form['valid']=$this->isValid();
		$form['submitted']=$this->isSubmitted();
		$form['fields']=array();
		foreach ($this->components as $component)
		{
			$form['fields'][$component->name]=array('field'=>$component->show(),'errMsg'=>$component->errMsg);
		}
		return $form;
	}
	
	
}





?>