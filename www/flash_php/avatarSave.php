<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='avatar';
$_GET['add']=1;
chdir(FLASH_DIR);
require_once('index.php');

/*
echo 
'<root>
<status>1</status>
<avatar>
	<panelMiniature path="http://localhost/imet/flash/assets/user/avatar/avatar1_panel.png" />
</avatar>
</root>';
*/

?>
