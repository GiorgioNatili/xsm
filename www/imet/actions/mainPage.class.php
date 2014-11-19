<?php
define('PART_MAIN','main');

class mainPage extends projectCommon 
{
	
	public $params=array();
	public $conn=null;
	public $navigation=array();
	
		
	public function __construct()
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		$this->navigation = &$GLOBALS['portal']->navigation;
	}
	
	
	public function content()
	{
		return array(
	      	'template'=>'mainPage.tpl'
	    );
	}
	
}
?>