<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session';
$_GET['category']='4';
$_GET['add']='1';
chdir(FLASH_DIR);
require_once('index.php');

/*
POST:
answers = "<root><answers><answer personId="1">true<answer><answer personId="2">false<answer><answer personId="3">true<answer><answer personId="4">true<answer><answer personId="5">false<answer><answer personId="6">true<answer><answer personId="7">true<answer><answer personId="8">false<answer><answer personId="9">true<answer><answer personId="10">false<answer><answer personId="11">true<answer><answer personId="12">false<answer><answer personId="13">true<answer><answer personId="14">false<answer><answer personId="15">true<answer><answer personId="16">false<answer><answer personId="17">true<answer><answer personId="18">false<answer><answer personId="19">true<answer><answer personId="20">false<answer><answer personId="21">true<answer></answers></root>"
*/

?>
