<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session';
$_GET['category']='3';
$_GET['add']='1';
chdir(FLASH_DIR);
require_once('index.php');


?>
