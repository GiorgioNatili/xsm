<?php

require_once('config.php');

$action = $_POST['action'];

if($action == "refresh")
{
  $_GET['pid']='flash';
  $_GET['sp']='mailbox';
  $_GET['category']='1';
  chdir(FLASH_DIR);
  require_once('index.php');
}
else if( $action == "setAsRead" )
{
  $_GET['pid']='flash';
  $_GET['sp']='mailbox';
  $_GET['category']='2';
  chdir(FLASH_DIR);
  require_once('index.php');
}
else if( $action == "sendMail" )
{
  $_GET['pid']='flash';
  $_GET['sp']='mailbox';
  $_GET['category']='3';
  chdir(FLASH_DIR);
  require_once('index.php');
}

/*
$action = $POST['action']  [refresh|setAsRead|sendMail]

if( $action == "refresh" ){
	POST:
	uids -  lista wszystkich UID'ów maili, które zostały już załadowane do skrzynki. 
			Lista uidów maili odebranych i wysłanych (w tej kolejności) oddzielona jest średnikiem,
			natomiast poszczególne UIDy są oddzielone przecinikiem, np:
			1234,1235,1236;876,908
			oznacza to że w skrzynce odbiorczej są wiadomości o UID'ach 1234, 1235 i 1236, natomiast w wysłanych 876 i 908
			skrypt z wartością parametru 'action' równą 'refresh' nie wywołuje się tylko raz, lecz w zależności od akcji użytkownika
			
	RESPONSE:
	xml zawierający listę maili, np:
	<root>
		<mails>
			<mail uid="4681644" type="inbox" read="true" date="23/01/2011">
				<fromUser id="2"><![CDATA[Dr. Avatar]]></fromUser>
				<toUser id="2"><![CDATA[TB]]></toUser>
				<subject><![CDATA[Test Subject....]]></subject>
				<content><![CDATA[Lorem ipsum dolor..gggggggggggggggggggggggggggggg gggggggggggggggg ggggggggggg gggggggggggg.]]></content>
			</mail>
			
			<mail.../>
			
		</mails>
	</root>
	
	mail.@uid - unikalny identyfikator maila
	mail.@type - typ skrzynki do której należy mail, dopuszczalne są wartości "inbox" i "sent"
	mail.@read - parametr określający czy mail został przeczytany
	mail.@date - data wysłąnia maila
	mail.fromUser - tag określający nadawcę wiadomości. Jego wartość to nazwa nadawcy
	mail.fromUser.@id - id nadawcy wiadomości
	mail.toUser - tag określający odbiorcę wiadomosci. Jego wartość to nazwa odbiorcy
	mail.toUser.@id - id odbiorcy wiadomośi
	mail.subject - temat maila
	mail.content - wiadmość
	
}

if( $action == "setAsRead" ){
	POST:
	uid - UID maila, który ma być oznaczony jako przeczytany
	
	RESPONSE:
	xml zawierający potwierdzenie zawierające UID, np:
	<root>
		<mail uid="1234" />
	</root>
}

if( $action == "sendMail" ){
	POST:
	toUserId - id odbiorcy maila
	fromUserId - id nadawcy maila
	subject - temat maila
	content - wiadomość
	
	RESPONSE:
	xml zawierający potwierdzenie, np:
	<root>
		<status>1</status>
	</root>
}

*/


?>
