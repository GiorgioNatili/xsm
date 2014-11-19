<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session';
$_GET['category']='3';
chdir(FLASH_DIR);
require_once('index.php');


/*
echo 
'<root>
	
	<boards>
		<board id="1" libraryPath="module/proscons/skateBoard.swf">
			<label><![CDATA[skate]]></label>
			<userActivities>
				<activity type="1" loopVideo="true">
					<startPosition x="0" y="-160" />
				</activity>
				<activity type="2" loopVideo="false">
					<startPosition x="0" y="-160" />
				</activity>
				<activity type="3" loopVideo="false">
					<startPosition x="5" y="-160" />
				</activity>
				<activity type="4" loopVideo="false">
					<startPosition x="0" y="-160" />
					<move x="0" y="-60" startTime=".5" duration=".2" />
				</activity>
				<activity type="5" loopVideo="true">
					<startPosition x="0" y="-60" />
				</activity>
				<activity type="6" loopVideo="false">
					<startPosition x="0" y="-60" />
				</activity>
			</userActivities>
			
		</board>
	</boards>
	
	<cards>
	
		<card id="1" type="regular" category="pros" >
			<label><![CDATA[I have fun with my friends when I drink.]]></label>
		</card>
		<card id="2" type="regular" category="pros" >
			<label><![CDATA[Drinking helps me fit in.]]></label>
		</card>
		<card id="3" type="regular" category="pros" >
			<label><![CDATA[Drinking helps me relax.]]></label>
		</card>
		<card id="4" type="regular" category="pros" >
			<label><![CDATA[Drinking helps me feel better when I\'m feeling bad.]]></label>
		</card>
		<card id="5" type="regular" category="pros" >
			<label><![CDATA[It\'s easier to talk to people when I drink.]]></label>
		</card>
		<card id="6" type="regular" category="pros" >
			<label><![CDATA[Drinking games are fun.]]></label>
		</card>
		<card id="7" type="regular" category="cons" >
			<label><![CDATA[I feel hung over after I drink.]]></label>
		</card>
		<card id="8" type="regular" category="cons" >
			<label><![CDATA[Alcohol is expensive.]]></label>
		</card>
		<card id="9" type="regular" category="cons" >
			<label><![CDATA[I feel sick when I drink.]]></label>
		</card>
		<card id="10" type="regular" category="cons" >
			<label><![CDATA[Alcohol is fattening.]]></label>
		</card>
		<card id="11" type="regular" category="cons" >
			<label><![CDATA[I regret what I do or say when I drink.]]></label>
		</card>
		<card id="12" type="regular" category="cons" >
			<label><![CDATA[I could get in trouble for drinking.]]></label>
		</card>
		<card id="13" type="regular" category="cons" >
			<label><![CDATA[Alcohol is bad for my health.]]></label>
		</card>
		<card id="14" type="regular" category="cons" >
			<label><![CDATA[I could get hurt or taken advantage of when I drink.]]></label>
		</card>
		
		
		<card id="101" type="regular" category="pros" >
			<label><![CDATA[I like the feeling of being high.]]></label>
		</card>
		<card id="102" type="regular" category="pros" >
			<label><![CDATA[Marijuana helps me relax or fall asleep.]]></label>
		</card>
		<card id="103" type="regular" category="pros" >
			<label><![CDATA[I have more fun when I\'m high.]]></label>
		</card>
		<card id="104" type="regular" category="pros" >
			<label><![CDATA[I\'m more creative after smoking marijuana.]]></label>
		</card>
		<card id="105" type="regular" category="pros" >
			<label><![CDATA[Using marijuana is something to do when I\'m bored.]]></label>
		</card>
		<card id="106" type="regular" category="pros" >
			<label><![CDATA[Marijuana helps me forget my problems.]]></label>
		</card>
		<card id="107" type="regular" category="cons" >
			<label><![CDATA[I get a headache after I smoke marijuana.]]></label>
		</card>
		<card id="108" type="regular" category="cons" >
			<label><![CDATA[Smoking marijuana is bad for my lungs.]]></label>
		</card>
		<card id="109" type="regular" category="cons" >
			<label><![CDATA[I spend a lot of time smoking marijuana.]]></label>
		</card>
		<card id="110" type="regular" category="cons" >
			<label><![CDATA[I spend money on marijuana.]]></label>
		</card>
		<card id="111" type="regular" category="cons" >
			<label><![CDATA[My parents don\'t like that I smoke marijuana.]]></label>
		</card>
		<card id="112" type="regular" category="cons" >
			<label><![CDATA[I could fail a drug test.]]></label>
		</card>
		<card id="113" type="regular" category="cons" >
			<label><![CDATA[Marijuana makes me lazy.]]></label>
		</card>
		<card id="114" type="regular" category="cons" >
			<label><![CDATA[Marijuana could get me in trouble.]]></label>
		</card>
		<card id="115" type="regular" category="cons" >
			<label><![CDATA[I get anxious when I smoke marijuana.]]></label>
		</card>
		<card id="116" type="regular" category="cons" >
			<label><![CDATA[Marijuana is bad for my brain and my memory.]]></label>
		</card>

	</cards>
	
</root>
';
*/


?>
