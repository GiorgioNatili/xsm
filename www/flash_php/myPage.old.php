<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='myPage';
chdir(FLASH_DIR);
require_once('index.php');


/*
<root>
	<mailboxReplyLine path="assets/myPage/line.png" />
    
	<user id="123">
    	<avatar id="1" type="normal">
            <panelMiniature path="assets/user/avatar/avatar1_panel.png" />
        </avatar>
        <email><![CDATA[test@test.test]]></email>
    </user>
    
	<myGoalInfo><![CDATA[My goal:<br>quit smoking cigarettes by 06.10.11, and quit using alcohol & marijuana ]]></myGoalInfo>
	
    <toolProgress>
    	<tool type="importantModule" progress="2"> <!-- progress: 0 | 1 | 2 [0-none, 1-part, 2-full] -->
        	<name><![CDATA[What’s important to me?]]></name>
        </tool>
    	<tool type="prosconsModule" progress="1"> <!-- progress: 0 | 1 | 2 [0-none, 1-part, 2-full] -->
        	<name><![CDATA[Pros & Cons]]></name>
        </tool>
    	<tool type="" progress="0"> <!-- progress: 0 | 1 | 2 [0-none, 1-part, 2-full] -->
        	<name><![CDATA[What have I experienced?]]></name>
        </tool>
    	<tool type="calculatorModule" progress="2"> <!-- progress: 0 | 1 | 2 [0-none, 1-part, 2-full] -->
        	<name><![CDATA[Tally it up!]]></name>
        </tool>
    	<tool type="drawLineModule" progress="2"> <!-- progress: 0 | 1 | 2 [0-none, 1-part, 2-full] -->
        	<name><![CDATA[Draw the line]]></name>
        </tool>
    	<tool type="take2Module" progress="2"> <!-- progress: 0 | 1 | 2 [0-none, 1-part, 2-full] -->
        	<name><![CDATA[Take 2]]></name>
        </tool>
        
        
    	<tool type="" progress="2"> <!-- progress: 0 | 1 | 2 [0-none, 1-part, 2-full] -->
        	<name><![CDATA[What would I do?]]></name>
        </tool>
    	<tool type="take2Module" progress="2"> <!-- progress: 0 | 1 | 2 [0-none, 1-part, 2-full] -->
        	<name><![CDATA[Take 2]]></name>
        </tool>
    </toolProgress>
</root>
*/

?>
