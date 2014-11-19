<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session';
$_GET['category']='5';
chdir(FLASH_DIR);
require_once('index.php');


/*
echo '
<root>
	
	<save>
		<answers>
			<answer>
				<substance id="2"/>
				<calculationType id="1"/>
				<overall value="120"/>
				<option1 type="input"><![CDATA[120]]></option1>
				<option2 type="list"><![CDATA[2]]></option2>
				<option3 type="list"><![CDATA[3]]></option3>
			</answer>
			<answer><substance id="3"/><calculationType id="1"/><overall value="4800"/><option1 type="input"><![CDATA[120]]></option1><option2 type="list"><![CDATA[3]]></option2><option3 type="list"><![CDATA[3]]></option3></answer><answer><substance id="4"/><calculationType id="2"/><overall value="1200"/><option1 type="input"><![CDATA[120]]></option1><option2 type="input"><![CDATA[10]]></option2><option3 type="list"><![CDATA[3]]></option3></answer><answer><substance id="4"/><calculationType id="1"/><overall value="120"/><option1 type="input"><![CDATA[120]]></option1><option2 type="list"><![CDATA[2]]></option2><option3 type="list"><![CDATA[3]]></option3></answer><answer><substance id="1"/><calculationType id="3"/><overall value="120"/><option1 type="input"><![CDATA[120]]></option1><option2 type="list"><![CDATA[1]]></option2><option3 type="list"><![CDATA[3]]></option3></answer><answer><substance id="1"/><calculationType id="1"/><overall value="120"/><option1 type="input"><![CDATA[120]]></option1><option2 type="list"><![CDATA[2]]></option2><option3 type="list"><![CDATA[3]]></option3></answer></answers>
	</save>
	
	<commentList>
    	<comment name="introInfo">
        	<message><![CDATA[test message]]></message>
        </comment>
    	<comment name="introNextButton">
        	<message><![CDATA[NEXT]]></message>
        </comment>
    	<comment name="introCompleteInfo">
        	<message><![CDATA[introCompleteInfo]]></message>
        </comment>
		<comment name="toolCompleteInfo">
        	<message><![CDATA[toolCompleteInfo]]></message>
        </comment>
    </commentList>
	
	<substances>
		<substance id="1" type="alcohol">
			<boxLabel><![CDATA[Alcohol & my:]]></boxLabel>
			<label><![CDATA[ALCOHOL]]></label>
			<calculationTypes>
				<calculationType id="1" type="time">
					<calculatorInfoText><![CDATA[Be surprised by the things you can do with the time you spend drinking alcohol.]]></calculatorInfoText>
					<stuffInfoText><![CDATA[With the time I spend drinking alcohol I can:]]></stuffInfoText>
					<label><![CDATA[TIME]]></label>
					<stuffs>
						<stuff id="1" />
						<stuff id="2" />
					</stuffs>
					<options>
						<option id="1" type="input">
							<label><![CDATA[Time:]]></label>
						</option>
						<option id="2" type="list">
							<label><![CDATA[Drinking per time:]]></label>
							<dataProvider>
								<item id="1" data="60">
									<label><![CDATA[HOURS]]></label>
								</item>
								<item id="2" data="1">
									<label><![CDATA[MINUTES]]></label>
								</item>
							</dataProvider>
						</option>
						<option id="3" type="list">
							<label><![CDATA[Drinking per time:]]></label>
							<dataProvider>
								<item id="1" data="x">
									<label><![CDATA[DAY]]></label>
								</item>
								<item id="2" data="x">
									<label><![CDATA[MONTH]]></label>
								</item>
								<item id="3" data="x">
									<label><![CDATA[WEEK]]></label>
								</item>
							</dataProvider>
						</option>
					</options>
				</calculationType>
				
				<calculationType id="2" type="calories">
					<calculatorInfoText><![CDATA[Be surprised by the number of calories you take in drinking alcohol.]]></calculatorInfoText>
					<stuffInfoText><![CDATA[calories:]]></stuffInfoText>
					<label><![CDATA[CALORIES]]></label>
					<stuffs>
						<stuff id="301" />
						<stuff id="302" />
						<stuff id="303" />
					</stuffs>
					<options>
						<option id="1" type="input">
							<label><![CDATA[Quantity:]]></label>
						</option>
						<option id="2" type="list">
							<label><![CDATA[Alcohol type:]]></label>
							<dataProvider>
								<item id="1" data="500">
									<label><![CDATA[BEER]]></label>
								</item>
								<item id="2" data="60">
									<label><![CDATA[GLASS OF WINE]]></label>
								</item>
								<item id="3" data="120">
									<label><![CDATA[SHOT OF LIQUOR]]></label>
								</item>
							</dataProvider>
						</option>
						<option id="3" type="list">
							<label><![CDATA[Drinks per:]]></label>
							<dataProvider>
								<item id="1" data="x">
									<label><![CDATA[DAY]]></label>
								</item>
								<item id="2" data="x">
									<label><![CDATA[MONTH]]></label>
								</item>
								<item id="3" data="x">
									<label><![CDATA[WEEK]]></label>
								</item>
							</dataProvider>
						</option>
					</options>
				</calculationType>
				
				<calculationType id="3" type="money">
					<calculatorInfoText><![CDATA[Be surprised by the things you could buy with the money you spend on alcohol.]]></calculatorInfoText>
					<stuffInfoText><![CDATA[money:]]></stuffInfoText>
					<label><![CDATA[MONEY]]></label>
					<stuffs>
						<stuff id="201" />
						<stuff id="202" />
					</stuffs>
					<options>
						<option id="1" type="input">
							<label><![CDATA[Quantity:]]></label>
						</option>
						<option id="2" type="list">
							<label><![CDATA[Alcohol type:]]></label>
							<dataProvider>
								<item id="1" data="1">
									<label><![CDATA[BEER]]></label>
								</item>
								<item id="2" data="10">
									<label><![CDATA[GLASS OF WINE]]></label>
								</item>
								<item id="3" data="20">
									<label><![CDATA[SHOT OF LIQUOR]]></label>
								</item>
							</dataProvider>
						</option>
						<option id="3" type="list">
							<label><![CDATA[Drinks per:]]></label>
							<dataProvider>
								<item id="1" data="x">
									<label><![CDATA[DAY]]></label>
								</item>
								<item id="2" data="x">
									<label><![CDATA[MONTH]]></label>
								</item>
								<item id="3" data="x">
									<label><![CDATA[WEEK]]></label>
								</item>
							</dataProvider>
						</option>
					</options>
				</calculationType>
			
			</calculationTypes>
		</substance>
		
		
		<substance id="2" type="marijuana">
			<boxLabel><![CDATA[Marijuana & my:]]></boxLabel>
			<label><![CDATA[MARIJUANA]]></label>
			<calculationTypes>
				<calculationType id="1" type="time">
					<calculatorInfoText><![CDATA[Be surprised by the things you could do with the time you spend smoking marijuana.]]></calculatorInfoText>
					<stuffInfoText><![CDATA[time:]]></stuffInfoText>
					<label><![CDATA[TIME]]></label>
					<stuffs>
						<stuff id="1" />
						<stuff id="2" />
					</stuffs>
					<options>
						<option id="1" type="input">
							<label><![CDATA[Time:]]></label>
						</option>
						<option id="2" type="list">
							<label><![CDATA[]]></label>
							<dataProvider>
								<item id="1" data="60">
									<label><![CDATA[HOURS]]></label>
								</item>
								<item id="2" data="1">
									<label><![CDATA[MINUTES]]></label>
								</item>
							</dataProvider>
						</option>
						<option id="3" type="list">
							<label><![CDATA[Smoking time per:]]></label>
							<dataProvider>
								<item id="1" data="x">
									<label><![CDATA[DAY]]></label>
								</item>
								<item id="2" data="x">
									<label><![CDATA[MONTH]]></label>
								</item>
								<item id="3" data="x">
									<label><![CDATA[WEEK]]></label>
								</item>
							</dataProvider>
						</option>
					</options>
				</calculationType>
				
				<calculationType id="2" type="money">
					<calculatorInfoText><![CDATA[Be surprised by the things you could buy with the money you spend on marijuana. ]]></calculatorInfoText>
					<stuffInfoText><![CDATA[money:]]></stuffInfoText>
					<label><![CDATA[MONEY]]></label>
					<stuffs>
						<stuff id="201" />
						<stuff id="202" />
					</stuffs>
					<options>
						<option id="1" type="input">
							<label><![CDATA[Quantity:]]></label>
						</option>
						<option id="2" type="list">
							<label><![CDATA[]]></label>
							<dataProvider>
								<item id="1" data="40">
									<label><![CDATA[GRAMS]]></label>
								</item>
							</dataProvider>
						</option>
						<option id="3" type="list">
							<label><![CDATA[Grams per:]]></label>
							<dataProvider>
								<item id="1" data="x">
									<label><![CDATA[DAY]]></label>
								</item>
								<item id="2" data="x">
									<label><![CDATA[MONTH]]></label>
								</item>
								<item id="3" data="x">
									<label><![CDATA[WEEK]]></label>
								</item>
							</dataProvider>
						</option>
					</options>
				</calculationType>
			
			</calculationTypes>
		</substance>
		
		<substance id="3" type="tobacco">
			<boxLabel><![CDATA[ Tobacco & my:]]></boxLabel>
			<label><![CDATA[TOBACCO]]></label>
			<calculationTypes>
				<calculationType id="1" type="money">
					<calculatorInfoText><![CDATA[Be surprised by the things you could buy with the money you spend on tobacco. ]]></calculatorInfoText>
					<stuffInfoText><![CDATA[money:]]></stuffInfoText>
					<label><![CDATA[MONEY]]></label>
					<stuffs>
						<stuff id="201" />
						<stuff id="202" />
					</stuffs>
					<options>
						<option id="1" type="input">
							<label><![CDATA[Quantity:]]></label>
						</option>
						<option id="2" type="list">
							<label><![CDATA[]]></label>
							<dataProvider>
								<item id="1" data="10">
									<label><![CDATA[CIGARETTES]]></label>
								</item>
								<item id="2" data="20">
									<label><![CDATA[TINS]]></label>
								</item>
								<item id="3" data="30">
									<label><![CDATA[PACKS]]></label>
								</item>
								<item id="3" data="40">
									<label><![CDATA[CHEWS]]></label>
								</item>
							</dataProvider>
						</option>
						<option id="3" type="list">
							<label><![CDATA[Uses per:]]></label>
							<dataProvider>
								<item id="1" data="x">
									<label><![CDATA[DAY]]></label>
								</item>
								<item id="2" data="x">
									<label><![CDATA[MONTH]]></label>
								</item>
								<item id="3" data="x">
									<label><![CDATA[WEEK]]></label>
								</item>
							</dataProvider>
						</option>
					</options>
				</calculationType>
			
			</calculationTypes>
		</substance>
		
		<substance id="4" type="stimulant">
			<boxLabel><![CDATA[ Stimulant & my:]]></boxLabel>
			<label><![CDATA[STIMULANT]]></label>
			<calculationTypes>
				<calculationType id="1" type="time">
					<calculatorInfoText><![CDATA[Be surprised by the things you could do with the time you spend using stimulant.]]></calculatorInfoText>
					<stuffInfoText><![CDATA[time:]]></stuffInfoText>
					<label><![CDATA[TIME]]></label>
					<stuffs>
						<stuff id="1" />
						<stuff id="2" />
					</stuffs>
					<options>
						<option id="1" type="input">
							<label><![CDATA[Time:]]></label>
						</option>
						<option id="2" type="list">
							<label><![CDATA[]]></label>
							<dataProvider>
								<item id="1" data="60">
									<label><![CDATA[HOURS]]></label>
								</item>
								<item id="2" data="1">
									<label><![CDATA[MINUTES]]></label>
								</item>
							</dataProvider>
						</option>
						<option id="3" type="list">
							<label><![CDATA[Using time per:]]></label>
							<dataProvider>
								<item id="1" data="x">
									<label><![CDATA[DAY]]></label>
								</item>
								<item id="2" data="x">
									<label><![CDATA[MONTH]]></label>
								</item>
								<item id="3" data="x">
									<label><![CDATA[WEEK]]></label>
								</item>
							</dataProvider>
						</option>
					</options>
				</calculationType>
				
				<calculationType id="2" type="money">
					<calculatorInfoText><![CDATA[Be surprised by the things you could buy with the money you spend on stimulants. ]]></calculatorInfoText>
					<stuffInfoText><![CDATA[money:]]></stuffInfoText>
					<label><![CDATA[MONEY]]></label>
					<stuffs>
						<stuff id="201" />
						<stuff id="202" />
					</stuffs>
					<options>
						<option id="1" type="input">
							<label><![CDATA[Quantity:]]></label>
						</option>
						<option id="2" type="input">
							<label><![CDATA[Cost per use ($)]]></label>
						</option>
						<option id="3" type="list">
							<label><![CDATA[Use per:]]></label>
							<dataProvider>
								<item id="1" data="x">
									<label><![CDATA[DAY]]></label>
								</item>
								<item id="2" data="x">
									<label><![CDATA[MONTH]]></label>
								</item>
								<item id="3" data="x">
									<label><![CDATA[WEEK]]></label>
								</item>
							</dataProvider>
						</option>
					</options>
				</calculationType>
			
			</calculationTypes>
		</substance>
	</substances>
	
	<stuffs>
		<stuff id="1" value="90" range="1">
			<label><![CDATA[Watch {#} of movies]]></label>
		</stuff>
		<stuff id="2" value="60" range="1">
			<label><![CDATA[Listen to {#} music CDs]]></label>
		</stuff>
		
		
		<stuff id="201" value="1000" range="1">
			<label><![CDATA[Buy {#} of TVs]]></label>
		</stuff>
		<stuff id="202" value="1" range="1">
			<label><![CDATA[Buy {#} of itunes songs]]></label>
		</stuff>
		
		
		<stuff id="301" value="100" range="1">
			<label><![CDATA[{#} Slice of pizza]]></label>
		</stuff>
		<stuff id="302" value="60" range="1">
			<label><![CDATA[{#} Can of regular cola]]></label>
		</stuff>
		<stuff id="303" value="1000" range="1">
			<label><![CDATA[{#} Hamburger]]></label>
		</stuff>
	</stuffs>
	
	
</root>
';
*/


?>
