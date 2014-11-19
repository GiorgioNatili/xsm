<?php
define('PART_PATIENTS','patients');
$GLOBALS['actionClasses'][PART_PATIENTS]='patients';

	define('PATIENTS_SINGLE','single');
	define('PATIENTS_JOURNAL','journal');
	define('PATIENTS_DETAILS','details');
	define('PATIENTS_QUESTIONNAIRE','questionnaire');
	define('PATIENTS_STIMULANTS','stimulants');
	define('PATIENTS_EVENTS','events');
	define('PATIENTS_TOOLS_SUMMARY','tools');
	define('PATIENTS_NEWPATIENT','newpatient');
	define('PATIENTS_DOCTORS','doctors');
	define('PATIENTS_ASSESSMENTS','assessments');

class patients extends projectCommon 
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
		$permissions = new permissions($this->doctor['user_id']);
		
		if($this->params[SUBPART_ID])
		{
			switch($this->params[SUBPART_ID])
			{
				case PATIENTS_SINGLE:
					return $this->getSinglePatient($this->params[ID]);
				break;
				case PATIENTS_JOURNAL:
					if($permissions->isPermittedPart('journal'))
					{
						return $this->getPatientJournal($this->params[ID]);
					}
				break;
				case PATIENTS_QUESTIONNAIRE:
					if($permissions->isPermittedPart('eligibility_results'))
					{
						return $this->getPatientQuestionnaireResults($this->params[ID]);
					}
				break;
				case PATIENTS_DETAILS:
					if($permissions->isPermittedPart('patient_information'))
					{
						return $this->getPatientDetails($this->params[ID]);
					}
				break;
				case PATIENTS_STIMULANTS:
					if($permissions->isPermittedPart('substance_list'))
					{
						return $this->getPatientStimulants($this->params[ID]);
					}
				break;
				case PATIENTS_EVENTS:
					if($permissions->isPermittedPart('events'))
					{
						return $this->getPatientEvents($this->params[ID]);
					}
				break;
				case PATIENTS_TOOLS_SUMMARY:
					if($permissions->isPermittedPart('tools_summary'))
					{
						if($this->params[ID2] == 1) // time details
						{
							return $this->getPatientTimeDetails($this->params[ID]);
						}
						return $this->getPatientToolsSummary($this->params[ID]);
					}
				break;
				/*
				case PATIENTS_DOCTORS:
					if($permissions->isPermittedPart('doctors'))
					{
						return $this->getPatientDoctors($this->params[ID]);
					}
				break;
				*/
				case PATIENTS_ASSESSMENTS:
					if($permissions->isPermittedPart('assessments'))
					{
						return $this->getPatientAssessments($this->params[ID]);
					}
				break;
				case PATIENTS_NEWPATIENT:
					if($permissions->isPermittedPart('add_new_patient'))
					{
						switch($this->params[ADD])
						{
							case 2:
								return $this->personalInformationForm();
							break;
							case 3:
								return $this->preTLFBQuestions();
							break;
							case 4:
								return $this->showPatientInstructionPage();
							break;
							case 5:
								return $this->eventsCalendar();
							break;
							case 6:
								return $this->TLFBCalendar();
							break;
							case 7:
								return $this->savePatient();
							break;
							default:
								return $this->addPatientQuestionnaire();
						}
					}
				break;
			}
		}
		
		$patients = array();
		$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
		
		if(count($doctorPatients))
		{
			$sql = 'SELECT p.*, pg.name as group_name
					FROM patients p
					INNER JOIN patients_groups pg ON pg.id_patient_group_pk = p.id_patient_group_fk
					WHERE p.id_patient_pk IN('.implode(',', $doctorPatients).')
			';
			$res = $this->dbQuery($sql);
			while($row = mysql_fetch_assoc($res))
			{
				$patients[] = array(
					'study_id'=>$this->decode($row['study_id']),
					'first_name'=>$this->decode($row['first_name']),
					'last_name'=>$this->decode($row['last_name']),
					'group'=>$this->decode($row['group_name']),
					'agreement'=>$row['agreement'],
					'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$row['id_patient_pk'])),
				);
			}
		}
		
		
		return array(
			'patientsList'=>$patients,
			'addNewPatientHref'=>$permissions->isPermittedPart('add_new_patient') ? $this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT)) : null,
	      	'template'=>'patientsList.tpl'
	    );
	}
	
	
	private function getSinglePatient($id_patient)
	{
		$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
		if(in_array($id_patient, $doctorPatients))
		{
			$sql = "SELECT p.*, CONCAT_WS(' ',d.first_name,d.last_name) as doctor
					FROM patients p
					INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
					WHERE p.id_patient_pk = $id_patient
			";
			if($patient = $this->getOneRowFromSql($sql))
			{
				if($this->params[TOKEN]=='date')
				{
					$id = intval($this->getPOST('id'));
					$date = $this->getPOST('date');
					if($id && $date && $this->isDate($date))
					{
						$q = new sqlQuery('study_manager');
						$q->addString('schedule', $date);
						$sql = $q->createUpdate('id_patient_fk = '.$id_patient.' AND id = '.$id);
						$this->dbQuery($sql);
						if(mysql_affected_rows())
						{
							echo 'Saved';
						}
					}
					die();
				}
				
				$patient['site'] = substr($patient['study_id'], 1, 2);
				$patient['provider'] = $patient['doctor'];
				
				$form=new form('formJournal');
					
				$inp_body=new formTextArea($form,'body','','',true,0,'','','','');
				$inp_body->init();
				if($form->isSubmitted() && $inp_body->error)
				{
					$inp_body->errMsg=$this->getText('form_pole_obowiazkowe');
				}
				
				if($form->isSubmitted() && $form->isValid())
				{
					$query=new sqlQuery();
					$query->table='journal';
					$query->addInt('id_patient_fk', $id_patient);
					$query->addInt('id_doctor_fk', $this->doctor['user_id']);
					$query->addString('body', strip_tags($inp_body->value));
					$query->addCurrentDateTime('add_date');
					$sql = $query->createInsert();
					$this->dbQuery($sql);
					
					$this->setSessionMessage('journal_add', $this->getText('journal_added'));
					$this->reload();
				}
				
				$permissions = new permissions($this->doctor['user_id']);
				
				$patientMenu = array();
				
				if($permissions->isPermittedPart('tools_summary'))
				{
					$patientMenu[] = array(
						'name'=>$this->getText('toolsSummary'),
						'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_TOOLS_SUMMARY, ID=>$id_patient)),
					);
				}
				if($permissions->isPermittedPart('journal'))
				{
					$patientMenu[] = array(
						'name'=>'Journal',
						'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_JOURNAL, ID=>$id_patient))
					);
				}
				if($permissions->isPermittedPart('eligibility_results'))
				{
					$patientMenu[] = array(
						'name'=>$this->getText('questionnaire_results'),
						'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_QUESTIONNAIRE, ID=>$id_patient))
					);
				}
				if($permissions->isPermittedPart('substance_list'))
				{
					$patientMenu[] = array(
						'name'=>'Substances',
						'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_STIMULANTS, ID=>$id_patient)),
					);
				}
				if($permissions->isPermittedPart('events'))
				{
					$patientMenu[] = array(
						'name'=>$this->getText('events'),
						'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_EVENTS, ID=>$id_patient)),
					);
				}
				if($permissions->isPermittedPart('patient_information'))
				{
					$patientMenu[] = array(
						'name'=>$this->getText('patient_details'),
						'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_DETAILS, ID=>$id_patient)),
					);
				}
				if($permissions->isPermittedPart('assessments'))
				{
					$patientMenu[] = array(
						'name'=>'Assessments',
						'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_ASSESSMENTS, ID=>$id_patient)),
					);
				}
				/*
				if($permissions->isPermittedPart('doctors'))
				{
					$patientMenu[] = array(
						'name'=>'Doctors',
						'href'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_DOCTORS, ID=>$id_patient)),
					);
				}
				*/
				
				$studyManager = new studyManager($id_patient);
				
				return array(
					'journalShow'=>$permissions->isPermittedPart('journal'),
					'journalForm'=>$form->smarty(),
					'journalAdded'=>$this->getSessionMessage('journal_add'),
					'patient'=>$patient,
					'patientMenu'=>$patientMenu,
					'studyManager'=>$studyManager->getList(),
					'studyMangerDateHref'=>str_replace('&amp;','&', $this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$id_patient, TOKEN=>'date'))),
			      	'template'=>'patientSingle.tpl',
			    );
			}
		}
		$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS)));
	}
	
	
	private function addPatientQuestionnaire()
	{
		$errors = array();
		$values = array();
		$questions = array();
		
		$values = $this->getSession('questionnaire');
		
		$sql = 'SELECT * FROM questionnaire ORDER BY sequence';
		$res = $this->dbQuery($sql);
		while($row = mysql_fetch_assoc($res))
		{
			$questions[$row['id_question_pk']] = $this->decode($row['text']);
		}
		
		if($this->getPOST('nextStep'))
		{
			$fields = $this->getQuestionnaireFields();
			
			foreach($fields as $field)
			{
				if($value = $this->getPOST($field['name']))
				{
					if(is_array($value))
					{
						foreach ($value as $key => $item)
						{
							$values[$field['name']][$key] = strip_tags($item);
						}
					}
					else
					{
						$values[$field['name']] = strip_tags($value);
					}
				}
				elseif($field['req'])
					$errors[$field['name']] = $this->getText('form_pole_obowiazkowe');
			}
			
			if(isset($values['refusal']) && $values['refusal'] == 'Other')
			{
				$values['refusal_other'] = strip_tags($this->getPOST('refusal_other'));
			}
			
			if(!count($errors))
			{
				$values['nextstep'] = 2;
				
				$this->setSession('questionnaire', $values);
				$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT, ADD=>$values['nextstep'])));
			}
		}
		
		return array(
			'showRefusal'=>(isset($values['agreement']) && $values['agreement'] == 'No'),
			'questions'=>$questions,
			'errors'=>$errors,
			'values'=>$values,
			'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS)),
			'template'=>'patientAdd_step1.tpl',
		);
	}
	
	
	private function personalInformationForm()
	{
		$values = $this->getSession('questionnaire');
		
		if(!$values || (isset($values) && $values['nextstep'] < 2))
		{
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT)));
		}
		
		$new_patient = $this->getSession('new_patient');
		if(!count($new_patient))
		{
			$new_patient = array('first_name'=>'', 'middle_name'=>'', 'last_name'=>'', 'medical_record'=>'', 'sex'=>'', 'dob'=>'',
								 'clinician'=>'', 'clinician2'=>'', 'email'=>'', 'email2'=>'', 'phone'=>'', 'cell'=>'', 'parent'=>'',
								 'alternate'=>'', 'address'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'alternate_name'=>'', 'alternate_email'=>'',
								 'alternate_phone'=>'', 'alternate_address'=>'', 'alternate_address2'=>'', 'alternate_city'=>'', 'alternate_state'=>'', 'alternate_zip'=>'',
								 'site'=>'', 'pcp_doctor'=>'',
			);
		}
		
		$req = true;
		//if($this->getPOST('siteSubmit')) $req = false;
		
		$form=new form('formPatient','formPatient');
		###
		$inp_firstname=new formInputBox($form,'firstname','',$new_patient['first_name'],$req,255,'','text2','','');
		$inp_firstname->init();
		if($form->isSubmitted() && $inp_firstname->error)
		{
			$inp_firstname->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_middlename=new formInputBox($form,'middlename','',$new_patient['middle_name'],false,255,'','text2','','');
		$inp_middlename->init();
		###
		$inp_lastname=new formInputBox($form,'lastname','',$new_patient['last_name'],$req,255,'','text2','','');
		$inp_lastname->init();
		if($form->isSubmitted() && $inp_lastname->error)
		{
			$inp_lastname->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_medical_record=new formInputBox($form,'medical_record','',$new_patient['medical_record'],$req,255,'','text2','','');
		$inp_medical_record->init();
		if($form->isSubmitted() && $inp_medical_record->error)
		{
			$inp_medical_record->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$patient_sex='';
		switch($new_patient['sex'])
		{
			case 'Male':
				$patient_sex=1;
			break;
			case 'Female':
				$patient_sex=2;
			break;
		}
		$inp_sex=new formSelect($form,'sex','',$patient_sex,$req,'','select2','border:1px solid red','');
		$sex=array();
		$sex[]=array('key'=>0,'value'=>'');
		$sex[]=array('key'=>1,'value'=>'Male');
		$sex[]=array('key'=>2,'value'=>'Female');
		$inp_sex->source=$sex;
		$inp_sex->init();
		if($form->isSubmitted() and $inp_sex->error)
		{
			$inp_sex->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_dob=new formInputBox($form,'dob','',$new_patient['dob'],$req,255,'','text2','','');
		$inp_dob->init();
		if($form->isSubmitted())
		{
			if($inp_dob->error)
			{
				$inp_dob->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			elseif(!$this->isValidDob($inp_dob->value))
			{
				$inp_dob->errMsg=$this->getText('form_nieprawidlowa_data');
				$inp_dob->error=1;
			}
		}
		###
		$inp_clinician=new formInputBox($form,'clinician','',$new_patient['clinician'],$req,255,'','text2','','');
		$inp_clinician->init();
		if($form->isSubmitted() && $inp_clinician->error)
		{
			$inp_clinician->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_clinician2=new formInputBox($form,'clinician2','',$new_patient['clinician2'],false,255,'','text2','','');
		$inp_clinician2->init();
		###
		$inp_email=new formInputBox($form,'email','',$new_patient['email'],$req,255,'','text2','','');
		$inp_email->init();
		if($form->isSubmitted())
		{
			if($inp_email->error)
			{
				$inp_email->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			elseif (!$this->isEmail($inp_email->value))
			{
				$inp_email->error=1;
				$inp_email->errMsg=$this->getText('form_email_nieprawidlowy');
			}
			else
			{
				$sql = 'SELECT id_patient_pk FROM patients WHERE email LIKE \''.$inp_email->value.'\'';
				if($this->getOneValueFromSql($sql))
				{
					$inp_email->error=1;
					$inp_email->errMsg=$this->getText('form_email_istnieje');
				}
			}
		}
		###
		$inp_email2=new formInputBox($form,'email2','',$new_patient['email2'],false,255,'','text2','','');
		$inp_email2->init();
		###
		$inp_phone=new formInputBox($form,'phone','',$new_patient['phone'],false,10,'','text2','','');
		$inp_phone->init();
		###
		$inp_cell=new formInputBox($form,'cell','',$new_patient['cell'],$req,10,'','text2','','');
		$inp_cell->init();
		if($form->isSubmitted() && $inp_cell->error)
		{
			$inp_cell->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_parent=new formInputBox($form,'parent','',$new_patient['parent'],false,255,'','text2','','');
		$inp_parent->init();
		###
		$inp_alternate=new formInputBox($form,'alternate','',$new_patient['alternate'],false,255,'','text2','','');
		$inp_alternate->init();
		###
		$inp_address_1=new formInputBox($form,'address_1','',$new_patient['address'],$req,255,'','text2','','');
		$inp_address_1->init();
		if($form->isSubmitted() && $inp_address_1->error)
		{
			$inp_address_1->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_address_2=new formInputBox($form,'address_2','',$new_patient['address2'],false,255,'','text2','','');
		$inp_address_2->init();
		###
		$inp_city=new formInputBox($form,'city','',$new_patient['city'],$req,255,'','text2','','');
		$inp_city->init();
		if($form->isSubmitted() && $inp_city->error)
		{
			$inp_city->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_state=new formInputBox($form,'state','',$new_patient['state'],$req,255,'','text2','','');
		$inp_state->init();
		if($form->isSubmitted() && $inp_state->error)
		{
			$inp_state->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_zip=new formInputBox($form,'zip','',$new_patient['zip'],$req,5,'','text2','','');
		$inp_zip->init();
		if($form->isSubmitted() && $inp_zip->error)
		{
			$inp_zip->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_alternate_name=new formInputBox($form,'alternate_name','',$new_patient['alternate_name'],false,255,'','text2','','');
		$inp_alternate_name->init();
		###
		$inp_alternate_email=new formInputBox($form,'alternate_email','',$new_patient['alternate_email'],false,255,'','text2','','');
		$inp_alternate_email->init();
		if($form->isSubmitted() && $inp_alternate_email->value && !$this->isEmail($inp_alternate_email->value))
		{
			$inp_alternate_email->error=1;
			$inp_alternate_email->errMsg=$this->getText('form_email_nieprawidlowy');
		}
		###
		$inp_alternate_phone=new formInputBox($form,'alternate_phone','',$new_patient['alternate_phone'],false,10,'','text2','','');
		$inp_alternate_phone->init();
		###
		$inp_alternate_address_1=new formInputBox($form,'alternate_address_1','',$new_patient['alternate_address'],false,255,'','text2','','');
		$inp_alternate_address_1->init();
		###
		$inp_alternate_address_2=new formInputBox($form,'alternate_address_2','',$new_patient['alternate_address2'],false,255,'','text2','','');
		$inp_alternate_address_2->init();
		###
		$inp_alternate_city=new formInputBox($form,'alternate_city','',$new_patient['alternate_city'],false,255,'','text2','','');
		$inp_alternate_city->init();
		###
		$inp_alternate_state=new formInputBox($form,'alternate_state','',$new_patient['alternate_state'],false,255,'','text2','','');
		$inp_alternate_state->init();
		###
		$inp_alternate_zip=new formInputBox($form,'alternate_zip','',$new_patient['alternate_zip'],false,5,'','text2','','');
		$inp_alternate_zip->init();
		
		### site ###
		
		$doctorType = $this->getDoctorType();
		
		$doctorsSites = array();
		$doctorsSitesSelected = false;
		
		if($doctorType == 2)
		{
			$inp_site=new formSelect($form,'site','',$new_patient['site'],true,'','select2','border:1px solid red','');
			$sql_site = 'SELECT DISTINCT(sd.id_site_fk) as `key`, s.name as `value`
						 FROM sites_doctors sd
						 INNER JOIN sites s ON s.id_site_pk = sd.id_site_fk
						 WHERE id_doctor_fk = '.$this->doctor['user_id'];
			$inp_site->getSourceFromSql($sql_site, $this->conn);
			$inp_site->init();
			if($form->isSubmitted() && $inp_site->error)
			{
				$inp_site->errMsg=$this->getText('form_pole_obowiazkowe');
			}
		}
		else
		{
			$doctorsSites[0] = array(
				'fullname'=>'',
			);
			
			$pcpDoctor = $new_patient['pcp_doctor'];
			if($this->getPOST('pcpDoctor')) $pcpDoctor = $this->getPOST('pcpDoctor');
			
			$pcpSite = $new_patient['site'];
			if($this->getPOST('pcpSite')) $pcpSite = $this->getPOST('pcpSite');
			
			$sql = 'SELECT * FROM doctors WHERE id_doctor_type_fk = 2 AND disabled = 0';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				if($pcpDoctor == $row['id_doctor_pk'])
				{
					$doctorsSitesSelected = true;
				}
				
				$doctorsSites[$row['id_doctor_pk']] = array(
					'fullname'=>$row['first_name'].' '.$row['last_name'],
					'active'=>$pcpDoctor == $row['id_doctor_pk'] ? true : false,
					'sites'=>array(),
				);
				$sql = 'SELECT sd.*, s.name
						FROM sites_doctors sd
						INNER JOIN sites s ON s.id_site_pk = sd.id_site_fk
						WHERE sd.id_doctor_fk = '.$row['id_doctor_pk'].'
				';
				$res2 = $this->dbQuery($sql);
				while($row2=mysql_fetch_assoc($res2))
				{
					$doctorsSites[$row['id_doctor_pk']]['sites'][] = array(
						'id'=>$row2['id_site_fk'],
						'name'=>$row2['name'],
						'active'=>$pcpSite == $row2['id_site_fk'] ? true : false,
					);
				}
			}
			
			if(!$doctorsSitesSelected && $form->isSubmitted())
			{
				$form->error = 1;
			}
		}

		
		
		/*
		$doctors_error = null;
		
		// zaznaczeni lekarze
		$active_doctors = array();
		if($form->isSubmitted())
		{
			if($this->getPOST('doctors'))
			{
				$active_doctors = $this->getPOST('doctors');
			}
			elseif(!$this->getPOST('siteSubmit'))
			{
				$doctors_error = 'At least one doctor required';
			}
		}
		
		// wszyscy lekarze
		$doctors_list = array();
		if($inp_site->value)
		{
			$siteDoctors = $this->getSiteDoctors($inp_site->value);
			
			$sql = 'SELECT id_doctor_pk, CONCAT(first_name,\' \',last_name) as fullname
					FROM doctors
					WHERE id_doctor_pk<>'.$this->doctor['user_id'].' AND id_doctor_pk IN ('.implode(',', $siteDoctors).')
					ORDER BY last_name, first_name
			';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$doctors_list[] = array(
					'id'=>$row['id_doctor_pk'],
					'fullname'=>$row['fullname'],
					'checked'=>in_array($row['id_doctor_pk'], $active_doctors),
				);
			}
		}
		
		$isAditionalDoctor = false;
		foreach($doctors_list as $doctor)
		{
			if($doctor['checked']==true)
			{
				$isAditionalDoctor = true;
				break;
			}
		}
		*/
		
		
		//if($form->isSubmitted() && $form->isValid() && $isAditionalDoctor)
		if($form->isSubmitted() && $form->isValid())
		{
			$patient = array();
			$patient['first_name'] = strip_tags($inp_firstname->value);
			$patient['middle_name'] = strip_tags($inp_middlename->value);
			$patient['last_name'] = strip_tags($inp_lastname->value);
			$patient['medical_record'] = strip_tags($inp_medical_record->value);
			$patient['sex'] = (intval($inp_sex->value) == 1) ? 'Male' : 'Female';
			$patient['dob'] = strip_tags($inp_dob->value);
			$patient['clinician'] = strip_tags($inp_clinician->value);
			$patient['clinician2'] = strip_tags($inp_clinician2->value);
			$patient['email'] = strip_tags($inp_email->value);
			$patient['email2'] = strip_tags($inp_email2->value);
			$patient['phone'] = strip_tags($inp_phone->value);
			$patient['cell'] = strip_tags($inp_cell->value);
			$patient['parent'] = strip_tags($inp_parent->value);
			$patient['alternate'] = strip_tags($inp_alternate->value);
			$patient['address'] = strip_tags($inp_address_1->value);
			$patient['address2'] = strip_tags($inp_address_2->value);
			$patient['city'] = strip_tags($inp_city->value);
			$patient['state'] = strip_tags($inp_state->value);
			$patient['zip'] = strip_tags($inp_zip->value);
			$patient['alternate_name'] = strip_tags($inp_alternate_name->value);
			$patient['alternate_email'] = strip_tags($inp_alternate_email->value);
			$patient['alternate_phone'] = strip_tags($inp_alternate_phone->value);
			$patient['alternate_address'] = strip_tags($inp_alternate_address_1->value);
			$patient['alternate_address2'] = strip_tags($inp_alternate_address_2->value);
			$patient['alternate_city'] = strip_tags($inp_alternate_city->value);
			$patient['alternate_state'] = strip_tags($inp_alternate_state->value);
			$patient['alternate_zip'] = strip_tags($inp_alternate_zip->value);
			if($doctorType == 1)
			{
				$patient['pcp_doctor'] = intval($this->getPOST('pcpDoctor'));
				$patient['site'] = intval($this->getPOST('pcpSite'));
			}
			elseif($doctorType == 2)
			{
				$patient['site'] = intval($inp_site->value);
			}
			
			/*
			$patient['doctors'] = array();
			
			foreach($doctors_list as $doctor)
			{
				if($doctor['checked']==true)
				{
					$patient['doctors'][] = $doctor['id'];
				}
			}
			*/
			
			$values['nextstep'] = 3;
			
			$this->setSession('questionnaire', $values);
			$this->setSession('new_patient', $patient);
			
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT, ADD=>3)));
		}
		
		
		return array(
			'form'=>$form->smarty(),
			//'doctorsList'=>$doctors_list,
			//'doctorsError'=>$doctors_error,
			'doctorsSites'=>$doctorsSites,
			'doctorsSitesError'=>($doctorType==1 && !$doctorsSitesSelected && $form->isSubmitted()) ? true : false,
			'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT)),
			'template'=>'patientAdd_step2.tpl',
		);
	}
	
	
	private function showPatientInstructionPage()
	{
		$values = $this->getSession('questionnaire');
		
		if(!$values || (isset($values) && $values['nextstep'] < 4))
		{
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT)));
		}
		
		if($this->getPOST('nextStep'))
		{
			$values['nextstep'] = 5;
			$this->setSession('questionnaire', $values);
			
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT, ADD=>5)));
		}
		
		$static = new staticPage(5);
		
		return array(
			'page'=>$static,
			'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT, ADD=>3)),
			'template'=>'patientAdd_step4.tpl',
		);
	}
	
	
	private function preTLFBQuestions()
	{
		$values = $this->getSession('questionnaire');
		if(!$values || (isset($values) && $values['nextstep'] < 3))
		{
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT)));
		}
		
		$sql = 'SELECT ptq.question, ptq.id_pre_tlfb_question_pk as id_question, pts.stimulant, pts.id_pre_tlfb_stimulant_pk as id_stimulant
				FROM pre_tlfb_questions ptq
				INNER JOIN pre_tlfb_stimulants pts ON pts.id_pre_tlfb_stimulant_pk = ptq.id_pre_tlfb_stimulant_fk
				ORDER BY ptq.sequence
		';
		$res=$this->dbQuery($sql);
		
		$form = array();
		$stimulants = array();
		while($row=mysql_fetch_assoc($res))
		{
			$show = 0;
			$selected = 0;
			if($selected = $this->getPOST('question_'.$row['id_stimulant'].'_'.$row['id_question']))
			{
				$show = 1;
			}
			
			$form[$row['id_stimulant']]['questions'][] = array(
				'id'=>$row['id_question'],
				'text'=>$this->decode($row['question']),
				'show'=>$show,
				'selected'=>$selected,
			);
			$form[$row['id_stimulant']]['name'] = $this->decode($row['stimulant']);
			$form[$row['id_stimulant']]['id'] = $row['id_stimulant'];
			
			if($selected==1 && isset($form[$row['id_stimulant']]['yes'])) $form[$row['id_stimulant']]['yes']++;
			elseif($selected==1 && !isset($form[$row['id_stimulant']]['yes'])) $form[$row['id_stimulant']]['yes']=1;
		}
		
		if($this->getPOST('nextStep'))
		{
			foreach($form as $stimulant)
			{
				if(isset($stimulant['yes']) && $stimulant['yes']>=2)
				{
					$stimulants[]=array(
						'id'=>$stimulant['id'],
						'name'=>$stimulant['name'],
					);
				}
			}
			
			$this->setSession('stimulants', $stimulants);
			
			$values['nextstep'] = 4;
			$this->setSession('questionnaire', $values);
			
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT, ADD=>4)));
		}
		
		
		return array(
			'form'=>$form,
			'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT, ADD=>2)),
			'template'=>'patientAdd_step3.tpl',
		);
	}
	
	
	private function eventsCalendar()
	{
		$values = $this->getSession('questionnaire');
		if(!$values || (isset($values) && $values['nextstep'] < 5))
		{
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT)));
		}
		
		if($this->getPOST('nextStep'))
		{
			$values['nextstep'] = 6;
			$this->setSession('questionnaire', $values);
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT, ADD=>6)));
		}
		
		$sql = 'SELECT * FROM holiday';
		$res = $this->dbQuery($sql);
		$holiday=array();
		while($row=mysql_fetch_assoc($res))
		{
			$holiday[sprintf("%02d",  $row['month']).'-'.sprintf("%02d",  $row['day'])] = $this->decode($row['name_en']);
		}
		
		$comments = array();
		
		if($temp_taken = $this->getSession('eventsCalendar'))
		{
			foreach($temp_taken as $date => $value)
			{
				$comments[$date] = $value;
			}
		}
		
		$calendar=array();

		for($i=0; $i<4; $i++)
		{
			$year  = date('Y');
			$month = date('n') - $i;
			
			if($month <= 0)
			{
				$month = 12;
				$year--;
			}
			
			$calendar[$month.'-'.$year] = array();
			$calendar[$month.'-'.$year]['id'] = ($i+1);
			$calendar[$month.'-'.$year]['month'] = date('F', strtotime(date($year.'-'.$month.'-01')));
			$calendar[$month.'-'.$year]['year'] = $year;
			
			$first_monday = date('w', strtotime(date($year.'-'.$month.'-01')));
			
			if($i==3) $first_monday+=(date('d')-1);
			
			for($j=0; $j<$first_monday; $j++)
			{
				$calendar[$month.'-'.$year]['days'][] = array();
			}
			
			$days_in_month = date('t', strtotime(date($year.'-'.$month.'-01')));
			for($j=0; $j<$days_in_month; $j++)
			{
				if(($i==0 && $j<date('d')) || ($i==3 && $j>=(date('d')-1)) || $i==1 || $i==2)
				{
					$calendar[$month.'-'.$year]['days'][] = array(
						'day' => $j+1,
						'month' => $month,
						'year' => $year,
						'text' => isset($comments[$year.'-'.$month.'-'.($j+1)]) ? $comments[$year.'-'.$month.'-'.($j+1)] : null,
						'holiday' => isset($holiday[sprintf("%02d",  $month).'-'.sprintf("%02d",  ($j+1))]) ? $holiday[sprintf("%02d",  $month).'-'.sprintf("%02d",  ($j+1))] : null,
					);
				}
				elseif($i<3)
				{
					break;
				}
			}
			
			if($toDo = count($calendar[$month.'-'.$year]['days']) % 7)
			{
				for($j=0; $j<(7-$toDo); $j++)
				{
					$calendar[$month.'-'.$year]['days'][] = array();
				}
			}
		}
		
		$comment = $this->getPOST('calendarComment');
		$addDate = $this->isDate($this->getPOST('addDate')) ? $this->getPOST('addDate') : null;
		
		if($comment && $addDate)
		{
			$temp_taken = $this->getSession('eventsCalendar');
			$temp_taken[$addDate] = strip_tags($comment);
			$this->setSession('eventsCalendar', $temp_taken);
			$this->reload();
		}
		
		
		$static = new staticPage(6);
		
		return array(
			'calendar'=>$calendar,
			'page'=>$static,
			'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT, ADD=>4)),
			'template'=>'patientAdd_step5.tpl',
		);
	}
	
	
	private function TLFBCalendar()
	{
		$values = $this->getSession('questionnaire');
		if(!$values || (isset($values) && $values['nextstep'] < 6))
		{
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT)));
		}
		
		$steps = array(
			'1'=>array('limit'=>7),
			'2'=>array('limit'=>14),
			'3'=>array('limit'=>30),
			'4'=>array('limit'=>60),
			'5'=>array('limit'=>90),
		);
		
		$tlfb_questions = $this->getSession('tlfbQuestions');
		if(!$tlfb_questions)
		{
			$tlfb_questions = array(
				'step'=>1,
			);
		}
		
		if($this->getPOST('nextStep'))
		{
			$tlfb_questions['step']++;
			
			if($tlfb_questions['step'] > count($steps))
			{
				$values['nextstep'] = 7;
				$this->setSession('questionnaire', $values);
				$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT, ADD=>7)));
			}
			
			$this->setSession('tlfbQuestions', $tlfb_questions);
			$this->reload();
		}
		
		if($this->getPOST('prevQuestion'))
		{
			$tlfb_questions['step']--;
			$this->setSession('tlfbQuestions', $tlfb_questions);
			$this->reload();
		}
		
		
		$stimulants = $this->getSession('stimulants');
		$tlfbCal = $this->getSession('tlfbCal');
		
		$addDate = $this->getPOST('addDate');
		foreach($_POST as $key => $value)
		{
			if(strstr($key, 'stimulantdel_') && $this->isDate($addDate))
			{
				$dateArr = explode('-', $addDate);
				$addDate = $dateArr[0].'-'.sprintf("%02d",  $dateArr[1]).'-'.sprintf("%02d",  $dateArr[2]);
				
				unset($tlfbCal[$addDate][intval(end(explode('_', $key)))]);
				$this->setSession('tlfbCal', $tlfbCal);
				$this->reload();
			}
		}
		
		

		$pastDate = date('Y-m-d', strtotime('-'.$steps[$tlfb_questions['step']]['limit'].' day'));
		$pastDateArr = explode('-', $pastDate);
		
		$calendar=array();

		if($pastDateArr[1] == date('n'))
		{
			$year  = date('Y');
			$month = sprintf("%02d",  date('n'));
			
			$first_monday = date('w', strtotime(date($year.'-'.$month.'-01')));
			$days_in_month = date('t', strtotime(date($year.'-'.$month.'-01')));
				
			$calendar[$month.'-'.$year] = array();
			$calendar[$month.'-'.$year]['id'] = 1;
			$calendar[$month.'-'.$year]['month'] = date('F', strtotime(date($year.'-'.$month.'-01')));
			$calendar[$month.'-'.$year]['year'] = $year;
			
			for($j=0; $j<$first_monday-1; $j++)
			{
				$calendar[$month.'-'.$year]['days'][] = array();
			}
			
			for($j=0; $j<$pastDateArr[2]+1; $j++)
			{
				$calendar[$month.'-'.$year]['days'][] = array();
			}

			for($k=0; $k<$days_in_month; $k++)
			{
				if($k<=date('d') && $k>intval($pastDateArr[2]))
				{
					$dayName = date('l', strtotime(date($year.'-'.$month.'-'.($k))));
					$dayName .= ', '. date('F', strtotime(date($year.'-'.$month.'-'.($k))));
					$dayName .= ' '.($k).', '.$year;
					
					$calendar[$month.'-'.$year]['days'][] = array(
						'day' => ($k),
						'dayName' => $dayName,
						'month' => $month,
						'year' => $year,
						'options' => (isset($tlfbCal[$year.'-'.$month.'-'.sprintf("%02d",($k))])) ? $tlfbCal[$year.'-'.$month.'-'.sprintf("%02d",($k))] : null,						
					);
				}
			}
			
			if($toDo = count($calendar[$month.'-'.$year]['days']) % 7)
			{
				for($j=0; $j<(7-$toDo); $j++)
				{
					$calendar[$month.'-'.$year]['days'][] = array();
				}
			}
		}
		else
		{
			$i = 0;
			$year = null; $month = null;
			do
			{
				if(!$year)  $year  = date('Y');
				if(!$month) $month = date('n') - $i;
				else $month--;
				
				if($month <= 0)
				{
					$month = 12;
					$year--;
				}
				
				$month = sprintf("%02d",  $month);
				
				$calendar[$month.'-'.$year] = array();
				$calendar[$month.'-'.$year]['id'] = ($i+1);
				$calendar[$month.'-'.$year]['month'] = date('F', strtotime(date($year.'-'.$month.'-01')));
				$calendar[$month.'-'.$year]['year'] = $year;
				
				$first_monday = date('w', strtotime(date($year.'-'.$month.'-01')));
				if(($year.'-'.$month) == ($pastDateArr[0].'-'.$pastDateArr[1]))
				{
					$first_monday = date('w', strtotime(date($pastDate)))+1;
				}
				
				for($j=0; $j<$first_monday; $j++)
				{
					$calendar[$month.'-'.$year]['days'][] = array();
				}
							
				$days_in_month = date('t', strtotime(date($year.'-'.$month.'-01')));
				
				/*
				$f = fopen(CACHE_DIR.'dim','a');
				fwrite($f, $days_in_month.' | '.$year.'-'.$month.'-01'."\n");
				fclose($f);
				*/
				
				for($j=0; $j<$days_in_month; $j++)
				{
					if(($i==0 && $j<date('d') && $month != $pastDateArr[1]) || ($i && $month != $pastDateArr[1]) || ($i && $month == $pastDateArr[1] && $j>=$pastDateArr[2]))
					{
						$dayName = date('l', strtotime(date($year.'-'.$month.'-'.($j+1))));
						
						/*
						$f = fopen(CACHE_DIR.'tlfb','a');
						fwrite($f, $year.'-'.$month.'-'.($j+1)."\n");
						fclose($f);
						*/
						
						$dayName .= ', '. date('F', strtotime(date($year.'-'.$month.'-'.($j+1))));
						$dayName .= ' '.($j+1).', '.$year;
											
						$calendar[$month.'-'.$year]['days'][] = array(
							'day' => $j+1,
							'dayName' => $dayName,
							'month' => $month,
							'year' => $year,
							'options' => (isset($tlfbCal[$year.'-'.$month.'-'.sprintf("%02d",($j+1))])) ? $tlfbCal[$year.'-'.$month.'-'.sprintf("%02d",($j+1))] : null,						
						);
					}
					elseif($month != $pastDateArr[1])
					{
						break;
					}
				}
				
				if($toDo = count($calendar[$month.'-'.$year]['days']) % 7)
				{
					for($j=0; $j<(7-$toDo); $j++)
					{
						$calendar[$month.'-'.$year]['days'][] = array();
					}
				}
				
				$i++;
				
				/*
				$f = fopen(CACHE_DIR.'while','a');
				fwrite($f, ($year.'-'.$month).' != '.($pastDateArr[0].'-'.$pastDateArr[1])."\n");
				fclose($f);
				*/
				
			} while(($year.'-'.$month) != ($pastDateArr[0].'-'.$pastDateArr[1]));

		}

		$date = $this->getPOST('addDate');
		if($this->getPOST('addTLFB') && $this->isDate($date))
		{
			foreach($_POST as $key => $value)
			{
				if(strstr($key, 'stimulant_') && $value)
				{
					$dateArr = explode('-', $date);
					$date = $dateArr[0].'-'.sprintf("%02d",  $dateArr[1]).'-'.sprintf("%02d",  $dateArr[2]);
					
					$stimulant_id = intval(end(explode('_', $key)));
					$tlfbCal[$date][$stimulant_id] = strip_tags($value);
					
					// repeat
					$dateFrom = $this->getPOST('dateFrom_'.$stimulant_id);
					$dateTo = $this->getPOST('dateTo_'.$stimulant_id);
					$option = $this->getPOST('stimulantoptions_'.$stimulant_id);
					
					if($this->isDate($dateFrom) && $this->isDate($dateTo) && $option)
					{
						$this->repeatInTLFBCalendar($tlfbCal, $dateFrom, $dateTo, $stimulant_id, $option, strip_tags($value));
					}
				}
			}
			
			$this->setSession('tlfbCal', $tlfbCal);
			$this->reload();
		}
		
		//$this->unsetSession('tlfbCal');
		//print_r($this->getSession('tlfbCal'));die;
		
		$static = new staticPage(7);
		
		$sql = 'SELECT text_en as text FROM tlfb_questions WHERE id_question_pk = '.$tlfb_questions['step'];
		$question = $this->getOneValueFromSql($sql);
		
		return array(
			'dayLimit'=>($steps[$tlfb_questions['step']]['limit'] - 1),
			'stimulants'=>$stimulants,
			'calendar'=>$calendar,
			'page'=>$static,
			'question'=>$question,
			'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT, ADD=>5)),
			'backQuestion'=>($tlfb_questions['step']!=1),
			'save'=>($tlfb_questions['step']==count($steps)),
			'template'=>'patientAdd_step6.tpl',
		);
	}
	
	
	
	private function repeatInTLFBCalendar(&$calendar, $from, $to, $id, $option, $value)
	{
		if($option==1)
		{
			do
			{
				$calendar[$from][$id] = $value;
				$from = date('Y-m-d', strtotime('+1 day', strtotime($from)));
			}
			while($from <= $to);
		}
		elseif($option==2)
		{
			do
			{
				if(in_array(date('N', strtotime($from)), array(1,2,3,4,5)))
				{
					$calendar[$from][$id] = $value;
				}
				$from = date('Y-m-d', strtotime('+1 day', strtotime($from)));
			}
			while($from <= $to);
		}
		elseif($option==3)
		{
			do
			{
				if(in_array(date('N', strtotime($from)), array(6,7)))
				{
					$calendar[$from][$id] = $value;
				}
				$from = date('Y-m-d', strtotime('+1 day', strtotime($from)));
			}
			while($from <= $to);
		}
		/*****/
		elseif($option==6)
		{
			do
			{
				if(in_array(date('N', strtotime($from)), array(5,6)))
				{
					$calendar[$from][$id] = $value;
				}
				$from = date('Y-m-d', strtotime('+1 day', strtotime($from)));
			}
			while($from <= $to);
		}
		elseif($option==7)
		{
			do
			{
				if(in_array(date('N', strtotime($from)), array(7,1,2,3,4)))
				{
					$calendar[$from][$id] = $value;
				}
				$from = date('Y-m-d', strtotime('+1 day', strtotime($from)));
			}
			while($from <= $to);
		}
	}
	
	
	
	
	
	private function savePatient()
	{
		$values = $this->getSession('questionnaire');
		$params = $this->getSession('new_patient');
		
		if(!$values || (isset($values) && $values['nextstep'] < 7))
		{
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_NEWPATIENT)));
		}
		
		$token = $this->create_token();
		$idPatientGroup = $this->getPatientGroupID($values['age'], $params['sex']);
		
		// KROK 2 - jako pierwszy bo potrzebne jest ID pacjenta
		$study_id = $this->generateStudyID($params['site']);
		$query=new sqlQuery('patients');
		$query->addInt('id_patient_group_fk', $idPatientGroup);
		
		$doctorType = $this->getDoctorType();
		if($doctorType==1)
		{
			$query->addInt('id_doctor_fk', $params['pcp_doctor']);
		}
		elseif($doctorType==2)
		{
			$query->addInt('id_doctor_fk', $this->doctor['user_id']);
		}
		$query->addInt('id_site_fk', $params['site']);
		$query->addString('study_id', $study_id);
		if($values['agreement']=='No')
		{
			$query->addInt('agreement', 0);
		}
		else
		{
			$query->addInt('agreement', 1);
		}
		$query->addCurrentDateTime('add_date');
		
		foreach ($params as $key => $value)
		{
			if($value && !in_array($key, array('doctors','site','pcp_doctor'))) $query->addString($key, $value);
		}
		$query->addString('username', $params['email']);
		$query->addString('register_token', $token);
		$this->dbQuery($query->createInsert());
		$id_patient = mysql_insert_id();
		$patient_email = $params['email'];
		
		
		/*
		foreach($params['doctors'] as $doctor)
		{
			if($doctor['checked']==true)
			{
				$q = new sqlQuery('patients_doctors');
				$q->addInt('id_patient_fk', $id_patient);
				$q->addInt('id_doctor_fk', $doctor['id']);
				$this->dbQuery($q->createInsert());
			}
		}
		*/
		
		
		// KROK 1
		$questions = array();
		$sql = 'SELECT * FROM questionnaire ORDER BY sequence';
		$res = $this->dbQuery($sql);
		while($row = mysql_fetch_assoc($res))
		{
			$questions[$row['id_question_pk']] = $this->decode($row['text']);
		}
		$this->savePatientQuestionnaire(true, $id_patient, $values);
		
		
		
		// KROK 3
		$stimulants = $this->getSession('stimulants');
		if(is_array($stimulants))
		{
			foreach($stimulants as $stimulant)
			{
				$query=new sqlQuery('patients_stimulants');
				$query->addInt('id_patient_fk', $id_patient);
				$query->addInt('id_pre_tlfb_stimulant_fk', $stimulant['id']);
				$sql = $query->createInsert();
				$this->dbQuery($sql);
			}
		}
		
		
		
		// KROK 5
		$events = $this->getSession('eventsCalendar');
		if(is_array($events))
		{
			foreach($events as $date => $event)
			{
				if($date && $event)
				{
					$query=new sqlQuery('patients_events');
					$query->addInt('id_patient_fk', $id_patient);
					$query->addString('event_date', $date);
					$query->addString('event_text', $event);
					$sql = $query->createInsert();
					$this->dbQuery($sql);
				}
			}
		}
		
		
		
		// KROK 6
		$calendar = $this->getSession('tlfbCal');
		if(is_array($calendar))
		{
			foreach($calendar as $date => $stimulants)
			{
				foreach($stimulants as $stimulant => $quantity)
				{
					if($quantity && $date && $stimulant)
					{
						$query=new sqlQuery('patients_calendar');
						$query->addInt('id_patient_fk', $id_patient);
						$query->addInt('id_stimulant_fk', $stimulant);
						$query->addString('date', $date);
						$query->addInt('quantity', $quantity);
						$sql = $query->createInsert();
						$this->dbQuery($sql);
					}
				}
			}
		}
		
		
		$this->unsetSession('new_patient');
		$this->unsetSession('questionnaire');
		$this->unsetSession('stimulants');
		$this->unsetSession('eventsCalendar');
		$this->unsetSession('tlfbCal');
		$this->unsetSession('tlfbQuestions');
		
		
		/* WYSLANIE MAILA Z LINKIEM DO FLASHA */
		if($idPatientGroup > 1)
		{
			$static = new staticPage(8);
			
			$mail=new sendmail();
			$mail->fromName=SERVICE_NAME;
			$mail->from=$this->getConfigValue('mailerEmail');
			$mail->to=$patient_email;
			$mail->subject=$static->title;
			$mail->smarty_template='default/emailDefault.tpl';
			
			$body = str_replace('*HREF*', FLASH_WWW.'?registrationHash='.$token, $static->body);
			
			$mail->smarty_assigns=array(
				'mainPageLink'=>$this->getlink(array(PART_ID=>PART_MAIN)),
				'logo'=>SERVICE_WWW.'templates/default/images/logomail.png',
				'emailBody'=>$body,
			);
			$mail->attachNotCmsImages=false;
			$mail->send();
		}
		
		
		// DODAWANIE ZDARZEN
		###
		$q = new sqlQuery('study_manager');
		$q->addInt('id_patient_fk', $id_patient);
		$q->addInt('id', 1);
		//$q->addString('event', 'Screening and Brief Advice');
		$q->addString('url', '*CSBIRT*');
		$q->addInt('csbirt', 1);
		$q->addInt('visible', 1);
		$q->addString('add_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createInsert());
		###
		$q = new sqlQuery('study_manager');
		$q->addInt('id_patient_fk', $id_patient);
		$q->addInt('id', 2);
		//$q->addString('event', 'Baseline Assessment.');
		$q->addString('url', '*EZSURVEY_1*');
		$q->addInt('ezsurvey', 1);
		$q->addInt('visible', 1);
		$q->addString('add_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createInsert());
		###
		$q = new sqlQuery('study_manager');
		$q->addInt('id_patient_fk', $id_patient);
		$q->addInt('id', 3);
		//$q->addString('event', 'Post-visit assessment');
		$q->addString('url', '*EZSURVEY_2*');
		$q->addInt('ezsurvey', 2);
		$q->addInt('visible', 0);
		$q->addString('add_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createInsert());
		###
		$q = new sqlQuery('study_manager');
		$q->addInt('id_patient_fk', $id_patient);
		$q->addInt('id', 4);
		//$q->addString('event', 'Session 1 Reminder');
		$q->addString('url', '*SEND_SESSION_1_EMAIL*');
		$q->addInt('visible', 1);
		$q->addString('add_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createInsert());
		###
		$q = new sqlQuery('study_manager');
		$q->addInt('id_patient_fk', $id_patient);
		$q->addInt('id', 5);
		//$q->addString('event', 'Imet Session 1');
		$q->addInt('visible', 0);
		$q->addString('add_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createInsert());
		###
		$q = new sqlQuery('study_manager');
		$q->addInt('id_patient_fk', $id_patient);
		$q->addInt('id', 6);
		//$q->addString('event', 'Session 2 Reminder');
		$q->addString('url', '*SEND_SESSION_2_EMAIL*');
		$q->addInt('visible', 0);
		$q->addString('add_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createInsert());
		###
		$q = new sqlQuery('study_manager');
		$q->addInt('id_patient_fk', $id_patient);
		$q->addInt('id', 7);
		//$q->addString('event', 'Imet Session2');
		$q->addInt('visible', 0);
		$q->addString('add_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createInsert());
		###
		$q = new sqlQuery('study_manager');
		$q->addInt('id_patient_fk', $id_patient);
		$q->addInt('id', 8);
		//$q->addString('event', '3 months follow-up');
		$q->addString('url', '*EZSURVEY_3*');
		$q->addInt('ezsurvey', 3);
		$q->addInt('visible', 0);
		$q->addString('add_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createInsert());
		###
		$q = new sqlQuery('study_manager');
		$q->addInt('id_patient_fk', $id_patient);
		$q->addInt('id', 9);
		//$q->addString('event', '6 months follow-up');
		$q->addString('url', '*EZSURVEY_4*');
		$q->addInt('ezsurvey', 4);
		$q->addInt('visible', 0);
		$q->addString('add_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createInsert());
		###
		$q = new sqlQuery('study_manager');
		$q->addInt('id_patient_fk', $id_patient);
		$q->addInt('id', 10);
		//$q->addString('event', 'TE Due');
		$q->addString('url', '*SEND_PATIENT_EMAIL*');
		$q->addInt('visible', 0);
		$q->addString('add_date', date('Y-m-d H:i:s'));
		$this->dbQuery($q->createInsert());
		
		
		// link do pierwszej ankiety
		$static = new staticPage(4);
		$sql = 'SELECT link FROM zsurvey_links WHERE id_zsurvey_link_pk = 1';
		$survey_link = $this->getOneValueFromSql($sql);
		$survey_link = str_replace('*STUDY_ID*', $study_id, $survey_link);
		$body = str_replace('*SURVEY_HREF*', $survey_link, $static->body);
		
		return array(
			'static'=>array(
				'title'=>$static->title,
				'body'=>$body,
			),
			'template'=>'staticPage.tpl',
		);
	}
	
	
	private function savePatientQuestionnaire($req, $id_patient, $values)
	{
		$fields = $this->getQuestionnaireFields($req);
		
		foreach ($fields as $field)
		{
			if($field['req'] && isset($values[$field['name']]))
			{
				if(is_array($values[$field['name']]))
				{
					foreach($values[$field['name']] as $answer)
					{
						$query=new sqlQuery();
						$query->table='questionnaire_answers';
						$query->addInt('id_patient_fk', $id_patient);
						$query->addInt('id_question_fk', $field['question']);
						$query->addString('answer', $answer);
						$sql = $query->createInsert();
						$this->dbQuery($sql);
					}
				}
				else
				{
					$query=new sqlQuery();
					$query->table='questionnaire_answers';
					$query->addInt('id_patient_fk', $id_patient);
					$query->addInt('id_question_fk', $field['question']);
					if($field['name']=='refusal' && isset($values['refusal_other']) && $values['refusal_other'])
					{
						$query->addString('answer', $values[$field['name']].': '.$values['refusal_other']);
					}
					else
					{
						$query->addString('answer', $values[$field['name']]);
					}
					$sql = $query->createInsert();
					$this->dbQuery($sql);
				}
			}
		}
	}
	
	
	private function getPatientJournal($id_patient)
	{
		$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
		if(in_array($id_patient, $doctorPatients))
		{
			$sql = "SELECT * FROM patients WHERE id_patient_pk = $id_patient";
			$patient = $this->getOneRowFromSql($sql);

			if($patient)
			{
				$journal=array();
				$sql = "SELECT j.*, CONCAT(d.first_name,' ',d.last_name) as doctor
						FROM journal j
						INNER JOIN doctors d ON j.id_doctor_fk = d.id_doctor_pk
						WHERE j.id_patient_fk = $id_patient ORDER BY j.add_date DESC";
				$res = $this->dbQuery($sql);
				while($row=mysql_fetch_assoc($res))
				{
					$journal[] = array(
						'body'=>nl2br($this->decode($row['body'])),
						'doctor'=>nl2br($this->decode($row['doctor'])),
						'add_date'=>$row['add_date'],
					);
				}
				
				return array(
					'patient'=>$patient,
					'journalList'=>$journal,
					'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$id_patient)),
					'template'=>'patientJournalList.tpl',
				);
			}
		}
	}
	
	
	private function getPatientQuestionnaireResults($id_patient)
	{
		$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
		if(in_array($id_patient, $doctorPatients))
		{
			$sql = "SELECT * FROM patients WHERE id_patient_pk = $id_patient";
			$patient = $this->getOneRowFromSql($sql);
		
			if($patient)
			{
				$results=array();
				
				$sql = "SELECT q.id_question_pk, q.text, qa.answer
						FROM questionnaire_answers qa
						INNER JOIN questionnaire q ON q.id_question_pk = qa.id_question_fk
						WHERE qa.id_patient_fk = $id_patient
						ORDER BY q.sequence
				";
				$res = $this->dbQuery($sql);
				while($row = mysql_fetch_assoc($res))
				{
					$results[$row['id_question_pk']]['question'] = $this->decode($row['text']);
					$results[$row['id_question_pk']]['answers'][] = $this->decode($row['answer']);
				}
				
				return array(
					'patient'=>$patient,
					'results'=>$results,
					'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$id_patient)),
					'template'=>'patientQuestionnaireResults.tpl'
				);
			}
		}
	}
	
	
	private function getPatientDetails($id_patient)
	{
		$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
		if(in_array($id_patient, $doctorPatients))
		{
			$sql = "SELECT * FROM patients WHERE id_patient_pk = $id_patient";
			$patient = $this->getOneRowFromSql($sql);
		
			if($patient)
			{
				
				return array(
					'patient'=>$patient,
					'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$id_patient)),
					'template'=>'patientDetails.tpl'
				);
			}
		}
	}
	
	
	private function getPatientStimulants($id_patient)
	{
		$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
		if(in_array($id_patient, $doctorPatients))
		{
			$sql = "SELECT * FROM patients WHERE id_patient_pk = $id_patient";
			$patient = $this->getOneRowFromSql($sql);
		
			if($patient)
			{
				$stimulants = array();
				
				$sql = 'SELECT pts.stimulant, ps.id_pre_tlfb_stimulant_fk
						FROM patients_stimulants ps
						INNER JOIN pre_tlfb_stimulants pts ON pts.id_pre_tlfb_stimulant_pk = ps.id_pre_tlfb_stimulant_fk
						WHERE ps.id_patient_fk = '.$id_patient.'
				';
				$res=$this->dbQuery($sql);
				while($row=mysql_fetch_assoc($res))
				{
					$dates=array();
					$sql = 'SELECT date, quantity
							FROM patients_calendar pc
							WHERE id_patient_fk = '.$id_patient.' AND id_stimulant_fk = '.$row['id_pre_tlfb_stimulant_fk'].'
							ORDER BY date DESC
					';
					$res2=$this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res2))
					{
						$dateArr = explode('-', $row2['date']);
						
						$dayName = date('l', strtotime(date($row2['date'])));
						$dayName .= ', '. date('F', strtotime(date($row2['date'])));
						$dayName .= ' '.($dateArr[1]).', '.$dateArr[0];
						
						$dates[] = array(
							'date'=>$row2['date'],
							'quantity'=>intval($row2['quantity']),
							'dayName'=>$dayName,
						);
					}
					
					$stimulants[] = array(
						'name'=>$this->decode($row['stimulant']),
						'dates'=>$dates,
					);
				}
				
				
				return array(
					'patient'=>$patient,
					'stimulants'=>$stimulants,
					'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$id_patient)),
					'template'=>'patientStimulants.tpl'
				);
			}
		}
	}
	
	
	private function getPatientEvents($id_patient)
	{
		$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
		if(in_array($id_patient, $doctorPatients))
		{
			$sql = "SELECT * FROM patients WHERE id_patient_pk = $id_patient";
			$patient = $this->getOneRowFromSql($sql);
		
			if($patient)
			{
				$events = array();
				
				$sql = 'SELECT pe.*
						FROM patients_events pe
						WHERE pe.id_patient_fk = '.$id_patient.'
				';
				$res=$this->dbQuery($sql);
				while($row=mysql_fetch_assoc($res))
				{
					$events[] = array(
						'date'=>$row['event_date'],
						'text'=>$this->decode($row['event_text']),
					);
				}
				
				
				return array(
					'patient'=>$patient,
					'events'=>$events,
					'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$id_patient)),
					'template'=>'patientEvents.tpl'
				);
			}
		}
	}
	
	
	public function getPatientToolsSummary($id_patient, $flash=false)
	{
		if(!$flash)
		{
			$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
			if(in_array($id_patient, $doctorPatients))
			{
				$sql = "SELECT * FROM patients WHERE id_patient_pk = $id_patient";
				$patient = $this->getOneRowFromSql($sql);
			}
		}
		else
		{
			$sql = "SELECT * FROM patients WHERE id_patient_pk = $id_patient";
			$patient = $this->getOneRowFromSql($sql);
		}
		
		if($patient)
		{
			$stimulants = array();
			$sql = 'SELECT stimulant
					FROM patients_stimulants ps
					INNER JOIN pre_tlfb_stimulants pts ON pts.id_pre_tlfb_stimulant_pk = ps.id_pre_tlfb_stimulant_fk
					WHERE ps.id_patient_fk = '.$id_patient.'
			';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$stimulants[]=$this->decode($row['stimulant']);
			}
			
			$extra = array();
			$sql = 'SELECT * FROM session_tool8_extra WHERE id_patient_fk = '.$id_patient;
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				if($row['text'])
				{
					$extra[$row['id_session_tool8_tools_fk']] = $this->decode($row['text']);
				}
			}
			
			
			$tools = array();
			
			$sql = 'SELECT *
					FROM session_tools
					ORDER BY number, sequence
			';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$tools[$row['id_session_tool_pk']] = array(
					'id'=>$row['id_session_tool_pk'],
					'name'=>$this->decode($row['title']),
					'number'=>$row['number'],
				);
				
				// WHAT'S IMPORTANT TO ME
				if($row['id_session_tool_pk'] == 2)
				{
					$tools[$row['id_session_tool_pk']]['template'] = 'patientToolSummaryResults.tpl';
					$tools[$row['id_session_tool_pk']]['answers'] = array();
					
					$sql = 'SELECT CONCAT_WS(\' \', st2c.label1, st2c.label2) as category, st2.answer
							FROM session_tool2 st2
							INNER JOIN session_tool2_categories st2c ON st2c.id_category_pk = st2.id_category_fk
							WHERE id_patient_fk = '.$id_patient.'
							ORDER BY st2c.part, st2.id_category_fk
					';
					$res2 = $this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res2))
					{
						$tools[$row['id_session_tool_pk']]['answers'][strip_tags($this->decode($row2['category']))][] = $this->decode($row2['answer']);
					}
					if(isset($extra[1]))
					{
						$tools[$row['id_session_tool_pk']]['extra'] = $extra[1];
					}
				}
				// PROS AND CONS
				elseif($row['id_session_tool_pk'] == 3)
				{
					$tools[$row['id_session_tool_pk']]['template'] = 'patientToolSummaryResults.tpl';
					$tools[$row['id_session_tool_pk']]['answers'] = array();
					
					$sql = 'SELECT stc.label, stc.category
							FROM session_tool3 st
							INNER JOIN session_tool3_cards stc ON stc.id_session_tool3_card_pk = st.id_session_tool3_card_fk
							WHERE st.id_patient_fk = '.$id_patient.'
					';
					$res2 = $this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res2))
					{
						$tools[$row['id_session_tool_pk']]['answers'][$this->decode($row2['category'])][] = $this->decode($row2['label']);
					}
					if(isset($extra[3]))
					{
						$tools[$row['id_session_tool_pk']]['extra'] = $extra[3];
					}
				}
				// WHAT HAVE I EXPERIENCED
				elseif($row['id_session_tool_pk'] == 4)
				{
					$tools[$row['id_session_tool_pk']]['template'] = 'patientToolSummaryResults.tpl';
					$tools[$row['id_session_tool_pk']]['answers'] = array();
					
					$sql = 'SELECT st.answer, stp.question
							FROM session_tool4_answers st
							INNER JOIN session_tool4_person stp ON stp.id_session_tool4_person_pk = st.id_session_tool4_person_fk
							WHERE st.id_patient_fk = '.$id_patient.'
					';
					$res2 = $this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res2))
					{
						$tools[$row['id_session_tool_pk']]['answers'][$this->decode(strip_tags($row2['question']))][] = $this->decode($row2['answer']);
					}
					if(isset($extra[5]))
					{
						$tools[$row['id_session_tool_pk']]['extra'] = $extra[5];
					}
				}
				// CALCULATOR
				elseif($row['id_session_tool_pk'] == 5)
				{
					$tools[$row['id_session_tool_pk']]['template'] = 'patientToolSummaryResults5.tpl';
					$tools[$row['id_session_tool_pk']]['answers'] = array();
					
					$sql = 'SELECT st.text
							FROM session_tool5_answers st
							WHERE st.id_patient_fk = '.$id_patient.'
					';
					$res2 = $this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res2))
					{
						$tools[$row['id_session_tool_pk']]['answers'][] = nl2br($this->decode($row2['text']));
					}
					if(isset($extra[2]))
					{
						$tools[$row['id_session_tool_pk']]['extra'] = $extra[2];
					}
				}
				// DRAW THE LINE
				elseif($row['id_session_tool_pk'] == 6)
				{
					$tools[$row['id_session_tool_pk']]['template'] = 'patientToolSummaryResults.tpl';
					$tools[$row['id_session_tool_pk']]['answers'] = array();
					
					$sql = 'SELECT stq.state, st.ready_digit as digit, IF(st.ready_answer=sta.answer, sta.answer, CONCAT(sta.answer,\' \',st.ready_answer)) as answer
							FROM session_tool6 st
							INNER JOIN session_tool6_answers sta ON sta.id_session_tool6_answer_pk = st.id_ready_answer_fk
							INNER JOIN session_tool6_questions stq ON stq.id_session_tool6_question_pk = sta.id_session_tool6_question_fk
							WHERE st.id_patient_fk = '.$id_patient.'
							UNION
							SELECT stq.state, st.confident_digit as digit, IF(st.confident_answer=sta.answer, sta.answer, CONCAT(sta.answer,\' \',st.confident_answer)) as answer
							FROM session_tool6 st
							INNER JOIN session_tool6_answers sta ON sta.id_session_tool6_answer_pk = st.id_confident_answer_fk
							INNER JOIN session_tool6_questions stq ON stq.id_session_tool6_question_pk = sta.id_session_tool6_question_fk
							WHERE st.id_patient_fk = '.$id_patient.'
					';
					$res2 = $this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res2))
					{
						if($row2['state']==1) $state = 'Am I ready? ('.$row2['digit'].') ';
						elseif($row2['state']==2) $state = 'Am I confident? ('.$row2['digit'].') ';
						$tools[$row['id_session_tool_pk']]['answers'][$state][] = $this->decode($row2['answer']);
					}
					if(isset($extra[4]))
					{
						$tools[$row['id_session_tool_pk']]['extra'] = $extra[4];
					}
				}
				// TAKE 2 SESSION 1
				elseif($row['id_session_tool_pk'] == 7)
				{
					$tools[$row['id_session_tool_pk']]['template'] = 'patientToolSummaryResults7.tpl';
					$tools[$row['id_session_tool_pk']]['answers'] = array();
					
					###
					
					$sql = 'SELECT st.answer, sti.info
							FROM session_tool7_introcard_answers st
							INNER JOIN session_tool7_introcard sti ON sti.id_session_tool7_introcard_pk = st.id_session_tool7_introcard_fk
							WHERE st.id_patient_fk = '.$id_patient.' AND st.session = 1 AND st.old=0
					';
					$res2 = $this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res2))
					{
						$tools[$row['id_session_tool_pk']]['answers']['new'][$this->decode($row2['info'])][] = $this->decode($row2['answer']);
					}
					
					###
					
					$sql = 'SELECT st.text, stc.text as coupon, sta.text as answer
							FROM session_tool7_coupons_answers st
							INNER JOIN session_tool7_coupons stc ON stc.id_session_tool7_coupon_pk = st.id_session_tool7_coupon_fk
							INNER JOIN session_tool7_answers sta ON sta.id_session_tool7_answer_pk = st.id_session_tool7_answer_fk
							WHERE st.id_patient_fk = '.$id_patient.' AND st.session = 1 AND st.old=0
					';
					$res2 = $this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res2))
					{
						if($row2['text'])
						{
							$tools[$row['id_session_tool_pk']]['answers']['new'][$this->decode($row2['coupon'])][] = $this->decode($row2['text']);
						}
						elseif($row2['answer'])
						{
							$tools[$row['id_session_tool_pk']]['answers']['new'][$this->decode($row2['coupon'])][] = $this->decode($row2['answer']);
						}
					}
					
					###
					
					// jesli sa stare odpowiedzi
					if(!$flash)
					{
						$sql = 'SELECT st.answer, sti.info
								FROM session_tool7_introcard_answers st
								INNER JOIN session_tool7_introcard sti ON sti.id_session_tool7_introcard_pk = st.id_session_tool7_introcard_fk
								WHERE st.id_patient_fk = '.$id_patient.' AND st.session = 1 AND st.old=1
						';
						$res2 = $this->dbQuery($sql);
						while($row2=mysql_fetch_assoc($res2))
						{
							$tools[$row['id_session_tool_pk']]['answers']['old'][$this->decode($row2['info'])][] = $this->decode($row2['answer']);
						}
						
						###
						
						$sql = 'SELECT st.text, stc.text as coupon, sta.text as answer
								FROM session_tool7_coupons_answers st
								INNER JOIN session_tool7_coupons stc ON stc.id_session_tool7_coupon_pk = st.id_session_tool7_coupon_fk
								INNER JOIN session_tool7_answers sta ON sta.id_session_tool7_answer_pk = st.id_session_tool7_answer_fk
								WHERE st.id_patient_fk = '.$id_patient.' AND st.session = 1 AND st.old=1
						';
						$res2 = $this->dbQuery($sql);
						while($row2=mysql_fetch_assoc($res2))
						{
							if($row2['text'])
							{
								$tools[$row['id_session_tool_pk']]['answers']['old'][$this->decode($row2['coupon'])][] = $this->decode($row2['text']);
							}
							elseif($row2['answer'])
							{
								$tools[$row['id_session_tool_pk']]['answers']['old'][$this->decode($row2['coupon'])][] = $this->decode($row2['answer']);
							}
						}
					}
				}
				// TAKE 2 SESSION 2
				elseif($row['id_session_tool_pk'] == 11)
				{
					$tools[$row['id_session_tool_pk']]['template'] = 'patientToolSummaryResults7.tpl';
					$tools[$row['id_session_tool_pk']]['answers'] = array();
					
					###
					
					$sql = 'SELECT st.answer, sti.info
							FROM session_tool7_introcard_answers st
							INNER JOIN session_tool7_introcard sti ON sti.id_session_tool7_introcard_pk = st.id_session_tool7_introcard_fk
							WHERE st.id_patient_fk = '.$id_patient.' AND st.session = 2 AND st.old = 0
					';
					$res2 = $this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res2))
					{
						$tools[$row['id_session_tool_pk']]['answers']['new'][$this->decode($row2['info'])][] = $this->decode($row2['answer']);
					}
					
					###
					
					$sql = 'SELECT st.text, stc.text as coupon, sta.text as answer
							FROM session_tool7_coupons_answers st
							INNER JOIN session_tool7_coupons stc ON stc.id_session_tool7_coupon_pk = st.id_session_tool7_coupon_fk
							INNER JOIN session_tool7_answers sta ON sta.id_session_tool7_answer_pk = st.id_session_tool7_answer_fk
							WHERE st.id_patient_fk = '.$id_patient.' AND st.session = 2 AND st.old = 0
					';
					$res2 = $this->dbQuery($sql);
					while($row2=mysql_fetch_assoc($res2))
					{
						if($row2['text'])
						{
							$tools[$row['id_session_tool_pk']]['answers']['new'][$this->decode($row2['coupon'])][] = $this->decode($row2['text']);
						}
						elseif($row2['answer'])
						{
							$tools[$row['id_session_tool_pk']]['answers']['new'][$this->decode($row2['coupon'])][] = $this->decode($row2['answer']);
						}
					}
					
					// jesli sa stare odpowiedzi
					if(!$flash)
					{
						$sql = 'SELECT st.answer, sti.info
								FROM session_tool7_introcard_answers st
								INNER JOIN session_tool7_introcard sti ON sti.id_session_tool7_introcard_pk = st.id_session_tool7_introcard_fk
								WHERE st.id_patient_fk = '.$id_patient.' AND st.session = 2 AND st.old = 1
						';
						$res2 = $this->dbQuery($sql);
						while($row2=mysql_fetch_assoc($res2))
						{
							$tools[$row['id_session_tool_pk']]['answers']['old'][$this->decode($row2['info'])][] = $this->decode($row2['answer']);
						}
						
						###
						
						$sql = 'SELECT st.text, stc.text as coupon, sta.text as answer
								FROM session_tool7_coupons_answers st
								INNER JOIN session_tool7_coupons stc ON stc.id_session_tool7_coupon_pk = st.id_session_tool7_coupon_fk
								INNER JOIN session_tool7_answers sta ON sta.id_session_tool7_answer_pk = st.id_session_tool7_answer_fk
								WHERE st.id_patient_fk = '.$id_patient.' AND st.session = 2 AND st.old = 1
						';
						$res2 = $this->dbQuery($sql);
						while($row2=mysql_fetch_assoc($res2))
						{
							if($row2['text'])
							{
								$tools[$row['id_session_tool_pk']]['answers']['old'][$this->decode($row2['coupon'])][] = $this->decode($row2['text']);
							}
							elseif($row2['answer'])
							{
								$tools[$row['id_session_tool_pk']]['answers']['old'][$this->decode($row2['coupon'])][] = $this->decode($row2['answer']);
							}
						}
					}
				}
				else
				{
					$tools[$row['id_session_tool_pk']]['answers'] = null;
				}
			}
			
			$mailbox = null;
			$permissions = new permissions($this->doctor['user_id']);
			if(!$flash && $permissions->isPermittedPart('mail'))
			{
				$mailbox = $this->mailbox();
			}
			
			// czas spedzony we flashu
			
			$sql = 'SELECT SUM(time) as spent_time FROM patients_activity WHERE id_patient_fk = '.$id_patient;
			$msec = $this->getOneValueFromSql($sql);
			
			$spentTime = floor($msec/60000);
			$msec-=$spentTime*60000;
			$spentTime.=' min ';
			$spentTime.=floor($msec/1000).' sec';
			
			return array(
				'spentTime'=>$spentTime,
				'tools'=>$tools,
				'patient'=>$patient,
				'stimulants'=>$stimulants,
				'mailbox'=>$mailbox,
				'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$id_patient)),
				'timeDetailsHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_TOOLS_SUMMARY, ID=>$id_patient, ID2=>1)),
				'template'=>'patientToolsSummary.tpl'
			);
		}
	}
	
	
	private function getPatientTimeDetails($id_patient)
	{
		$details = array();
		
		$sql = 'SELECT * FROM patients_activity WHERE id_patient_fk = '.$id_patient;
		$res = $this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$details[$row['module_type'].'_'.$row['activity_type']]['type'] = $row['module_type'].' ('.$row['activity_type'].')';
			$details[$row['module_type'].'_'.$row['activity_type']]['items'][] = $row['time'];
			if(!isset($details[$row['module_type'].'_'.$row['activity_type']]['totalTime']))
			{
				$details[$row['module_type'].'_'.$row['activity_type']]['totalTime'] = $row['time'];
			}
			else
			{
				$details[$row['module_type'].'_'.$row['activity_type']]['totalTime'] += $row['time'];
			}
			
			$msec = $details[$row['module_type'].'_'.$row['activity_type']]['totalTime'];
			
			$spentTime = floor($msec/60000);
			$msec-=$spentTime*60000;
			$spentTime.=' min ';
			$spentTime.=floor($msec/1000).' sec';
			
			$details[$row['module_type'].'_'.$row['activity_type']]['totalTimeText'] = $spentTime;
		}
		
		return array(
			'timeDetails'=>$details,
			'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_TOOLS_SUMMARY, ID=>$id_patient)),
			'template'=>'patientToolsTime.tpl'
		);
	}
	
	
	private function mailbox()
	{
		$list = array();
		$new = 0;
		
		$sql = 'SELECT m.*, d.last_name
				FROM mail m
				INNER JOIN doctors d ON d.id_doctor_pk = m.id_doctor_fk
				WHERE type = \'inbox\'
					  AND id_patient_fk = '.$this->params[ID].'
					  AND delete_inbox = 0
					  AND approved = 1
				ORDER BY date DESC
		';
		$res = $this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			if($this->params[DELETE] == $row['id_mail_pk'])
			{
				$sql = 'UPDATE mail SET delete_inbox = 1 WHERE id_mail_pk = '.$this->params[DELETE];
				$this->dbQuery($sql);
				$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS,SUBPART_ID=>PATIENTS_TOOLS_SUMMARY,ID=>$this->params[ID])));
			}
			elseif($this->params[ADD] == $row['id_mail_pk'])
			{
				$sql = 'UPDATE mail SET approved = 1 WHERE id_mail_pk = '.$this->params[ADD];
				$this->dbQuery($sql);
				$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS,SUBPART_ID=>PATIENTS_TOOLS_SUMMARY,ID=>$this->params[ID])));
			}
			else
			{
				//$date = explode('-', reset(explode(' ', )));
				
				$list[] = array(
					'from'=>'Dr '.$row['last_name'],
					'date'=>$row['date'],
					'subject'=>$row['subject'],
					'content'=>strip_tags($row['content']),
					'approved'=>$row['approved'],
					'delHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS,SUBPART_ID=>PATIENTS_TOOLS_SUMMARY,ID=>$this->params[ID],DELETE=>$row['id_mail_pk'])),
					'approveHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS,SUBPART_ID=>PATIENTS_TOOLS_SUMMARY,ID=>$this->params[ID],ADD=>$row['id_mail_pk'])),
				);
				
				if(!$row['is_read']) $new++;
			}
		}
		
		$user = $this->getSession(DOCTOR);
		
		
		$form=new form('newMsg');
		$showForm = false;
		
		
		$inp_subject=new formInputBox($form,'subject','','',true,0,'','subject','','');
		$inp_subject->init();
		if($form->isSubmitted() && $inp_subject->error)
		{
			$inp_subject->errMsg=$this->getText('form_pole_obowiazkowe');
		}
			
		$inp_message=new formTextArea($form,'message','','',true,0,'','calendarComment','','');
		$inp_message->init();
		if($form->isSubmitted() && $inp_message->error)
		{
			$inp_message->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		if($form->isSubmitted() && !$form->isValid())
		{
			$showForm = true;
		}
		elseif($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('mail');
			$q->addInt('id_patient_fk', $this->params[ID]);
			$q->addInt('id_doctor_fk', $user['user_id']);
			$q->addString('type','inbox');
			$q->addString('subject',strip_tags($inp_subject->value));
			$q->addString('content',strip_tags($inp_message->value));
			$q->addCurrentDateTime('date');
			$q->addInt('is_read', 0);
			
			// sprawdzam czy do akceptacji czy odrazu do pacjenta
			$sql = 'SELECT id_doctor_fk FROM patients WHERE id_patient_pk = '.$this->params[ID];
			if($this->getOneValueFromSql($sql) == $user['user_id'])
			{
				$q->addInt('approved', 1);
				$sql = 'SELECT email FROM patients WHERE id_patient_pk = '.$this->params[ID];
				$patient_email = $this->getOneValueFromSql($sql);
				$this->sendNewEmailNotification($patient_email, 1);
			}
			else
			{
				$q->addInt('approved', 0);
				$sql = 'SELECT d.email
						FROM patients p
						INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
						WHERE p.id_patient_pk = '.$this->params[ID];
				$doctor_email = $this->getOneValueFromSql($sql);
				$this->sendNewEmailNotification($doctor_email, 4);
				$this->setSessionMessage('approvalNeeded', 'Message was sent to PCP for approval');
			}
			
			$sql = $q->createInsert();
			$this->dbQuery($sql);
			$this->setSessionMessage('mailSent',1);
			
			$this->reload();
		}
		
		return array(
			'approval'=>$this->getSessionMessage('approvalNeeded'),
			'list'=>$list,
			'form'=>$form->smarty(),
			'showForm'=>$showForm,
			'new'=>$new,
		);
	}
	
	
	private function getPatientDoctors($id_patient)
	{
		$sql = "SELECT * FROM patients WHERE id_doctor_fk = {$this->doctor['user_id']} AND id_patient_pk = $id_patient";
		$patient = $this->getOneRowFromSql($sql);
		
		if(!$patient)
		{
			$sql = 'SELECT id_patient_doctor_pk
					FROM patients_doctors
					WHERE id_patient_fk = '.$id_patient.' AND id_doctor_fk = '.$this->doctor['user_id'].'
					LIMIT 1
			';
			if($this->getOneValueFromSql($sql))
			{
				$sql = "SELECT * FROM patients WHERE id_patient_pk = $id_patient";
				$patient = $this->getOneRowFromSql($sql);
			}
		}
		
		if($patient)
		{
			$form = new form('doctorsList');
			
			// zaznaczeni lekarze
			$active_doctors = array();
			if($form->isSubmitted())
			{
				if($this->getPOST('doctors'))
				{
					$active_doctors = $this->getPOST('doctors');
				}
				else
				{
					$form_error = 'At least one doctor required';
				}
			}
			else
			{
				$sql = 'SELECT id_doctor_fk FROM patients_doctors WHERE id_patient_fk = '.$id_patient;
				$res = $this->dbQuery($sql);
				while($row=mysql_fetch_assoc($res))
				{
					$active_doctors[] = $row['id_doctor_fk'];
				}
			}
			
			// wszyscy lekarze
			$doctors = array();
			$sql = 'SELECT id_doctor_pk, CONCAT(first_name,\' \',last_name) as fullname
					FROM doctors
					WHERE id_doctor_pk <> '.$this->doctor['user_id'].'
					ORDER BY last_name, first_name
			';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$doctors[] = array(
					'id'=>$row['id_doctor_pk'],
					'fullname'=>$row['fullname'],
					'checked'=>in_array($row['id_doctor_pk'], $active_doctors),
				);
			}
			
			if($form->isSubmitted() && !isset($form_error))
			{
				$sql = 'DELETE FROM patients_doctors WHERE id_patient_fk = '.$id_patient;
				$this->dbQuery($sql);
				foreach($doctors as $doctor)
				{
					if($doctor['checked']==true)
					{
						$q = new sqlQuery('patients_doctors');
						$q->addInt('id_patient_fk', $id_patient);
						$q->addInt('id_doctor_fk', $doctor['id']);
						$this->dbQuery($q->createInsert());
					}
				}
				$this->setSessionMessage('saved','Successfully saved');
			}
			
			return array(
				'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$id_patient)),
				'form'=>$form->smarty(),
				'formError'=>isset($form_error) ? $form_error : null,
				'doctors'=>$doctors,
				'saved'=>$this->getSessionMessage('saved'),
				'template'=>'patientDoctors.tpl'
			);
		}
		else
		{
			$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS)));
		}
	}
	
	
	private function getPatientAssessments($id_patient)
	{
		$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
		if(in_array($id_patient, $doctorPatients))
		{
			$sql = "SELECT study_id FROM patients WHERE id_patient_pk = $id_patient";
			$study_id = $this->getOneValueFromSql($sql);
		
			if($study_id)
			{
				$links = array();
				
				$sql = 'SELECT * FROM zsurvey_links';
				$res = $this->dbQuery($sql);
				while($row=mysql_fetch_assoc($res))
				{
					$links[] = array(
						'table'=>$this->decode($row['table']),
						'link'=>str_replace('*STUDY_ID*', $study_id, $row['link']),
					);
				}
				
				return array(
					'links'=>$links,
					'backHref'=>$this->getlink(array(PART_ID=>PART_PATIENTS, SUBPART_ID=>PATIENTS_SINGLE, ID=>$id_patient)),
					'template'=>'patientAssessments.tpl'
				);
			}
		}
		$this->redirect($this->getlink(array(PART_ID=>PART_PATIENTS)));
	}

	
	public function generateStudyID($id_site)
	{
		$sql = 'SELECT code FROM sites WHERE id_site_pk = '.$id_site;
		$site = $this->getOneValueFromSql($sql);
		
		$sql = 'SELECT study_id
				FROM patients
				WHERE study_id LIKE \'7'.$site.'%\'
				ORDER BY add_date DESC LIMIT 1';
		if($old_study = $this->getOneValueFromSql($sql))
		{
			$number = substr($old_study, 3, 3);
			
			//if($number < 999)
			{
				$number++;
				if(strlen($number) == 1) $number = '00'.$number;
				elseif(strlen($number) == 2) $number = '0'.$number;
			}
			//else
			//{
			//	$site++;
			//	$number = '000';
			//}
			
			return '7'.$site.$number.mt_rand(0,9);
		}
		
		return '7'.$site.'000'.mt_rand(0,9);
	}
	
	
	private function getQuestionnaireFields($req=true)
	{
		return array(
			array('name'=>'gender','req'=>true, 'question'=>1),
			array('name'=>'age', 'req'=>true, 'question'=>2),
			array('name'=>'requirements', 'req'=>true, 'question'=>3),
			array('name'=>'agreement', 'req'=>true, 'question'=>4),
			array('name'=>'assent', 'req'=>true, 'question'=>13),
			array('name'=>'refusal', 'req'=>!$req, 'question'=>5),
			array('name'=>'attend_school', 'req'=>$req, 'question'=>6),
			array('name'=>'school_grade', 'req'=>$req, 'question'=>7),
			array('name'=>'parents', 'req'=>$req, 'question'=>8),
			array('name'=>'parents_level', 'req'=>$req, 'question'=>9),
			array('name'=>'latino', 'req'=>$req, 'question'=>10),
			array('name'=>'race', 'req'=>$req, 'question'=>11),
			array('name'=>'may_use', 'req'=>$req, 'question'=>12),
		);
	}
	
	
	private function isValidDob($dob)
	{
		$dob = explode('/', $dob);
		if(count($dob)==3)
		{
			if(is_numeric($dob[0]) && is_numeric($dob[1]) && is_numeric($dob[2])) return true;
		}
		return false;
	}
	
	
	private function getPatientGroupID($age, $sex)
	{
		$sql = 'SELECT id FROM sm_Categories WHERE CategoryName = \'';
		if($age >= $this->getConfigValue('agelevel'))
		{
			$sql.='Older '.$sex.'\'';
		}
		else
		{
			$sql.='Younger '.$sex.'\'';
		}
		$myCategory = $this->getOneValueFromSql($sql);
		
		###
		
		$sql = 'SELECT Size FROM sm_BlockSizes WHERE CategoryID = '.$myCategory.' AND Selected = 1';
		$myBlockSize = $this->getOneValueFromSql($sql);
		if(!$myBlockSize) $myBlockSize = 0;
		
		###
		
		if(!$this->checkBlockUnassigned($myCategory, $myBlockSize))
		{
			$myBlockSize = $this->selectNewBlock($myCategory);
		}
		
		###
		
		if(!$this->checkBlockUnassigned($myCategory, $myBlockSize))
		{
			$myBlockSize = $this->selectNewBlock($myCategory);
			$this->resetUnassigned($myCategory, $myBlockSize);
		}
		
		$sql = 'SELECT id, GroupID
				FROM sm_CurrentGroupAssignments
				WHERE CategoryID = '.$myCategory.' AND Size = '.$myBlockSize.' AND Assigned = 0
				ORDER BY RAND()
				LIMIT 1
		';
		$row = $this->getOneRowFromSql($sql);
		
		$q = new sqlQuery('sm_CurrentGroupAssignments');
		$q->addInt('Assigned', 1);
		$this->dbQuery($q->createUpdate('id = '.$row['id']));
		
		return $row['GroupID'];
	}
	
	private function checkBlockUnassigned($category,$size)
	{
		$sql = 'SELECT COUNT(*) FROM sm_CurrentGroupAssignments WHERE CategoryID = '.$category.' AND Size = '.$size.' and Assigned = 0';
		return $this->getOneValueFromSql($sql);
	}
	
	private function selectNewBlock($category)
	{
		$q = new sqlQuery('sm_BlockSizes');
		$q->addInt('Selected', 0);
		$this->dbQuery($q->createUpdate('CategoryID = '.$category));
		
		$sql = 'SELECT id FROM sm_BlockSizes WHERE CategoryID = '.$category.' ORDER BY RAND() LIMIT 1';
		$idBlockSize = $this->getOneValueFromSql($sql);
		
		$q = new sqlQuery('sm_BlockSizes');
		$q->addInt('Selected', 1);
		$this->dbQuery($q->createUpdate('id = '.$idBlockSize));
		
		$sql = 'SELECT Size FROM sm_BlockSizes WHERE id = '.$idBlockSize;
		return $this->getOneValueFromSql($sql);
	}
	
	private function resetUnassigned($category,$size)
	{
		$q = new sqlQuery('sm_CurrentGroupAssignments');
		$q->addInt('Assigned', 1);
		$this->dbQuery($q->createUpdate('CategoryID = '.$category.' AND Size = '.$size));
		return true;
	}
	
	private function getDoctorType()
	{
		$doctor = $this->getSession('doctor');
		$sql = 'SELECT id_doctor_type_fk FROM doctors WHERE id_doctor_pk = '.$doctor['user_id'];
		return $this->getOneValueFromSql($sql);
	}
	
}
?>