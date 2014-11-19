<?php

class permissions extends projectCommon 
{
	public $params=array();
	public $conn=null;

	public  $id_doctor = null;
	private $perms = array();
		
	public function __construct($id_doctor)
	{
		$this->conn = $GLOBALS['portal']->conn;
		$this->params = &$GLOBALS['portal']->params;
		$this->id_doctor = $id_doctor;
		if($this->id_doctor)
		{
			$this->getDoctorPermissions();
		}
	}
	
	
	private function getDoctorPermissions()
	{
		$sql = 'SELECT * FROM doctors_roles WHERE id_doctor_fk = '.$this->id_doctor;
		if($row = $this->getOneRowFromSql($sql))
		{
			foreach($row as $key=>$value)
			{
				if(!in_array($key, array('id_doctor_role_pk', 'id_doctor_fk')))
				{
					$this->perms[$key] = $value;
				}
			}
			
			$sql = 'SELECT id_doctor_type_fk FROM doctors WHERE id_doctor_pk = '.$this->id_doctor;
			$doctor_type = $this->getOneValueFromSql($sql);
			//$this->perms['add_new_patient'] = in_array($doctor_type, array(2)) ? true : false;
		}
	}
	
	
	public function isPermittedPart($name)
	{
		if(isset($this->perms[$name]))
		{
			return $this->perms[$name];
		}
		return false;
	}

	

}
?>