<?php
define('TOOL_DOCTORS','toolDoctors');
$GLOBALS['toolClasses'][TOOL_DOCTORS]='toolDoctors';

	define('DOCTORS_SITES','sites');
	define('DOCTORS_ICONS','icons');

class toolDoctors extends projectCommon 
{
	public $params=array();
	public $conn=null;
	public $texts=array();
	public $navigation=array();
	
	function __construct()
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		$this->navigation = &$GLOBALS['portal']->navigation;
		$this->texts = &$GLOBALS['portal']->texts;
	}
	

	public function content()
	{
		if($this->params[SUBPART_ID]==DOCTORS_ICONS)
		{
			return $this->doctorsIcons();
		}
		elseif($this->params[SUBPART_ID]==DOCTORS_SITES)
		{
			if($this->params[ADD]==1)
			{
				return $this->getDoctorsSite(0);
			}
			elseif($this->params[ID])
			{
				return $this->getDoctorsSite($this->params[ID]);
			}
			return $this->doctorsSites();
		}
		else
		{
			if($this->params[ADD])
			{
				return $this->getOneDoctor();
			}
			
			if($this->params[ID])
			{
				return $this->getOneDoctor($this->params[ID]);
			}
			
			
			$sql = 'SELECT d.*, dt.title as role
					FROM doctors d
					INNER JOIN doctors_types dt ON dt.id_doctor_type_pk = d.id_doctor_type_fk
					ORDER BY d.login
			';
			$res = $this->dbQuery($sql);
			
			$doctors = array();
			
			while($row=mysql_fetch_assoc($res))
			{
				if($this->params[DELETE] == $row['id_doctor_pk'])
				{
					$sql='DELETE FROM doctors WHERE id_doctor_pk = '.$this->params[DELETE];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>TOOL_DOCTORS)));
				}
				
				$doctors[]=array(
					'login'=>$this->decode($row['login']),
					'name'=>$this->decode($row['first_name']),
					'surname'=>$this->decode($row['last_name']),
					'role'=>$this->decode($row['role']),
					'href'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS, ID=>$row['id_doctor_pk'])),
					'delHref'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS, DELETE=>$row['id_doctor_pk'])),
				);
			}
			
			return array(
				'toolSaved'=>$this->getSessionMessage('toolSaved'),
				'doctors'=>$doctors,
				'newHref'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS, ADD=>1)),
				'template'=>'admin/toolDoctors.tpl',
			);
		}
	}
	
	
	private function getOneDoctor($edit = null)
	{
		$doctor = array();
		
		if($edit)
		{
			$sql='SELECT * FROM doctors WHERE id_doctor_pk='.$edit;
			if(!$doctor=$this->getOneRowFromSql($sql))
			{
				$this->redirect($this->getlink(array(PART_ID=>TOOL_DOCTORS)));
			}
		}
		
		$form=new form('doctor');
		
		$inp_login=new formInputBox($form,'login','',$this->getField('login',$doctor),true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_login->init();
		if($form->isSubmitted() && $inp_login->error)
		{
			$inp_login->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_pass1=new formInputBox($form,'pass1','','',$edit?false:true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_pass1->type = INPUTBOX_PASSWORD;
		$inp_pass1->init();
		if($form->isSubmitted() && $inp_pass1->error)
		{
			$inp_pass1->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_pass2=new formInputBox($form,'pass2','','',$edit?false:true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_pass2->type = INPUTBOX_PASSWORD;
		$inp_pass2->init();
		if($form->isSubmitted() && $inp_pass2->error)
		{
			$inp_pass2->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		if($form->isSubmitted() && !$inp_pass1->error && !$inp_pass2->error && $inp_pass1->value != $inp_pass2->value)
		{
			$inp_pass1->errMsg=$this->getText('form_pole_obowiazkowe');
			$inp_pass2->errMsg=$this->getText('form_pole_obowiazkowe');
			$inp_pass1->error = true;
			$inp_pass2->error = true;
		}
		
		$inp_passhint=new formInputBox($form,'passhint','',$this->getField('password_hint',$doctor),true,255,'width:648px;','adminInput','border:1px solid red;width:648px;','');
		$inp_passhint->init();
		if($form->isSubmitted() && $inp_passhint->error)
		{
			$inp_passhint->errMsg=$this->getText('form_pole_obowiazkowe');
		}

		$inp_name=new formInputBox($form,'name','',$this->getField('first_name',$doctor),true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_name->init();
		if($form->isSubmitted() && $inp_name->error)
		{
			$inp_name->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_surname=new formInputBox($form,'surname','',$this->getField('last_name',$doctor),true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_surname->init();
		if($form->isSubmitted() && $inp_surname->error)
		{
			$inp_surname->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_email=new formInputBox($form,'email','',$this->getField('email',$doctor),true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_email->init();
		if($form->isSubmitted() && $inp_email->error)
		{
			$inp_email->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_email2=new formInputBox($form,'email2','',$this->getField('email2',$doctor),true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_email2->init();
		if($form->isSubmitted() && $inp_email2->error)
		{
			$inp_email2->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_organization=new formInputBox($form,'organization','',$this->getField('organization',$doctor),true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_organization->init();
		if($form->isSubmitted() && $inp_organization->error)
		{
			$inp_organization->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_phone1=new formInputBox($form,'phone1','',$this->getField('telephone1',$doctor),true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_phone1->init();
		if($form->isSubmitted() && $inp_phone1->error)
		{
			$inp_phone1->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_phone2=new formInputBox($form,'phone2','',$this->getField('telephone2',$doctor),true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_phone2->init();
		if($form->isSubmitted() && $inp_phone2->error)
		{
			$inp_phone2->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$doctorType = null;
		if(!$edit)
		{
			$inp_type=new formSelect($form,'type','typeSelect',$this->getField('id_doctor_type_fk',$doctor),true,'width:200px;','','width:200px;border:1px solid red','');
			$typesList = array(array('key'=>0,'value'=>''));
			$sql='SELECT id_doctor_type_pk,title FROM doctors_types';
			$res=$this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$typesList[] = array('key'=>$row['id_doctor_type_pk'], 'value'=>$this->decode($row['title']));
			}
			$inp_type->source=$typesList;
			$inp_type->init();
			if($form->isSubmitted() and $inp_type->error)
			{
				$inp_type->errMsg=$this->getText('form_pole_obowiazkowe');
			}
		}
		else
		{
			$sql='SELECT title FROM doctors_types WHERE id_doctor_type_pk = '.$doctor['id_doctor_type_fk'];
			$doctorType = $this->getOneValueFromSql($sql);
		}
		
		$inp_notes=new formInputBox($form,'notes','',$this->getField('notes',$doctor),true,255,'width:648px;','adminInput','border:1px solid red;width:648px;','');
		$inp_notes->init();
		if($form->isSubmitted() && $inp_notes->error)
		{
			$inp_notes->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_disabled=new formCheckBox($form,'disabled','disabled','',false);
		$inp_disabled->cssStyle='vertical-align:middle';
		if($this->getField('disabled', $doctor))
		{
			$inp_disabled->checked = true;
		}
		$inp_disabled->init();
		
		### site ###
		
		$doctorSites = array();
		if($edit)
		{
			$sql = 'SELECT * FROM sites_doctors WHERE id_doctor_fk = '.$edit;
			$res = $this->dbQuery($sql);
			while($row=mysql_fetch_assoc($res))
			{
				$doctorSites[]=$row['id_site_fk'];
			}
		}
		
		$inp_site=new formSelect($form,'site','typeSelect',$doctorSites,true,'width:400px;','','width:400px;border:1px solid red','');
		//$inp_site->value=
		$sitesList = array();
		$sql='SELECT id_site_pk,name FROM sites';
		$res=$this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$sitesList[] = array('key'=>$row['id_site_pk'], 'value'=>$this->decode($row['name']));
		}
		$inp_site->source=$sitesList;
		$inp_site->size=10;
		$inp_site->multiple=true;
		$inp_site->init();
		if($form->isSubmitted() and $inp_site->error)
		{
			$inp_site->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		
		### ico ###
		
		$inp_ico=new formInputBox($form,'ico','doctorIcoId',$this->getField('id_doctor_icon_fk',$doctor),true,255,'','','','');
		$inp_ico->type = INPUTBOX_HIDDEN;
		$inp_ico->init();
		
		$icons = array();
		
		$sql = 'SELECT * FROM doctors_icons';
		$res = $this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$file = $this->getCMSFileInfo($row['id_file_fk']);
			if(isset($file['www_path']))
			{
				$icons[] = array(
					'id'=>$row['id_doctors_icon_pk'],
					'img'=>$file['www_path'],
					'selected'=>$inp_ico->value == $row['id_doctors_icon_pk'],
				);
			}
		}
		
		### uprawnienia ###
		
		$roles = array(
			'1'=>array('title'=>'patient_information','checked'=>false),
			'2'=>array('title'=>'events','checked'=>false),
			'3'=>array('title'=>'substance_list','checked'=>false),
			'4'=>array('title'=>'eligibility_results','checked'=>false),
			'5'=>array('title'=>'journal','checked'=>false),'',
			'6'=>array('title'=>'tools_summary','checked'=>false),
			'7'=>array('title'=>'mail','checked'=>false),
			'8'=>array('title'=>'doctors','checked'=>false),
			'9'=>array('title'=>'assessments','checked'=>false),
			'10'=>array('title'=>'add_new_patient','checked'=>false),
		);
		if(!$form->isSubmitted() && $edit)
		{
			$sql = 'SELECT * FROM doctors_roles WHERE id_doctor_fk = '.$this->params[ID];
			if($row = $this->getOneRowFromSql($sql))
			{
				foreach($row as $key=>$value)
				{
					foreach($roles as $i=>$role)
					{
						if($role['title']===$key && $value)
						{
							$roles[$i]['checked'] = true;
							break;
						}
					}
				}
			}
		}
		else
		{
			if($this->getPOST('roles'))
			{
				foreach($this->getPOST('roles') as $item)
				{
					if(isset($roles[$item]))
					{
						$roles[$item]['checked'] = true;
					}
				}
			}
		}

		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('doctors');
			if(!$edit) $q->addInt('id_doctor_type_fk', $inp_type->value);
			if(intval($inp_ico->value))
			{
				$q->addInt('id_doctor_icon_fk', intval($inp_ico->value));
			}
			else
			{
				$q->addNull('id_doctor_icon_fk');
			}
			$q->addString('login', strip_tags($inp_login->value));
			if($inp_pass1->value && $inp_pass2->value)
			{
				$q->addString('password', md5($inp_pass1->value));
			}
			$q->addString('password_hint', strip_tags($inp_passhint->value));
			$q->addString('first_name', strip_tags($inp_name->value));
			$q->addString('last_name', strip_tags($inp_surname->value));
			$q->addString('email', strip_tags($inp_email->value));
			if($inp_email2->value) $q->addString('email2', strip_tags($inp_email2->value));
			else $q->addNull('email2');
			$q->addString('organization', strip_tags($inp_organization->value));
			$q->addString('site_name', strip_tags($inp_site->value));
			$q->addString('telephone1', strip_tags($inp_phone1->value));
			$q->addString('telephone2', strip_tags($inp_phone2->value));
			$q->addString('notes', strip_tags($inp_notes->value));
			if($inp_disabled->checked)
			{
				$q->addInt('disabled', 1);
			}
			else
			{
				$q->addInt('disabled', 0);
			}
			
			if($edit)
			{
				$sql = $q->createUpdate('id_doctor_pk ='.$edit);
				$this->dbQuery($sql);
			}
			else
			{
				$sql = $q->createInsert();
				$this->dbQuery($sql);
				$id_doctor = mysql_insert_id();
			}
			
			// sites
			if($edit)
			{
				$sql = 'DELETE FROM sites_doctors WHERE id_doctor_fk = '.$edit;
				$this->dbQuery($sql);
			}
			
			foreach($inp_site->value as $id_site)
			{
				$q = new sqlQuery('sites_doctors');
				$q->addInt('id_site_fk', $id_site);
				$q->addInt('id_doctor_fk', $edit?$edit:$id_doctor);
				$this->dbQuery($q->createInsert());
			}
			
			// roles
			$q = new sqlQuery('doctors_roles');
			if($edit)
			{
				$q->addInt('id_doctor_fk', $this->params[ID]);
			}
			else
			{
				$q->addInt('id_doctor_fk', $id_doctor);
			}
			foreach($roles as $role)
			{
				$q->addInt($role['title'], $role['checked'] ? 1 : 0);
			}
			
			if($edit)
			{
				$this->dbQuery($q->createUpdate('id_doctor_fk = '.$edit));
			}
			else
			{
				$this->dbQuery($q->createInsert());
			}
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			
			if($this->getPOST('backToList') || !$edit) $this->redirect($this->getlink(array(PART_ID=>TOOL_DOCTORS)));
			else $this->reload();
		}
		
		return array(
			'singleDoctor'=>true,
			'icons'=>$icons,
			'roles'=>$roles,
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'form'=>$form->smarty(),
			'addNew'=>($edit) ? false : true,
			'edit'=>($edit) ? true : false,
			'doctorType'=>$doctorType,
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS)),
			'template'=>'admin/toolDoctors.tpl',
		);
	}
	
	
	private function doctorsIcons()
	{
		$icons = array();
		
		$sql = 'SELECT * FROM doctors_icons';
		$res = $this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			$file = $this->getCMSFileInfo($row['id_file_fk']);
			
			if(isset($file['www_path']))
			{
				if($this->params[DELETE]==$row['id_doctors_icon_pk'])
				{
					$sql = 'DELETE FROM admin_files WHERE id_file_pk = '.$row['id_file_fk'];
					$this->dbQuery($sql);
					
					unlink($file['file_path']);
					
					$sql = 'DELETE FROM doctors_icons WHERE id_doctors_icon_pk = '.$this->params[DELETE];
					$this->dbQuery($sql);
					$this->redirect($this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_ICONS)));
				}
				
				
				$icons[] = array(
					'id'=>$row['id_doctors_icon_pk'],
					'img'=>$file['www_path'],
					'delHref'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_ICONS, DELETE=>$row['id_doctors_icon_pk'])),
				);
			}
		}
		
		$form = new form('iconsForm');
		
		$allowed_ext   = $this->mimes['img']['ext'];
		$allowed_mimes = $this->mimes['img']['mime'];
		
		$inp_icon=new formFile($form,'icon',true,'','','','');
        $inp_icon->fieldSize=50;
        $inp_icon->allowed_fileSize=1048576; // 1MB
        $inp_icon->allowed_extensions=$allowed_ext;
        $inp_icon->allowed_mimes=$allowed_mimes;
        $inp_icon->init();
        if($inp_icon->isSubmitted)
        {
            if($inp_icon->error)
            {
                if($inp_icon->error_noFile)
                {
                    $inp_icon->errMsg=$this->getText('form_pole_obowiazkowe');
                }
                else
                {
	                if($inp_icon->error_fileSize)
	                {
	                    $inp_icon->errMsg=$this->getText('form_plik_za_duzy_max_1MB');
	                }
	                elseif($inp_icon->error_fileExtension)
	                {
	                    $inp_icon->errMsg=$this->getText('form_niedozwolone_rozszerzenie_pliku');/*.' '.implode(',',$inp_icon->allowed_extensions);*/
	                }
	                elseif($inp_icon->error_fileMime)
	                {
	                    $inp_icon->errMsg=$this->getText('form_niedozwolone_mime_pliku');/*.' '.implode(',',$inp_icon->allowed_mimes);*/
	                }
                }
            }
            else
            {
	            if($inp_icon->uploaded_filePath)
	            {
	            	$filename = $this->create_token().'.'.strtolower($inp_icon->uploaded_fileExtension);
	            	
            		copy($inp_icon->uploaded_filePath, FILE_DIR.'doctors_icons/_'.$filename);
            		$thumb = new imageThumb('doctors_icons/_'.$filename);
            		$temp_img = $thumb->resizeInscribed(100, 100);
            		copy($thumb->resultLocalPath, FILE_DIR.'doctors_icons/'.$filename);
            		unlink(FILE_DIR.'doctors_icons/_'.$filename);
            		
            		$q = new sqlQuery('admin_files');
            		$q->addString('folderpath', '/doctors_icons');
            		$q->addString('file', $filename);
            		$this->dbQuery($q->createInsert());
            		
            		$id_file = mysql_insert_id();
            		
            		$q = new sqlQuery('doctors_icons');
            		$q->addInt('id_file_fk', $id_file);
            		$this->dbQuery($q->createInsert());
            		
            		$this->reload();
	            }
            }
        }
		
		return array(
			'icons'=>$icons,
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'form'=>$form->smarty(),
			'template'=>'admin/toolDoctorsIcons.tpl',
		);
	}
	
	
	private function doctorsSites()
	{
		$list = array();
		
		$sql = 'SELECT * FROM sites ORDER BY code';
		$res = $this->dbQuery($sql);
		while($row=mysql_fetch_assoc($res))
		{
			if($this->params[DELETE]==$row['id_site_pk'])
			{
				$sql = 'DELETE FROM sites WHERE id_site_pk = '.$row['id_site_pk'];
				$this->dbQuery($sql);
				$this->redirect($this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_SITES)));
			}
			
			$sql = 'SELECT COUNT(id_site_doctor_pk) FROM sites_doctors WHERE id_site_fk = '.$row['id_site_pk'];
			$quantityDoctors = $this->getOneValueFromSql($sql);
			
			$sql = 'SELECT COUNT(*) FROM patients WHERE id_site_fk = '.$row['id_site_pk'];
			$quantityPatients = $this->getOneValueFromSql($sql);
			
			$list[] = array(
				'name'=>$this->decode($row['name']),
				'code'=>$this->decode($row['code']),
				'quantityDoctors'=>$quantityDoctors,
				'quantityPatients'=>$quantityPatients,
				'href'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_SITES, ID=>$row['id_site_pk'])),
				'delHref'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_SITES, DELETE=>$row['id_site_pk'])),
			);
		}
		
		return array(
			'newHref'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_SITES, ADD=>1)),
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'list'=>$list,
			'template'=>'admin/toolDoctorsSites.tpl',
		);
	}
	
	
	private function getDoctorsSite($id_site)
	{
		$site = array();
		
		if($id_site)
		{
			$sql = 'SELECT * FROM sites WHERE id_site_pk = '.$id_site;
			$site = $this->getOneRowFromSql($sql);
			if(!$site) $this->redirect($this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_SITES)));
		}
		
		$form=new form('doctor');
		
		$inp_name=new formInputBox($form,'name','',$this->getField('name',$site),true,255,'width:200px;','adminInput','border:1px solid red;width:200px;','');
		$inp_name->init();
		if($form->isSubmitted() && $inp_name->error)
		{
			$inp_name->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_code=new formInputBox($form,'code','',$this->getField('code',$site),$id_site?false:true,2,'width:100px;','adminInput','border:1px solid red;width:100px;','');
		if($id_site)
		{
			$inp_code->disabled=true;
		}
		$inp_code->init();
		if($form->isSubmitted() && !$id_site)
		{
			if($inp_code->error)
			{
				$inp_code->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			elseif(strlen($inp_code->value)!=2 || !intval($inp_code->value))
			{
				$inp_code->error = 1;
				$inp_code->errMsg='Code must be a two digit';
			}
		}
		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('sites');
			$q->addString('name', strip_tags($inp_name->value));
			if($id_site)
			{
				$sql = $q->createUpdate('id_site_pk = '.$id_site);
			}
			else
			{
				$q->addString('code', intval($inp_code->value));
				$sql = $q->createInsert();
			}
			$this->dbQuery($sql);
			
			$this->setSessionMessage('toolSaved','Successfully saved');
			if($this->getPOST('backToList') || !$id_site) $this->redirect($this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_SITES)));
		}
		
		return array(
			'form'=>$form->smarty(),
			'singleSite'=>true,
			'edit'=>$id_site,
			'toolSaved'=>$this->getSessionMessage('toolSaved'),
			'backHref'=>$this->getlink(array(PART_ID=>TOOL_DOCTORS, SUBPART_ID=>DOCTORS_SITES)),
			'template'=>'admin/toolDoctorsSites.tpl',
		);
	}
	
	
	private function getField($name, $fields)
	{
		if(isset($fields[$name])) return $fields[$name];
		else return null;
	}

}


?>