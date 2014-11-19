<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session';
$_GET['category']='7';
$_GET['id']=$_POST['session'];
chdir(FLASH_DIR);
require_once('index.php');

/*
echo 
'
<root>
	<introCards>
		<card id="1" cardClass="Take2UserInfoCard" >
			<info><![CDATA[Right now I use tobacco, marijuana & alcohol.]]></info>
			<userCommentBalloon><![CDATA[Comment...]]></userCommentBalloon>
		</card>
		<card id="2" cardClass="Take2DoctorInfoCard" >
			<info><![CDATA[I see that your use of tobacco use interferes with your goals. Sounds like it would be a good idea for you to quit. Would you like to try?]]></info>
			<userCommentBalloon><![CDATA[Comment...]]></userCommentBalloon>
		</card>
		<card id="3" cardClass="Take2TryQuestionCard" >
			<yesOption value="1" cardClass="Take2TryYesTobaccoCard" />
			<!--<yesOption cardClass="Take2TryYesOtherCard" />-->
			<!--<yesOption cardClass="Take2TryYesTobaccoCard" />-->
			<noOption value="2" cardClass="Take2TryNoCard" />
			<userCommentBalloon><![CDATA[Comment...]]></userCommentBalloon>
		</card>
		
		<card id="4" cardClass="Take2TryYesOtherCard" >
			<info><![CDATA[Great desicion!]]></info>
			<userCommentBalloon><![CDATA[Comment...]]></userCommentBalloon>
		</card>
		<card id="5" cardClass="Take2TryYesTobaccoCard" >
			<nextCard cardClass="Take2DateChooserCard" />
			<info><![CDATA[Great desicion!<br>Now, let’s pick a date.]]></info>
			<userCommentBalloon><![CDATA[Comment...]]></userCommentBalloon>
		</card>
		
		<card id="6" cardClass="Take2DateChooserCard" >
			<nextCard value="" cardClass="Take2TobaccoSummaryCard" />
			<userCommentBalloon><![CDATA[Comment...]]></userCommentBalloon>
		</card>
		<card id="7" cardClass="Take2TobaccoSummaryCard" >
			<info><![CDATA[Great desicion!<br>Let’s talk about how you can achieve your goals.]]></info>
			<userCommentBalloon><![CDATA[My Goal: quit before {DATE}.]]></userCommentBalloon>
		</card>
		
		<card id="8" cardClass="Take2TryNoCard" >
			<nextCard cardClass="Take2ChangeSubstanceCard" />
			<info><![CDATA[Are you willing to change any part of your substance use?]]></info>
			<userCommentBalloon><![CDATA[Comment...]]></userCommentBalloon>
		</card>
		
		<card id="9" cardClass="Take2ChangeSubstanceCard" >
			<yesAlcoholOption value="1" cardClass="Take2ChangeSubstanceYesCard" />
			<yesMarijuanaOption value="2" cardClass="Take2ChangeSubstanceYesCard" />
			<noOption value="3" cardClass="Take2ChangeSubstanceNoCard" />
			<userCommentBalloon><![CDATA[Comment...]]></userCommentBalloon>
		</card>
		
		<card id="10" cardClass="Take2ChangeSubstanceYesCard" >
			<info><![CDATA[Great desicion!<br>Let’s talk about how you can achieve your goals.]]></info>
			<userCommentBalloon><![CDATA[Comment...]]></userCommentBalloon>
		</card>
		<card id="11" cardClass="Take2ChangeSubstanceNoCard" >
			<info><![CDATA[Please think about changing your substance use and we can talk about it later.]]></info>
			<userCommentBalloon><![CDATA[Comment...]]></userCommentBalloon>
		</card>
	</introCards>
	
	<coupons>
		
		<coupon id="1" type="intro" background="0xFF0000">
			<smallText><![CDATA[What can I do to help]]></smallText>
			<normalText><![CDATA[myself succeed?]]></normalText>
			<substancesPanel>
				<coupon id="1" background="0xCCCCCC"><![CDATA[Tobacco]]></coupon>
				<coupon id="2" background="0xCCCCCC"><![CDATA[Others]]></coupon>
			</substancesPanel>
		</coupon>
		
		<coupon id="101" type="info" background="0xFF0000" substanceCouponId="1">
			<smallText><![CDATA[What can I do to help me succeed?]]></smallText>
			<normalText><![CDATA[]]></normalText>
		</coupon>
		<coupon id="102" type="answer" background="0xFFFF00" substanceCouponId="1">
			<options>
				<option id="1" inputMode="false">
					<label><![CDATA[Find a new activity (exercise, play a sport, join a club)]]></label>
				</option>
				<option id="2" inputMode="false">
					<label><![CDATA[Tell my friends what I’m doing ]]></label>
				</option>
				<option id="3" inputMode="false">
					<label><![CDATA[Hang out with non-using friends]]></label>
				</option>
				<option id="4" inputMode="true">
					<label><![CDATA[Other?]]></label>
				</option>
			</options>
		</coupon>
		
		<coupon id="111" type="info" background="0xFF0000" substanceCouponId="1">
			<smallText><![CDATA[How can my doctor help me succeed?]]></smallText>
			<normalText><![CDATA[]]></normalText>
		</coupon>
		<coupon id="112" type="answer" background="0xFFFF00" substanceCouponId="1">
			<options>
				<option id="1" inputMode="false">
					<label><![CDATA[Provide encouragement]]></label>
				</option>
				<option id="2" inputMode="false">
					<label><![CDATA[Help me find a counselor or other treatment]]></label>
				</option>
				<option id="3" inputMode="false">
					<label><![CDATA[Give me more information]]></label>
				</option>
				<option id="4" inputMode="false">
					<label><![CDATA[Nicotine replacement (patch, gum, etc.) [if smoker]]]></label>
				</option>
				<option id="5" inputMode="true">
					<label><![CDATA[Other?]]></label>
				</option>
			</options>
		</coupon>
		
		<coupon id="121" type="info" background="0xFF0000" substanceCouponId="2">
			<smallText><![CDATA[What might get in my way? ]]></smallText>
			<normalText><![CDATA[]]></normalText>
		</coupon>
		<coupon id="122" type="answer" background="0xFFFF00" substanceCouponId="2">
			<options>
				<option id="1" inputMode="false">
					<label><![CDATA[Hanging out with friends who use]]></label>
				</option>
				<option id="2" inputMode="false">
					<label><![CDATA[Attending parties where other kids are using ]]></label>
				</option>
				<option id="3" inputMode="false">
					<label><![CDATA[Feeling anxious, angry, tired, or lonely]]></label>
				</option>
				<option id="4" inputMode="true">
					<label><![CDATA[Other?]]></label>
				</option>
			</options>
		</coupon>
		
		<coupon id="131" type="info" background="0xFF0000" substanceCouponId="2">
			<smallText><![CDATA[Who is going to be there to help me? ]]></smallText>
			<normalText><![CDATA[]]></normalText>
		</coupon>
		<coupon id="132" type="answer" background="0xFFFF00" substanceCouponId="2">
			<options>
				<option id="1" inputMode="false">
					<label><![CDATA[Non-using friends  ]]></label>
				</option>
				<option id="2" inputMode="false">
					<label><![CDATA[A family member]]></label>
				</option>
				<option id="3" inputMode="false">
					<label><![CDATA[Dr. [Name] or another professional ]]></label>
				</option>
				<option id="4" inputMode="false">
					<label><![CDATA[A trusted adult (teacher, coach, counselor)]]></label>
				</option>
				<option id="5" inputMode="true">
					<label><![CDATA[Other?]]></label>
				</option>
			</options>
		</coupon>
		
	</coupons>
	
</root>
';
*/


?>
