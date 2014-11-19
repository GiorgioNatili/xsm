<?php
define('PART_PROFILE','profile');
$GLOBALS['actionClasses'][PART_PROFILE]='profile';

	define('PROFILE_LOGOUT','logout');
	define('PROFILE_EDITPASS','edit-pass');
	
	define('DOCTOR','doctor');
	define('ADMIN','admin');

class profile extends projectCommon 
{
	
	public $params=array();
	public $conn=null;
	public $navigation=array();
	public $texts=array();
	
		
	public function __construct()
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		$this->navigation = &$GLOBALS['portal']->navigation;
		$this->texts = &$GLOBALS['portal']->texts;
	}
	
	
	public function content()
	{
		switch ($this->params[SUBPART_ID])
		{
			case PROFILE_EDITPASS:
				return $this->editPasswordForm();
			break;
		}
	}
	
	
	public function loginForm()
	{
		$form=new form('formLogin');
			
		$inp_login=new formInputBox($form,'login','','',true,255,'','','','');
		$inp_login->init();
		if($form->isSubmitted() && $inp_login->error)
		{
			$inp_login->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_pass=new formInputBox($form,'password','','',true,255,'','','','');
		$inp_pass->type=INPUTBOX_PASSWORD;
		$inp_pass->init();
		if($form->isSubmitted() && $inp_pass->error)
		{
			$inp_pass->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		
		if($form->isSubmitted() && $form->isValid())
		{
			$sql = "SELECT *
					FROM doctors
					WHERE password LIKE '".md5($inp_pass->value)."' AND login LIKE '".mysql_real_escape_string($inp_login->value)."' AND disabled = 0";
			$row = $this->getOneRowFromSql($sql);
			if($row)
			{
				$user = array(
					'user_id'=>$row['id_doctor_pk'],
					'login'=>$this->decode($row['login']),
					'first_name'=>$this->decode($row['first_name']),
					'last_name'=>$this->decode($row['last_name']),
					'full_name'=>$this->decode($row['first_name']).' '.$this->decode($row['last_name']),
				);
				$this->setSession(DOCTOR, $user);
				$this->reload();
			}
			else
			{
				$sql = "SELECT *
						FROM admin_users
						WHERE password LIKE '".md5($inp_pass->value)."' AND username LIKE '".mysql_real_escape_string($inp_login->value)."' AND disabled = 0";
				$row = $this->getOneRowFromSql($sql);
				if($row)
				{
					$admin = array(
						'admin_id'=>$row['id_user_pk'],
						'full_name'=>$this->decode($row['fullname']),
					);
					$this->setSession(ADMIN, $admin);
					$this->reload();
				}
				else
				{
					$inp_login->error=1;
					$inp_pass->error=1;
					$inp_pass->errMsg='The username or password you entered is incorrect';
				}
			}
		}
		
		
		return array(
			'form'=>$form->smarty(),
			'template'=>'login.tpl',
		);
	}
	
	
	public function editPasswordForm()
	{
		$doctor = $this->getSession(DOCTOR);
		
		$form=new form('formEditPass');

		$inp_oldpass=new formInputBox($form,'oldpass','','',true,255,'','','','');
		$inp_oldpass->type=INPUTBOX_PASSWORD;
		$inp_oldpass->init();
		if($form->isSubmitted())
		{
			if($inp_oldpass->error)
			{
				$inp_oldpass->errMsg=$this->getText('form_pole_obowiazkowe');
			}
			elseif(!$this->isDoctorPassword($doctor, $inp_oldpass->value))
			{
				$inp_oldpass->errMsg=$this->getText('form_invalid_pass');
				$inp_oldpass->error = 1;
			}
		}
		
		$inp_newpass1=new formInputBox($form,'newpass1','','',true,255,'','','','');
		$inp_newpass1->type=INPUTBOX_PASSWORD;
		$inp_newpass1->init();
		if($form->isSubmitted() && $inp_newpass1->error)
		{
			$inp_newpass1->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		$inp_newpass2=new formInputBox($form,'newpass2','','',true,255,'','','','');
		$inp_newpass2->type=INPUTBOX_PASSWORD;
		$inp_newpass2->init();
		if($form->isSubmitted() && $inp_newpass2->error)
		{
			$inp_newpass2->errMsg=$this->getText('form_pole_obowiazkowe');
		}
		
		if($form->isSubmitted() && $inp_newpass1->value != $inp_newpass2->value)
		{
			$inp_newpass1->error = 1;
			$inp_newpass2->error = 1;
			$inp_newpass2->errMsg=$this->getText('form_new_pass_error');
		}
		
		
		if($form->isSubmitted() && $form->isValid())
		{
			$q = new sqlQuery('doctors');
			$q->addString('password', md5($inp_newpass1->value));
			$this->dbQuery($q->createUpdate('id_doctor_pk = '.$doctor['user_id']));
			$this->setSessionMessage('passwordSaved', 'Password has been changed');
			$this->reload();
		}
		
		
		return array(
			'passwordSaved'=>$this->getSessionMessage('passwordSaved'),
			'form'=>$form->smarty(),
			'template'=>'passwordEdit.tpl',
		);
	}


	public function getUserInfo()
	{
		if($user = $this->getSession(DOCTOR))
		{
			$user['helpHref'] = $this->getlink(array(PART_ID=>PART_STATIC, ID=>3));
			$user['logoutHref'] = $this->getlink(array(PART_ID=>PROFILE_LOGOUT));
			$user['editPassHref'] = $this->getlink(array(PART_ID=>PART_PROFILE, SUBPART_ID=>PROFILE_EDITPASS));
			
			return $user;
		}
		elseif($admin = $this->getSession(ADMIN))
		{
			$admin['logoutHref'] = $this->getlink(array(PART_ID=>PROFILE_LOGOUT));
			
			return $admin;
		}
		
		return false;
	}


	public function userLogout()
	{
		$this->unsetSession(DOCTOR);
		$this->unsetSession(ADMIN);
		
		$this->redirect($this->getlink(array(PART_ID=>PART_MAIN)));
	}
	
	
	private function isDoctorPassword($doctor, $pass)
	{
		$sql = 'SELECT login FROM doctors
				WHERE password = \''.md5($pass).'\' AND id_doctor_pk = '.$doctor['user_id'].'
		';
		if($this->getOneValueFromSql($sql))
		{
			return true;
		}
		return false;
	}
	
}
?>