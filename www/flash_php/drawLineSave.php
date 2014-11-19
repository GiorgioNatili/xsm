<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session';
$_GET['category']='6';
$_GET['add']='1';
chdir(FLASH_DIR);
require_once('index.php');



/*
$_POST['answers'] :
answers = "
<root>
<stateResults>

<confidentStateResult>
<digit>7</digit>
<optionId>4</optionId>
<answer><![CDATA[]]></answer>
</confidentStateResult>

<readyStateResult>
<digit>4</digit>
<optionId>1</optionId>
<answer><![CDATA[It?s not good for my health]]></answer>
</readyStateResult>

</stateResults>
</root>"
*/

?>
