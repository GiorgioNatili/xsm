<?php
define('PART_FLASH','flash');
$GLOBALS['actionClasses'][PART_FLASH]='flash';


class flash extends projectCommon 
{
	public $params=array();
	public $conn=null;
	public $texts=array();
	
		
	public function __construct()
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		$this->texts = &$GLOBALS['portal']->texts;
	}
	
	
	public function content()
	{
		if($this->params[SUBPART_ID])
		{
			$method = $this->params[SUBPART_ID];
			if(method_exists($this, $method))
			{
				echo $this->$method();
				die;
			}
		}
	}
	
	
	private function session()
	{
		$method = 'session_tool'.$this->params[CATEGORY];
		if(method_exists($this, $method))
		{
			return $this->$method();
		}
	}
	
	
	private function initlogin()
	{
		$sql = 'SELECT * FROM patients WHERE register_token LIKE \''.mysql_real_escape_string($this->params[TOKEN]).'\'';
		
		if($patient = $this->getOneRowFromSql($sql))
		{
			$studyManager = new studyManager($patient['id_patient_pk']);
			$studyManager->setAsCompleted(4);
			$studyManager->setAsVisible(5);
			
			$xml='<root>';
				$xml.='<status>1</status><!-- 1=OK, 0,2,...=Error -->';
				$xml.='<user>';
					$xml.='<username><![CDATA['.$patient['username'].']]></username>';
					$xml.='<password><![CDATA[]]></password>';
					$xml.='<firstName><![CDATA['.$patient['first_name'].']]></firstName>';
					$xml.='<middleName><![CDATA['.$patient['middle_name'].']]></middleName>';
					$xml.='<lastName><![CDATA['.$patient['last_name'].']]></lastName>';
					$sex = ($patient['sex'] == 'Female') ? 1 : 2;
					$xml.='<sex><![CDATA['.$sex.']]></sex>';
					$xml.='<birthDate><![CDATA['.$patient['dob'].']]></birthDate>';
					$xml.='<email><![CDATA['.$patient['email'].']]></email>';
					$xml.='<email2><![CDATA['.$patient['email2'].']]></email2>';
					$xml.='<cellPhone><![CDATA['.$patient['cell'].']]></cellPhone>';
					$xml.='<homePhone><![CDATA['.$patient['phone'].']]></homePhone>';
					$xml.='<alternatePhone><![CDATA['.$patient['alternate'].']]></alternatePhone>';
					$xml.='<address><![CDATA['.$patient['address'].']]></address>';
					#$xml.='<suite><![CDATA['.$patient['address2'].']]></suite>';
					$xml.='<city><![CDATA['.$patient['city'].']]></city>';
					$xml.='<state><![CDATA['.$patient['state'].']]></state>';
					$xml.='<zipCode><![CDATA['.$patient['zip'].']]></zipCode>';
					$xml.='<alternateName><![CDATA['.$patient['alternate_name'].']]></alternateName>';
					$xml.='<alternateEmail><![CDATA['.$patient['alternate_email'].']]></alternateEmail>';
					$xml.='<alternatePhone><![CDATA['.$patient['alternate_phone'].']]></alternatePhone>';
					$xml.='<alternateAddress><![CDATA['.$patient['alternate_address'].']]></alternateAddress>';
					#$xml.='<alternateSuite><![CDATA['.$patient['alternate_address2'].']]></alternateSuite>';
					$xml.='<alternateCity><![CDATA['.$patient['alternate_city'].']]></alternateCity>';
					$xml.='<alternateState><![CDATA['.$patient['alternate_state'].']]></alternateState>';
					$xml.='<alternateZipCode><![CDATA['.$patient['alternate_zip'].']]></alternateZipCode>';
				$xml.='</user>';
				$xml.='<ui>';
					$sql = 'SELECT * FROM intro WHERE id_intro_type_fk = 1';
					$res = $this->dbQuery($sql);
					while($row=mysql_fetch_assoc($res))
					{
						$xml.='<text uid="'.$row['uid'].'">';
							$xml.='<![CDATA['.$this->decode($row['text']).']]>';
						$xml.='</text>';
					}
				$xml.='</ui>';
			$xml.='</root>';
			
			$this->setSession('flash_user_id', $patient['id_patient_pk']);
			
			header ('Content-type: text/xml');
			return $xml;
		}
		
		return $this->returnStatus(2);
	}
	
	
	private function logout()
	{
		$userTime = $this->getSession('userTime');
		if(is_array($userTime) && isset($userTime['moduleType']))
		{
			$q = new sqlQuery('patients_activity');
			$q->addInt('id_patient_fk', $userTime['userId']);
			$q->addString('module_type', $userTime['moduleType']);
			$time = floor(microtime(true)*1000) - $userTime['time'];
			
			$spentTimeSec = floor($time/1000); // ilosc sekund
			
			$q->addString('datetime_start',date('Y-m-d H:i:s', strtotime(date('Y-m-d h:i:s')) - $spentTimeSec));
			$q->addString('datetime_finish',date('Y-m-d h:i:s'));
			$q->addString('time', $time);
			$this->dbQuery($q->createInsert());
		}
		
		$this->unsetSession('userTime');
		$this->unsetSession('flash_user_id');
		
		$sql = 'SELECT * FROM session_static WHERE id_session_static_pk = 3';
		$row = $this->getOneRowFromSql($sql);
		
		$xml='';
		$xml.='<root>';
			$xml.='<ui>';
				$xml.='<text uid="complete1_info1">';
					$xml.='<![CDATA['.$this->decode($row['title']).']]>';
				$xml.='</text>';
				$xml.='<text uid="complete1_info2">';
					$xml.='<![CDATA['.$this->decode($row['body']).']]>';
				$xml.='</text>';
				$xml.='<text uid="complete1_info3">';
					$xml.='<![CDATA['.$this->decode($row['body2']).']]>';
				$xml.='</text>';
			$xml.='</ui>';
		$xml.='</root>';
		
		header ('Content-type: text/xml');
		return $xml;
	}
	
	
	private function login()
	{
		$username = $this->getPOST('username');
		$password = md5($this->getPOST('password'));
		//$username = 'krzysiek@emocni.pl';
		//$password = md5('qazqazqaz');
		if($username && $password)
		{
			$sql = 'SELECT p.id_patient_pk, CONCAT(p.first_name,\' \',p.last_name) as fullname,
						   clinician, p.id_doctor_fk
					FROM patients p
					INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
					WHERE p.username LIKE \''.mysql_real_escape_string($username).'\' AND p.password LIKE \''.$password.'\'';
			if($row=$this->getOneRowFromSql($sql))
			{
				$this->setSession('flash_user_id', $row['id_patient_pk']);
				$this->setSession('flash_user_fullname', $row['fullname']);
				$this->setSession('flash_user_starttime', floor(microtime(true)*1000));
				
				$xml='<root>';
					$xml.='<status>1</status>';
					$xml.=$this->getPatientAvatar($row['id_patient_pk']);
					$xml.='<doctor>';
						$xml.='<name><![CDATA['.$row['clinician'].']]></name>';
						$xml.='<avatar><![CDATA['.$this->getDoctorAvatarPath($row['id_doctor_fk']).']]></avatar>';
					$xml.='</doctor>';
				$xml.='</root>';
				
				header ('Content-type: text/xml');
				return $xml;
			}
		}
		return $this->returnStatus(2);
	}
	
	
	private function register()
	{
		if($this->getPOST('action')=='saveData' && intval($this->getSession('flash_user_id')))
		{
			$patient = new patients();
			
			$q = new sqlQuery('patients');
			
			$q->addString('password', md5($this->getPOST('password')));
			$q->addString('first_name', strip_tags($this->getPOST('firstName')));
			$q->addString('middle_name', strip_tags($this->getPOST('middleName')));
			$q->addString('last_name', strip_tags($this->getPOST('lastName')));
			if($this->getPOST('sex')==1)
				$q->addString('sex', 'Female');
			else
				$q->addString('sex', 'Male');
			$q->addString('dob', strip_tags($this->getPOST('birthDate')));
			$q->addString('email', strip_tags($this->getPOST('email')));
			$q->addString('email2', strip_tags($this->getPOST('email2')));
			$q->addString('cell', strip_tags($this->getPOST('cellPhone')));
			$q->addString('phone', strip_tags($this->getPOST('homePhone')));
			$q->addString('alternate', strip_tags($this->getPOST('alternatePhone')));
			$q->addString('address', strip_tags($this->getPOST('address')));
			$q->addString('address2', strip_tags($this->getPOST('suite')));
			$q->addString('city', strip_tags($this->getPOST('city')));
			$q->addString('state', strip_tags($this->getPOST('state')));
			$q->addString('zip', strip_tags($this->getPOST('zipCode')));
			$q->addString('alternate_name', strip_tags($this->getPOST('alternateName')));
			$q->addString('alternate_email', strip_tags($this->getPOST('alternateEmail')));
			$q->addString('alternate_phone', strip_tags($this->getPOST('alternatePhone')));
			$q->addString('alternate_address', strip_tags($this->getPOST('alternateAddress')));
			$q->addString('alternate_address2', strip_tags($this->getPOST('alternateSuite')));
			$q->addString('alternate_city', strip_tags($this->getPOST('alternateCity')));
			$q->addString('alternate_state', strip_tags($this->getPOST('alternateState')));
			$q->addString('alternate_zip', strip_tags($this->getPOST('alternateZipCode')));
			
			$sql = $q->createUpdate('id_patient_pk = '.intval($this->getSession('flash_user_id')));
			$this->dbQuery($sql);
			
			if(!mysql_error())
			{
				$sql = 'SELECT p.clinician, p.id_doctor_fk
						FROM patients p
						WHERE id_patient_pk = '.intval($this->getSession('flash_user_id'));
				$doctor = $this->getOneRowFromSql($sql);
				
				header ('Content-type: text/xml');
				return '<root>
							<status>1</status>
							'.$this->getPatientAvatar(intval($this->getSession('flash_user_id'))).'
							<doctor>
								<name><![CDATA['.$doctor['clinician'].']]></name>
								<avatar><![CDATA['.$this->getDoctorAvatarPath($doctor['id_doctor_fk']).']]></avatar>
							</doctor>
						</root>
				';
			}
		}
		
		header ('Content-type: text/xml');
		return '<root>
					'.$this->getToolComments(10).'
					<status>2</status>
				</root>';
	}
	
	
	private function changePassword()
	{
		if($user_id = intval($this->getSession('flash_user_id')))
		{
			$sql = 'SELECT * FROM patients WHERE id_patient_pk = '.$user_id;
			if($user=$this->getOneRowFromSql($sql))
			{
				if($this->params[ADD])
				{
					$xml='';
					
					if(md5($this->getPOST('oldPassword')) != $user['password'])
					{
						$xml.='<root>';
							$xml.='<status>2</status><!-- 1=OK, 2=Error -->';
							$xml.='<info><![CDATA[Old password is incorrect]]></info>';
						$xml.='</root>';
					}
					elseif($this->getPOST('password'))
					{
						$q = new sqlQuery('patients');
						$q->addString('password', md5($this->getPOST('password')));
						$this->dbQuery($q->createUpdate('id_patient_pk = '.$user_id));
						$xml.='<root>';
							$xml.='<status>1</status><!-- 1=OK, 2=Error -->';
						$xml.='</root>';
					}
					else
					{
						$xml.='<root>';
							$xml.='<status>2</status><!-- 1=OK, 2=Error -->';
							$xml.='<info><![CDATA[New password error]]></info>';
						$xml.='</root>';
					}
					
					header ('Content-type: text/xml');
					return $xml;
				}
				else
				{
					$sql = 'SELECT * FROM session_static WHERE id_session_static_pk = 3';
					$row = $this->getOneRowFromSql($sql);
					
					$xml='';
					$xml.='<root>';
						$xml.='<user>';
							$xml.='<username><![CDATA['.$user['username'].']]></username>';
						$xml.='</user>';
						$xml.='<ui>';
							$xml.='<text uid="info1">';
								$xml.='<![CDATA['.$this->decode($row['title']).']]>';
							$xml.='</text>';
							$xml.='<text uid="info2">';
								$xml.='<![CDATA['.$this->decode($row['body']).']]>';
							$xml.='</text>';
							$xml.='<text uid="info3">';
								$xml.='<![CDATA['.$this->decode($row['body2']).']]>';
							$xml.='</text>';
						$xml.='</ui>';
					$xml.='</root>';
					
					header ('Content-type: text/xml');
					return $xml;
				}
			}
		}
		return $this->returnStatus(2);
	}
	
	
	private function changeContact()
	{
		if($user_id = intval($this->getSession('flash_user_id')))
		{
			$sql = 'SELECT * FROM patients WHERE id_patient_pk = '.$user_id;
			if($user=$this->getOneRowFromSql($sql))
			{
				if($this->params[ADD])
				{
					$q = new sqlQuery('patients');
					$q->addString('email', strip_tags($this->getPOST('email')));
					$q->addString('email2', strip_tags($this->getPOST('email2')));
					$q->addString('cell', strip_tags($this->getPOST('cellPhone')));
					$q->addString('phone', strip_tags($this->getPOST('homePhone')));
					$q->addString('alternate', strip_tags($this->getPOST('alternatePhone')));
					$q->addString('address', strip_tags($this->getPOST('address')));
					$q->addString('city', strip_tags($this->getPOST('city')));
					$q->addString('state', strip_tags($this->getPOST('state')));
					$q->addString('zip', strip_tags($this->getPOST('zipCode')));
					$this->dbQuery($q->createUpdate('id_patient_pk = '.$user_id));
				
					$xml='';
					$xml.='<root>';
						$xml.='<status>1</status><!-- 1=OK, 2=Error -->';
						$xml.='<info><![CDATA[User data updated]]></info>';
					$xml.='</root>';
				}
				else
				{
					$xml='';
					$xml.='<root>';
						$xml.='<user>';
							$xml.='<username><![CDATA['.$user['username'].']]></username>';
							$xml.='<email><![CDATA['.$user['email'].']]></email>';
							$xml.='<email2><![CDATA['.$user['email2'].']]></email2>';
							$xml.='<cellPhone><![CDATA['.$user['cell'].']]></cellPhone>';
							$xml.='<homePhone><![CDATA['.$user['phone'].']]></homePhone>';
							$xml.='<alternatePhone><![CDATA['.$user['alternate'].']]></alternatePhone>';
							$xml.='<address><![CDATA['.$user['address'].']]></address>';
							$xml.='<city><![CDATA['.$user['city'].']]></city>';
							$xml.='<state><![CDATA['.$user['state'].']]></state>';
							$xml.='<zipCode><![CDATA['.$user['zip'].']]></zipCode>';
						$xml.='</user>';
						$xml.='<ui>';
							$xml.='<text uid="info1">';
								$xml.='<![CDATA[Please confirm your contact information:]]>';
							$xml.='</text>';
						$xml.='</ui>';
					$xml.='	</root>';
				}
				
				header ('Content-type: text/xml');
				return $xml;
			}
		}
		return $this->returnStatus(2);
	}
	
	
	private function myPage()
	{
		if($user_id = intval($this->getSession('flash_user_id')))
		{
			$xml='';
			$xml.='<root>';
			
				$xml.=$this->getToolComments(1);
				$xml.='<mailboxReplyLine path="assets/myPage/line.png" />';
				$xml.=$this->getPatientAvatar($user_id);
				/*
				$xml.='<user id="'.$user_id.'">';
					$xml.='<avatar id="1" type="normal">';
						$xml.='<panelMiniature path="assets/user/avatar/avatar1_panel.png" />';
					$xml.='</avatar>';
					$xml.='<email><![CDATA[test@test.test]]></email>';
				$xml.='</user>';
				*/
				
				$sql = 'SELECT my_goal FROM patients WHERE id_patient_pk = '.$user_id;
				if($myGoal = $this->getOneValueFromSql($sql))
				{
					$xml.='<myGoalInfo><![CDATA['.$myGoal.']]></myGoalInfo>';
				}
				else
				{
					$xml.='<myGoalInfo><![CDATA['.$this->getText('my_goal_info').']]></myGoalInfo>';
				}
				
				$xml.='<toolProgress>';

					###
				
					$sql = 'SELECT st2.id_session_tool2_pk
							FROM session_tool2 st2
							INNER JOIN session_tool2_categories st2c ON st2c.id_category_pk = st2.id_category_fk AND st2c.part = 2
							WHERE st2.id_patient_fk = '.$user_id.'
							LIMIT 1';
					if($this->getOneValueFromSql($sql)) $progress = 2; else $progress = 0;
					
					if($progress==0)
					{
						$sql = 'SELECT st2.id_session_tool2_pk
							FROM session_tool2 st2
							INNER JOIN session_tool2_categories st2c ON st2c.id_category_pk = st2.id_category_fk AND st2c.part = 1
							WHERE st2.id_patient_fk = '.$user_id.'
							LIMIT 1';
						if($this->getOneValueFromSql($sql)) $progress = 1; else $progress = 0;
					}
				
					$xml.='<tool type="importantModule" progress="'.$progress.'"> <!-- progress: 0 | 1 | 2 [0-none, 1-part, 2-full] -->';
						$xml.='<name><![CDATA[What’s important to me?]]></name>';
					$xml.='</tool>';
						
					if($progress==2)
					{
						$sql='SELECT id_session_tool3_pk FROM session_tool3 WHERE id_patient_fk = '.$user_id.' LIMIT 1';
						if($this->getOneValueFromSql($sql)) $progress = 2; else $progress = 0;
						
						$xml.='<tool type="prosconsModule" progress="'.$progress.'"> <!-- progress: 0 | 1 | 2 [0-none, 1-part, 2-full] -->';
							$xml.='<name><![CDATA[Pros & Cons]]></name>';
						$xml.='</tool>';
						
						if($progress==2)
						{
							$sql='SELECT id_session_tool5_answer_pk FROM session_tool5_answers WHERE id_patient_fk = '.$user_id.' LIMIT 1';
							if($this->getOneValueFromSql($sql)) $progress = 2; else $progress = 0;
							
							$xml.= '<tool type="calculatorModule" progress="'.$progress.'">
						        		<name><![CDATA[Tally it up!]]></name>
							        </tool>';
							
							if($progress==2)
							{
								$sql='SELECT id_session_tool6_pk FROM session_tool6 WHERE id_patient_fk = '.$user_id.' LIMIT 1';
								if($this->getOneValueFromSql($sql)) $progress = 2; else $progress = 0;
							
								$xml.= '<tool type="drawLineModule" progress="'.$progress.'">
											<name><![CDATA[Draw the line]]></name>
							        	</tool>';
								
								if($progress==2)
								{
									$sql='SELECT id_session_tool4_answer_pk FROM session_tool4_answers WHERE id_patient_fk = '.$user_id.' LIMIT 1';
									if($this->getOneValueFromSql($sql)) $progress = 2; else $progress = 0;
								
									$xml.= '<tool type="expModule" progress="'.$progress.'">
												<name><![CDATA[What have I experienced?]]></name>
						        			</tool>';
									
									if($progress==2)
									{
										$sql='SELECT id_session_tool7_coupon_answer_pk FROM session_tool7_coupons_answers WHERE session=1 AND id_patient_fk = '.$user_id.' LIMIT 1';
										if($this->getOneValueFromSql($sql)) $progress = 2; else $progress = 0;
										
										$xml.= '<tool type="take2Module" progress="'.$progress.'">
													<name><![CDATA[Take 2]]></name>
												</tool>';
										
										if($progress==2)
										{
											$sql='SELECT id_session_tool7_coupon_answer_pk FROM session_tool7_coupons_answers WHERE session=2 AND id_patient_fk = '.$user_id.' LIMIT 1';
											if($this->getOneValueFromSql($sql)) $progress = 2; else $progress = 0;
											
									    	$xml.= '<tool type="take2Module" progress="'.$progress.'">
									        	<name><![CDATA[Take 2]]></name>
									        </tool>';
										}
									}
								}
							}
						}
					}
					
				$xml.='</toolProgress>';
				
				
				
				$xml.='<categoryList>';
					$sql='SELECT * FROM whatlike_categories ORDER BY category';
					$res = $this->dbQuery($sql);
					$max = 0;
					while($row=mysql_fetch_assoc($res))
					{
						$xml.='<category id="'.$row['id_whatlike_category_pk'].'" baseColor="'.$row['baseColor'].'">';
							$xml.='<label><![CDATA['.$this->decode($row['category']).']]></label>';
						$xml.='</category>';
						if($row['id_whatlike_category_pk'] > $max) $max = $row['id_whatlike_category_pk'];
					}
				$xml.='</categoryList>';
						        
				$sql = 'SELECT * FROM whatlike WHERE id_patient_fk = '.$user_id;
				$res = $this->dbQuery($sql);
				if(mysql_num_rows($res))
				{
					$xml.='<photoList>';
						while($row=mysql_fetch_assoc($res))
						{
							$xml.='<photo id="'.$row['id_whatlike_pk'].'" categoryId="'.$row['id_whatlike_category_fk'].'" miniaturePath="'.FILE_WWW.'what_like/miniature/'.$row['image'].'" />';
						}
					$xml.='</photoList>';
				}
			$xml.='</root>';
			
			header ('Content-type: text/xml');
			return $xml;
		}
		
		return $this->returnStatus(2);
	}
	
	
	private function avatar()
	{
		$user_id = intval($this->getSession('flash_user_id'));
		
		if($user_id && $this->params[ADD] && $this->getPOST('avatarId') && $this->getPOST('avatarType'))
		{
			$id = intval($this->getPOST('avatarId'));
			$type = strip_tags($this->getPOST('avatarType'));
			if(in_array($type, array('normal','silhouette')))
			{
				$sql = 'SELECT id_'.$type.'_fk FROM avatars WHERE id_avatar_pk = '.$id;
				if($id_avatar = $this->getOneValueFromSql($sql))
				{
					$q = new sqlQuery('patients');
					$q->addInt('id_avatar_fk', $id_avatar);
					$this->dbQuery($q->createUpdate('id_patient_pk = '.$user_id));
					
					$file = $this->getCMSFileInfo($id_avatar);
					
					header ('Content-type: text/xml');
					return '<root>
								<status>1</status>
								<avatar>
									<panelMiniature path="'.$file['www_path'].'" />
								</avatar>
							</root>
					';
				}
			}
		}
		elseif($user_id)
		{
			$xml='';
			$xml.='<root>';
			
				$xml.=$this->getToolComments(1);
				
				$xml.='<avatarList>';
				
					$sql = 'SELECT * FROM avatars';
					$res = $this->dbQuery($sql);
					
					while($row=mysql_fetch_assoc($res))
					{
						$align=null;
						if($row['chooserPopupAlign']) $align=' chooserPopupAlign="'.$row['chooserPopupAlign'].'"';
						
						$xml.='<avatar id="'.$row['id_avatar_pk'].'" instanceName="avatar'.$row['id_avatar_pk'].'" startBlurValue="'.$row['startBlurValue'].'"'.$align.'>';
							$xml.='<panelMiniature normalPath="'.SERVICE_WWW.'getimage.php?id='.$row['id_normal_fk'].'" silhouettePath="'.SERVICE_WWW.'getimage.php?id='.$row['id_silhouette_fk'].'" />';
						$xml.='</avatar>';
					}
						
				$xml.='</avatarList>';
			$xml.='</root>';
			
			header ('Content-type: text/xml');
			return $xml;
		}
		
		return $this->returnStatus(2);
	}
	
	
	private function iamHere()
	{
		$user_id = intval($this->getSession('flash_user_id'));
		
		if($this->params[ADD] && $this->getPOST('answers') && $user_id)
		{
			$answers = simplexml_load_string($this->decode($this->getPOST('answers')), 'SimpleXMLElement', LIBXML_NOCDATA);
			
			$sql = 'DELETE FROM session_tool8_extra WHERE id_patient_fk = '.$user_id;
			$this->dbQuery($sql);
			
			foreach($answers->tool as $tool)
			{
				if(!empty($tool))
				{
					$q = new sqlQuery('session_tool8_extra');
					$q->addInt('id_patient_fk', $user_id);
					$q->addInt('id_session_tool8_tools_fk', $tool['id']);
					$q->addString('text', strip_tags($tool));
					$this->dbQuery($q->createInsert());
				}
			}
			
			return $this->returnStatus(1);
		}
		elseif($user_id)
		{
			$patient = new patients();
			$summary = $patient->getPatientToolsSummary($user_id, true);
			
			//print_r($summary);die;
			
			$comments = array();
			$sql = 'SELECT * FROM session_tool8_tools';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$comments[$row['id_session_tool8_tools_pk']] = $this->decode($row['comment']);
			}
			
			
			$xml='<root>';
			
				$xml.=$this->getToolComments(8);
			
				$xml.='<tools>';
				
					$xml.='<tool id="1" name="Important" themeColor="0xffbf00" darkThemeColor="0xc49100">';
						$xml.='<miniature x="242" y="17" >';
							$xml.='<label><![CDATA[WHAT’S IMPORTANT TO ME?]]></label>';
						$xml.='</miniature>';
						$xml.='<content width="348" height="330" x="260" y="247" >';
							$xml.='<label><![CDATA[WHAT’S IMPORTANT TO ME?]]></label>';
							$xml.='<value><![CDATA[';
							
								if(isset($summary['tools'][2]['answers']))
								{
									$n=1;
									foreach($summary['tools'][2]['answers'] as $title => $answers)
									{
										$xml.='<p>'.$n.'. '.strip_tags($title).'</p>';
										$xml.='<ul>';
										foreach($answers as $answer)
										{
											$xml.='<li>'.$answer.'</li>';
										}
										$xml.='</ul>';
										$n++;
									}
									$n=null;
								}
							
							$xml.=']]></value>';
						$xml.='</content>';
						$xml.='<doctorComment><![CDATA['.$comments[1].']]></doctorComment>';
					$xml.='</tool>';
					
					
					$xml.='<tool id="2" name="ProsCons" themeColor="0x1af6ff" darkThemeColor="0x15c4cc">';
						$xml.='<miniature x="242" y="200" >';
							$xml.='<label><![CDATA[PROS & CONS]]></label>';
						$xml.='</miniature>';
						$xml.='<content width="348" height="277" x="260" y="303" >';
							$xml.='<label><![CDATA[PROS & CONS]]></label>';
							$xml.='<value><![CDATA[';
								
								if(isset($summary['tools'][3]['answers']['pros']))
								{
									$xml.='<p>Pros:</p>';
									$xml.='<ul>';
										foreach($summary['tools'][3]['answers']['pros'] as $answer)
										{
											$xml.='<li>'.$answer.'</li>';
										}
									$xml.='</ul>';
								}
								if(isset($summary['tools'][3]['answers']['cons']))
								{
									$xml.='<p>Cons:</p>';
									$xml.='<ul>';
										foreach($summary['tools'][3]['answers']['cons'] as $answer)
										{
											$xml.='<li>'.$answer.'</li>';
										}
									$xml.='</ul>';
								}
							
							$xml.=']]></value>';
						$xml.='</content>';
						$xml.='<doctorComment><![CDATA['.$comments[3].']]></doctorComment>';
					$xml.='</tool>';
					

					$xml.='<tool id="3" name="Calculator" themeColor="0xff4d10" darkThemeColor="0xbd390c">';
						$xml.='<miniature x="550" y="17" >';
							$xml.='<label><![CDATA[TALLY IT UP!]]></label>';
						$xml.='</miniature>';
						$xml.='<content width="348" height="276" x="260" y="304" >';
							$xml.='<label><![CDATA[TALLY IT UP!]]></label>';
							$xml.='<value><![CDATA[';
					
								if(isset($summary['tools'][5]['answers']))
								{
									foreach($summary['tools'][5]['answers'] as $answer)
									{
										$xml.='<p>'.$answer.'</p>';
									}
								}
							
							$xml.=']]></value>';
						$xml.='</content>';
						$xml.='<doctorComment><![CDATA['.$comments[2].']]></doctorComment>';
					$xml.='</tool>';
					
					
					$xml.='<tool id="4" name="DrawLine" themeColor="0xfb2801" darkThemeColor="0xb31d01">';
						$xml.='<miniature x="550" y="200" >';
							$xml.='<label><![CDATA[DRAW THE LINE]]></label>';
						$xml.='</miniature>';
						$xml.='<content width="348" height="270" x="262" y="309" >';
							$xml.='<label><![CDATA[DRAW THE LINE]]></label>';
							$xml.='<value><![CDATA[';
					
								if(isset($summary['tools'][6]['answers']))
								{
									$n=1;
									foreach($summary['tools'][6]['answers'] as $title => $answers)
									{
										$xml.='<p>'.$n.'. '.strip_tags($title).'</p>';
										$xml.='<ul>';
										foreach($answers as $answer)
										{
											$xml.='<li>'.$answer.'</li>';
										}
										$xml.='</ul>';
										$n++;
									}
									$n=null;
								}
							
							$xml.=']]></value>';
						$xml.='</content>';
						$xml.='<doctorComment><![CDATA['.$comments[4].']]></doctorComment>';
					$xml.='</tool>';
					
					
					$xml.='<tool id="5" name="Experience" themeColor="0x1ECD06" darkThemeColor="0x18a405">';
						$xml.='<miniature x="242" y="404" >';
							$xml.='<label><![CDATA[WHAT HAVE I EXPERIENCED]]></label>';
						$xml.='</miniature>';
						$xml.='<content width="348" height="277" x="260" y="303" >';
							$xml.='<label><![CDATA[WHAT HAVE I EXPERIENCED?]]></label>';
							$xml.='<value><![CDATA[';
					
								if(isset($summary['tools'][4]['answers']))
								{
									$n=1;
									foreach($summary['tools'][4]['answers'] as $title => $answers)
									{
										$xml.='<p>'.$n.'. '.strip_tags($title).'</p>';
										$xml.='<ul>';
										foreach($answers as $answer)
										{
											$xml.='<li>'.$answer.'</li>';
										}
										$xml.='</ul>';
										$n++;
									}
									$n=null;
								}
							
							$xml.=']]></value>';
						$xml.='</content>';
						$xml.='<doctorComment><![CDATA['.$comments[5].']]></doctorComment>';
					$xml.='</tool>';
					
				$xml.='</tools>';
				
			$xml.='</root>';
			
			header ('Content-type: text/xml');
			return $xml;
		}
		
		return $this->returnStatus(1);
	}
	
	
	private function whatLike()
	{
		$user_id = intval($this->getSession('flash_user_id'));
		
		if($user_id)
		{
			if($this->params[ADD])
			{
				$saveHash = $_POST['saveHash'];
				$title = $_POST['title'];
				$content = $_POST['content'];
				$categoryId = $_POST['categoryId'];
				$boxId = $_POST['boxId'];
				
				$imageWidth = 74;
				$normalPath = "";
				$miniaturePath = "";
				
				$fileExist = count( $_FILES );
				
				if( $fileExist )
				{
					$fileName = $_FILES['Filedata']['name'];
					$ext = explode( '.', $fileName );
					$ext = $ext[ count( $ext )-1 ];
					
					$normalPath = FILE_DIR.'what_like/normal/'.$saveHash.".".$ext;
					$miniaturePath = FILE_DIR.'what_like/miniature/'.$saveHash.".".$ext;
					
					move_uploaded_file($_FILES['Filedata']['tmp_name'], $normalPath );
					move_uploaded_file($_FILES['FiledataMiniature']['tmp_name'], $miniaturePath );
					
					$normalPath = FILE_WWW.'what_like/normal/'.$saveHash.".".$ext;
					$miniaturePath = FILE_WWW.'what_like/miniature/'.$saveHash.".".$ext;
					
					$q=new sqlQuery('whatlike');
					$q->addInt('id_whatlike_category_fk', $categoryId);
					$q->addInt('id_patient_fk', $user_id);
					$q->addInt('boxId', $boxId);
					$q->addString('image', $saveHash.'.'.$ext);
					$q->addString('title', $title);
					$q->addString('content', $content);
					$this->dbQuery($q->createInsert());
				}
				
				$xml = '<root>
							<normalPath>'.$normalPath.'</normalPath>
							<miniaturePath>'.$miniaturePath.'</miniaturePath>
							<title><![CDATA['.$title.']]></title>
							<content><![CDATA['.$content.']]></content>
						</root>';
				header ('Content-type: text/xml');
				return $xml;
			}
			else
			{
				$xml='';
				$xml.='
						<root>
						
							'.$this->getToolComments(9).'
						
							<boxList>
						    	<!-- row 1 -->
						    	<box id="1" rowIndex="0" columnIndex="1" interactive="0" />
						    	<box id="2" rowIndex="0" columnIndex="2" interactive="0" />
						    	<box id="3" rowIndex="0" columnIndex="4" interactive="1" />
						    	<box id="4" rowIndex="0" columnIndex="5" interactive="1" />
						        <!-- row 2 -->
						    	<box id="5" rowIndex="1" columnIndex="0" interactive="0" />
						    	<box id="6" rowIndex="1" columnIndex="1" interactive="0" />
						    	<box id="7" rowIndex="1" columnIndex="2" interactive="0" />
						    	<box id="8" rowIndex="1" columnIndex="3" interactive="1" />
						    	<box id="9" rowIndex="1" columnIndex="4" interactive="1" />
						    	<box id="10" rowIndex="1" columnIndex="5" interactive="1" />
						    	<box id="11" rowIndex="1" columnIndex="6" interactive="1" />
						    	<!-- row 3 -->
						    	<box id="12" rowIndex="2" columnIndex="0" interactive="1" />
						    	<box id="13" rowIndex="2" columnIndex="1" interactive="1" />
						    	<box id="14" rowIndex="2" columnIndex="2" interactive="1" />
						    	<box id="15" rowIndex="2" columnIndex="3" interactive="1" />
						    	<box id="16" rowIndex="2" columnIndex="4" interactive="1" />
						    	<box id="17" rowIndex="2" columnIndex="5" interactive="1" />
						    	<box id="18" rowIndex="2" columnIndex="6" interactive="1" />
						    	<!-- row 4 -->
						    	<box id="19" rowIndex="3" columnIndex="0" interactive="1" />
						    	<box id="20" rowIndex="3" columnIndex="1" interactive="1" />
						    	<box id="21" rowIndex="3" columnIndex="2" interactive="1" />
						    	<box id="22" rowIndex="3" columnIndex="3" interactive="1" />
						    	<!-- row 5 -->
						    	<box id="23" rowIndex="4" columnIndex="1" interactive="1" />
						    	<box id="24" rowIndex="4" columnIndex="2" interactive="1" />
						    	<box id="25" rowIndex="4" columnIndex="3" interactive="1" />
						    	<!-- row 6 -->
						    	<box id="26" rowIndex="5" columnIndex="2" interactive="1" />
						    	<box id="27" rowIndex="5" columnIndex="3" interactive="1" />
						    	<!-- row 7 -->
						    	<box id="28" rowIndex="6" columnIndex="3" interactive="1" />
						    </boxList>
				';
				
				$xml.='<categoryList>';
					$sql='SELECT * FROM whatlike_categories ORDER BY category';
					$res = $this->dbQuery($sql);
					$max = 0;
					while($row=mysql_fetch_assoc($res))
					{
						$xml.='<category id="'.$row['id_whatlike_category_pk'].'" baseColor="'.$row['baseColor'].'" baseDarkColor="'.$row['baseDarkColor'].'" overColor="'.$row['overColor'].'" outColor="'.$row['outColor'].'" editable="1">';
							$xml.='<label><![CDATA['.$this->decode($row['category']).']]></label>';
						$xml.='</category>';
						if($row['id_whatlike_category_pk'] > $max) $max = $row['id_whatlike_category_pk'];
					}
					$xml.='<category id="'.($max+1).'" baseColor="0xfb2801" baseDarkColor="0x9e1901" overColor="0x5a0e01" outColor="0x9e1901" editable="0">';
						$xml.='<label><![CDATA[VIEW ALL]]></label>';
					$xml.='</category>';
				$xml.='</categoryList>';
						        
				$sql = 'SELECT * FROM whatlike WHERE id_patient_fk = '.$user_id;
				$res = $this->dbQuery($sql);
				if(mysql_num_rows($res))
				{
					$xml.='<photoList>';
						while($row=mysql_fetch_assoc($res))
						{
							$xml.='<photo id="'.$row['id_whatlike_pk'].'" categoryId="'.$row['id_whatlike_category_fk'].'" boxId="'.$row['boxId'].'" miniaturePath="'.FILE_WWW.'what_like/miniature/'.$row['image'].'" normalPath="'.FILE_WWW.'what_like/normal/'.$row['image'].'">';
						    	$xml.='<title><![CDATA['.$this->decode($row['title']).']]></title>';
						    	$xml.='<content><![CDATA['.$this->decode($row['content']).']]></content>';
							$xml.='</photo>';
						}
					$xml.='</photoList>';
				}
				$xml.='</root>';
				
				header ('Content-type: text/xml');
				return $xml;
			}
		}
		
		return $this->returnStatus(1);
	}
	
	
	private function mailbox()
	{
		$user_id = intval($this->getSession('flash_user_id'));
		
		if($user_id)
		{
			if($this->params[CATEGORY]==1)
			{
				// REFRESH
				$xml='<root>';
					$xml.='<mails>';
					
						$sql = 'SELECT m.*, d.last_name, p.id_doctor_fk as pcp
								FROM mail m
								INNER JOIN doctors d ON d.id_doctor_pk = m.id_doctor_fk
								INNER JOIN patients p ON p.id_patient_pk = m.id_patient_fk
								WHERE m.id_patient_fk = '.$user_id.' AND approved = 1
								ORDER BY m.date DESC, type ASC';
						$res = $this->dbQuery($sql);
						while($row=mysql_fetch_assoc($res))
						{
							if($row['pcp'] != $row['id_doctor_fk'])
							{
								$sql = 'SELECT last_name FROM doctors WHERE id_doctor_pk = '.$row['pcp'];
								$row['last_name'] = $this->getOneValueFromSql($sql);
							}
							
							$read = $row['is_read'] ? 'true' : 'false';
							if($row['type']=='sent') $read='true';
							$date = reset(explode(' ', $row['date']));
							$date = explode('-', $date);
							
							$xml.='<mail uid="'.$row['id_mail_pk'].'" type="'.$row['type'].'" read="'.$read.'" date="'.$date[2].'/'.$date[1].'/'.$date[0].'">';
							
								if($row['type']=='inbox')
								{
					        		$xml.='<fromUser id="'.$row['id_doctor_fk'].'"><![CDATA[Dr. '.$row['last_name'].']]></fromUser>';
					        		$xml.='<toUser id="'.$user_id.'"><![CDATA['.$this->getSession('flash_user_fullname').']]></toUser>';
								}
								else
								{
									$xml.='<fromUser id="'.$user_id.'"><![CDATA['.$this->getSession('flash_user_fullname').']]></fromUser>';
					        		$xml.='<toUser id="'.$row['id_doctor_fk'].'"><![CDATA[Dr. '.$row['last_name'].']]></toUser>';
								}
					            $xml.='<subject><![CDATA['.$this->decode($row['subject']).']]></subject>';
					            $xml.='<content><![CDATA['.$this->decode($row['content']).']]></content>';
					        $xml.='</mail>';
						}
					$xml.='</mails>';
				$xml.='</root>';
				
				header ('Content-type: text/xml');
				return $xml;
			}
			elseif($this->params[CATEGORY]==2)
			{
				// SET AS READ
				$mail_id = intval($this->getPOST('uid'));
				if($mail_id)
				{
					$q = new sqlQuery('mail');
					$q->addInt('is_read', 1);
					$sql = $q->createUpdate('id_mail_pk = '.$mail_id);
					$res = $this->dbQuery($sql);
					if(mysql_affected_rows())
					{
						header ('Content-type: text/xml');
						return'<root><mail uid="'.$mail_id.'" /></root>';
					}
				}
			}
			elseif($this->params[CATEGORY]==3)
			{
				// SEND MAIL
				$toUserId   = array();
				//if($this->getPOST('toUserId')) $toUserId[] = $this->getPOST('toUserId');
				$fromUserId = $this->getPOST('fromUserId');
				$subject    = $this->getPOST('subject');
				$content    = $this->getPOST('content');
				
				if($fromUserId)
				{
					/*
					if(!count($toUserId))
					{
						$sql = 'SELECT id_doctor_fk
								FROM patients
								WHERE id_patient_pk = '.$user_id;
						$toUserId[] = $this->getOneValueFromSql($sql);
						$sql = 'SELECT id_doctor_fk FROM patients_doctors WHERE id_patient_fk = '.$user_id;
						$res = $this->dbQuery($sql);
						while($row=mysql_fetch_assoc($res))
						{
							$toUserId[] = $row['id_doctor_fk'];
						}
					}
					*/
					
					$sql = 'SELECT id_site_fk FROM patients WHERE id_patient_pk = '.$fromUserId;
					$id_site = $this->getOneValueFromSql($sql);
					
					$sql = 'SELECT sd.id_doctor_fk
							FROM sites_doctors sd
							INNER JOIN doctors d ON d.id_doctor_pk = sd.id_doctor_fk
							WHERE sd.id_site_fk = '.$id_site.' AND d.id_doctor_type_fk = 1
					';
					$res = $this->dbQuery($sql);
					while($row=mysql_fetch_assoc($res))
					{
						$q = new sqlQuery('mail');
						$q->addInt('id_patient_fk', $fromUserId);
						$q->addInt('id_doctor_fk', $row['id_doctor_fk']);
						$q->addString('type', 'sent');
						$q->addString('subject', $subject);
						$q->addString('content', strip_tags($content));
						$q->addCurrentDateTime('date');
						$q->addInt('is_read', 0);
						$q->addInt('approved', 1);
						$this->dbQuery($q->createInsert());
						
						$sql = 'SELECT email FROM doctors WHERE id_doctor_pk = '.$row['id_doctor_fk'];
						$email = $this->getOneValueFromSql($sql);
						$this->sendNewEmailNotification($email, 1);
					}
					
					return $this->returnStatus(1);
				}
			}
		}
	}
	
	
	private function session1complete()
	{
		$id_patient = intval($this->getSession('flash_user_id'));
		if($id_patient)
		{
			$studyManager = new studyManager($id_patient);
			
			$q = new sqlQuery('patients');
			$q->addString('session1_completed', date('Y-m-d H:i:s'));
			
			$sql = 'SELECT id_patient_group_fk FROM patients WHERE id_patient_pk = '.$id_patient;
			if($this->getOneValueFromSql($sql)==3)
			{
				$q->addInt('session1_summary_mail', 1);
			}
			
			$this->dbQuery($q->createUpdate('id_patient_pk = '.$id_patient));
			
			$sql = 'SELECT * FROM session_static WHERE id_session_static_pk = 1';
			$row = $this->getOneRowFromSql($sql);
			
			$xml='';
			$xml.='<root>';
				$xml.='<ui>';
					$xml.='<text uid="info1">';
						$xml.='<![CDATA['.$this->decode($row['body']).']]>';
					$xml.='</text>';
					$xml.='<text uid="info2">';
						$xml.='<![CDATA['.$this->decode($row['body2']).']]>';
					$xml.='</text>';
				$xml.='</ui>';
			$xml.='</root>';
			
			$studyManager->setAsCompleted(5);
			$this->sentSessionCompleteNotification(1, $id_patient);
			
			header ('Content-type: text/xml');
			return $xml;
		}
		return $this->returnStatus(1);
	}
	
	
	private function session2complete()
	{
		$id_patient = intval($this->getSession('flash_user_id'));
		if($id_patient)
		{
			$studyManager = new studyManager($id_patient);
			
			$q = new sqlQuery('patients');
			$q->addString('session2_completed', date('Y-m-d H:i:s'));
			
			$sql = 'SELECT id_patient_group_fk FROM patients WHERE id_patient_pk = '.$id_patient;
			if($this->getOneValueFromSql($sql)==3)
			{
				$q->addInt('session2_summary_mail', 1);
			}
			
			$this->dbQuery($q->createUpdate('id_patient_pk = '.$id_patient));
			
			$sql = 'SELECT * FROM session_static WHERE id_session_static_pk = 4';
			$row = $this->getOneRowFromSql($sql);
			
			$sql = 'SELECT CONCAT(d.first_name,\' \', d.last_name) as doctor
					FROM patients p
					INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
					WHERE p.id_patient_pk = '.$id_patient.'
			';
			$doctorName = $this->getOneValueFromSql($sql);
			
			$row['body']  = str_replace('*DOCTOR*', $doctorName, $row['body']);
			$row['body2'] = str_replace('*DOCTOR*', $doctorName, $row['body2']);
			
			$xml='';
			$xml.='<root>';
				$xml.='<ui>';
					$xml.='<text uid="info1">';
						$xml.='<![CDATA['.$this->decode($row['body']).']]>';
					$xml.='</text>';
					$xml.='<text uid="info2">';
						$xml.='<![CDATA['.$this->decode($row['body2']).']]>';
					$xml.='</text>';
				$xml.='</ui>';
			$xml.='</root>';
			
			$studyManager->setAsCompleted(7);
			$this->sentSessionCompleteNotification(2, $id_patient);
			
			header ('Content-type: text/xml');
			return $xml;
		}
		return $this->returnStatus(1);
	}
	
	
	/************************************************************************/
	
	
	private function session_tool2()
	{
		$id_patient = intval($this->getSession('flash_user_id'));
		
		if($this->params[ADD] && $this->getPOST('answers') && $id_patient)
		{
			$sql = 'DELETE FROM session_tool2 WHERE id_patient_fk = '.$id_patient;
			$this->dbQuery($sql);
			
			$answers = simplexml_load_string($this->decode($this->getPOST('answers')), 'SimpleXMLElement', LIBXML_NOCDATA);
			
			foreach($answers as $categories)
			{
				$level = $categories['level'];
				
				if($level==1)
				{
					$save = str_replace('<root>', '<save>', $this->decode($this->getPOST('answers')));
					$save = str_replace('</root>', '</save>', $save);
					$start  = (strpos($save, '<category id="3">')+strlen('<category id="3">'));
					$length = (strpos($save, '</categories>')-strlen('</category>')) - $start;
					$save = str_replace(substr($save, $start, $length), '', $save);
					
					
					$sql = 'DELETE FROM session_tool2_part1 WHERE id_patient_fk = '.$id_patient;
					$this->dbQuery($sql);
					
					$q = new sqlQuery('session_tool2_part1');
					$q->addInt('id_patient_fk', $id_patient);
					$q->addString('save', $save);
					$this->dbQuery($q->createInsert());
				}
				elseif($level==2)
				{
					$sql = 'DELETE FROM session_tool2_part1 WHERE id_patient_fk = '.$id_patient;
					$this->dbQuery($sql);
				}
				
				foreach($categories as $category)
				{
					if(count($category->cards))
					{
						$id_category = $category['id'];
						
						foreach($category->cards as $card)
						{
							foreach($card as $single)
							{
								$q = new sqlQuery('session_tool2');
								$q->addInt('id_patient_fk', $id_patient);
								$q->addInt('id_category_fk', $id_category);
								$q->addString('answer', $single->label);
								$sql = $q->createInsert();
								$this->dbQuery($sql);
							}
						}
					}
				}
			}
			
			return $this->returnStatus(1);
		}
		else
		{
			$xml = '';
			$xml.='<root>';
			
				$sql = 'SELECT save FROM session_tool2_part1 WHERE id_patient_fk = '.$id_patient;
				$xml.=$this->getOneValueFromSql($sql);
			
				$xml.=$this->getToolComments(2);
			
				$sql='SELECT * FROM session_tool2_categories ORDER BY part';
				$res=$this->dbQuery($sql);
				
				while($row=mysql_fetch_assoc($res))
				{
					$xml.='<categories>';
						$xml.='<category id="'.$row['id_category_pk'].'" level="'.$row['part'].'" backgroundColor="'.$row['background'].'">';
							$xml.='<label1><![CDATA['.$row['label1'].']]></label1>';
							$xml.='<label2><![CDATA['.$row['label2'].']]></label2>';
						$xml.='</category>';
					$xml.='</categories>';
				}
				
				$sql = 'SELECT stc.*, stt.type FROM session_tool2_cards stc
						INNER JOIN session_tool2_types stt ON stt.id_session_tool2_type_pk = stc.id_session_tool2_type_fk
						ORDER BY stc.id_session_tool2_type_fk
				';
				$res=$this->dbQuery($sql);
				
				while($row=mysql_fetch_assoc($res))
				{
					$xml.='<cards>';
						$xml.='<card id="'.$row['id_session_tool2_card_pk'].'" type="'.$row['type'].'" backgroundColor="'.$row['background'].'">';
							$xml.='<label><![CDATA['.$row['label1'].']]></label>';
							$xml.='<secondSideLabel><![CDATA['.$row['label2'].']]></secondSideLabel>';
						$xml.='</card>';
					$xml.='</cards>';
				}
				
			$xml.='</root>';
			
			header ('Content-type: text/xml');
			return $xml;
		}
	}
	
	
	private function session_tool3()
	{
		$id_patient = intval($this->getSession('flash_user_id'));

		if($this->params[ADD] && $this->getPOST('answers') && $id_patient)
		{
			$sql = 'DELETE FROM session_tool3 WHERE id_patient_fk = '.$id_patient;
			$this->dbQuery($sql);
			
			$xml = simplexml_load_string($this->decode($this->getPOST('answers')), 'SimpleXMLElement', LIBXML_NOCDATA);
			
			foreach($xml->answers->answer as $card)
			{
				$q = new sqlQuery('session_tool3');
				$q->addInt('id_patient_fk', $id_patient);
				$q->addInt('id_session_tool3_card_fk', $card['id']);
				$sql = $q->createInsert();
				$this->dbQuery($sql);
			}
			
			return $this->returnStatus(1);
		}
		else
		{
			$xml = '';
			$xml.='<root>';
				
				$xml.=$this->getToolComments(3);
			
				$xml.='<boards>';
					$xml.='<board id="1" libraryPath="module/proscons/skateBoard.swf">';
						$xml.='<label><![CDATA[skate]]></label>';
						$xml.='<userActivities>';
							$xml.='<activity type="1" loopVideo="true">';
								$xml.='<startPosition x="0" y="-160" />';
							$xml.='</activity>';
							$xml.='<activity type="2" loopVideo="false">';
								$xml.='<startPosition x="0" y="-160" />';
							$xml.='</activity>';
							$xml.='<activity type="3" loopVideo="false">';
								$xml.='<startPosition x="5" y="-160" />';
							$xml.='</activity>';
							$xml.='<activity type="4" loopVideo="false">';
								$xml.='<startPosition x="0" y="-160" />';
								$xml.='<move x="0" y="-60" startTime=".5" duration=".2" />';
							$xml.='</activity>';
							$xml.='<activity type="5" loopVideo="true">';
								$xml.='<startPosition x="0" y="-60" />';
							$xml.='</activity>';
							$xml.='<activity type="6" loopVideo="false">';
								$xml.='<startPosition x="0" y="-60" />';
							$xml.='</activity>';
						$xml.='</userActivities>';
					$xml.='</board>';
				$xml.='</boards>';
				$xml.='<cards>';
				
					$patient_stimulants = array();
					$patient_stimulants = $this->getPatientStimulants($id_patient, true);
					
					if(!count($patient_stimulants))
					{
						file_put_contents(CACHE_DIR.'session3_error_'.date('Y.m.d.H.i.s'), $id_patient);
					}
					
					$sql = 'SELECT * FROM session_tool3_cards
							WHERE id_stimulant_fk IN ('.implode(',', $patient_stimulants).')
							ORDER BY id_stimulant_fk
					';
					
					$res = $this->dbQuery($sql);
					
					while($row=mysql_fetch_assoc($res))
					{
						$xml.='<card id="'.$row['id_session_tool3_card_pk'].'" type="regular" category="'.$this->decode($row['category']).'" >';
							$xml.='<label><![CDATA['.$this->decode($row['label']).']]></label>';
						$xml.='</card>';
					}
				
				$xml.='</cards>';
			$xml.='</root>';
			
			header ('Content-type: text/xml');
			return $xml;
		}
		
		fclose($fp);
	}
	
	
	private function session_tool4()
	{
		$id_patient = intval($this->getSession('flash_user_id'));

		if($this->params[ADD] && $this->getPOST('answers') && $id_patient)
		{
			$answers = simplexml_load_string($this->decode($this->getPOST('answers')), 'SimpleXMLElement', LIBXML_NOCDATA);
			
			//$a='<root><answers><answer personId="1" value="false" /><answer personId="2" value="true" /><answer personId="3" value="true" /><answer personId="4" value="true" /><answer personId="5" value="true" /><answer personId="6" value="true" /><answer personId="7" value="false" /><answer personId="8" value="false" /><answer personId="9" value="true" /><answer personId="10" value="true" /><answer personId="11" value="false" /><answer personId="12" value="true" /><answer personId="13" value="false" /><answer personId="14" value="true" /><answer personId="15" value="false" /><answer personId="16" value="false" /><answer personId="17" value="true" /><answer personId="18" value="true" /><answer personId="19" value="true" /><answer personId="20" value="true" /><answer personId="21" value="false" /></answers></root>';
			//$answers = simplexml_load_string($a, 'SimpleXMLElement', LIBXML_NOCDATA);
			
			$sql = 'DELETE FROM session_tool4_answers WHERE id_patient_fk = '.$id_patient;
			$this->dbQuery($sql);
			
			foreach($answers->answers->answer as $answer)
			{
				$q = new sqlQuery('session_tool4_answers');
				$q->addInt('id_patient_fk', $id_patient);
				$q->addInt('id_session_tool4_person_fk', $answer['personId']);
				$q->addString('answer', $answer['value']=='true'?'Yes':'No');
				$this->dbQuery($q->createInsert());
			}
			
			return $this->returnStatus(1);
		}
		else
		{
			$xml = '';
			$xml.='<root>';
			
				$xml.=$this->getToolComments(4);
				
				$xml.='<board path="assets/exp/board.png" />';
				$xml.='<personList>';
				
					$sql = 'SELECT * FROM session_tool4_person ORDER BY id_session_tool4_person_pk';
					$res = $this->dbQuery($sql);
					
					while($row=mysql_fetch_assoc($res))
					{
				    	$xml.='<person id="'.$row['id_session_tool4_person_pk'].'" boardImagePath="assets/exp/person/'.$row['id_session_tool4_person_pk'].'_board.png" selectedImagePath="assets/exp/person/'.$row['id_session_tool4_person_pk'].'_selected.png">';
				        	$xml.='<boardImagePosition x="'.$row['x1'].'" y="'.$row['y1'].'" />';
				            $xml.='<statusIconPosition x="'.$row['x2'].'" y="'.$row['y2'].'" />';
				            $xml.='<selectedImagePosition x="'.$row['x3'].'" y="'.$row['y3'].'" />';
				            $xml.='<card type="regular">';
				            	$xml.='<position x="'.$row['x4'].'" y="'.$row['y4'].'" />';
				                $xml.='<question><![CDATA['.$this->decode($row['question']).']]></question>';
				            $xml.='</card>';
				        $xml.='</person>';
					}
					
        		$xml.='</personList>';
			
			$xml.='</root>';
			
			header ('Content-type: text/xml');
			return $xml;
		}
	}
	
	
	private function session_tool5()
	{
		$id_patient = intval($this->getSession('flash_user_id'));
		
		if($this->params[ADD] && $this->getPOST('answers') && $id_patient)
		{
			$sql = 'DELETE FROM session_tool5_answers WHERE id_patient_fk = '.$id_patient;
			$this->dbQuery($sql);
			
			$answers = simplexml_load_string($this->decode($this->getPOST('answers')), 'SimpleXMLElement', LIBXML_NOCDATA);
			
			foreach($answers->answers->answer as $answer)
			{
				// id_pre_tlfb_stimulant_fk = $answer->substance['id'];
				// id_calculator_type_fk = $answer->calculationType['id'];
				// value = $answer->overall['value'];
				// input = $answer->option1
				// id_value1_fk = $answer->option2
				// id_value2_fk = $answer->option3
				
				$text = null;
				$sql = 'SELECT box_label FROM pre_tlfb_stimulants WHERE id_pre_tlfb_stimulant_pk = '.$answer->substance['id'];
				$text.=$this->getOneValueFromSql($sql);
				$sql = 'SELECT type FROM calculator_types WHERE id_calculator_type_pk = '.$answer->calculationType['id'];
				$type = $this->getOneValueFromSql($sql);
				$text.=' '.$type;
				$text.=' ('.$answer->overall['value'];
				switch($type)
				{
					case 'time':
						$text.=' hours';
					break;
					case 'money':
						$text.=' dollars';
					break;
					case 'calories':
						$text.=' calories';
					break;
				}
				$text.=')'."\n";
				
				$sql = 'SELECT cs.text, cs.value
						FROM calculator_types_stuffs cts
						INNER JOIN calculator_stuffs cs ON cs.id_calculator_stuff_pk = cts.id_calculator_stuff_fk
						WHERE cts.id_calculator_type_fk = '.$answer->calculationType['id'].'
				';
				$res = $this->dbQuery($sql);
				while($row=mysql_fetch_assoc($res))
				{
					if(intval($row['value']) < intval($answer->overall['value']))
					{
						$division = round(intval($answer->overall['value']) / intval($row['value']));
						$text.=str_replace('{#}', $division, $row['text'])."\n";
					}
				}
				
				$q = new sqlQuery('session_tool5_answers');
				$q->addInt('id_patient_fk', $id_patient);
				$q->addInt('id_pre_tlfb_stimulant_fk', $answer->substance['id']);
				$q->addInt('id_calculator_type_fk', $answer->calculationType['id']);
				$q->addString('value', $answer->overall['value']);
				$q->addInt('input', $answer->option1);
				$q->addInt('id_value1_fk', $answer->option2);
				$q->addInt('id_value2_fk', $answer->option3);
				$q->addString('text', $text);
				$this->dbQuery($q->createInsert());
			}
			
			return $this->returnStatus(1);
		}
		elseif($id_patient)
		{
			$substances = array();
			
			$patient_substances = $this->getPatientStimulants($id_patient, true);
			
			/*
			$sql = 'SELECT pts.*
					FROM patients_stimulants ps
					INNER JOIN pre_tlfb_stimulants pts ON pts.id_pre_tlfb_stimulant_pk = ps.id_pre_tlfb_stimulant_fk
					WHERE ps.id_patient_fk = '.$id_patient.'
			';
			*/
			
			$sql = 'SELECT *
					FROM pre_tlfb_stimulants
					WHERE id_pre_tlfb_stimulant_pk IN('.implode(',', $patient_substances).')
			';
			
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$substances[] = array('id'=>$row['id_pre_tlfb_stimulant_pk'], 'type'=>$row['stimulant'], 'box_label'=>$this->decode($row['box_label']));
			}
			
			if(count($substances))
			{
				$xml = '';
				$xml.='<root>';
				
					$xml.= '<save>
								<answers>
									<answer>
										<substance id="2"/>
										<calculationType id="1"/>
										<overall value="120"/>
										<option1 type="input"><![CDATA[120]]></option1>
										<option2 type="list"><![CDATA[2]]></option2>
										<option3 type="list"><![CDATA[3]]></option3>
									</answer>
									<answer><substance id="3"/><calculationType id="1"/><overall value="4800"/><option1 type="input"><![CDATA[120]]></option1><option2 type="list"><![CDATA[3]]></option2><option3 type="list"><![CDATA[3]]></option3></answer><answer><substance id="4"/><calculationType id="2"/><overall value="1200"/><option1 type="input"><![CDATA[120]]></option1><option2 type="input"><![CDATA[10]]></option2><option3 type="list"><![CDATA[3]]></option3></answer><answer><substance id="4"/><calculationType id="1"/><overall value="120"/><option1 type="input"><![CDATA[120]]></option1><option2 type="list"><![CDATA[2]]></option2><option3 type="list"><![CDATA[3]]></option3></answer><answer><substance id="1"/><calculationType id="3"/><overall value="120"/><option1 type="input"><![CDATA[120]]></option1><option2 type="list"><![CDATA[1]]></option2><option3 type="list"><![CDATA[3]]></option3></answer><answer><substance id="1"/><calculationType id="1"/><overall value="120"/><option1 type="input"><![CDATA[120]]></option1><option2 type="list"><![CDATA[2]]></option2><option3 type="list"><![CDATA[3]]></option3></answer></answers>
							</save>';
				
					$xml.=$this->getToolComments(5);
				
					$xml.='<substances>';
						foreach($substances as $substance)
						{
							$xml.='<substance id="'.$substance['id'].'" type="'.$substance['type'].'">';
								$xml.='<boxLabel><![CDATA['.$substance['box_label'].']]></boxLabel>';
								$xml.='<label><![CDATA['.strtoupper($substance['type']).']]></label>';
								$xml.='<calculationTypes>';
								
									$sql = 'SELECT ct.*
											FROM calculator_types ct
											WHERE id_pre_tlfb_stimulant_fk = '.$substance['id'];
									$res=$this->dbQuery($sql);
									
									while($type=mysql_fetch_assoc($res))
									{
										$xml.='<calculationType id="'.$type['id_calculator_type_pk'].'" type="'.$type['type'].'">';
											$xml.='<calculatorInfoText><![CDATA['.$type['calculator_info_text'].']]></calculatorInfoText>';
											$xml.='<stuffInfoText><![CDATA['.$type['stuff_info_text'].']]></stuffInfoText>';
											$xml.='<label><![CDATA['.strtoupper($type['type']).']]></label>';
		
											$xml.='<stuffs>';
												
												$sql = 'SELECT cts.id_calculator_stuff_fk as id
														FROM calculator_types_stuffs cts
														WHERE id_calculator_type_fk = '.$type['id_calculator_type_pk'].'
												';
												$res2=$this->dbQuery($sql);
												
												while($stuff=mysql_fetch_assoc($res2))
												{
													$xml.='<stuff id="'.$stuff['id'].'" />';
												}
											
											$xml.='</stuffs>';
											$xml.='<options>';
											
												$sql = 'SELECT co.id_calculator_option_pk as id, co.type, co.label
														FROM calculator_options co
														WHERE id_calculator_type_fk = '.$type['id_calculator_type_pk'].'
												';
												$res2=$this->dbQuery($sql);
												
												while($option=mysql_fetch_assoc($res2))
												{
													$xml.='<option id="'.$option['id'].'" type="'.$option['type'].'">';
														$xml.='<label><![CDATA['.$option['label'].']]></label>';
														
														if($option['type'] == 'list')
														{
															$xml.='<dataProvider>';
																$sql = 'SELECT cov.*
																		FROM calculator_option_values cov
																		WHERE id_calculator_option_fk = '.$option['id'].'
																';
																$res3=$this->dbQuery($sql);
																
																while($value=mysql_fetch_assoc($res3))
																{
																	$xml.='<item id="'.$value['id_calculator_option_value_pk'].'" data="'.$value['data'].'">';
																		$xml.='<label><![CDATA['.$value['label'].']]></label>';
																	$xml.='</item>';
																}
															$xml.='</dataProvider>';
														}
														
													$xml.='</option>';
												}
											
											$xml.='</options>';
										$xml.='</calculationType>';
									}
								
								$xml.='</calculationTypes>';
							$xml.='</substance>';
						}
					$xml.='</substances>';
					$xml.='<stuffs>';
					
						$sql = 'SELECT * FROM calculator_stuffs';
						$res = $this->dbQuery($sql);
						
						while($stuff=mysql_fetch_assoc($res))
						{
							$xml.='<stuff id="'.$stuff['id_calculator_stuff_pk'].'" value="'.$stuff['value'].'" range="1">';
								$xml.='<label><![CDATA['.$stuff['text'].']]></label>';
							$xml.='</stuff>';
						}
					$xml.='</stuffs>';
				$xml.='</root>';
				
				header ('Content-type: text/xml');
				return $xml;
			}
		}
		
		return $this->returnStatus(1);
	}
	
	
	private function session_tool6()
	{
		$id_patient = intval($this->getSession('flash_user_id'));
				
		if($this->params[ADD] && $this->getPOST('answers') && $id_patient)
		{
			$answers = simplexml_load_string($this->decode($this->getPOST('answers')), 'SimpleXMLElement', LIBXML_NOCDATA);
			
			$sql = 'DELETE FROM session_tool6 WHERE id_patient_fk = '.$id_patient;
			$this->dbQuery($sql);
			
			foreach($answers->stateResults->confidentStateResult->answerList->answer as $answer)
			{
				$q = new sqlQuery('session_tool6');
				$q->addInt('id_patient_fk', $id_patient);
				$q->addInt('id_confident_answer_fk', $answer['optionId']);
				$q->addInt('confident_digit', $answers->stateResults->confidentStateResult->digit);
				$q->addString('confident_answer', $answer);
				$sql = $q->createInsert();
				$this->dbQuery($sql);
			}
			
			foreach($answers->stateResults->readyStateResult->answerList->answer as $answer)
			{
				$q = new sqlQuery('session_tool6');
				$q->addInt('id_patient_fk', $id_patient);
				$q->addInt('id_ready_answer_fk', $answer['optionId']);
				$q->addInt('ready_digit', $answers->stateResults->readyStateResult->digit);
				$q->addString('ready_answer', $answer);
				$sql = $q->createInsert();
				$this->dbQuery($sql);
			}
			
			return $this->returnStatus(1);
		}
		else
		{
			$xml='';
			
			$xml.='<root>'."\n";
			
				$xml.=$this->getToolComments(6);
			
				$xml.='<board id="1" libraryPath="module/drawLine/drawLineBoard2.swf">'."\n";
					$xml.='<label><![CDATA[skate]]></label>'."\n";
						
						$xml.='<states>'."\n";
							
							for($i=1; $i<=2; $i++)
							{
								$xml.='<state type="'.$i.'">'."\n";
									$xml.='<questions>'."\n";
									
										for($j=1; $j<=3; $j++)
										{
											$k = ($i == 1) ? $j : $j+3;
											$sql = 'SELECT sta.*, stq.*
													FROM session_tool6_answers sta
													INNER JOIN session_tool6_questions stq ON stq.id_session_tool6_question_pk = sta.id_session_tool6_question_fk
													WHERE stq.state = '.$i.' AND id_session_tool6_question_pk = '.$k.'
													ORDER BY digits
											';
											$res = $this->dbQuery($sql);
											$question=false;
											while($row=mysql_fetch_assoc($res))
											{
												if(!$question)
												{
													$xml.='<question id="'.$k.'" digits="'.$this->decode($row['digits']).'">'."\n";
													$xml.='<label><![CDATA['.$this->decode($row['question']).']]></label>'."\n";
													$xml.='<doctorFeedback><![CDATA['.$this->decode($row['doctor_feedback']).']]></doctorFeedback>';
													$xml.='<options>'."\n";
													$question=true;
												}
												
												$xml.='<option id="'.$row['id_session_tool6_answer_pk'].'" type="'.$row['type'].'">'."\n";
													$xml.='<label><![CDATA['.$this->decode($row['answer']).']]></label>'."\n";
												$xml.='</option>'."\n";
											}
											$xml.='</options>'."\n";
											$xml.='</question>'."\n";
										}
										
									$xml.='</questions>'."\n";
										
									if($i == 1)
									{
										$xml.='<userActivities>'."\n";
											$xml.='<activity type="1" loopVideo="false">'."\n";
												$xml.='<startPosition x="150" y="-500" />'."\n";
												$xml.='<cuePoint name="showScale" startTime="13" /><!-- 13 -->'."\n";
											$xml.='</activity>'."\n";
											$xml.='<activity type="3" loopVideo="true">'."\n";
												$xml.='<startPosition x="70" y="-490" />'."\n";
											$xml.='</activity>'."\n";
											$xml.='<activity type="2" loopVideo="false">'."\n";
												$xml.='<startPosition x="-250" y="-500" />'."\n";
											$xml.='</activity>'."\n";
										$xml.='</userActivities>'."\n";
									}
									elseif($i == 2)
									{
										$xml.='<userActivities>'."\n";
											$xml.='<activity type="1" loopVideo="false">'."\n";
												$xml.='<startPosition x="-1400" y="-500" />'."\n";
												$xml.='<cuePoint name="showScale" startTime="1" /><!-- 13 -->'."\n";
											$xml.='</activity>'."\n";
											$xml.='<activity type="3" loopVideo="true">'."\n";
												$xml.='<startPosition x="-1500" y="-500" />'."\n";
											$xml.='</activity>'."\n";
											$xml.='<activity type="2" loopVideo="false">'."\n";
												$xml.='<startPosition x="-560" y="-500" />'."\n";
											$xml.='</activity>'."\n";
										$xml.='</userActivities>'."\n";
									}
									
								$xml.='</state>'."\n";
							}
							
							$xml.='
							
							<state type="3">
								<userActivities>
									<activity type="1" loopVideo="true">
										<startPosition x="70" y="-550" />
									</activity>
									
									<activity type="2" loopVideo="true">
										<startPosition x="680" y="-550" />
									</activity>
								</userActivities>
							</state>
							
						</states>
						
					</board>
				
				<cards>
				</cards>
				
			</root>'."\n";

			header ('Content-type: text/xml');
			return $xml;
		}
	}
	
	
	private function session_tool7()
	{
		$id_patient = intval($this->getSession('flash_user_id'));
		$session = $this->params[ID];
		if(!in_array($session, array(1,2))) $session=1;
		
		if($this->params[ADD] && $this->getPOST('answers') && $id_patient && $session)
		{
			//file_put_contents(CACHE_DIR.'take2ans', $this->getPOST('answers'));
			
			$answers = simplexml_load_string(stripslashes($this->getPOST('answers')), 'SimpleXMLElement', LIBXML_NOCDATA);
			
 			//$a='<root><answers><introCardList><introCard id="3"><userAnswer type="normal" ><value>1</value></userAnswer></introCard><introCard id="6"><userAnswer type="date" ><value>1327748400000</value></userAnswer></introCard></introCardList><selectedCouponSetCodeList><selectedCouponSetCode>GAF</selectedCouponSetCode><selectedCouponSetCode>GDF</selectedCouponSetCode><selectedCouponSetCode>GTF</selectedCouponSetCode></selectedCouponSetCodeList><coupons><coupon id="5"><optionAnswers><option id="19" inputMode="0"><selected>1</selected></option><option id="20" inputMode="0"><selected>1</selected></option><option id="21" inputMode="0"><selected>0</selected></option><option id="22" inputMode="1"><inputValue>null</inputValue></option></optionAnswers></coupon><coupon id="6"><optionAnswers><option id="23" inputMode="0"><selected>0</selected></option><option id="24" inputMode="0"><selected>0</selected></option><option id="25" inputMode="0"><selected>1</selected></option><option id="26" inputMode="1"><inputValue>null</inputValue></option></optionAnswers></coupon><coupon id="12"><optionAnswers><option id="42" inputMode="0"><selected>0</selected></option><option id="43" inputMode="0"><selected>0</selected></option><option id="44" inputMode="0"><selected>0</selected></option><option id="45" inputMode="1"><inputValue>lorem ipsum</inputValue></option></optionAnswers></coupon><coupon id="13"><optionAnswers><option id="46" inputMode="0"><selected>1</selected></option><option id="47" inputMode="0"><selected>1</selected></option><option id="48" inputMode="0"><selected>1</selected></option><option id="49" inputMode="1"><inputValue>null</inputValue></option></optionAnswers></coupon><coupon id="14"><optionAnswers><option id="50" inputMode="0"><selected>0</selected></option><option id="51" inputMode="0"><selected>0</selected></option><option id="52" inputMode="0"><selected>1</selected></option><option id="53" inputMode="1"><inputValue>null</inputValue></option></optionAnswers></coupon><coupon id="15"><optionAnswers><option id="54" inputMode="0"><selected>0</selected></option><option id="55" inputMode="0"><selected>1</selected></option><option id="56" inputMode="0"><selected>1</selected></option><option id="57" inputMode="1"><inputValue>null</inputValue></option></optionAnswers></coupon><coupon id="16"><optionAnswers><option id="58" inputMode="0"><selected>0</selected></option><option id="59" inputMode="0"><selected>1</selected></option><option id="60" inputMode="0"><selected>0</selected></option><option id="61" inputMode="1"><inputValue>null</inputValue></option></optionAnswers></coupon><coupon id="17"><optionAnswers><option id="62" inputMode="0"><selected>1</selected></option><option id="63" inputMode="0"><selected>1</selected></option><option id="64" inputMode="0"><selected>0</selected></option><option id="65" inputMode="1"><inputValue>null</inputValue></option></optionAnswers></coupon><coupon id="18"><optionAnswers><option id="66" inputMode="0"><selected>0</selected></option><option id="67" inputMode="0"><selected>1</selected></option><option id="68" inputMode="0"><selected>1</selected></option><option id="69" inputMode="1"><inputValue>null</inputValue></option></optionAnswers></coupon><coupon id="19"><optionAnswers><option id="70" inputMode="0"><selected>0</selected></option><option id="71" inputMode="0"><selected>0</selected></option><option id="72" inputMode="0"><selected>1</selected></option><option id="73" inputMode="1"><inputValue>lorem ipsum 2</inputValue></option></optionAnswers></coupon><coupon id="20"><optionAnswers><option id="74" inputMode="0"><selected>0</selected></option><option id="75" inputMode="0"><selected>1</selected></option><option id="76" inputMode="0"><selected>1</selected></option><option id="77" inputMode="0"><selected>0</selected></option></optionAnswers></coupon><coupon id="21"><optionAnswers><option id="78" inputMode="0"><selected>1</selected></option><option id="79" inputMode="0"><selected>1</selected></option><option id="80" inputMode="0"><selected>0</selected></option><option id="81" inputMode="1"><inputValue>null</inputValue></option></optionAnswers></coupon></coupons></answers></root>';
 			//$answers = simplexml_load_string(stripcslashes($a), 'SimpleXMLElement', LIBXML_NOCDATA);
 			

			// sprawdzam czy to part 1 czy part 2 take2
			if(!isset($answers->answers->coupons->coupon)) // part 1
			{
	 			// sprawdzam czy sa stare odpowiedzi
	 			$sql = 'SELECT id_session_tool7_introcard_answer_pk FROM session_tool7_introcard_answers
	 					WHERE old=1 AND id_patient_fk = '.$id_patient.' AND session = '.$session.'
	 					LIMIT 1
	 			';
	 			if($this->getOneValueFromSql($sql))
	 			{
	 				$sql = 'DELETE FROM session_tool7_introcard_answers
	 						WHERE old=1 AND id_patient_fk = '.$id_patient.' AND session = '.$session;
	 				$this->dbQuery($sql);
	 			}
	 			
	 			$q = new sqlQuery('session_tool7_introcard_answers');
	 			$q->addInt('old', 1);
	 			$this->dbQuery($q->createUpdate('old=0 AND id_patient_fk = '.$id_patient.' AND session = '.$session));
	 			
	 			if(mysql_affected_rows())
	 			{
	 				$q2 = new sqlQuery('patients');
					$q2->addInt('session'.$session.'_take2_changed_mail', 1);
					$this->dbQuery($q2->createUpdate('id_patient_pk = '.$id_patient));
	 			}
			}
 			
 			if($session==1 && !isset($answers->answers->coupons->coupon))
 			{
				foreach($answers->answers->introCardList->introCard as $card)
				{
					$q = new sqlQuery('session_tool7_introcard_answers');
					$q->addInt('id_patient_fk', $id_patient);
					
					$sql = 'SELECT id_session_tool7_introcard_pk
							FROM session_tool7_introcard
							WHERE id = '.$card['id'].' AND session = '.$session;
					
					$q->addInt('id_session_tool7_introcard_fk', $this->getOneValueFromSql($sql));
					if($card['id']==3)
					{
						switch($card->userAnswer->value)
						{
							case 0:
							case 1:
								$q->addString('answer', 'Yes');
							break;
							case 2:
								$q->addString('answer', 'No');
							break;
						}
					}
					elseif($card['id']==6 || $card['id']==14)
					{
						$d = (float)$card->userAnswer->value;
						$date = date('m.d.Y', strtotime('1970-01-01 +'.floor($d / 86400000).'days'));
						
						$q->addString('answer', $date);
						
						$patientSubstances = $this->getCsbirtSubstances($id_patient);
						
						$q2 = new sqlQuery('patients');
						$q2->addString('my_goal', 'My Goal: Quit using '.$patientSubstances['text']);
						$this->dbQuery($q2->createUpdate('id_patient_pk = '.$id_patient));
					}
					elseif($card['id']==9)
					{
						$answer_sql = null;
						$answer_goal = null;
						
						$answerArr = array();
						
						foreach($card->userAnswer->value->answerList->answer as $answer)
						{
							if($answer>=1 && $answer<=11)
							{
								$sql = 'SELECT substance FROM cSBIRT_substances WHERE id_csbirt_substance_pk = '.$answer;
								$substanceName = $this->getOneValueFromSql($sql);

								$answerArr[] = $this->decode($substanceName);
							}
							elseif($answer==99)
							{
								$answer_sql='Nothing. I\'m not ready yet.';
								$answer_goal='Nothing. I\'m not ready yet.';
							}
						}
						
						if(count($answerArr) == 2)
						{
							$answer_sql = $answer_goal = implode(' and ', $answerArr);
						}
						elseif(count($answerArr) > 2)
						{
							foreach($answerArr as $key => $item)
							{
								if($key < count($answerArr)-1 && $answer_sql)
								{
									$answer_sql .= ', '.$item;
								}
								elseif($answer_sql)
								{
									$answer_sql .= ' and '.$item;
								}
								else
								{
									$answer_sql = $item;
								}
							}
							$answer_goal = $answer_sql;
						}
						
						if($answer_goal)
						{
							$q2 = new sqlQuery('patients');
							$q2->addString('my_goal', 'My Goal is to: quit using '.$answer_goal);
							$this->dbQuery($q2->createUpdate('id_patient_pk = '.$id_patient));
						}
						
						if($answer_sql && $answer_sql=='Nothing. I\'m not ready yet.')
						{
							$q->addString('answer', $answer_sql);
						}
						elseif($answer_sql)
						{
							$q->addString('answer', $answer_sql.' use');
						}
						else
						{
							continue;
						}
					}
					$q->addInt('session', $session);
					$sql = $q->createInsert();
					$this->dbQuery($sql);
				}
 			}
 			elseif($session==2 && !isset($answers->answers->coupons->coupon))
 			{
 				$substances = $this->getCsbirtSubstances($id_patient);
 				$id_flow = 0;
 				
 				if(count($substances['items'])==1 && isset($substances['items'][1])) // Jedna substancja Tobacco
 				{
 					// sprawdzam czy jest data
 					$sql = 'SELECT answer
							FROM session_tool7_introcard_answers
							WHERE session = 1 AND old = 0 AND id_patient_fk = '.$id_patient.' AND id_session_tool7_introcard_fk = 6
					';
 					$dateAnswer = $this->getOneValueFromSql($sql);
 					if($dateAnswer) // jest data
 					{
 						$dateAnswer = explode('.', $dateAnswer);
 						$dateAnswer = strtotime(date('Y-m-d', strtotime($dateAnswer[2].'-'.$dateAnswer[0].'-'.$dateAnswer[1])));
 					
 						if($dateAnswer > strtotime(date('Y-m-d'))) // Tobacco – Quit Date Hasn’t Come Yet
 						{
 							$id_flow = 1;
 						}
 						else // Tobacco – Quit Date Passed
 						{
 							$id_flow = 2;
 						}
 					}
 					else // Tobacco Only – Didn't Pick Quit Date
 					{
 						$id_flow = 3;
 					}
 				}
 				else
 				{
 					// sprawdzam czy jest data
 					$sql = 'SELECT answer
							FROM session_tool7_introcard_answers
							WHERE session = 1 AND old = 0 AND id_patient_fk = '.$id_patient.' AND id_session_tool7_introcard_fk = 6
					';
 					$dateAnswer = $this->getOneValueFromSql($sql);
 						
 					if(isset($substances['items'][1]) && $dateAnswer) // Tobacco
 					{
 						$dateAnswer = explode('.', $dateAnswer);
 						$dateAnswer = strtotime(date('Y-m-d', strtotime($dateAnswer[2].'-'.$dateAnswer[0].'-'.$dateAnswer[1])));
 						if($dateAnswer > strtotime(date('Y-m-d'))) // Tobacco – Quit Date Hasn’t Come Yet
 						{
 							$id_flow = 1;
 						}
 						else // Tobacco – Quit Date Passed
 						{
 							$id_flow = 2;
 						}
 					}
 					else
 					{
 						// sprawdzam czy YES czy NO
 						$sql = 'SELECT answer
								FROM session_tool7_introcard_answers
								WHERE session = 1 AND old = 0 AND id_patient_fk = '.$id_patient.' AND id_session_tool7_introcard_fk = 3
						';
 						$answer = strtolower($this->getOneValueFromSql($sql));
 						
 						if($answer=='no')
 						{
 							// sprawdzam czy pozniej jednak chcial zmienic
 							$sql = 'SELECT answer
									FROM session_tool7_introcard_answers
									WHERE session = 1 AND old = 0 AND id_patient_fk = '.$id_patient.' AND id_session_tool7_introcard_fk = 9
							';
 							$answer2 = strtolower($this->getOneValueFromSql($sql));
 							if($answer2 && $answer2!='nothing. i\'m not ready yet.')
 							{
 								$answer = 'yes';
 							}
 						}
 						if($answer=='yes')
 						{
 							$id_flow = 4;
 						}
 						else
 						{
 							$id_flow = 5;
 						}
 					}
 				}
 				
 				foreach($answers->answers->introCardList->introCard as $card)
				{
					$q = new sqlQuery('session_tool7_introcard_answers');
					$q->addInt('id_patient_fk', $id_patient);
					
					$sql = 'SELECT id_session_tool7_introcard_pk
							FROM session_tool7_introcard
							WHERE id = '.$card['id'].' AND session = '.$session.' AND id_session_tool7_flow_fk = '.$id_flow.'
					';
					
					if($card['id']==3)
					{
						//$q->addInt('id_session_tool7_introcard_fk', $this->getOneValueFromSql($sql)); //removed LRS 2012-10-09
						
						if($id_flow==1)
						{
							switch($card->userAnswer->value)
							{
								case 7:
									$q->addString('answer', 'I still plan to quit on that date.');
								break;
								case 8:
									$q->addString('answer', 'I already stopped smoking.');
								break;
								case 4:
									$q->addString('answer', 'I changed my quit date but I still plan to stop.');
								break;
								case 9:
									$q->addString('answer', 'I no longer plan to quit.');
								break;
							}
						}
						elseif($id_flow==2)
						{
							switch($card->userAnswer->value)
							{
								case 6:
									$q->addString('answer', 'I stopped smoking.');
								break;
								case 4:
									$q->addString('answer', 'I quit but started again.');
								break;
								case 9:
									$q->addString('answer', 'I am still smoking.');
								break;
							}
						}
						elseif($id_flow==3)
						{
							switch($card->userAnswer->value)
							{
								case 4:
									$q->addString('answer', 'Yes');
									break;
								case 7:
									$q->addString('answer', 'No');
									break;
							}
						}
						elseif($id_flow==4)
						{
							switch($card->userAnswer->value)
							{
								case 6:
									$q->addString('answer', 'I stopped using.');
								break;
								case 7:
									$q->addString('answer', 'I use less.');
								break;
								case 8:
									$q->addString('answer', 'I am still using.');
								break;
							}
						}
						elseif($id_flow==5)
						{
							switch($card->userAnswer->value)
							{
								case 6:
									$q->addString('answer', 'Yes');
								break;
								case 7:
									$q->addString('answer', 'No');
								break;
							}
						}
					}
					elseif($card['id']==4)
					{
						$sql = 'SELECT id_session_tool7_introcard_pk
								FROM session_tool7_introcard
								WHERE id = '.$card['id'].' AND session = '.$session.' AND id_session_tool7_flow_fk = '.$id_flow.'
						';
						$q->addInt('id_session_tool7_introcard_fk', $this->getOneValueFromSql($sql));
						
						if($id_flow==2)
						{
							switch($card->userAnswer->value)
							{
								case 5:
									$q->addString('answer', 'Yes');
								break;
								case 7:
									$q->addString('answer', 'No');
								break;
							}
						}
					}
					elseif($card['id']==5)
					{
						$sql = 'SELECT id_session_tool7_introcard_pk
								FROM session_tool7_introcard
								WHERE id = '.$card['id'].' AND session = '.$session;
						$q->addInt('id_session_tool7_introcard_fk', $this->getOneValueFromSql($sql));
						
						$d = (float)$card->userAnswer->value;
						$date = date('m.d.Y', strtotime('1970-01-01 +'.floor($d / 86400000).'days'));
						
						$q->addString('answer', $date);
					}
					elseif($card['id']==6)
					{
						$sql = 'SELECT id_session_tool7_introcard_pk
								FROM session_tool7_introcard
								WHERE id = 4 AND session = '.$session;
						$q->addInt('id_session_tool7_introcard_fk', $this->getOneValueFromSql($sql));
						switch($card->userAnswer->value)
						{
							case 7:
								$q->addString('answer', 'Yes');
							break;
							case -1:
								$q->addString('answer', 'No');
							break;
						}
					}
					elseif($card['id']==7)
					{
						$sql = 'SELECT id_session_tool7_introcard_pk
								FROM session_tool7_introcard
								WHERE id = 5 AND session = '.$session;
						$q->addInt('id_session_tool7_introcard_fk', $this->getOneValueFromSql($sql));
						
						$d = (float)$card->userAnswer->value;
						$date = date('m.d.Y', strtotime('1970-01-01 +'.floor($d / 86400000).'days'));
						
						$q->addString('answer', $date);
					}
					elseif($card['id']==9)
					{
						if($id_flow==2)
						{
							$card['id'] = 4;
						}
						$sql = 'SELECT id_session_tool7_introcard_pk
								FROM session_tool7_introcard
								WHERE id = '.$card['id'].' AND session = '.$session.' AND id_session_tool7_flow_fk = '.$id_flow.'
						';
						$q->addInt('id_session_tool7_introcard_fk', $this->getOneValueFromSql($sql));
					
						if($id_flow==2)
						{
							switch($card->userAnswer->value)
							{
								case 5:
									$q->addString('answer', 'Yes');
									break;
								case 7:
									$q->addString('answer', 'No');
									break;
							}
						}
						elseif($id_flow==4)
						{
							switch($card->userAnswer->value)
							{
								case 10:
									$q->addString('answer', 'Yes');
									break;
								case 11:
									$q->addString('answer', 'No');
									break;
							}
						}
					}
					$q->addInt('session', $session);
					$sql = $q->createInsert();
					$this->dbQuery($sql);
				}
 			}
 			
 			
 			
 			
 			if(isset($answers->answers->coupons->coupon))
 			{
	 			// sprawdzam czy sa stare odpowiedzi
	 			$sql = 'SELECT id_session_tool7_coupon_answer_pk FROM session_tool7_coupons_answers
	 					WHERE old=1 AND id_patient_fk = '.$id_patient.' AND session = '.$session.'
	 					LIMIT 1
	 			';
	 			if($this->getOneValueFromSql($sql))
	 			{
	 				$sql = 'DELETE FROM session_tool7_coupons_answers
	 						WHERE old=1 AND id_patient_fk = '.$id_patient.' AND session = '.$session;
	 				$this->dbQuery($sql);
	 			}
	 			
	 			$q = new sqlQuery('session_tool7_coupons_answers');
	 			$q->addInt('old', 1);
	 			$this->dbQuery($q->createUpdate('old=0 AND id_patient_fk = '.$id_patient.' AND session = '.$session));
 			}
			
			foreach($answers->answers->coupons->coupon as $coupon)
			{
				foreach($coupon->optionAnswers->option as $option)
				{
					if($option->selected==1)
					{
						$q = new sqlQuery('session_tool7_coupons_answers');
						$q->addInt('id_patient_fk', $id_patient);
						$q->addInt('id_session_tool7_coupon_fk', $coupon['id']);
						$q->addInt('id_session_tool7_answer_fk', $option['id']);
						$q->addInt('session', $session);
						$this->dbQuery($q->createInsert());
					}
					elseif($option->inputValue && $option->inputValue!='null' && !empty($option->inputValue))
					{
						$q = new sqlQuery('session_tool7_coupons_answers');
						$q->addInt('id_patient_fk', $id_patient);
						$q->addInt('id_session_tool7_coupon_fk', $coupon['id']);
						$q->addInt('id_session_tool7_answer_fk', $option['id']);
						$q->addString('text', $option->inputValue);
						$q->addInt('session', $session);
						$this->dbQuery($q->createInsert());
					}
				}
			}
			
			//return $this->returnStatus(1);
		}

		
		if($id_patient && $session)
		{
			$xml='';
			
			$comments = $session==1 ? $this->getToolComments(7) : $this->getToolComments(11);
			
			$sql = 'SELECT p.id_avatar_fk, p.email, p.id_doctor_fk,p.clinician, di.id_file_fk as doctor_icon
					FROM patients p
					INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
					INNER JOIN doctors_icons di ON di.id_doctors_icon_pk = d.id_doctor_icon_fk
					WHERE id_patient_pk = '.$id_patient;
			$patient = $this->getOneRowFromSql($sql);
			
			$xml.='<root>';
				$xml.=$comments;
				
				$doctorAvatar = null;
				if($patient['doctor_icon'])
				{
					$thumb = new imageThumb($patient['doctor_icon']);
					if($thumb->imageExist)
					{
						$doctorAvatar = $thumb->resizeInscribed(80,80);
					}
				}
				
				$xml.='
						<user id="'.$id_patient.'">
					    	<avatar>
					            <take2 path="'.FILE_WWW.'avatars/big/avatar'.$patient['id_avatar_fk'].'.png" />
					            <panelMiniatureMyPage path="'.$this->getPatientAvatarPath($id_patient).'" />
					            <panelMiniature path="'.$this->getPatientAvatarPath($id_patient).'" />
					        </avatar>
					    </user>
					    <doctor id="1">
							<take2>
					            <name><![CDATA['.$this->decode($patient['clinician']).']]></name>
					            <avatar path="'.$doctorAvatar.'" />
					        </take2>
					    </doctor>
				';
			
			
			// pobieranie substancji z cSBIRT
			$substances = $this->getCsbirtSubstances($id_patient);
			
			$introCards = array();
			$sql = 'SELECT * FROM session_tool7_introcard WHERE session = '.$session.' ORDER BY id';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$introCards[$row['id']] = array(
					'cardClass'=>$this->decode($row['cardClass']),
					'info'=>str_replace('*SUBSTANCES*', $substances['text'], $this->decode($row['info'])),
					'comment'=>$this->decode($row['comment']),
				);
			}
			
			if($session==1)
			{
				$card3Yes = array();
				$card3No  = array();
				if(isset($substances['items'][1]))
				{
					$card3Yes[] = 'GTF';
					$card3No[]  = 'RTF';
				}
				if(isset($substances['items'][2]))
				{
					$card3Yes[] = 'GAF';
					$card3No[]  = 'RSF';
				}
				if(isset($substances['items'][1]) && count($substances['items'])==1)
				{
					$card3YesId = 13;
				}
				else
				{
					$card3YesId = 10;
				}
				
				// wszystkie drug
				if(isset($substances['items'][3]) || isset($substances['items'][4]) || isset($substances['items'][5]) ||
				   isset($substances['items'][6]) || isset($substances['items'][7]) || isset($substances['items'][8]) ||
				   isset($substances['items'][9]) || isset($substances['items'][11]))
				{
					$card3Yes[] = 'GDF';
					$addCard = true;
					foreach($card3No as $no)
					{
						if($no=='RSF')
						{
							$addCard = false;
							break;
						}
					}
					if($addCard)
					{
						$card3No[]  = 'RSF';
					}
				}
				
				$xml.='
						<introCards>
							<card id="1" cardClass="'.$introCards[1]['cardClass'].'" index="1">
								<info><![CDATA['.$introCards[1]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[1]['comment'].']]></userCommentBalloon>
							</card>
							<card id="2" cardClass="'.$introCards[2]['cardClass'].'" index="2">
								<info><![CDATA['.$introCards[2]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[2]['comment'].']]></userCommentBalloon>
							</card>
							<card id="3" cardClass="'.$introCards[3]['cardClass'].'" index="3">
								<yesOption value="1" cardId="'.$card3YesId.'" couponSetCodes="'.implode('|', $card3Yes).'" />
								<noOption value="2" cardId="8" />
								<userCommentBalloon><![CDATA['.$introCards[3]['comment'].']]></userCommentBalloon>
							</card>
							<card id="4" cardClass="'.$introCards[4]['cardClass'].'">
								<info><![CDATA['.$introCards[4]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[4]['comment'].']]></userCommentBalloon>
							</card>
							
							<card id="5" cardClass="'.$introCards[5]['cardClass'].'" index="6">
								<nextCard cardId="6" />
								<info><![CDATA['.$introCards[5]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[5]['comment'].']]></userCommentBalloon>
							</card>
							<card id="6" cardClass="'.$introCards[6]['cardClass'].'">
								<nextCard value="" cardId="7" />
								<userCommentBalloon><![CDATA['.$introCards[6]['comment'].']]></userCommentBalloon>
							</card>
							<card id="7" cardClass="'.$introCards[7]['cardClass'].'" index="9">
								<info><![CDATA['.$introCards[7]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[7]['comment'].']]></userCommentBalloon>
							</card>
							
							<card id="8" cardClass="'.$introCards[8]['cardClass'].'" index="4">
								<nextCard cardId="9" />
								<info><![CDATA['.$introCards[8]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[8]['comment'].']]></userCommentBalloon>
							</card>
							
							<card id="9" cardClass="'.$introCards[9]['cardClass'].'" index="5">
								<label><![CDATA['.$introCards[9]['info'].']]></label>
								<multiOption cardId="12" />
				';
				
					$card9Nothing = array();
				
					foreach($substances['itemsNames'] as $key=>$value)
					{
						if($key==1) // Tobacco
						{
							$couponSetCode = 'GTF';
							$card9id = 5;
							$card9Nothing['RTF'] = 'RTF';
						}
						elseif($key==2) // Alcohol
						{
							$couponSetCode = 'GAF';
							$card9id = 12;
							$card9Nothing['RSF'] = 'RSF';
						}
						else // Drugs
						{
							$couponSetCode = 'GDF';
							$card9id = 12;
							$card9Nothing['RSF'] = 'RSF';
						}
						
						//$card9Nothing[$couponSetCode] = $couponSetCode;
						
						$xml.='<option label="'.$value.'" cardId="'.$card9id.'" value="'.$key.'|'.$couponSetCode.'" group="multi" />';
					}

					
						$xml.='
								<option label="Nothing. I\'m not ready yet." cardId="11" value="99|'.implode('|',$card9Nothing).'" group="single" />
								<userCommentBalloon><![CDATA['.$introCards[9]['comment'].']]></userCommentBalloon>
							</card>
							
							<card id="10" cardClass="'.$introCards[10]['cardClass'].'" index="4">
								<info><![CDATA['.$introCards[10]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[10]['comment'].']]></userCommentBalloon>
							</card>
							<card id="11" cardClass="'.$introCards[11]['cardClass'].'" index="6">
								<info><![CDATA['.$introCards[11]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[11]['comment'].']]></userCommentBalloon>
							</card>
							<card id="12" cardClass="'.$introCards[12]['cardClass'].'" index="6">
								<info><![CDATA['.$introCards[12]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[12]['comment'].']]></userCommentBalloon>
							</card>
							<card id="13" cardClass="'.$introCards[13]['cardClass'].'" index="4">
								<nextCard cardId="14" />
								<info><![CDATA['.$introCards[13]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[13]['comment'].']]></userCommentBalloon>
							</card>
							<card id="14" cardClass="'.$introCards[14]['cardClass'].'">
								<nextCard value="" cardId="15" />
								<userCommentBalloon><![CDATA['.$introCards[14]['comment'].']]></userCommentBalloon>
							</card>
							<card id="15" cardClass="'.$introCards[15]['cardClass'].'" index="7">
								<info><![CDATA['.$introCards[15]['info'].']]></info>
								<userCommentBalloon><![CDATA['.$introCards[15]['comment'].']]></userCommentBalloon>
							</card>
							
						</introCards>
				'."\n";	
			}
			elseif($session==2) 
			{
				// *SUBSTANCES* = $substances['text']
				
				if(count($substances['items'])==1 && isset($substances['items'][1])) // Jedna substancja Tobacco
				{
					// sprawdzam czy jest data
					$sql = 'SELECT answer
							FROM session_tool7_introcard_answers
							WHERE session = 1 AND old = 0 AND id_patient_fk = '.$id_patient.' AND id_session_tool7_introcard_fk = 6
					';
					$dateAnswer = $this->getOneValueFromSql($sql);
					if($dateAnswer) // jest data
					{
						$dateAnswer = explode('.', $dateAnswer);
						$dateAnswer = strtotime(date('Y-m-d', strtotime($dateAnswer[2].'-'.$dateAnswer[0].'-'.$dateAnswer[1])));
						
						if($dateAnswer > strtotime(date('Y-m-d'))) // Tobacco – Quit Date Hasn’t Come Yet
						{
							$xml.=$this->tool7TobaccoDateXML(1, $substances, $dateAnswer);
						}
						else // Tobacco – Quit Date Passed
						{
							$xml.=$this->tool7TobaccoDateXML(2, $substances, $dateAnswer);
						}
					}
					else // Tobacco Only – Didn't Pick Quit Date
					{
						$introCards = array();
						$sql = 'SELECT *
								FROM session_tool7_introcard
								WHERE session = 2 AND id_session_tool7_flow_fk = 3
								ORDER BY id';
						$res = $this->dbQuery($sql);
						while($row=mysql_fetch_assoc($res))
						{
							$info = str_replace('*SUBSTANCES*', $substances['text'], $this->decode($row['info']));
							
							$introCards[$row['id']] = array(
								'cardClass'=>$this->decode($row['cardClass']),
								'info'=>$info,
								'comment'=>$this->decode($row['comment']),
							);
						}
						
						$xml.='
								<introCards>
									<card id="1" cardClass="'.$introCards[1]['cardClass'].'" index="1">
										<info>'.$introCards[1]['info'].'</info>
										<userCommentBalloon>'.$introCards[1]['comment'].'</userCommentBalloon>
									</card>
									<card id="2" cardClass="'.$introCards[2]['cardClass'].'" index="2">
										<info><![CDATA['.$introCards[2]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[2]['comment'].']]></userCommentBalloon>
									</card>
									<card id="3" cardClass="'.$introCards[3]['cardClass'].'" index="3">
										<label><![CDATA['.$introCards[3]['info'].']]></label>
										<option label="YES" cardId="4" couponSetCodes="GTF" />
										<option label="NO" cardId="7" couponSetCodes="RTF2" />
										<userCommentBalloon><![CDATA['.$introCards[3]['comment'].']]></userCommentBalloon>
									</card>
									<card id="4" cardClass="'.$introCards[4]['cardClass'].'" index="4">
										<nextCard cardId="5"/>
										<info><![CDATA['.$introCards[4]['info'].']]></info>
										<userCommentBalloon>'.$introCards[4]['comment'].'</userCommentBalloon>
									</card>
									<card id="5" cardClass="'.$introCards[5]['cardClass'].'" >
										<nextCard value="" cardId="6"/>
										<userCommentBalloon><![CDATA['.$introCards[5]['comment'].']]></userCommentBalloon>
									</card>
									<card id="6" cardClass="'.$introCards[6]['cardClass'].'" index="7">
										<info><![CDATA['.$introCards[6]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[6]['comment'].']]></userCommentBalloon>
									</card>
									<card id="7" cardClass="'.$introCards[7]['cardClass'].'" index="4">
										<info><![CDATA['.$introCards[7]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[7]['comment'].']]></userCommentBalloon>
									</card>
								</introCards>
						';
					}
				}
				else
				{
					// sprawdzam czy jest data
					$sql = 'SELECT answer
							FROM session_tool7_introcard_answers
							WHERE session = 1 AND old = 0 AND id_patient_fk = '.$id_patient.' AND id_session_tool7_introcard_fk = 6
					';
					$dateAnswer = $this->getOneValueFromSql($sql);
					
					if(isset($substances['items'][1]) && $dateAnswer) // Tobacco
					{
						$dateAnswer = explode('.', $dateAnswer);
						$dateAnswer = strtotime(date('Y-m-d', strtotime($dateAnswer[2].'-'.$dateAnswer[0].'-'.$dateAnswer[1])));
						if($dateAnswer > strtotime(date('Y-m-d'))) // Tobacco – Quit Date Hasn’t Come Yet
						{
							$xml.=$this->tool7TobaccoDateXML(1, $substances, $dateAnswer);
						}
						else // Tobacco – Quit Date Passed
						{
							$xml.=$this->tool7TobaccoDateXML(2, $substances, $dateAnswer);
						}
					}
					else
					{
						$card3Set = array(); // mozliwe wartosci: GTF,GAF,GDF
						$card9Yes = array(); // mozliwe wartosci: GTF,GAF,GDF
						$card9No  = array(); // mozliwe wartosci: RTF2,RSF2
						$card3Set2= array(); // mozliwe wartosci: RTF2,RSF2
						
						if(isset($substances['items'][1])) // tobacco
						{
							$card3Set[] = 'GTF';
							$card9Yes[] = 'GTF';
							$card9No[]  = 'RTF2';
							$card3Set2[]= 'RTF2';
						}
						if(isset($substances['items'][2])) // alcohol
						{
							$card3Set[] = 'GAF';
							$card9Yes[] = 'GAF';
							$card9No[]  = 'RSF2';
							$card3Set2[]= 'RSF2';
						}
						// wszystkie drug
						if(isset($substances['items'][3]) || isset($substances['items'][4]) || isset($substances['items'][5]) ||
						   isset($substances['items'][6]) || isset($substances['items'][7]) || isset($substances['items'][8]) ||
						   isset($substances['items'][9]) || isset($substances['items'][11]))
						{
							$card3Set[] = 'GDF';
							$card9Yes[] = 'GDF';
							$card9No[]  = 'RSF2';
							$card3Set2[]= 'RSF2';
						}
						
						
						
						// sprawdzam czy YES czy NO
						$sql = 'SELECT answer
								FROM session_tool7_introcard_answers
								WHERE session = 1 AND old = 0 AND id_patient_fk = '.$id_patient.' AND id_session_tool7_introcard_fk = 3
						';
						$answer = strtolower($this->getOneValueFromSql($sql));
						
						if($answer=='no')
						{
							// sprawdzam czy pozniej jednak chcial zmienic
							$sql = 'SELECT answer
									FROM session_tool7_introcard_answers
									WHERE session = 1 AND old = 0 AND id_patient_fk = '.$id_patient.' AND id_session_tool7_introcard_fk = 9
							';
							$answer2 = strtolower($this->getOneValueFromSql($sql));
							if($answer2 && $answer2!='nothing. i\'m not ready yet.')
							{
								$answer = 'yes';
							}
						}
						
						if($answer=='yes')
						{
							$quitsubstance = isset($answer2) ? $answer2 : $substances['text'];
							
							$introCards = array();
							$sql = 'SELECT *
									FROM session_tool7_introcard
									WHERE session = 2 AND id_session_tool7_flow_fk = 4
									ORDER BY id';
							$res = $this->dbQuery($sql);
							while($row=mysql_fetch_assoc($res))
							{
								$info = str_replace('*SUBSTANCES*', $substances['text'], $this->decode($row['info']));
								$info = str_replace('*QUIT_SUBSTANCES*', $quitsubstance, $info);
									
								$introCards[$row['id']] = array(
									'cardClass'=>$this->decode($row['cardClass']),
									'info'=>$info,
									'comment'=>$this->decode($row['comment']),
								);
							}
							
							$xml.='
								<introCards>
									<card id="1" cardClass="'.$introCards[1]['cardClass'].'" index="1">
										<info><![CDATA['.$introCards[1]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[1]['comment'].']]></userCommentBalloon>
									</card>
									<card id="2" cardClass="'.$introCards[2]['cardClass'].'" index="2">
										<info><![CDATA['.$introCards[2]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[2]['comment'].']]></userCommentBalloon>
									</card>
									<card id="3" cardClass="'.$introCards[3]['cardClass'].'" index="3">
										<label><![CDATA['.$introCards[3]['info'].']]></label>
										<option label="I stopped using." cardId="6" couponSetCodes="'.implode('|',$card3Set).'" />
										<option label="I use less." cardId="7" />
										<option label="I am still using." cardId="8" />
										<userCommentBalloon><![CDATA['.$introCards[3]['comment'].']]></userCommentBalloon>
									</card>

									<card id="6" cardClass="'.$introCards[6]['cardClass'].'" index="4">
										<info><![CDATA['.$introCards[6]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[6]['comment'].']]></userCommentBalloon>
									</card>
									<card id="7" cardClass="'.$introCards[7]['cardClass'].'" index="4">
										<nextCard cardId="9"/>
										<info><![CDATA['.$introCards[7]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[7]['comment'].']]></userCommentBalloon>
									</card>
									<card id="8" cardClass="'.$introCards[8]['cardClass'].'" index="4">
										<nextCard cardId="9"/>
										<info><![CDATA['.$introCards[8]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[8]['comment'].']]></userCommentBalloon>
									</card>
									
									<card id="9" cardClass="'.$introCards[9]['cardClass'].'" index="5">
										<label><![CDATA['.$introCards[9]['info'].']]></label>
										<option label="YES" cardId="10" couponSetCodes="'.implode('|', $card9Yes).'" />
										<option label="NO" cardId="11" couponSetCodes="'.implode('|', $card9No).'" />
										<userCommentBalloon><![CDATA['.$introCards[9]['comment'].']]></userCommentBalloon>
									</card>
									
									<card id="10" cardClass="'.$introCards[10]['cardClass'].'" index="6">
										<info><![CDATA['.$introCards[10]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[10]['comment'].']]></userCommentBalloon>
									</card>
									<card id="11" cardClass="'.$introCards[11]['cardClass'].'" index="6">
										<info><![CDATA['.$introCards[11]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[11]['comment'].']]></userCommentBalloon>
									</card>
									
									
								</introCards>
							';
						}
						else
						{
							$introCards = array();
							$sql = 'SELECT *
									FROM session_tool7_introcard
									WHERE session = 2 AND id_session_tool7_flow_fk = 5
									ORDER BY id';
							$res = $this->dbQuery($sql);
							while($row=mysql_fetch_assoc($res))
							{
								$info = str_replace('*SUBSTANCES*', $substances['text'], $this->decode($row['info']));
									
								$introCards[$row['id']] = array(
									'cardClass'=>$this->decode($row['cardClass']),
									'info'=>$info,
									'comment'=>$this->decode($row['comment']),
								);
							}
							
							$xml.='
								<introCards>
									<card id="1" cardClass="'.$introCards[1]['cardClass'].'" index="1">
										<info><![CDATA['.$introCards[1]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[1]['comment'].']]></userCommentBalloon>
									</card>
									<card id="2" cardClass="'.$introCards[2]['cardClass'].'" index="2">
										<info><![CDATA['.$introCards[2]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[2]['comment'].']]></userCommentBalloon>
									</card>
									<card id="3" cardClass="'.$introCards[3]['cardClass'].'" index="3">
										<label><![CDATA['.$introCards[3]['info'].']]></label>
										<option label="Yes" cardId="6" couponSetCodes="'.implode('|',$card3Set).'" />
										<option label="No" cardId="7" couponSetCodes="'.implode('|',$card3Set2).'" />
										<userCommentBalloon><![CDATA['.$introCards[3]['comment'].']]></userCommentBalloon>
									</card>
									<card id="6" cardClass="'.$introCards[6]['cardClass'].'" index="4">
										<info><![CDATA['.$introCards[6]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[6]['comment'].']]></userCommentBalloon>
									</card>
									<card id="7" cardClass="'.$introCards[7]['cardClass'].'" index="4">
										<info><![CDATA['.$introCards[7]['info'].']]></info>
										<userCommentBalloon><![CDATA['.$introCards[7]['comment'].']]></userCommentBalloon>
									</card>
								</introCards>
							';
						}
					}
				}
			}

			$xml.= '<couponSetList>'."\n";
			
				$sql = 'SELECT * FROM session_tool7_coupons_set';
				$res = $this->dbQuery($sql);
				while($set = mysql_fetch_assoc($res))
				{
					$xml.='<couponSet code="'.$set['set'].'">'."\n";
						$xml.='<coupons>'."\n";
						
							$xml.='<coupon id="9999" type="info" background="0xFF0000" substanceCouponId="1">'."\n";
								$xml.='<smallText><![CDATA[]]></smallText>'."\n";
								$xml.='<normalText><![CDATA['.$set['info'].']]></normalText>'."\n";
							$xml.='</coupon>'."\n";
						
							$sql = 'SELECT *
									FROM session_tool7_coupons stc
									WHERE id_session_tool7_coupon_set_fk = '.$set['id_session_tool7_coupon_set_pk'].'
									ORDER BY stc.id_session_tool7_substance_fk
							';
							$res3 = $this->dbQuery($sql);
							while($row=mysql_fetch_assoc($res3))
							{
								$xml.='<coupon id="'.$row['id_session_tool7_coupon_pk'].'" type="answer" background="0xFFFF00" substanceCouponId="'.$row['id_session_tool7_substance_fk'].'">'."\n";
									$xml.='<question><![CDATA['.$this->decode($row['text']).']]></question>'."\n";
									$xml.='<options>'."\n";
									
										$sql = 'SELECT *
												FROM session_tool7_answers sta
												WHERE id_session_tool7_coupon_fk = '.$row['id_session_tool7_coupon_pk'].'
										';
										$res2 = $this->dbQuery($sql);
										while($row2=mysql_fetch_assoc($res2))
										{
											$input = $row2['input_mode'] ? 'true' : 'false'; 
											$xml.='<option id="'.$row2['id_session_tool7_answer_pk'].'" inputMode="'.$input.'">'."\n";
												$xml.='<label><![CDATA['.$this->decode($row2['text']).']]></label>'."\n";
											$xml.='</option>'."\n";
										}
									$xml.='</options>'."\n";
								$xml.='</coupon>'."\n";
							}
							
						$xml.='</coupons>'."\n";
					$xml.='</couponSet>'."\n";
				}

			
			$xml.='</couponSetList>'."\n";
			$xml.='</root>';
			
			header ('Content-type: text/xml');
			return $xml;
		}
	}
	
	
	private function tool7TobaccoDateXML($type, $substances, $dateAnswer)
	{
		if($type==1) // Tobacco – Quit Date Hasn’t Come Yet
		{
			$introCards = array();
			$sql = 'SELECT *
					FROM session_tool7_introcard
					WHERE session = 2 AND id_session_tool7_flow_fk = 1
					ORDER BY id';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$info = str_replace('*SUBSTANCES*', $substances['text'], $this->decode($row['info']));
				$info = str_replace('*DATE*', date('m.d.Y', $dateAnswer), $info);
				
				$introCards[$row['id']] = array(
					'cardClass'=>$this->decode($row['cardClass']),
					'info'=>$info,
					'comment'=>$this->decode($row['comment']),
				);
			}
			
			$xml='
					<introCards>
						<card id="1" cardClass="'.$introCards[1]['cardClass'].'" index="1">
							<info>'.$introCards[1]['info'].'</info>
							<userCommentBalloon>'.$introCards[1]['comment'].'</userCommentBalloon>
						</card>
						<card id="2" cardClass="'.$introCards[2]['cardClass'].'" index="2">
							<info><![CDATA['.$introCards[2]['info'].']]></info>
							<userCommentBalloon><![CDATA['.$introCards[2]['comment'].']]></userCommentBalloon>
						</card>
						<card id="3" cardClass="'.$introCards[3]['cardClass'].'" index="3">
							<label><![CDATA['.$introCards[3]['info'].']]></label>
							<option label="I plan to quit then." cardId="7" couponSetCodes="GTF" />
							<option label="I already stopped." cardId="8" couponSetCodes="GTF" />
							<option label="I changed my quit date." cardId="4" couponSetCodes="GTF" />
							<option label="I am not ready yet." cardId="9" couponSetCodes="RTF" />
							<userCommentBalloon><![CDATA['.$introCards[3]['comment'].']]></userCommentBalloon>
						</card>
						<card id="4" cardClass="'.$introCards[4]['cardClass'].'" index="4">
							<nextCard cardId="5"/>
							<info><![CDATA['.$introCards[4]['info'].']]></info>
							<userCommentBalloon>'.$introCards[4]['comment'].'</userCommentBalloon>
						</card>
						<card id="5" cardClass="'.$introCards[5]['cardClass'].'" >
							<nextCard value="" cardId="6"/>
							<userCommentBalloon><![CDATA['.$introCards[5]['comment'].']]></userCommentBalloon>
						</card>
						<card id="6" cardClass="'.$introCards[6]['cardClass'].'" index="7">
							<info><![CDATA['.$introCards[6]['info'].']]></info>
							<userCommentBalloon><![CDATA['.$introCards[6]['comment'].']]></userCommentBalloon>
						</card>
						<card id="7" cardClass="'.$introCards[7]['cardClass'].'" index="4">
							<info><![CDATA['.$introCards[7]['info'].']]></info>
							<userCommentBalloon><![CDATA['.$introCards[7]['comment'].']]></userCommentBalloon>
						</card>
						<card id="8" cardClass="'.$introCards[8]['cardClass'].'" index="4">
							<info><![CDATA['.$introCards[8]['info'].']]></info>
							<userCommentBalloon><![CDATA['.$introCards[8]['comment'].']]></userCommentBalloon>
						</card>
						<card id="9" cardClass="'.$introCards[9]['cardClass'].'" index="4">
							<info><![CDATA['.$introCards[9]['info'].']]></info>
							<userCommentBalloon><![CDATA['.$introCards[9]['comment'].']]></userCommentBalloon>
						</card>
					</introCards>
			';
		}
		elseif($type==2) // Tobacco – Quit Date Passed
		{
			$introCards = array();
			$sql = 'SELECT *
					FROM session_tool7_introcard
					WHERE session = 2 AND id_session_tool7_flow_fk = 2
					ORDER BY id';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$info = str_replace('*SUBSTANCES*', $substances['text'], $this->decode($row['info']));
				$info = str_replace('*DATE*', date('m.d.Y', $dateAnswer), $info);
				
				$introCards[$row['id']] = array(
					'cardClass'=>$this->decode($row['cardClass']),
					'info'=>$info,
					'comment'=>$this->decode($row['comment']),
				);
			}
			
			$xml='
					<introCards>
						<card id="1" cardClass="'.$introCards[1]['cardClass'].'" index="1">
							<info>'.$introCards[1]['info'].'</info>
							<userCommentBalloon>'.$introCards[1]['comment'].'</userCommentBalloon>
						</card>
						<card id="2" cardClass="'.$introCards[2]['cardClass'].'" index="2">
							<info><![CDATA['.$introCards[2]['info'].']]></info>
							<userCommentBalloon><![CDATA['.$introCards[2]['comment'].']]></userCommentBalloon>
						</card>
						<card id="3" cardClass="'.$introCards[3]['cardClass'].'" index="3">
							<label><![CDATA['.$introCards[3]['info'].']]></label>
							<option label="I stopped smoking." cardId="6" couponSetCodes="GTF" />
							<option label="I quit but started again." cardId="4" />
							<option label="I am still smoking." cardId="9" />
							<userCommentBalloon><![CDATA['.$introCards[3]['comment'].']]></userCommentBalloon>
						</card>
						<card id="4" cardClass="'.$introCards[4]['cardClass'].'" index="4">
							<label><![CDATA['.$introCards[4]['info'].']]></label>
							<option label="Yes" cardId="5" couponSetCodes="GTF" />
							<option label="No" cardId="7" couponSetCodes="RTF" />
							<userCommentBalloon>'.$introCards[4]['comment'].'</userCommentBalloon>
						</card>
						<card id="5" cardClass="'.$introCards[5]['cardClass'].'" >
							<nextCard value="" cardId="8"/>
							<userCommentBalloon><![CDATA['.$introCards[5]['comment'].']]></userCommentBalloon>
						</card>
						<card id="6" cardClass="'.$introCards[6]['cardClass'].'" index="4">
							<info><![CDATA['.$introCards[6]['info'].']]></info>
							<userCommentBalloon><![CDATA['.$introCards[6]['comment'].']]></userCommentBalloon>
						</card>
						<card id="7" cardClass="'.$introCards[7]['cardClass'].'" index="5">
							<info><![CDATA['.$introCards[7]['info'].']]></info>
							<userCommentBalloon><![CDATA['.$introCards[7]['comment'].']]></userCommentBalloon>
						</card>
						<card id="8" cardClass="'.$introCards[8]['cardClass'].'" index="7">
							<info><![CDATA['.$introCards[8]['info'].']]></info>
							<userCommentBalloon><![CDATA['.$introCards[8]['comment'].']]></userCommentBalloon>
						</card>
						<card id="9" cardClass="'.$introCards[4]['cardClass'].'" index="4">
							<label><![CDATA['.$introCards[4]['info'].']]></label>
							<option label="Yes" cardId="5" couponSetCodes="GTF" />
							<option label="No" cardId="7" couponSetCodes="RTF" />
							<userCommentBalloon>'.$introCards[4]['comment'].'</userCommentBalloon>
						</card>
					</introCards>
			';
		}
		return $xml;
	}
	
	
	private function getToolComments($id)
	{
		$xml = null;
		
		$sql = 'SELECT * FROM session_comments WHERE id_session_tool_fk = '.$id;
		$res = $this->dbQuery($sql);
		while($row = mysql_fetch_assoc($res))
		{
			if($row['name'] && $row['value'])
			{
				if(!$xml)
				{
					$xml='<commentList>';
				}
				$xml.='<comment name="'.$this->decode($row['name']).'">';
					$xml.='<message><![CDATA['.$this->decode($row['value']).']]></message>';
				$xml.='</comment>';
			}
		}
		if($xml)
		{
			$xml.='</commentList>';
		}
		
		return $xml;
	}
	
	
	private function getStaticPage()
	{
		if($this->params[ID] && in_array($this->params[ID], array(10,11)))
		{
			$static = new staticPage($this->params[ID]);
			echo $static->body;
		}
	}
	
	
	private function sentSessionCompleteNotification($number, $id_patient)
	{
		$sql = 'SELECT d.id_doctor_pk, d.email as doctor_email, id_site_fk
				FROM patients p
				INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
				WHERE p.id_patient_pk = '.$id_patient;
		if($row = $this->getOneRowFromSql($sql))
		{
			$recipients = array();
			
			// PCP
			/*
			$recipients[] = array(
				'id'=>$row['id_doctor_pk'],
				'email'=>$row['doctor_email'],
			);
			*/
			
			// Staff
			$sql = 'SELECT d.id_doctor_pk, d.email
					FROM sites_doctors sd
					INNER JOIN doctors d ON d.id_doctor_pk = sd.id_doctor_fk
					WHERE sd.id_site_fk = '.$row['id_site_fk'].' AND sd.id_doctor_fk <> '.$row['id_doctor_pk'].'
			';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$recipients[] = array(
					'id'=>$row['id_doctor_pk'],
					'email'=>$row['email'],
				);
			}
			
			$static = new staticPage(9);
			
			foreach($recipients as $recipient)
			{
				$q = new sqlQuery('mail');
				$q->addInt('id_patient_fk', $id_patient);
				$q->addInt('id_doctor_fk', $recipient['id']);
				$q->addString('type', 'sent');
				$subject = str_replace(array('*NUMBER*'), array($number), $static->title);
				$body = str_replace(array('*NUMBER*'), array($number), $static->body);
				$q->addString('subject', $subject);
				$q->addString('content', $body);
				$q->addString('date', date('Y-m-d H:i:s'));
				$q->addInt('approved', 1);
				$this->dbQuery($q->createInsert());
				
				switch($number)
				{
					case 1:
						$msg=2;
					break;
					case 2:
						$msg=3;
					break;
				}
				
				$this->sendNewEmailNotification($recipient['email'], $msg);
			}
			
			return true;
		}
	}
	
	
	private function initData()
	{
		$id_patient = intval($this->getSession('flash_user_id'));
		if($id_patient)
		{
			$sql = 'SELECT CONCAT_WS(\' \', d.first_name, d.last_name) as fullname
					FROM patients p
					INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
					WHERE id_patient_pk = '.$id_patient.'	
			';
			$doctorName = $this->getOneValueFromSql($sql);
			
			$xml='';
			$xml.='<root>';
				$xml.=$this->getPatientAvatar($id_patient);
				$xml.='<doctor>';
					$xml.='<name><![CDATA['.$doctorName.']]></name>';
				$xml.='</doctor>';
			$xml.='</root>';
			
			header ('Content-type: text/xml');
			return $xml;
		}
		/*
		else
		{
			header ('Content-type: text/xml');
			$xml='<root>
					<user id="123">
				    	<avatar id="1" type="normal">
				            <panelMiniature path="assets/user/avatar/avatar1_normal_panel.png" />
				        </avatar>
				        <email><![CDATA[test@test.test]]></email>
				    </user>
					
					<doctor>
						<name><![CDATA[Joseph Akim]]></name>
					</doctor>
				</root>';
			return $xml;
		}
		*/
	}
	
	
	private function getPatientAvatar($id_patient)
	{
		$sql = 'SELECT id_avatar_fk, email FROM patients WHERE id_patient_pk = '.$id_patient;
		$patient = $this->getOneRowFromSql($sql);
		if($patient['id_avatar_fk'])
		{
			$file = $this->getCMSFileInfo($patient['id_avatar_fk']);
		}
		
		$xml='';
		$xml.='<user id="'.$id_patient.'">';
			$xml.='<avatar id="1" type="normal">';
				if(isset($file['www_path']))
				{
					$xml.='<panelMiniature path="'.$file['www_path'].'" />';
					$xml.='<panelMiniatureMyPage path="'.FILE_WWW.'avatars/big/avatar'.$patient['id_avatar_fk'].'.png" />';
				}
				else
				{
					$xml.='<panelMiniature path="" />';
					$xml.='<panelMiniatureMyPage path="" />';
				}
			$xml.='</avatar>';
			$xml.='<email><![CDATA['.$patient['email'].']]></email>';
		$xml.='</user>';
		
		return $xml;
	}
	
	private function getPatientAvatarPath($id_patient)
	{
		$sql = 'SELECT id_avatar_fk, email FROM patients WHERE id_patient_pk = '.$id_patient;
		$patient = $this->getOneRowFromSql($sql);
		if($patient['id_avatar_fk'])
		{
			$file = $this->getCMSFileInfo($patient['id_avatar_fk']);
		}

		if(isset($file['www_path']))
		{
			return $file['www_path'];
		}
		else
		{
			return null;
		}
	}
	
	
	private function getDoctorAvatarPath($id_doctor)
	{
		$sql = 'SELECT di.id_file_fk
				FROM doctors d
				INNER JOIN doctors_icons di ON di.id_doctors_icon_pk = d.id_doctor_icon_fk
				WHERE d.id_doctor_pk = '.$id_doctor;
		$doctor = $this->getOneRowFromSql($sql);
		if($doctor['id_file_fk'])
		{
			$file = $this->getCMSFileInfo($doctor['id_file_fk']);
		}

		if(isset($file['www_path']))
		{
			return $file['www_path'];
		}
		else
		{
			return null;
		}
	}
	
	
	private function getPatientStimulants($id_patient, $id_only=false)
	{
		$studyObj = new studyManager($id_patient);
		return $studyObj->getCsbirtSubstances($id_only);
	}
	
	
	private function getCsbirtSubstances($id_patient)
	{
		$substances = null;
		$substanceArr = array();
		$substanceArrName = array();
		
		$sql = 'SELECT study_id FROM patients WHERE id_patient_pk = '.$id_patient;
		if($study_id = $this->getOneValueFromSql($sql))
		{
			$studObj = new studyManager($id_patient);
			
			$conn = $studObj->studyConnect();
			$sql = 'SELECT c.*
					FROM cSBIRT c
					WHERE c.studyid = \''.$study_id.'\'';
			$res = $this->dbQuery($sql);
			if($row = mysql_fetch_array($res))
			{
				if($row['polysub'] == 0)
				{
					$patient_substances = $this->getPatientStimulants($id_patient);
					$total_substances = count($patient_substances);
					$n = 1;
					foreach($patient_substances as $item)
					{
						if($substances && $n != $total_substances)
						{
							$substances.=', ';
						}
						elseif($substances && $n == $total_substances)
						{
							$substances.=' and ';
						}
						$substances.=$item['name'];
						$substanceArr[$item['id_substance']] = 1;
						$substanceArrName[$item['id_substance']] = $item['name'];
						$n++;
					}
				}
				elseif($row['mjdrug'] == 0)
				{
					$substances = 'tobacco and alcohol';
					$substanceArr[1] = 1; // tobacco
					$substanceArr[2] = 1; // alcohol
					$substanceArrName[1] = 'Tobacco';
					$substanceArrName[2] = 'Alcohol';
				}
				elseif($row['tob'] == 1 && $row['alc'] == 0)
				{
					$substances = 'tobacco and ';
					$substanceArr[1] = 1; // tobacco
					$substanceArrName[1] = 'Tobacco';
					if($row['polydrug'] == 0 && $row['mj'] == 1)
					{
						$substances.='marijuana';
						$substanceArr[3] = 1; // marijuana
						$substanceArrName[3] = 'Marijuana';
					}
					else
					{
						$substances.='drugs';
						$substanceArr[11] = 1; // drugs
						$substanceArrName[11] = 'Drugs';
					}
				}
				else
				{
					$substances = 'alcohol, tobacco and ';
					$substanceArr[1] = 1; // tobacco
					$substanceArr[2] = 1; // alcohol
					$substanceArrName[1] = 'Tobacco';
					$substanceArrName[2] = 'Alcohol';
					if($row['polydrug'] == 0 && $row['mj'] == 1)
					{
						$substances.='marijuana';
						$substanceArr[3] = 1; // marijuana
						$substanceArrName[3] = 'Marijuana';
					}
					else
					{
						$substances.='drugs';
						$substanceArr[11] = 1; // drugs
						$substanceArrName[11] = 'Drugs';
					}
				}
			}
		}
		
		return array(
			'text'  => $substances,
			'items' => $substanceArr,
			'itemsNames' => $substanceArrName,
		);
	}
	
	
	private function userActivity()
	{
		$id_user = intval($this->getPOST('userId'));
		
		if($id_user && $this->getPOST('moduleType') && $this->getPOST('activityType') && $this->getSession('flash_user_id'))
		{
			$sql = 'SELECT username FROM patients WHERE id_patient_pk = '.$id_user;
			if($this->getOneValueFromSql($sql))
			{
				$userTime = $this->getSession('userTime');
				if(is_array($userTime) && isset($userTime['moduleType']) && $userTime['moduleType']!='null')
				{
					$q = new sqlQuery('patients_activity');
					$q->addInt('id_patient_fk', $id_user);
					$q->addString('module_type', $userTime['moduleType']);
					if($userTime['activityType'])
					{
						$q->addString('activity_type', $userTime['activityType']);
					}
					
					$time = floor(microtime(true)*1000) - $userTime['time'];
					
					$spentTimeSec = floor($time/1000); // ilosc sekund
					
					$q->addString('datetime_start',date('Y-m-d H:i:s', strtotime(date('Y-m-d h:i:s')) - $spentTimeSec));
					$q->addString('datetime_finish',date('Y-m-d h:i:s'));
					$q->addString('time', $time);
					$this->dbQuery($q->createInsert());
				}
				
				$userTime = array(
					'userId' => $id_user,
					'moduleType' => $this->getPOST('moduleType'),
					'activityType' => $this->getPOST('activityType'),
					'time'=>floor(microtime(true)*1000),
				);
				$this->setSession('userTime', $userTime);
			}
		}
		return $this->returnStatus(1);
	}
	
	
	/************************************************************************/
	
	
	private function returnStatus($status)
	{
		header ('Content-type: text/xml');
		return '<root><status>'.$status.'</status></root>';
	}
	
	
}
?>