<?php

require_once('config.php');

$moduleAction = $_POST['moduleAction'];
$action = $_POST['action'];

if($moduleAction == 'registration')
{
	if($action=='getInitLogin')
	{
		$_GET['pid']='flash';
		$_GET['sp']='initlogin';
		$_GET['token']=$_POST['hash'];
		chdir(FLASH_DIR);
		require_once('index.php');
	}
	else if($action=='saveData')
	{
		$_GET['pid']='flash';
		$_GET['sp']='register';
		chdir(FLASH_DIR);
		require_once('index.php');
	}
}
elseif($moduleAction=='showLogoutForm')
{
	$_GET['pid']='flash';
	$_GET['sp']='logout';
	chdir(FLASH_DIR);
	require_once('index.php');
}
elseif($moduleAction=='changePasswordForm')
{
	if($action=='getInitLogin')
	{
		$_GET['pid']='flash';
		$_GET['sp']='changePassword';
		chdir(FLASH_DIR);
		require_once('index.php');
	}
	elseif($action=='saveData')
	{
		$_GET['pid']='flash';
		$_GET['sp']='changePassword';
		$_GET['add']=1;
		chdir(FLASH_DIR);
		require_once('index.php');
	}
}
elseif($moduleAction=='changeContactForm')
{
	if($action=='getInitLogin')
	{
		$_GET['pid']='flash';
		$_GET['sp']='changeContact';
		chdir(FLASH_DIR);
		require_once('index.php');
	}
	elseif($action=='saveData')
	{
		$_GET['pid']='flash';
		$_GET['sp']='changeContact';
		$_GET['add']=1;
		chdir(FLASH_DIR);
		require_once('index.php');
	}
}

?>
