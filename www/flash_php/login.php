<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='login';
chdir(FLASH_DIR);
require_once('index.php');



?>
