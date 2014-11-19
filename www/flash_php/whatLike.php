<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='whatLike';
chdir(FLASH_DIR);
require_once('index.php');

/*
<root>
	<boxList>
    	<!-- row 1 -->
    	<box id="1" rowIndex="0" columnIndex="1" interactive="0" />
    	<box id="2" rowIndex="0" columnIndex="2" interactive="0" />
    	<box id="3" rowIndex="0" columnIndex="4" interactive="1" />
    	<box id="4" rowIndex="0" columnIndex="5" interactive="1" />
        <!-- row 2 -->
    	<box id="5" rowIndex="1" columnIndex="0" interactive="0" />
    	<box id="6" rowIndex="1" columnIndex="1" interactive="0" />
    	<box id="7" rowIndex="1" columnIndex="2" interactive="0" />
    	<box id="8" rowIndex="1" columnIndex="3" interactive="1" />
    	<box id="9" rowIndex="1" columnIndex="4" interactive="1" />
    	<box id="10" rowIndex="1" columnIndex="5" interactive="1" />
    	<box id="11" rowIndex="1" columnIndex="6" interactive="1" />
    	<!-- row 3 -->
    	<box id="12" rowIndex="2" columnIndex="0" interactive="1" />
    	<box id="13" rowIndex="2" columnIndex="1" interactive="1" />
    	<box id="14" rowIndex="2" columnIndex="2" interactive="1" />
    	<box id="15" rowIndex="2" columnIndex="3" interactive="1" />
    	<box id="16" rowIndex="2" columnIndex="4" interactive="1" />
    	<box id="17" rowIndex="2" columnIndex="5" interactive="1" />
    	<box id="18" rowIndex="2" columnIndex="6" interactive="1" />
    	<!-- row 4 -->
    	<box id="19" rowIndex="3" columnIndex="0" interactive="1" />
    	<box id="20" rowIndex="3" columnIndex="1" interactive="1" />
    	<box id="21" rowIndex="3" columnIndex="2" interactive="1" />
    	<box id="22" rowIndex="3" columnIndex="3" interactive="1" />
    	<!-- row 5 -->
    	<box id="23" rowIndex="4" columnIndex="1" interactive="1" />
    	<box id="24" rowIndex="4" columnIndex="2" interactive="1" />
    	<box id="25" rowIndex="4" columnIndex="3" interactive="1" />
    	<!-- row 6 -->
    	<box id="26" rowIndex="5" columnIndex="2" interactive="1" />
    	<box id="27" rowIndex="5" columnIndex="3" interactive="1" />
    	<!-- row 7 -->
    	<box id="28" rowIndex="6" columnIndex="3" interactive="1" />
    	
    </boxList>
    
    <categoryList>
    	<category id="1" baseColor="0x01B1FA" baseDarkColor="0x0778BA" overColor="0x004b76" outColor="0x0778BA" editable="1">
        	<label><![CDATA[MUSIC]]></label>
            
        </category>
    	<category id="2" baseColor="0xfd007a" baseDarkColor="0x950048" overColor="0x670032" outColor="0x950048" editable="1">
        	<label><![CDATA[FASHION]]></label>
            
        </category>
        
        <category id="3" baseColor="0x2100f4" baseDarkColor="0x140764" overColor="0x000000" outColor="0x140764" editable="1">
        	<label><![CDATA[CELEBS]]></label>
            
        </category>
        
        <category id="4" baseColor="0x1ecd06" baseDarkColor="0x127c04" overColor="0x0b5103" outColor="0x127c04" editable="1">
        	<label><![CDATA[MOVIES]]></label>
            
        </category>
        
        <category id="5" baseColor="0xfb2801" baseDarkColor="0x9e1901" overColor="0x5a0e01" outColor="0x9e1901" editable="0">
        	<label><![CDATA[VIEW ALL]]></label>
            
        </category>
    </categoryList>
    
    <photoList>
    	<photo id="1" categoryId="1" boxId="12" miniaturePath="assets/whatLike/images/miniature/1.png" normalPath="assets/whatLike/images/normal/1.png">
        	<title><![CDATA[Lorem Ipsum]]></title>
            <content><![CDATA[Blablabla...]]></content>
        </photo>
        <photo id="2" categoryId="2" boxId="13" miniaturePath="assets/whatLike/images/miniature/1.png" normalPath="assets/whatLike/images/normal/1.png">
        	<title><![CDATA[Lorem Ipsum_2]]></title>
            <content><![CDATA[Blablabla_2...]]></content>
        </photo>
    </photoList>
</root>
*/
