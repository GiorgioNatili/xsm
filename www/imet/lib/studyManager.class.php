<?php

define('STUDY_SERV', DB_SERV);
define('STUDY_USER', DB_USER);
define('STUDY_PASS', DB_PASS);
define('STUDY_NAME', DB_NAME);

class studyManager extends projectCommon 
{
	public  $params=array();
	public  $conn=null;
	private $id_patient=0;
	private $doctor;

	
	public function __construct($id_patient)
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		
		$this->id_patient = $id_patient;
		$this->doctor = $this->getSession(DOCTOR);
	}

	
	public function getList()
	{
		$sendEmail = null;
		$list = array();
		$sql = 'SELECT * FROM patients WHERE id_patient_pk = '.$this->id_patient;
		if($patient = $this->getOneRowFromSql($sql))
		{
			if($this->getPOST('teSubject') && $this->getPOST('teMessage'))
			{
				// wyslania maila do pacjenta z poziomu tabeli wydarzen
				$q = new sqlQuery('mail');
				$q->addInt('id_patient_fk', $this->id_patient);
				$q->addInt('id_doctor_fk', $this->doctor['user_id']);
				$q->addString('type','inbox');
				$q->addString('subject',strip_tags($this->getPOST('teSubject')));
				$q->addString('content',strip_tags($this->getPOST('teMessage')));
				$q->addCurrentDateTime('date');
				$q->addInt('is_read', 0);
				
				// sprawdzam czy do akceptacji czy odrazu do pacjenta
				$sql = 'SELECT id_doctor_fk FROM patients WHERE id_patient_pk = '.$this->id_patient;
				if($this->getOneValueFromSql($sql) == $this->doctor['user_id'])
				{
					$q->addInt('approved', 1);
					$sql = 'SELECT email FROM patients WHERE id_patient_pk = '.$this->id_patient;
					$patient_email = $this->getOneValueFromSql($sql);
					$this->sendNewEmailNotification($patient_email, 'You have VYou mail!');
				}
				else
				{
					$q->addInt('approved', 0);
					$sql = 'SELECT d.email
							FROM patients p
							INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
							WHERE p.id_patient_pk = '.$this->id_patient;
					$doctor_email = $this->getOneValueFromSql($sql);
					$this->sendNewEmailNotification($doctor_email, 'VYou Notice: You have a pending Session I draft');
				}
				
				$sql = $q->createInsert();
				$this->dbQuery($sql);
				
				$sql = 'SELECT mail FROM study_manager WHERE id = 10 AND id_patient_fk = '.$this->id_patient;
				$mail = $this->getOneValueFromSql($sql);
				$mail++;
				
				$q=new sqlQuery('study_manager');
				$q->addInt('mail', $mail);
				if($mail>=3) $q->addInt('status', 1);
				$this->dbQuery($q->createUpdate('id=10 AND id_patient_fk = '.$this->id_patient));
				
				$this->reload();
			}
			
			// sprawdzam czy trzeba uaktywnic jakies wydarzenie
			$sql = 'SELECT *
					FROM study_manager
					WHERE visible = 0 AND id_patient_fk = '.$patient['id_patient_pk'].'
					ORDER BY id
			';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				if($row['id']==3)
				{
					$sql = 'SELECT status FROM study_manager WHERE id_patient_fk = '.$patient['id_patient_pk'].' AND id = 2';
					$status = $this->getOneValueFromSql($sql);
					if($status==1 && $this->isCsbirtCompleted())
					{
						$this->setAsVisible(3);
					}
				}
			}
			// -------------------------------------------------
			
			// wyswietla liste zdarzen
			$sql = 'SELECT sm.*, sme.name as event
					FROM study_manager sm
					INNER JOIN study_manager_events sme ON sme.id_study_manager_event_pk = sm.id
					WHERE visible = 1 AND id_patient_fk = '.$patient['id_patient_pk'].'
					ORDER BY id
			';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$item = array();
				$item['id'] = $row['id'];
				$item['schedule'] = $row['schedule'];
				$item['event'] = $this->decode($row['event']);
				$item['status'] = $row['status'] == 1 ? 'Completed' : 'Not completed';
				if($row['url'])
				{
					if(strstr($row['url'], '*EZSURVEY_') && $row['status']==0)
					{
						if($this->isEzsurveyCompleted($row['ezsurvey']))
						{
							switch($row['ezsurvey'])
							{
								case 1:
									$this->setAsCompleted(2);
								break;
								case 2:
									$this->setAsCompleted(3);
								break;
								case 3:
									$this->setAsCompleted(8);
									$this->setAsVisible(9);
									$this->reload();
								break;
								case 4:
									$this->setAsCompleted(9);
									$this->setAsVisible(10);
									$this->reload();
								break;
							}
							$item['status'] = 'Completed';
						}
						else 
						{
							$sql = 'SELECT link FROM zsurvey_links WHERE id_zsurvey_link_pk = '.$row['ezsurvey'];
							$survey_link = $this->getOneValueFromSql($sql);
							$item['url'] = str_replace('*STUDY_ID*', $patient['study_id'], $survey_link);
						}
					}
					elseif(strstr($row['url'], '*CSBIRT*'))
					{
						$sql = 'SELECT link FROM cSBIRT_links WHERE id_csbirt_link_pk = 1';
						$survey_link = $this->getOneValueFromSql($sql);
						$item['url'] = str_replace('*STUDY_ID*', $patient['study_id'], $survey_link);
					}
					elseif($row['url']=='*SEND_SESSION_1_EMAIL*' && $row['status']==0)
					{
						$item['url'] = $this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$patient['id_patient_pk'], REQUEST=>4));
					}
					elseif($row['url']=='*SEND_PATIENT_EMAIL*' && $row['status']==0)
					{
						$item['url'] = '#';
						$item['email'] = true;
						$sendEmail = true; 
					}
				}
				elseif($row['id']==1 && $row['status']==0)
				{
					if($this->isCsbirtCompleted())
					{
						$this->setAsCompleted(1);
						$item['status'] = 'Completed';
					}
				}
				if($item['schedule'] && strtotime($item['schedule']) < strtotime(date('Y-m-d')) && $item['status']=='Not completed')
				{
					$item['scheduleErr'] = true;
				}
				if($item['status'] == 'Completed')
				{
					$item['scheduleEdit'] = false;
				}
				else
				{
					$item['scheduleEdit'] = true;
				}
				$list[] = $item;
			}
		}
		return array(
			'items'=>$list,
			'sendEmail'=>$sendEmail,
		);
	}
	

	public function setAsCompleted($id_status)
	{
		$q = new sqlQuery('study_manager');
		$q->addInt('status', 1);
		$q->addString('completed_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createUpdate('id_patient_fk = '.$this->id_patient.' AND id = '.$id_status));
		return mysql_error() ? false : true;
	}
	
	
	public function setAsVisible($id_status)
	{
		$q = new sqlQuery('study_manager');
		$q->addInt('visible', 1);
		$this->dbQuery($q->createUpdate('id_patient_fk = '.$this->id_patient.' AND id = '.$id_status));
		return mysql_error() ? false : true;
	}
	
	
	public function isEzsurveyCompleted($number)
	{
		switch($number)
		{
			case 1:
				$table = 'EZ_Pre';
			break;
			case 2:
				$table = 'EZ_Post';
			break;
			case 3:
				$table = 'EZ_Three';
			break;
			case 4:
				$table = 'EZ_Six';
			break;
		}
		if($table)
		{
			$conn = $this->studyConnect();
			$sql = 'SELECT study_id FROM patients WHERE id_patient_pk = '.$this->id_patient;
			$res = mysql_query($sql, $conn);
			if($row = mysql_fetch_row($res))
			{
				$study_id = $row[0];
				$sql = 'SELECT COUNT(*) AS TOTAL
						FROM '.$table.'
						WHERE '.$table.'.IFMUID = \''.$study_id.'\' AND `'.$table.'`.`[_page]` = \'pageZEND\'
				';
				$res = mysql_query($sql, $conn);
				if($row = mysql_fetch_row($res))
				{
					$count = $row[0];
					if($count && $count>0)
					{
						//mysql_close($conn);
						return true;
					}
				}
			}
		}
		//mysql_close($conn);
		return false;
	}
	
	
	public function isCsbirtCompleted()
	{
		$conn = $this->studyConnect();
		$sql = 'SELECT study_id FROM patients WHERE id_patient_pk = '.$this->id_patient;
		$res = mysql_query($sql, $conn);
		if($row = mysql_fetch_row($res))
		{
			$study_id = $row[0];
			$sql = 'SELECT COUNT(*) AS TOTAL
					FROM cSBIRT
					WHERE studyid = \''.$study_id.'\' AND complete = 1
			';
			$res = mysql_query($sql, $conn);
			if($row = mysql_fetch_row($res))
			{
				$count = $row[0];
				if($count && $count>0)
				{
					return true;
				}
			}
		}
		return false;
	}
	
	
	public function getCsbirtSubstances($id_only=false)
	{
		$list = array();
		
		$sql = 'SELECT study_id FROM patients WHERE id_patient_pk = '.$this->id_patient;
		if($study_id = $this->getOneValueFromSql($sql))
		{
			$conn = $this->studyConnect();
			$sql = 'SELECT c.*
					FROM cSBIRT c
					WHERE c.studyid = \''.$study_id.'\'';
			$res = mysql_query($sql, $conn);
			if($row = mysql_fetch_array($res))
			{
				$sql  = 'SELECT * FROM cSBIRT_substances';
				$res2 = mysql_query($sql, $conn);
				while($row2 = mysql_fetch_assoc($res2))
				{
					if(isset($row[$row2['short']]) && $row[$row2['short']])
					{
						if($id_only)
						{
							$list[] = $row2['id_pre_tlfb_stimulant_fk'];
						}
						else
						{
							$list[] = array(
								'id'=>$row2['id_pre_tlfb_stimulant_fk'],
								'name'=>$row2['substance'],
								'short'=>$row2['short'],
								'value'=>$row[$row2['short']],
							);
						}
					}
				}
			}
		}
		
		return $list;
	}
	
	
	public function studyConnect()
	{
		if($conn=mysql_connect(STUDY_SERV,STUDY_USER,STUDY_PASS,true))
		{
			if(mysql_select_db(STUDY_NAME,$conn))
			{
				mysql_query('set names utf8',$conn);
				return $conn;
			}
			else
			{
				echo 'db select failed';
				exit();
			}
		}
		else 
		{
			echo 'db connect failed';
			exit();
		}
	}
	

}
?>