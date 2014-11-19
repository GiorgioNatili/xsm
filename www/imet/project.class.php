<?php
define ('PART_ID','pid');
define ('SUBPART_ID','sp');
#		
define('CATEGORY','category');
define('ID','id');
define('ID2','id2');
define('TAB','tab');
define('TOKEN','token');
define('SEARCH_TOKEN','stk');
define('PAGE_ID','page');
define('LETTER','letter');
define('PRINTER','print');
define('FULLPAGE','fullpage');
define('EDIT','edit');
define('ADD','add');
define('ADD2','add2');
define('QUERY','query');
define('ACTIVATE','activate');
define('APPROVE','approve');
define('DELETE','delete');
define('DELETE2','delete2');
define('GRADE','grade');
define('MESSAGE','msg');
define('COMMENT','comment');
define('INFO','info');
define('ID_COMMENT','idcomm');
define('SHOW_ALL','show_all');
define('USER','user');
define('SUBSCRIBE','subscribe');
define('REQUEST','request');
define('ANNOUNCES','ogloszenia');
define('COMMENTS','komentarze');
#
define('NAVIGATION_ROOT',0);
define('NAVIGATION_PART',1);
define('NAVIGATION_SUBPART',2);
define('NAVIGATION_CATEGORY',3);
define('NAVIGATION_SUBCATEGORY',4);
define('NAVIGATION_SUBCATEGORY2',4);
#
define('TITLE_ROOT',0);
define('TITLE_SUBTITLE1',1);
define('TITLE_SUBTITLE2',2);
define('TITLE_SUBTITLE3',3);
define('TITLE_SUBTITLE4',4);
#
define('SEARCH','search');
define('SEARCH_NAME','sname');
define('SEARCH_YEAR','syear');
#
define('ORDER','sort');
	define('ORDER_NAME_ASC',1);
	define('ORDER_NAME_DESC',2);
#	
define('LANG','lang');
	define('LANG_PL','pl');
	define('LANG_EN','en');
#


class project extends projectCommon
{
	public $params=array();
	public $navigation=array();
	
	public $lang=array();
	public $conn=null; //trzeba wpisywac link do poaczenia na wszelki wypadek
	
	public $custom_scripts=array();
	public $debug=true;
	
	public $texts=array();

	
	//public $collumLeft=1;
	//public $collumRight=1;
	
	public $meta=array(
		'title'=>'',
		'keywords'=>'',
		'description'=>''
	);
	
	public function __construct()
	{
		$this->keywords=array_reverse(array());
		$this->conn=$this->connectDB();
		$this->getParams();
		$this->getTexts();
		
		$GLOBALS['portal'] = &$this;

		
		$this->navigation[NAVIGATION_ROOT]=array('label'=>SERVICE_NAME,'link'=>$this->getlink(array(PART_ID=>PART_MAIN)));
		
		if($this->params[PART_ID]==PART_CRON)
		{
			$cron=new cron();
			echo $cron->content();
		}
		elseif($this->params[FULLPAGE])
		{
			
		}
		else
		{
			$this->ShowPage();
		}
		
		$this->closeDB();
	}
	

	
	
	
	private function ShowPage()
	{
		$categories = new categories();
		
		$smarty=new Smarty();
		$smarty->debugging=false;
		$smarty->compile_dir=CACHE_DIR.'template_c';
		$smarty->template_dir='templates/'.TEMPLATE;

		$smarty->assign('links',array(
			'mainPage'=>$this->getlink(array(PART_ID=>PART_MAIN)),
			'aboutImet'=>$this->getlink(array(PART_ID=>PART_STATIC, ID=>1)),
			'privacyPolicy'=>$this->getlink(array(PART_ID=>PART_STATIC, ID=>2)),
		));
		
		$user = new profile();
		$smarty->assign('isLoggedIn',$this->isLoggedIn());
		$smarty->assign('isAdmin',$this->isAdmin());
		$smarty->assign('user',$user->getUserInfo());
		$smarty->assign('lang',$this->getTextSmarty());

		$smarty->assign('sideMenu',$categories->sideMenu);
		if($this->isLoggedIn() || $this->params[PART_ID]==PART_FLASH)
		{
			$smarty->assign($this->content());
		}
		else
		{
			$action = new profile();
			$smarty->assign($action->loginForm());
		}

		$smarty->display('index.tpl');
	}
	

	private function content()
	{
		$data=array();
		switch ($this->params[PART_ID])
		{
			//jesli chcemy obsłużyć inaczej to piszemy np.: case PART_PRODUCTS: {} break;
			case PART_MAIN:
				$action=new mainPage();
				$data=$action->content();
			break;
			case PART_STATIC:
				$action=new staticPage($this->params[ID]);
				$data=$action->content();
			break;
			case PROFILE_LOGOUT:
				$action=new profile();
				$action->userLogout();
			break;
			default: //automatycznie podpina akcje
				if($this->isAdmin() && $this->params[PART_ID] != PART_FLASH)
				{
					if(isset($GLOBALS['toolClasses'][ $this->params[PART_ID] ]))
					{
						$className=$GLOBALS['toolClasses'][ $this->params[PART_ID] ];
						$action=new $className();
						$data=$action->content();
					}
				}
				else
				{
					if(isset($GLOBALS['actionClasses'][ $this->params[PART_ID] ]))
					{
						$className=$GLOBALS['actionClasses'][ $this->params[PART_ID] ];
						$action=new $className();
						$data=$action->content();
					}
				}
		}
		if(empty($data['template'])) $this->redirect($this->getlink(array(PART_ID=>PART_MAIN)));
		return $data;
	}
}
?>