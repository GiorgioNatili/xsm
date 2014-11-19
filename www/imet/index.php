<?php
session_start(); ob_start();

require_once('config/config.php');
require_once('projectCommon.class.php'); //funcje uzywane w calym portalu
require_once('project.class.php'); //glowna klasa portalu
require_once('lib/smarty/Smarty.class.php');
require_once('lib/form/form.class.php');

//klasy
if ($dir = opendir('lib')) 
{
	while (($file = readdir($dir)) !== false) 
	{
    	if(strstr($file,'class.php'))
    	{
			require_once('lib/'.$file);
    	}
    }
	closedir($dir);
}

// dzialy
if ($dir = opendir('actions')) 
{
	while (($file = readdir($dir)) !== false) 
	{
    	if(strstr($file,'class.php'))
    	{
			require_once('actions/'.$file);
    	}
    }
	closedir($dir);
}

//narzedzia administratora
if ($dir = opendir('admin')) 
{
	while (($file = readdir($dir)) !== false) 
	{
    	if(strstr($file,'class.php'))
    	{
			require_once('admin/'.$file);
    	}
    }
	closedir($dir);
}

new project();
exit();
?>


