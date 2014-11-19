<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session';
$_GET['category']='7';
$_GET['add']='1';
$_GET['id']=$_POST['session'];
chdir(FLASH_DIR);
require_once('index.php');


/*
$_POST['answers'] :
answers = "

<root>
  <answers>
    
    <introCardList>
      <introCard id="3">
        <userAnswer type="normal" value="2">
      </introCard>
      <introCard id="9">
        <userAnswer type="normal" value="3">
      </introCard>
    </introCardList>
    
    <coupons>
    
      <coupon id="102">
        <optionAnswers>
          <option id="1" inputMode="0">
            <selected>0</selected>
          </option>
          <option id="2" inputMode="0">
            <selected>1</selected>
          </option>
          <option id="3" inputMode="0">
            <selected>0</selected>
          </option>
          <option id="4" inputMode="1">
            <inputValue>null</inputValue>
          </option>
        </optionAnswers>
      </coupon>
      
      <coupon id="112">
        <optionAnswers>
          <option id="5" inputMode="0">
            <selected>0</selected>
          </option>
          <option id="6" inputMode="0">
            <selected>0</selected>
          </option>
          <option id="7" inputMode="0">
            <selected>0</selected>
          </option>
          <option id="8" inputMode="0">
            <selected>1</selected>
          </option>
          <option id="9" inputMode="1">
            <inputValue></inputValue>
          </option>
        </optionAnswers>
      </coupon>
      
      <coupon id="122">
        <optionAnswers>
          <option id="10" inputMode="0">
            <selected>1</selected>
          </option>
          <option id="11" inputMode="0">
            <selected>0</selected>
          </option>
          <option id="12" inputMode="0">
            <selected>0</selected>
          </option>
          <option id="13" inputMode="1">
            <inputValue>null</inputValue>
          </option>
        </optionAnswers>
      </coupon>
      
      <coupon id="132">
        <optionAnswers>
          <option id="14" inputMode="0">
            <selected>0</selected>
          </option>
          <option id="15" inputMode="0">
            <selected>0</selected>
          </option>
          <option id="16" inputMode="0">
            <selected>0</selected>
          </option>
          <option id="17" inputMode="0">
            <selected>1</selected>
          </option>
          <option id="18" inputMode="1">
            <inputValue></inputValue>
          </option>
        </optionAnswers>
      </coupon>
      
    </coupons>
  </answers>
</root>

"
*/

?>
