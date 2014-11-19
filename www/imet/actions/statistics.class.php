<?php
define('PART_STATISTICS','statistics');
$GLOBALS['actionClasses'][PART_STATISTICS]='statistics';

	define('SUMMARY','summary');
	define('CORRESPONDENCE','correspondence');
	define('AJAX_REQUEST','ajax');
	#
	define('SUMMARY_STATUSES',10);


class statistics extends projectCommon 
{
	public $params=array();
	public $conn=null;
	public $navigation=array();
	public $texts=array();
	
	public $doctor;
		
	public function __construct()
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		$this->navigation = &$GLOBALS['portal']->navigation;
		$this->texts = &$GLOBALS['portal']->texts;
		$this->doctor = $this->getSession(DOCTOR);
	}
	
	
	public function content()
	{
		switch($this->params[SUBPART_ID])
		{
			case SUMMARY:
				if($this->params[ID])
				{
					return $this->getUpcomingEvents($this->params[ID]);
				}
				return $this->getSummaryPage();
			break;
			case CORRESPONDENCE:
				if($this->params[ID])
				{
					return $this->getCorrespondencePage($this->params[ID]);
				}
				return $this->getCorrespondencePage();
			break;
			case AJAX_REQUEST:
				$this->getAjaxRequest();
			break;
		}
	}
	
	
	private function getCorrespondencePage($id_status=null)
	{
		$list = array();
		
		$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
		
		$sql_status = null;
		if($id_status)
		{
			$sql_status = 'WHERE id_correspondence_pk = '.$id_status;
		}
		$sql = 'SELECT id_correspondence_pk as id,name,description
				FROM correspondence
				'.$sql_status.'
				ORDER BY id_correspondence_pk';
		if(!$id_status)
		{
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$quantity = count($this->getCorrespondencePatients($row['id'], $doctorPatients));
				$list[] = array(
					'name'=>$this->decode($row['name']),
					'desc'=>$this->decode($row['description']),
					'quantity'=>$quantity,
					'href'=>$quantity ? $this->getlink(array(PART_ID=>PART_STATISTICS, SUBPART_ID=>CORRESPONDENCE, ID=>$row['id'])) : null,
				);
			}
			
			return array(
				'list'=>$list,
				'template'=>'statCorrespondence.tpl'
			);
		}
		else
		{
			if($statusInfo = $this->getOneRowFromSql($sql))
			{
				$list = array();
				
				$id_patients = $this->getCorrespondencePatients($id_status, $doctorPatients);
				if(count($id_patients))
				{
					$sql = 'SELECT p.id_patient_pk, p.study_id, p.last_name, p.first_name,
								   CONCAT(d.first_name,\' \',d.last_name) as provider
							FROM patients p
							INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
							WHERE id_patient_pk IN('.implode(',', $id_patients).')
					';
					$res = $this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res))
					{
						$list[] = array(
							'id_patient'=>$row2['id_patient_pk'],
							'id_status'=>$id_status,
							'study_id'=>$row2['study_id'],
							'last_name'=>$row2['last_name'],
							'first_name'=>$row2['first_name'],
							'site'=>substr($row2['study_id'], 1, 2),
							'provider'=>$row2['provider'],
							'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$row2['id_patient_pk'])),
						);
					}
				}
				
				return array(
					'status'=>$statusInfo,
					'list'=>$list,
					'backHref'=>$this->getlink(array(PART_ID=>PART_STATISTICS, SUBPART_ID=>CORRESPONDENCE)),
					'template'=>'statCorrespondence.tpl'
				);
			}
		}
	}
	
	
	private function getCorrespondencePatients($number, $patients)
	{
		$id_patients = array();
		if(count($patients))
		{
			$session = in_array($number, array(1,2,3)) ? 1 : 2;
			
			/*
			 * Session 1/2 draft pending – Imet Staff (RA) musi sprawdzic i odpowiedziec na maila (wysłać do akceptacji do Doctora)
			 * z informacja, ze sesja 1 zostala zakonczona przez użytkownika. Oznacza to, ze na liscie osob z tym statusem znajda się
			 * wszyscy pacjenci przypisani danemu pracownikowi dla których trzeba stworzyc maila z podsumowaniem jego dotychczasowej aktywności
			 */
			if($number==1 || $number==4)
			{
				$sql = 'SELECT id_patient_pk
						FROM patients
						WHERE id_patient_pk IN('.implode(',', $patients).')
							  AND session'.$session.'_completed IS NOT NULL
							  AND session'.$session.'_summary_mail = 1
				';
				$id_patients = $this->getSqlResult($sql, 'id_patient_pk');
			}
			/*
			 * Session 1/2 email pending  - oznacza, ze Doctor dostal maila od RA odnośnie sesji 1 i musi go sprawdzic, edytowac i wysłać do pacjenta
			 */
			elseif($number==2 || $number==5)
			{
				$sql = 'SELECT DISTINCT(id_session_patient_fk)
						FROM mail
						WHERE id_session_patient_fk IN('.implode(',', $patients).')
							  AND session = '.$session.'
							  AND type = \'inbox\' AND id_doctor_fk = '.$this->doctor['user_id'].'
							  AND is_read = 0
				';
				$id_patients = $this->getSqlResult($sql, 'id_session_patient_fk');
			}
			/*
			 * Session 1/2 Take 2 correction draft pending – Imet staff (RA) musi sprawdzic i odpowiedziec na maila
			 * (wysłać do akceptacji do Doctora) z informacja, ze pacjent wprowadzil poprawki do toola Take 2 w sesji pierwszej/drugiej.
			 * Oznacza to, ze na liscie osob z tym statusem znajda się wszyscy pacjenci przypisani danemu pracownikami dla których
			 * trzeba stworzyc maila z podsumowaniem jego zmian w toolu Take2
			 */
			elseif($number==3 || $number==6)
			{
				$sql = 'SELECT id_patient_pk
						FROM patients
						WHERE id_patient_pk IN('.implode(',', $patients).')
							  AND session'.$session.'_take2_changed_mail = 1
				';
				$id_patients = $this->getSqlResult($sql, 'id_patient_pk');
			}
		}
		return $id_patients;
	}
	
	
	private function getSummaryPage()
	{
		$showStatuses = $this->getDoctorsPatients($this->isLoggedIn());
		
		return array(
			'statusesCount'=>SUMMARY_STATUSES,
			'showStatuses'=>$showStatuses,
			'ajaxHref'=>str_replace('&amp;', '&', $this->getlink(array(PART_ID=>PART_STATISTICS, SUBPART_ID=>AJAX_REQUEST))),
			'statusHref'=>str_replace('&amp;', '&', $this->getlink(array(PART_ID=>PART_STATISTICS, SUBPART_ID=>SUMMARY, ID=>'*id*'))),
			'template'=>'statSummary.tpl'
		);
	}
	
	
	private function getUpcomingEvents($id_status)
	{
		$sql = 'SELECT event,description FROM summary WHERE id_summary_pk = '.$id_status;
		if($statusDesc = $this->getOneRowFromSql($sql))
		{
			if($this->params[TOKEN])
			{
				$id_patient = intval($this->getPOST('id_patient'));
				$date = strip_tags($this->getPOST('date'));
				if(!$this->isDate($date)) $date = null;
				
				$patients = $this->getDoctorsPatients($this->isLoggedIn());
				if(in_array($id_patient, $patients) && $date)
				{
					$sql = 'SELECT id_summary_schedule_pk FROM summary_schedule WHERE id_summary_fk = '.$id_status.' AND id_patient_fk = '.$id_patient;
					$id_schedule = $this->getOneValueFromSql($sql);
					
					$q = new sqlQuery('summary_schedule');
					if(!$id_schedule)
					{
						$q->addInt('id_summary_fk', $id_status);
						$q->addInt('id_patient_fk', $id_patient);
						$q->addString('date', $date);
						$sql = $q->createInsert();
					}
					else 
					{
						$q->addString('date', $date);
						$sql = $q->createUpdate('id_summary_schedule_pk = '.$id_schedule);
					}
					$this->dbQuery($sql);
					echo 'Saved';
				}
				else
				{
					echo 'Error';
				}
				die;
			}
			
			$list = array();
			
			$patients = array();
			$patients = $this->getDoctorsPatients($this->isLoggedIn());
			
			$id_patients = $this->getStatusInfo($id_status, $patients);
			if(count($id_patients))
			{
				$sql = 'SELECT p.id_patient_pk, p.study_id, p.last_name, p.first_name,
							   CONCAT(d.first_name,\' \',d.last_name) as provider
						FROM patients p
						INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
						WHERE id_patient_pk IN('.implode(',', $id_patients).')
				';
				$res = $this->dbQuery($sql);
				while($row=mysql_fetch_assoc($res))
				{
					$scheduleErr = false;
					
					$sql = 'SELECT date
							FROM summary_schedule
							WHERE id_summary_fk = '.$id_status.' AND id_patient_fk = '.$row['id_patient_pk'].'
					';
					$schedule = null;
					if($schedule=$this->getOneValueFromSql($sql))
					{
						if(strtotime($schedule)<strtotime(date('Y-m-d')))
						{
							$scheduleErr = true;
						}
					}
					
					$list[] = array(
						'id_patient'=>$row['id_patient_pk'],
						'id_status'=>$id_status,
						'study_id'=>$row['study_id'],
						'last_name'=>$row['last_name'],
						'first_name'=>$row['first_name'],
						'site'=>substr($row['study_id'], 1, 2),
						'provider'=>$row['provider'],
						'schedule'=>$schedule,
						'scheduleErr'=>$scheduleErr,
						'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$row['id_patient_pk'])),
					);
				}
			}
			
			return array(
				'backHref'=>$this->getlink(array(PART_ID=>PART_STATISTICS, SUBPART_ID=>SUMMARY)),
				'upcomingDateHref'=>str_replace('&amp;', '&', $this->getlink(array(PART_ID=>PART_STATISTICS, SUBPART_ID=>SUMMARY, ID=>$id_status))),
				'list'=>$list,
				'statusName'=>$statusDesc['event'],
				'template'=>'statUpcomingEvents.tpl'
			);
		}
	}
	
	
	private function getAjaxRequest()
	{
		$status = intval($this->getPOST('status'));
		if($status>=1 && $status<=SUMMARY_STATUSES)
		{
			$patients = array();
			$patients = $this->getDoctorsPatients($this->isLoggedIn());
			
			$sql = 'SELECT event,description FROM summary WHERE id_summary_pk = '.$status;
			$statusInfo = $this->getOneRowFromSql($sql);
			
			$statusInfo['quantity'] = count($this->getStatusInfo($status, $patients));
			
			echo 'ok||'.$statusInfo['quantity'].'||'.$statusInfo['event'].'||'.$statusInfo['description'];
		}
		else
		{
			echo 'error';
		} 
		die();
	}
	
	
	private function getStatusInfo($number, $patients)
	{
		$list = array();
	
		switch($number)
		{
			case 1:
				// Osoby, które na pytanie „Do you agree to aprticipate In VYou” odpowiedzialy - NIE
				$sql = 'SELECT DISTINCT(id_patient_fk)
						FROM questionnaire_answers
						WHERE id_question_fk=4 AND answer=\'No\' and id_patient_fk IN('.implode(',', $patients).')';
				$list = $this->getSqlResult($sql, 'id_patient_fk');
			break;
			case 2:
				// Osoby, ktore na pytanie pytanie „Do you agree to participate In VYou” odpowiedzialy – TAK
				$sql = 'SELECT DISTINCT(id_patient_fk)
						FROM questionnaire_answers
						WHERE id_question_fk=4 AND answer=\'Yes\' and id_patient_fk IN('.implode(',', $patients).')';
				$list = $this->getSqlResult($sql, 'id_patient_fk');
			break;
			case 3:
				// Klikniety checkbox że podpisali umowe
				// Osoby, ktore na pytanie pytanie „Do you agree to participate In VYou” odpowiedzialy – TAK
				$sql = 'SELECT DISTINCT(id_patient_fk)
						FROM questionnaire_answers
						WHERE id_question_fk=13 AND answer=\'Yes\' and id_patient_fk IN('.implode(',', $patients).')';
				$list = $this->getSqlResult($sql, 'id_patient_fk');
			break;
			case 4:
				// Pacjenci, ktorzy zgodzili sie na udzial w VYou i którzy wypelnili TLFB i 1szy Ezsurvey ale którzy nie wypelnili Csbirt
				$sql = 'SELECT id_patient_fk
						FROM questionnaire_answers
						WHERE id_question_fk=4 AND answer=\'Yes\' and id_patient_fk IN('.implode(',', $patients).')';
				$res = $this->dbQuery($sql);
				while($row=mysql_fetch_assoc($res))
				{
					$studyObj = new studyManager($row['id_patient_fk']);
					if($studyObj->isEzsurveyCompleted(1) && !$studyObj->isCsbirtCompleted())
					{
						$list[] = $row['id_patient_fk'];
					}
				}
			break;
			case 5:
				// status aktywny po ukonczeniu czesci Csbirt 
				foreach($patients as $patient)
				{
					$studyObj = new studyManager($patient);
					if($studyObj->isCsbirtCompleted())
					{
						$list[] = $patient;
					}
				}
			break;
			case 6:
				// status aktywny od momentu wyslania linku do VYou do pacjenta do momentu zakonczenia przez niego Sesji 1
				// czyli wszyscy zarejestrowani pacjenci ktorzy nie ukonczyli take2 session1
				$sql = 'SELECT id_patient_pk
						FROM patients
						WHERE id_patient_pk IN ('.implode(',', $patients).') AND session1_completed IS NULL
				';
				$list = $this->getSqlResult($sql, 'id_patient_pk');
			break;
			case 7:
				// status od momentu kiedy minie 2 tygodnie (14 dni) od ukończenia przez pacjenta Sesji 1 do ukończenia Sesji 2
				$sql = 'SELECT id_patient_pk
						FROM patients
						WHERE session1_completed IS NOT NULL AND session2_completed IS NULL
							  AND DATE(session1_completed) <= \''.date('Y-m-d', strtotime('-14day')).'\'
							  AND id_patient_pk IN ('.implode(',', $patients).')
				';
				$list = $this->getSqlResult($sql, 'id_patient_pk');
			break;
			case 8:
				// status aktywny po zakonczeniu przez pacjenta Sesji 2 do wykonania trzeciego Ezsurvey
				// ...
			break;
			case 9:
				// status aktywny po wykonaniu trzeciego Ezsurvey do wykonania czwartego Ezsurvey
				foreach($patients as $patient)
				{
					$studyObj = new studyManager($patient);
					if($studyObj->isEzsurveyCompleted(3) && !$studyObj->isEzsurveyCompleted(4))
					{
						$list[] = $patient;
					}
				}
			break;
			case 10:
				// status aktywny dla pacjentów po wykonaniu 4 Ezsurvey
				foreach($patients as $patient)
				{
					$studyObj = new studyManager($patient);
					if($studyObj->isEzsurveyCompleted(4))
					{
						$list[] = $patient;
					}
				}
			break;
		}
		
		return $list;
	}
	
	
	private function getSqlResult($sql, $field)
	{
		$result = array();
		$res = $this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$result[] = $row[$field];
		}
		return $result;
	}
	
}
?>