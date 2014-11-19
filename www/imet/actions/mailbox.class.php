<?php
define('PART_MAILBOX','mailbox');
$GLOBALS['actionClasses'][PART_MAILBOX]='mailbox';

	define('MAILBOX_INBOX','inbox');
	define('MAILBOX_SENT','sent');


class mailbox extends projectCommon 
{
	public $params=array();
	public $conn=null;
	
	public $texts=array();
	public $doctor;
	
		
	public function __construct()
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		$this->texts = &$GLOBALS['portal']->texts;
		$this->doctor = $this->getSession(DOCTOR);
	}
	
	
	public function content()
	{
		$permissions = new permissions($this->doctor['user_id']);
		if(!$permissions->isPermittedPart('mail')) $this->redirect($this->getlink(array(PART_ID=>PART_MAIN)));
		
		$doctorPatients = $this->getDoctorsPatients($this->doctor['user_id']);
		$patients=array(array('key'=>0,'value'=>''));
		if(count($doctorPatients))
		{
			$sql = 'SELECT id_patient_pk,CONCAT(last_name,\' \',first_name) as fullname
					FROM patients
					WHERE id_patient_pk IN('.implode(',', $doctorPatients).')
					ORDER BY fullname';
			$res=$this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$patients[]=array(
					'key'=>$row['id_patient_pk'],
					'value'=>$row['fullname'],
					'selected'=>$this->params[ORDER]==$row['id_patient_pk'],
				);
			}
		}
		
		$inbox = $this->getBox(MAILBOX_INBOX);
		$sent  = $this->getBox(MAILBOX_SENT);
	
		$form=new form('newMsg');
		$showForm = false;
		$req_patients = false;
		$req_doctors = false;
		
		$sendTo = null;
		if($form->isSubmitted())
		{
			$sendTo = intval($this->getPOST('sendTo'));
			if(!$sendTo)
			{
				$form->error = 1;
			}
			else
			{
				if($sendTo==1)
				{
					$req_patients = true;
				}
				elseif($sendTo==2)
				{
					$req_doctors = true;
				}
				else
				{
					$form->error = 1;
				}
			}
		}
		
		###
		$inp_patients=new formSelect($form,'patients','patients','',$req_patients,'','','border:1px solid red','');
		if($req_patients)
		{
			$inp_patients->cssStyle='display:block;';
		}
		$inp_patients->source=$patients;
		$inp_patients->init();
		if($form->isSubmitted() and $inp_patients->error)
		{
			$inp_patients->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_doctors=new formSelect($form,'doctors','doctors','',$req_doctors,'','','border:1px solid red','');
		if($req_doctors)
		{
			$inp_doctors->cssStyle='display:block;';
		}
		$doctors=array(array('key'=>0,'value'=>''));
		
		$sql='SELECT id_doctor_pk,CONCAT(last_name,\' \',first_name) as fullname FROM doctors WHERE id_doctor_pk <> '.$this->doctor['user_id'].' ORDER BY fullname';
		$res=$this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$doctors[]=array('key'=>$row['id_doctor_pk'], 'value'=>$row['fullname']);
		}
		
		$inp_doctors->source=$doctors;
		$inp_doctors->init();
		if($form->isSubmitted() and $inp_doctors->error)
		{
			$inp_doctors->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
		$inp_msgTypes=new formSelect($form,'msgTypes','msgTypes','',false,'','','border:1px solid red','');
		$inp_msgTypes->source=array(
			array('key'=>'','value'=>''),
			array('key'=>'1','value'=>'Session 1 draft pending'),
			array('key'=>'2','value'=>'Session 1 email pending'),
			array('key'=>'3','value'=>'Session 1 Take 2 correction draft pending'),
			array('key'=>'4','value'=>'Session 2 draft pending'),
			array('key'=>'5','value'=>'Session 2 email pending'),
			array('key'=>'6','value'=>'Session 2 Take 2 correction draft pending'),
		);
		$inp_msgTypes->init();
		###
		$reqMsgTypePatients = false;
		if(in_array($inp_msgTypes->value, array(1,3,4,6)))
		{
			$reqMsgTypePatients = true;
		}
		$inp_msgTypePatients=new formSelect($form,'msgTypePatients','msgTypePatients','',$reqMsgTypePatients,'','','border:1px solid red','');
		$inp_msgTypePatients->source=array();
		if(count($doctorPatients))
		{
			$sql = 'SELECT id_patient_pk, CONCAT(last_name,\' \',first_name) as fullname
					FROM patients
					WHERE id_patient_pk IN('.implode(',', $doctorPatients).')
			';
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$inp_msgTypePatients->source[]=array('key'=>$row['id_patient_pk'],'value'=>$row['fullname']);
			}
		}
		$inp_msgTypePatients->init();
		###
		$inp_subject=new formInputBox($form,'subject','','',true,0,'','subject','','');
		$inp_subject->init();
		if($form->isSubmitted() && $inp_subject->error)
		{
			$inp_subject->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		###
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
			
			if($sendTo == 1) // do pacjenta
			{
				$q->addInt('id_patient_fk', $inp_patients->value);
				$q->addInt('id_doctor_fk', $this->doctor['user_id']);
				$q->addString('type','inbox');
				$q->addString('subject',strip_tags($inp_subject->value));
				$q->addString('content',strip_tags($inp_message->value));
				$q->addCurrentDateTime('date');
				$q->addInt('is_read', 0);
				
				// sprawdzam czy do akceptacji czy odrazu do pacjenta
				$sql = 'SELECT id_doctor_fk FROM patients WHERE id_patient_pk = '.$inp_patients->value;
				if($this->getOneValueFromSql($sql) == $this->doctor['user_id'])
				{
					$q->addInt('approved', 1);
					$sql = 'SELECT email FROM patients WHERE id_patient_pk = '.intval($inp_patients->value);
					$patient_email = $this->getOneValueFromSql($sql);
					$this->sendNewEmailNotification($patient_email, 1);
				}
				else
				{
					$q->addInt('approved', 0);
					$sql = 'SELECT d.email
							FROM patients p
							INNER JOIN doctors d ON d.id_doctor_pk = p.id_doctor_fk
							WHERE p.id_patient_pk = '.intval($inp_patients->value);
					$doctor_email = $this->getOneValueFromSql($sql);
					$this->sendNewEmailNotification($doctor_email, 4);
					$this->setSessionMessage('approvalNeeded', 'Message was sent to PCP for approval');
				}
			}
			elseif($sendTo==2) // do lekarza
			{
				$q->addInt('id_doctor_fk', $inp_doctors->value);
				$q->addInt('id_doctor2_fk', $this->doctor['user_id']);
				$q->addString('type','inbox');
				$q->addString('subject',strip_tags($inp_subject->value));
				$q->addString('content',strip_tags($inp_message->value));
				$q->addCurrentDateTime('date');
				$q->addInt('is_read', 0);
				$q->addInt('approved', 1);
				
				$sql = 'SELECT email FROM doctors WHERE id_doctor_pk = '.intval($inp_doctors->value);
				$patient_email = $this->getOneValueFromSql($sql);
				$this->sendNewEmailNotification($patient_email, 5);
				
				if(in_array($inp_msgTypes->value, array(1,2,3,4,5,6)) && in_array(intval($inp_msgTypePatients->value), $doctorPatients))
				{
					if($inp_msgTypes->value==1 || $inp_msgTypes->value==4)
					{
						$q2 = new sqlQuery('patients');
						$q2->addInt($inp_msgTypes->value==1?'session1_summary_mail':'session2_summary_mail', 0);
						$this->dbQuery($q2->createUpdate('id_patient_pk = '.intval($inp_msgTypePatients->value)));
					}
					elseif($inp_msgTypes->value==3 || $inp_msgTypes->value==6)
					{
						$q2 = new sqlQuery('patients');
						$q2->addInt($inp_msgTypes->value==3?'session1_take2_changed_mail':'session2_take2_changed_mail', 0);
						$this->dbQuery($q2->createUpdate('id_patient_pk = '.intval($inp_msgTypePatients->value)));
					}
					elseif($inp_msgTypes->value==2 || $inp_msgTypes->value==5)
					{
						$q->addInt('id_session_patient_fk', intval($inp_msgTypePatients->value));
						$q->addInt('session', $inp_msgTypes->value==2 ? 1 : 2);
					}
				}
			}
			$sql = $q->createInsert();
			$this->dbQuery($sql);
			
			//$this->setSessionMessage('mailSent',1);
			$this->reload();
		}
		
		return array(
			'approval'=>$this->getSessionMessage('approvalNeeded'),
			'sortLink'=>$this->getlink(array(PART_ID=>PART_MAILBOX, ORDER=>'*param1*')),
			'patients'=>$patients,
			'inbox'=>$inbox,
			'sent'=>$sent,
			'form'=>$form->smarty(),
			'formSendTo'=>$sendTo,
			'showForm'=>$showForm,
			'template'=>'mailbox.tpl',
		);
	}
	
	
	
	
	private function getBox($type)
	{
		$box = array(
			'new'=>0,
			'list'=>array(),
		);
		
		$sql_sort = null;
		if($this->params[ORDER])
		{
			$sql_sort = ' AND id_patient_fk = '.$this->params[ORDER];
		}
		
		if($type == MAILBOX_INBOX)
		{
			// MAILE WYSLANE OD PACJENTA DO LEKARZA
			$sql = 'SELECT m.*, CONCAT(p.first_name,\' \',p.last_name) as sender
					FROM mail m
					INNER JOIN patients p ON p.id_patient_pk = m.id_patient_fk
					WHERE m.id_doctor_fk = '.$this->doctor['user_id'].'
						  AND id_patient_fk IS NOT NULL
						  AND id_doctor2_fk IS NULL
						  AND type = \'sent\'
						  AND delete_inbox = 0
						  '.$sql_sort.'
			';
			
			// MAILE WYSLANE OD LEKARZA DO LEKARZA
			$sql.= 'UNION SELECT m.*, CONCAT(d.first_name,\' \',d.last_name) as sender
					FROM mail m
					INNER JOIN doctors d ON d.id_doctor_pk = m.id_doctor2_fk
					WHERE m.id_doctor_fk = '.$this->doctor['user_id'].'
						  AND id_patient_fk IS NULL
						  AND id_doctor2_fk IS NOT NULL
						  AND type = \'inbox\'
						  AND delete_inbox = 0
						  '.$sql_sort.'
			';
			
			// MAILE KTORE TRZEBA ZAAKCEPTOWAC
			$sql2 = 'SELECT id_patient_pk FROM patients WHERE id_doctor_fk = '.$this->doctor['user_id'];
			$res = $this->dbQuery($sql2);
			$additional = array();
			while($row = mysql_fetch_assoc($res))
			{
				$additional[] = $row['id_patient_pk'];
			}
			$sql_patients = null;
			if(count($additional))
			{
				$sql_patients = 'AND m.id_patient_fk IN ('.implode(',', $additional).')';
			}
			
			
			$sql.= 'UNION SELECT m.*, CONCAT(d.first_name,\' \',d.last_name) as sender
					FROM mail m
					INNER JOIN doctors d ON d.id_doctor_pk = m.id_doctor_fk
					WHERE id_doctor_fk IS NOT NULL
						  AND id_doctor2_fk IS NULL
						  AND type = \'inbox\'
						  AND delete_inbox = 0
						  AND approved = 0
						  '.$sql_patients.'
						  '.$sql_sort.'
					ORDER BY date DESC
			';
		}
		elseif($type == MAILBOX_SENT)
		{
			// MAILE WYSLANE OD LEKARZA DO PACJENTA
			$sql = 'SELECT m.*, CONCAT(p.first_name,\' \',p.last_name) as sender
					FROM mail m
					INNER JOIN patients p ON p.id_patient_pk = m.id_patient_fk
					WHERE m.id_doctor_fk = '.$this->doctor['user_id'].'
						  AND id_patient_fk IS NOT NULL
						  AND id_doctor2_fk IS NULL
						  AND type = \'inbox\'
						  AND delete_sent = 0
						  '.$sql_sort.'
			';
			
			// MAILE WYSLANE OD LEKARZA DO LEKARZA
			$sql.= 'UNION SELECT m.*, CONCAT(d.first_name,\' \',d.last_name) as sender
					FROM mail m
					INNER JOIN doctors d ON d.id_doctor_pk = m.id_doctor_fk
					WHERE m.id_doctor2_fk = '.$this->doctor['user_id'].'
						  AND id_patient_fk IS NULL
						  AND id_doctor_fk IS NOT NULL
						  AND type = \'inbox\'
						  AND delete_sent = 0
						  '.$sql_sort.'
					ORDER BY date DESC
			';
		}
		$res = $this->dbQuery($sql);
		while($row = mysql_fetch_assoc($res))
		{
			if($type==MAILBOX_INBOX && $this->params[ACTIVATE]==$row['id_mail_pk'])
			{
				$sql = 'UPDATE mail SET is_read=1 WHERE id_mail_pk = '.$this->params[ACTIVATE];
				$this->dbQuery($sql);
				$this->redirect($this->getlink(array(PART_ID=>PART_MAILBOX)));
			}
			elseif($type==MAILBOX_INBOX && $this->params[APPROVE]==$row['id_mail_pk'])
			{
				$sql = 'UPDATE mail SET approved=1 WHERE id_mail_pk = '.$this->params[APPROVE];
				$this->dbQuery($sql);
				
				$sql = 'SELECT email FROM patients WHERE id_patient_pk = '.$row['id_patient_fk'];
				$patient_email = $this->getOneValueFromSql($sql);
				$this->sendNewEmailNotification($patient_email, 1);
				
				$this->redirect($this->getlink(array(PART_ID=>PART_MAILBOX)));
			}
			elseif($type==MAILBOX_INBOX && intval($this->getPOST('edit_id'))==$row['id_mail_pk'])
			{
				$subject = mysql_real_escape_string(strip_tags($this->getPOST('editSubject')));
				$msg = mysql_real_escape_string(strip_tags($this->getPOST('editMessage')));
				if($subject && $msg)
				{
					$sql = 'UPDATE mail SET subject=\''.$subject.'\', content = \''.$msg.'\' WHERE id_mail_pk = '.$row['id_mail_pk'];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>PART_MAILBOX)));
				}
			}
			elseif($this->params[SUBPART_ID] && $this->params[DELETE]==$row['id_mail_pk'])
			{
				if($this->params[SUBPART_ID]==MAILBOX_INBOX)
				{
					$sql = 'UPDATE mail SET delete_inbox = 1 WHERE id_mail_pk = '.$this->params[DELETE];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>PART_MAILBOX)));
				}
				elseif($this->params[SUBPART_ID]==MAILBOX_SENT)
				{
					$sql = 'UPDATE mail SET delete_sent = 1 WHERE id_mail_pk = '.$this->params[DELETE];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>PART_MAILBOX)));
				}
			}
			
			if($row['approved']==0 && $type == MAILBOX_INBOX)
			{
				$sql = 'SELECT id_doctor_fk FROM patients WHERE id_patient_pk = '.$row['id_patient_fk'];
				if($this->getOneValueFromSql($sql) != $this->doctor['user_id'])
				{
					continue;
				}
			}
			
			if($row['type']=='sent' && $row['id_patient_fk'] && $row['id_doctor_fk'])
			{
				$sender_id = $row['id_patient_fk'];
			}
			elseif($row['type']=='inbox' && $row['id_doctor_fk'] && $row['id_doctor2_fk'])
			{
				$sender_id = $row['id_doctor2_fk'];
			}
			else
			{
				$sender_id = null;
			}
			
			$box['list'][] = array(
				'id'=>$row['id_mail_pk'],
				'sender'=>($row['id_patient_fk']) ? $row['sender'] : 'Dr. '.$row['sender'],
				'sender_type'=>($row['id_patient_fk']) ? 1 : 2,
				'sender_id'=>$sender_id,
				'date'=>$row['date'],
				'subject'=>$row['subject'],
				'content'=>strip_tags($this->decode($row['content'])),
				'read'=>$row['is_read'],
				'approved'=>$row['approved'],
				'readHref'=>$this->getlink(array(PART_ID=>PART_MAILBOX, SUBPART_ID=>$type, ACTIVATE=>$row['id_mail_pk'])),
				'approveHref'=>$this->getlink(array(PART_ID=>PART_MAILBOX, SUBPART_ID=>$type, APPROVE=>$row['id_mail_pk'])),
				'delHref'=>$this->getlink(array(PART_ID=>PART_MAILBOX, SUBPART_ID=>$type, DELETE=>$row['id_mail_pk'])),
			);
			
			if(!$row['is_read'] && $type == MAILBOX_INBOX) $box['new']++;
		}
		
		return $box;
	}
	
}
?>