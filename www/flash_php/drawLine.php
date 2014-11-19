<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session';
$_GET['category']='6';
chdir(FLASH_DIR);
require_once('index.php');

/*
echo 
'<root>
	
		<board id="1" libraryPath="module/drawLine/drawLineBoard2.swf">
			<label><![CDATA[skate]]></label>
			<states>
				<state type="1">
					<questions>
						<question id="1" digits="0">
							<label><![CDATA[You don’t think you’re at all ready to change right now. What are the signals that tell someone they should change?]]></label>
							<options>
								<option id="1" type="normal">
									<label><![CDATA[Getting in trouble with parents, school or the law.]]></label>
								</option>
								<option id="2" type="normal">
									<label><![CDATA[Going to the Emergency Department or getting sick from using.]]></label>
								</option>
								<option id="3" type="normal">
									<label><![CDATA[Grades going down or losing a job.]]></label>
								</option>
								<option id="4" type="input">
									<label><![CDATA[Other:]]></label>
								</option>
							</options>
						</question>
						<question id="1" digits="1,2,3,4,5,6,7,8,9,10">
							<label><![CDATA[Why didn’t you choose a lower number?]]></label>
							<options>
								<option id="1" type="normal">
									<label><![CDATA[It’s not good for my health]]></label>
								</option>
								<option id="2" type="normal">
									<label><![CDATA[There are some things I don’t like about using.]]></label>
								</option>
								<option id="3" type="normal">
									<label><![CDATA[My parents or friends don’t like it when I use.]]></label>
								</option>
								<option id="4" type="input">
									<label><![CDATA[Other:]]></label>
								</option>
							</options>
						</question>
					</questions>
					<userActivities>
						<activity type="1" loopVideo="false">
							<startPosition x="150" y="-500" />
							<cuePoint name="showScale" startTime="13" /><!-- 13 -->
						</activity>
						<activity type="3" loopVideo="true">
							<startPosition x="70" y="-490" />
						</activity>
						<activity type="2" loopVideo="false">
							<startPosition x="-250" y="-500" />
						</activity>
					</userActivities>
				</state>
				
				<state type="2">
					<questions>
						<question id="1" digits="0">
							<label><![CDATA[What would help you be confident?]]></label>
							<options>
								<option id="1" type="normal">
									<label><![CDATA[Learn ways to say no]]></label>
								</option>
								<option id="2" type="normal">
									<label><![CDATA[Learn more about health effects of tobacco, alcohol and drugs]]></label>
								</option>
								<option id="3" type="normal">
									<label><![CDATA[Get help from my doctor/dentist]]></label>
								</option>
								<option id="4" type="normal">
									<label><![CDATA[Talk to my parents]]></label>
								</option>
								<option id="5" type="input">
									<label><![CDATA[Other:]]></label>
								</option>
							</options>
						</question>
						<question id="1" digits="1,2,3,4,5,6,7,8,9,10">
							<label><![CDATA[Why didn’t you choose a lower number?]]></label>
							<options>
								<option id="1" type="normal">
									<label><![CDATA[I’ve done it before so know I can again.]]></label>
								</option>
								<option id="2" type="normal">
									<label><![CDATA[My friends/family will help me.]]></label>
								</option>
								<option id="3" type="normal">
									<label><![CDATA[I don’t feel like I HAVE to use, it’s no problem to say no.]]></label>
								</option>
								<option id="4" type="input">
									<label><![CDATA[Other:]]></label>
								</option>
							</options>
						</question>
					</questions>
					<userActivities>
						<activity type="1" loopVideo="false">
							<startPosition x="-1400" y="-500" />
							<cuePoint name="showScale" startTime="1" /><!-- 13 -->
						</activity>
						<activity type="3" loopVideo="true">
							<startPosition x="-1500" y="-500" />
						</activity>
						<activity type="2" loopVideo="false">
							<startPosition x="-560" y="-500" />
						</activity>
					</userActivities>
				</state>
				
				<state type="3">
					<userActivities>
						<activity type="1" loopVideo="true">
							<startPosition x="70" y="-550" />
						</activity>
						
						<activity type="2" loopVideo="true">
							<startPosition x="680" y="-550" />
						</activity>
					</userActivities>
				</state>
				
			</states>
			
		</board>
	
	<cards>
	
		
	</cards>
	
</root>
';
*/

?>
