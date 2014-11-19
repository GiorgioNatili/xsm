<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='iamHere';
chdir(FLASH_DIR);
require_once('index.php');


/*
echo 
'<root>
	<tools>
		<tool id="1" name="Important" themeColor="0xffbf00" darkThemeColor="0xc49100">
			<miniature x="242" y="17" >
				<label><![CDATA[WHAT’S IMPORTANT TO ME?]]></label>
			</miniature>
			<content width="348" height="330" x="260" y="247" >
				<label><![CDATA[WHAT’S IMPORTANT TO ME?]]></label>
				<value><![CDATA[THE 3 MOST IMPORTANT THINGS<br>FOR ME ARE:<br>1. To be well liked by many people.<br>2. To be famous.<br>3. To have a lot of money.]]></value>
			</content>
		</tool>
		
		<tool id="2" name="Calculator" themeColor="0xff4d10" darkThemeColor="0xbd390c">
			<miniature x="550" y="17" >
				<label><![CDATA[TALLY IT UP!]]></label>
			</miniature>
			<content width="348" height="276" x="260" y="304" >
				<label><![CDATA[TALLY IT UP!]]></label>
				<value><![CDATA[MARIJUANA & MY:<br>Money 280 dollars]]></value>
			</content>
		</tool>
		
		<tool id="3" name="ProsCons" themeColor="0x1af6ff" darkThemeColor="0x15c4cc">
			<miniature x="242" y="200" >
				<label><![CDATA[PROS & CONS]]></label>
			</miniature>
			<content width="348" height="277" x="260" y="303" >
				<label><![CDATA[PROS & CONS]]></label>
				<value><![CDATA[CONS:<br>1. I get sick when I drink.<br>2. I waste money on alcohol.<br>3.  Alcohol is fattening.<br>4. I get sick when I drink.<br>5. I get sick when I drink.<br>6.  Alcohol is fattening.]]></value>
			</content>
		</tool>
		
		<tool id="4" name="DrawLine" themeColor="0xfb2801" darkThemeColor="0xb31d01">
			<miniature x="550" y="200" >
				<label><![CDATA[DRAW THE LINE]]></label>
			</miniature>
			<content width="348" height="270" x="262" y="309" >
				<label><![CDATA[DRAW THE LINE]]></label>
				<value><![CDATA[AM I READY?<br><font size="35">3 / 10</font><br>Quite ready!<br>I chose a higher number because it’s not<br>good for my health.]]></value>
			</content>
		</tool>
		
		
		<tool id="5" name="Experience" themeColor="0x1ECD06" darkThemeColor="0x18a405">
			<miniature x="242" y="404" >
				<label><![CDATA[WHAT HAVE I EXPERIENCED]]></label>
			</miniature>
			<content width="348" height="277" x="260" y="303" >
				<label><![CDATA[WHAT HAVE I EXPERIENCED?]]></label>
				<value><![CDATA[<font size="20">I’VE EXPERIENCED:<br><font size="39">1. Feeling regret about things I did when<br>    using alcohol or drugs.<br>2. Drinking or using drugs in a car.<br>3. Being in a car  with a drunk driver.<br>4. Using tobacco at school.</font>]]></value>
			</content>
		</tool>
	</tools>
	
</root>
';
*/


?>
