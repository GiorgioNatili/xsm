<?php

class categories extends projectCommon 
{
	public $params=array();
	public $conn=null;
	
	public $sideMenu = array();
	
		
	public function __construct()
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		
		
		if($this->isAdmin())
		{
			$this->sideMenu = $this->getAdminMenu();
		}
		else
		{
			$this->sideMenu = $this->getUserMenu();
		}
	}
	
	
	private function getAdminMenu()
	{
		$menu = array();
		
		$menu[] = array(
			'title'=>'Users',
			'href'=>'#',
			'active'=>$this->params[PART_ID]==TOOL_DOCTORS,
			'subpages'=>array(
				array(
					'title'=>'Sites',
					'href'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_SITES)),
					'active'=>$this->params[PART_ID]==TOOL_DOCTORS && $this->params[SUBPART_ID]==DOCTORS_SITES,
				),
				array(
					'title'=>'List',
					'href'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS)),
					'active'=>$this->params[PART_ID]==TOOL_DOCTORS && !$this->params[SUBPART_ID],
				),
				array(
					'title'=>'Icons',
					'href'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_ICONS)),
					'active'=>$this->params[PART_ID]==TOOL_DOCTORS && $this->params[SUBPART_ID]==DOCTORS_ICONS,
				),
			),
		);
		$menu[] = array(
			'title'=>'Static pages',
			'href'=>$this->getlink(array(PART_ID=>TOOL_STATIC)),
			'active'=>$this->params[PART_ID]==TOOL_STATIC,
		);
		$menu[] = array(
			'title'=>'Holidays',
			'href'=>$this->getlink(array(PART_ID=>TOOL_HOLIDAY)),
			'active'=>$this->params[PART_ID]==TOOL_HOLIDAY,
		);
		$menu[] = array(
			'title'=>'Short texts',
			'href'=>$this->getlink(array(PART_ID=>TOOL_LANGTEXT)),
			'active'=>$this->params[PART_ID]==TOOL_LANGTEXT,
		);
		$menu[] = array(
			'title'=>'Flash tools',
			'href'=>'#',
			'active'=>in_array($this->params[PART_ID], array(TOOL_INTRO, TOOL_FLASHSTATIC, TOOL_AVATAR, TOOL_WHATS_IMPORTANT, TOOL_TAILITUP, TOOL_PROSANDCONS, TOOL_DRAWTHELINE, TOOL_TAKE2, TOOL_COMMENTS, TOOL_EXPERIENCED, TOOL_STIMULANTS, TOOL_HERE)),
			'subpages'=>array(
				array(
					'title'=>'Intro',
					'href'=>$this->getlink(array(PART_ID=>TOOL_INTRO)),
					'active'=>($this->params[PART_ID] == TOOL_INTRO),
				),
				array(
					'title'=>'Static pages',
					'href'=>$this->getlink(array(PART_ID=>TOOL_FLASHSTATIC)),
					'active'=>($this->params[PART_ID] == TOOL_FLASHSTATIC),
				),
				array(
					'title'=>'What\'s important to me?',
					'href'=>$this->getlink(array(PART_ID=>TOOL_WHATS_IMPORTANT)),
					'active'=>($this->params[PART_ID] == TOOL_WHATS_IMPORTANT),
				),
				array(
					'title'=>'Pros And Cons',
					'href'=>$this->getlink(array(PART_ID=>TOOL_PROSANDCONS)),
					'active'=>($this->params[PART_ID] == TOOL_PROSANDCONS),
				),
				array(
					'title'=>'What Have I Experienced',
					'href'=>$this->getlink(array(PART_ID=>TOOL_EXPERIENCED)),
					'active'=>($this->params[PART_ID] == TOOL_EXPERIENCED),
				),
				array(
					'title'=>'Tally It Up!',
					'href'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP)),
					'active'=>($this->params[PART_ID] == TOOL_TAILITUP && !$this->params[SUBPART_ID]),
				),
				array(
					'title'=>'Tally It Up! - Things',
					'href'=>$this->getlink(array(PART_ID=>TOOL_TAILITUP, SUBPART_ID=>TAILITUP_STUFFS)),
					'active'=>($this->params[PART_ID] == TOOL_TAILITUP && $this->params[SUBPART_ID]==TAILITUP_STUFFS),
				),
				array(
					'title'=>'Draw the line',
					'href'=>$this->getlink(array(PART_ID=>TOOL_DRAWTHELINE)),
					'active'=>($this->params[PART_ID] == TOOL_DRAWTHELINE),
				),
				array(
					'title'=>'Take 2 - Sets',
					'href'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, SUBPART_ID=>TAKE2_SET)),
					'active'=>($this->params[PART_ID] == TOOL_TAKE2 && $this->params[SUBPART_ID] == TAKE2_SET),
				),
				array(
					'title'=>'Take 2 - Intro Cards',
					'href'=>$this->getlink(array(PART_ID=>TOOL_TAKE2, SUBPART_ID=>TAKE2_INTROCARDS)),
					'active'=>($this->params[PART_ID] == TOOL_TAKE2 && $this->params[SUBPART_ID] == TAKE2_INTROCARDS),
				),
				array(
					'title'=>'Take 2',
					'href'=>$this->getlink(array(PART_ID=>TOOL_TAKE2)),
					'active'=>($this->params[PART_ID] == TOOL_TAKE2 && !$this->params[SUBPART_ID]),
				),
				array(
					'title'=>'I\'m here',
					'href'=>$this->getlink(array(PART_ID=>TOOL_HERE)),
					'active'=>($this->params[PART_ID] == TOOL_HERE),
				),
				array(
					'title'=>'Comments',
					'href'=>$this->getlink(array(PART_ID=>TOOL_COMMENTS)),
					'active'=>($this->params[PART_ID] == TOOL_COMMENTS),
				),
				array(
					'title'=>'Substances',
					'href'=>$this->getlink(array(PART_ID=>TOOL_STIMULANTS)),
					'active'=>($this->params[PART_ID] == TOOL_STIMULANTS),
				),
			),
		);
		$menu[] = array(
			'title'=>'Summary Page',
			'href'=>$this->getlink(array(PART_ID=>TOOL_SUMMARY)),
			'active'=>$this->params[PART_ID]==TOOL_SUMMARY,
		);
		$menu[] = array(
			'title'=>'Notifications',
			'href'=>$this->getlink(array(PART_ID=>TOOL_NOTIFICATIONS)),
			'active'=>$this->params[PART_ID]==TOOL_NOTIFICATIONS,
		);
		$menu[] = array(
			'title'=>'cSBIRT',
			'href'=>$this->getlink(array(PART_ID=>TOOL_CSBIRT_LINKS)),
			'active'=>$this->params[PART_ID]==TOOL_CSBIRT_LINKS,
		);
		$menu[] = array(
			'title'=>'eZsurvey',
			'href'=>'#',
			'active'=>in_array($this->params[PART_ID], array(TOOL_ZSURVEY_LINKS)),
			'subpages'=>array(
				array(
					'title'=>'eZsurvey links',
					'href'=>$this->getlink(array(PART_ID=>TOOL_ZSURVEY_LINKS)),
					'active'=>($this->params[PART_ID] == TOOL_ZSURVEY_LINKS),
				),
			),
		);
		
		return $menu;
	}
	
	
	private function getUserMenu()
	{
		$doctor = $this->getSession(DOCTOR);
		$permissions = new permissions($doctor['user_id']);
		
		$menu=array();
		
		$menu[] = array(
			'title'=>'Patients list',
			'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS)),
			'active'=>$this->params[PART_ID]==PART_PATIENTS,
		);
		
		$menu[] = array(
			'title'=>'Summary page',
			'href'=>$this->getlink(array(PART_ID=>PART_STATISTICS, SUBPART_ID=>SUMMARY)),
			'active'=>$this->params[PART_ID]==PART_STATISTICS && $this->params[SUBPART_ID]==SUMMARY,
		);
		
		$menu[] = array(
			'title'=>'Correspondence page',
			'href'=>$this->getlink(array(PART_ID=>PART_STATISTICS, SUBPART_ID=>CORRESPONDENCE)),
			'active'=>$this->params[PART_ID]==PART_STATISTICS && $this->params[SUBPART_ID]==CORRESPONDENCE,
		);
		
		if($permissions->isPermittedPart('mail'))
		{
			$menu[] = array(
				'title'=>'Mailbox',
				'href'=>$this->getlink(array(PART_ID=>PART_MAILBOX)),
				'active'=>($this->params[PART_ID] == PART_MAILBOX),
			);
		}
		
		return $menu;
	}

	

}
?>