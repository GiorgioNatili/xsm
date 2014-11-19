<?php
define('DATEBOX_SELECT',1);

/*Nieskonczone to jest*/

class formDateBox extends projectCommon
{
	var $type=0;

	var $value='';
	
	var $submit='submit';

	
	var $name='',$name_day='',$name_month='',$name_year=''; 
	var $id='',$id_day='',$id_month='',$id_year='';

	var $cssStyle='',$cssStyle_day='',$cssStyle_month='',$cssStyle_year=''; 
	var $cssClass='',$cssClass_day='',$cssClass_month='',$cssClass_year=''; 
	var $errStyle='',$errStyle_day='',$errStyle_month='',$errStyle_year=''; 
	var $errClass='',$errClass_day='',$errClass_month='',$errClass_year=''; 
	
	function formDateBox($submit,$name,$id,$value,$required)
	{
		$this->type=DATEBOX_SELECT;

		$this->submit=$submit;
		if($name)
		{
			$this->name=$name;
			$this->name_day=$name.'_day';
			$this->name_month=$name.'_month';
			$this->name_year=$name.'_year';
		}
		if($id)
		{
			$this->id=$id;
			$this->id_day=$id.'_day';
			$this->id_month=$id.'_month';
			$this->id_year=$id.'_year';
		}
		$this->value=$value;
		$this->required=$required;
	}



	function show()
	{
		$value='';
		
		
		
		
		switch($this->type)
		{
			case DATEBOX_SELECT:
				$value;
				
				$day=0;$month=0;$year=0;
				
				if($this->cssStyle_day) $cssStyle=$this->cssStyle_day; else $cssStyle=$this->cssStyle;
				if($this->errStyle_day) $errStyle=$this->errStyle_day; else $errStyle=$this->errStyle;
				if($this->cssClass_day) $cssClass=$this->cssClass_day; else $cssClass=$this->cssClass;
				if($this->errClass_day) $errClass=$this->errClass_day; else $errClass=$this->errClass;
				$source_day=array('key'=>0,'value'=>'');
				for($i=1;$i<=31;$i++) $source_day[]=array('key'=>$i,'value'=>$i);
				$inp_day=new formSelect($this->submit,$this->name_day,$this->id_day,$day,$this->required,$cssStyle,$cssClass,$errStyle,$errClass);
				$inp_day->source=$source_day;
				//$inp_day
				
				
				
				
			break;
			
		}
		
		
	}
	
	
}



?>