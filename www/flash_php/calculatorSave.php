<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='session';
$_GET['category']='5';
$_GET['add']='1';
chdir(FLASH_DIR);
require_once('index.php');

/*
$_POST['answers'] :
answers = "
<root>
  <answers>
    <answer>
      <substance id="3"/>
      <calculationType id="3"/>
      <overall value="220"/>
      <option1 type="input"><![CDATA[11]]></option1>
      <option2 type="list"><![CDATA[14]]></option2>
      <option3 type="list"><![CDATA[17]]></option3>
    </answer>
    <answer>
      <substance id="3"/>
      <calculationType id="1"/>
      <overall value="22"/>
      <option1 type="input"><![CDATA[22]]></option1>
      <option2 type="list"><![CDATA[2]]></option2>
      <option3 type="list"><![CDATA[5]]></option3>
    </answer>
    <answer>
      <substance id="3"/>
      <calculationType id="2"/>
      <overall value="16500"/>
      <option1 type="input"><![CDATA[33]]></option1>
      <option2 type="list"><![CDATA[6]]></option2>
      <option3 type="list"><![CDATA[10]]></option3>
    </answer>
  </answers>
</root>
"
*/
