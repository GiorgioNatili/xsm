<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session2complete';
chdir(FLASH_DIR);
require_once('index.php');

/*
<root>
		
		<ui>
			<text uid="info1">
				<![CDATA[Thank you for completing Session 2. You did a great job! I hope you found it helpful as well as enjoyable. All the information you entered is confidential!After this, please go to My Page to view my feedback on Take 2 (Expect to receive it in the next 2 days), send me e-mails, and use more interactive tools. In 2 weeks. In 2 weeks we’re going to meet here again (I’ll email you a reminder email). ]]>
			</text>
			<text uid="info2">
				<![CDATA[I believe that nothing can hold you back from success, but your own will.<br><br>Yours,<br>Dr. John Smith]]>
			</text>
			
		</ui>
		
	</root>
*/
