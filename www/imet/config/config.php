<?php
error_reporting(E_ALL); ini_set('display_errors','on');
#phpinfo(); exit();

define('SERVICE_LOCAL','/var/www/html/imet/');
define('SERVICE_ROOT','/imet/');
define('SERVICE_WWW','http://'.$_SERVER['HTTP_HOST'].SERVICE_ROOT);
define('SERVICE_NAME','Myvyou');

define('FLASH_WWW','http://'.$_SERVER['HTTP_HOST'].'/');

define('DB_ENGINE','mysql');
define('DB_SERV', 'localhost');
define('DB_USER', 'vndothersource');
define('DB_PASS', 'FirstBa$e');
define('DB_NAME', 'ezdb');
define('CSM_DB_NAME', 'csm');

define('FILE_DIR', SERVICE_LOCAL.'files/');
define('FILE_WWW', SERVICE_WWW.'files/');
define('CACHE_DIR', SERVICE_LOCAL.'cache/');
define('CACHE_WWW', SERVICE_WWW.'cache/'); 

define('FTP_FILES',0);
define('FTP_CACHE',0);
define('FTP_SERV','localhost');
define('FTP_USER','');
define('FTP_PASS','');
define('FTP_ROOT','/html/files/'); 

define('TEMPLATE','default');
define('SESSION_PREFIX','imet');
define('PAGE_LIMIT',25);

date_default_timezone_set('America/New_York');

define('MAIL_SERVER','nonstopstd.nazwa.pl');
define('MAIL_SERVER_PORT','25');
define('MAIL_SERVER_AUTH',true);
define('MAIL_SERVER_SSL',false);
define('MAIL_SERVER_TLS',false);
define('MAIL_SERVER_USER','mailer@emocni.pl');
define('MAIL_SERVER_PASSWORD','aGQprvK2@HE*F*ruf59Jay=TS');

?>