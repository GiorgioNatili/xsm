<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session';
$_GET['category']='4';
chdir(FLASH_DIR);
require_once('index.php');

/*
<root>

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
    </commentList>

	<board path="assets/exp/board.png" />
    
    <personList>
    	<person id="1" boardImagePath="assets/exp/person/1_board.png" selectedImagePath="assets/exp/person/1_selected.png">
        	<boardImagePosition x="33" y="202" />
            <statusIconPosition x="54" y="-15" /><!-- relative to boardImage -->
            <selectedImagePosition x="10" y="87" />
            
            <card type="regular">
            	<position x="123" y="46" />
                <question><![CDATA[I've forgotten<br>things I did<br>because of my<br>alcohol & drug.]]></question>
            </card>
            
        </person>
        
        <person id="2" boardImagePath="assets/exp/person/2_board.png" selectedImagePath="assets/exp/person/2_selected.png">
        	<boardImagePosition x="142" y="70" />
            <statusIconPosition x="27" y="-20" />
            <selectedImagePosition x="81" y="31" />
            
            <card type="regular">
            	<position x="280" y="31" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
    	<person id="3" boardImagePath="assets/exp/person/3_board.png" selectedImagePath="assets/exp/person/3_selected.png">
        	<boardImagePosition x="219" y="255" />
            <statusIconPosition x="35" y="-28" /><!-- relative to boardImage -->
            <selectedImagePosition x="167" y="163" />
            
            <card type="regular">
            	<position x="300" y="57" />
                <question><![CDATA[Lorem Ipsum?]]></question>
            </card>
            
        </person>
        
        <person id="4" boardImagePath="assets/exp/person/4_board.png" selectedImagePath="assets/exp/person/4_selected.png">
        	<boardImagePosition x="472" y="214" />
            <statusIconPosition x="5" y="-9" />
            <selectedImagePosition x="303" y="-6" />
            
            <card type="regular">
            	<position x="136" y="122" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="5" boardImagePath="assets/exp/person/5_board.png" selectedImagePath="assets/exp/person/5_selected.png">
        	<boardImagePosition x="628" y="130" />
            <statusIconPosition x="-6" y="2" />
            <selectedImagePosition x="608" y="4" />
            
            <card type="regular">
            	<position x="393" y="111" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
         <person id="6" boardImagePath="assets/exp/person/6_board.png" selectedImagePath="assets/exp/person/6_selected.png">
        	<boardImagePosition x="826" y="258" />
            <statusIconPosition x="58" y="-14" />
            <selectedImagePosition x="820" y="197" />
            
            <card type="regular">
            	<position x="916" y="48" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="7" boardImagePath="assets/exp/person/7_board.png" selectedImagePath="assets/exp/person/7_selected.png">
        	<boardImagePosition x="988" y="152" />
            <statusIconPosition x="-18" y="-8" />
            <selectedImagePosition x="987" y="84" />
            
            <card type="regular">
            	<position x="1082" y="22" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="8" boardImagePath="assets/exp/person/8_board.png" selectedImagePath="assets/exp/person/8_selected.png">
        	<boardImagePosition x="1158" y="176" />
            <statusIconPosition x="6" y="-20" />
            <selectedImagePosition x="1149" y="129" />
            
            <card type="regular">
            	<position x="1284" y="110" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="9" boardImagePath="assets/exp/person/9_board.png" selectedImagePath="assets/exp/person/9_selected.png">
        	<boardImagePosition x="1283" y="134" />
            <statusIconPosition x="-16" y="-12" />
            <selectedImagePosition x="1273" y="88" />
            
            <card type="regular">
            	<position x="1061" y="30" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="10" boardImagePath="assets/exp/person/10_board.png" selectedImagePath="assets/exp/person/10_selected.png">
        	<boardImagePosition x="1461" y="76" />
            <statusIconPosition x="-8" y="-33" />
            <selectedImagePosition x="1450" y="15" />
            
            <card type="regular">
            	<position x="1234" y="59" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="11" boardImagePath="assets/exp/person/11_board.png" selectedImagePath="assets/exp/person/11_selected.png">
        	<boardImagePosition x="1673" y="168" />
            <statusIconPosition x="34" y="-32" />
            <selectedImagePosition x="1671" y="106" />
            
            <card type="regular">
            	<position x="1778" y="3" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="12" boardImagePath="assets/exp/person/12_board.png" selectedImagePath="assets/exp/person/12_selected.png">
        	<boardImagePosition x="1867" y="170" />
            <statusIconPosition x="85" y="-33" />
            <selectedImagePosition x="1859" y="106" />
            
            <card type="regular">
            	<position x="1984" y="45" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="13" boardImagePath="assets/exp/person/13_board.png" selectedImagePath="assets/exp/person/13_selected.png">
        	<boardImagePosition x="2167" y="118" />
            <statusIconPosition x="-15" y="-53" />
            <selectedImagePosition x="2149" y="40" />
            
            <card type="regular">
            	<position x="1940" y="9" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="14" boardImagePath="assets/exp/person/14_board.png" selectedImagePath="assets/exp/person/14_selected.png">
        	<boardImagePosition x="2360" y="132" />
            <statusIconPosition x="-2" y="-10" />
            <selectedImagePosition x="2320" y="66" />
            
            <card type="regular">
            	<position x="2143" y="44" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="15" boardImagePath="assets/exp/person/15_board.png" selectedImagePath="assets/exp/person/15_selected.png">
        	<boardImagePosition x="2555" y="54" />
            <statusIconPosition x="-7" y="-6" />
            <selectedImagePosition x="2558" y="4" />
            
            <card type="regular">
            	<position x="2349" y="34" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="16" boardImagePath="assets/exp/person/16_board.png" selectedImagePath="assets/exp/person/16_selected.png">
        	<boardImagePosition x="2732" y="201" />
            <statusIconPosition x="213" y="84" />
            <selectedImagePosition x="2738" y="171" />
            
            <card type="regular">
            	<position x="2958" y="114" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="17" boardImagePath="assets/exp/person/17_board.png" selectedImagePath="assets/exp/person/17_selected.png">
        	<boardImagePosition x="2820" y="99" />
            <statusIconPosition x="6" y="-28" />
            <selectedImagePosition x="2802" y="30" />
            
            <card type="regular">
            	<position x="2922" y="20" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="18" boardImagePath="assets/exp/person/18_board.png" selectedImagePath="assets/exp/person/18_selected.png">
        	<boardImagePosition x="3085" y="146" />
            <statusIconPosition x="43" y="-43" />
            <selectedImagePosition x="2973" y="38" />
            
            <card type="regular">
            	<position x="2805" y="22" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="19" boardImagePath="assets/exp/person/19_board.png" selectedImagePath="assets/exp/person/19_selected.png">
        	<boardImagePosition x="3353" y="66" />
            <statusIconPosition x="98" y="-19" />
            <selectedImagePosition x="3343" y="-1" />
            
            <card type="regular">
            	<position x="3492" y="29" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="20" boardImagePath="assets/exp/person/20_board.png" selectedImagePath="assets/exp/person/20_selected.png">
        	<boardImagePosition x="3708" y="187" />
            <statusIconPosition x="155" y="42" />
            <selectedImagePosition x="3694" y="139" />
            
            <card type="regular">
            	<position x="3875" y="49" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <person id="21" boardImagePath="assets/exp/person/21_board.png" selectedImagePath="assets/exp/person/21_selected.png">
        	<boardImagePosition x="4428" y="200" />
            <statusIconPosition x="11" y="-50" />
            <selectedImagePosition x="4292" y="123" />
            
            <card type="regular">
            	<position x="4155" y="9" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        
        <!--
        <person id="" boardImagePath="assets/exp/person/_board.png" selectedImagePath="assets/exp/person/_selected.png">
        	<boardImagePosition x="" y="" />
            <statusIconPosition x="" y="" />
            <selectedImagePosition x="" y="" />
            
            <card type="regular">
            	<position x="" y="" />
                <question><![CDATA[...]]></question>
            </card>
        </person>
        -->
        
    </personList>
</root>
*/
