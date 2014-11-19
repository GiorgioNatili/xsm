<?php
define('PART_STATIC','static');
$GLOBALS['actionClasses'][PART_STATIC]='staticPage';

class staticPage extends projectCommon 
{
	
	public $params=array();
	public $conn=null;
	
	public $title='';
	public $lead='';
	public $body='';
	public $link='';
	
	public $navigation=array();
	
	function __construct($id,$noTitle=0)
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		$this->navigation = &$GLOBALS['portal']->navigation;
		
		
		if($id)
		{
			$sql="
				select * 
				from static_pages
				where id_static_page_pk=$id
			";
			if($row=$this->getOneRowFromSql($sql))
			{
				$this->title=$this->decode($row['title']);
				$this->body=$this->decode($row['body']);
				$this->link=$this->decode($row['link']);
				return true;
			}
		}
		return false;
	}
	

	public function content()
	{
		$this->navigation[NAVIGATION_PART]=array('label'=>$this->title,'link'=>'');
		
		$GLOBALS['portal']->collumLeft=1;
		$GLOBALS['portal']->collumRight=1;
		
		return array(
			'static'=>array(
				'title'=>$this->title,
				'body'=>$this->body,
			),
			'template'=>'staticPage.tpl',
		);
		
		return $html;
	}

	
	
	
}


?>