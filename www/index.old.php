<?php

	define('SERVICE_ROOT','/');
	//define('SERVICE_WWW','http://'.$_SERVER['HTTP_HOST'].SERVICE_ROOT);
	define('SERVICE_WWW','https://webvpn.childrens.harvard.edu/,DanaInfo=imet.tch.harvard.edu/');

	
	


	$flashvars='';
	$swf = 'main.swf';
	if(isset($_GET['registrationHash']))
	{
    	$flashvars.='&registrationHash='.$_GET['registrationHash'].'&startModulePath=module/registration.swf&action=registration';
	}
	else
	{
    header('Location: '.SERVICE_WWW.'login.html');
    die();
	}

	if( isset( $_GET['startModulePath'] ) )
	{
		$flashvars.='&startModulePath='.$_GET['startModulePath'];
	}
	if( isset( $_GET['session'] ) )
	{
		$flashvars.='&session='.$_GET['session'];
	}
	if( isset( $_GET['action'] ) )
	{
		$flashvars.='&action='.$_GET['action'];
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title>main</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="swfobject.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.simplemodal.js"></script>
	
	<script type="text/javascript">
		var flashvars = { flashvars:"<?php echo $flashvars; ?>" };
		var att = {quality:"high", play:"true", loop:"true", wmode:"transparent"};
		swfobject.embedSWF("main.swf", "myContent", "960", "810", "9.0.0", "expressInstall.swf", flashvars, att);
	</script>
	<script language="JavaScript" type="text/javascript">
		function showHelpPage(){
			if(!$("#help .cont").html())
			{
				$.ajax({
					type: "POST",
					url: "<?php echo SERVICE_WWW; ?>?pid=flash&sp=getStaticPage&id=10",
					success: function(msg){
						$("#help .cont").html(msg);
						$("#help").modal();
					}
				});
			}
			else
			{
				$("#help").modal();
			}
		}
		function showPrivacyPage(){
			if(!$("#privacy .cont").html())
			{
				$.ajax({
					type: "POST",
					url: "<?php echo SERVICE_WWW; ?>?pid=flash&sp=getStaticPage&id=11",
					success: function(msg){
						$("#privacy .cont").html(msg);
						$("#privacy").modal();
					}
				});
			}
			else
			{
				$("#privacy").modal();
			}
		}
		
		$(window).bind('beforeunload', function(){
			return true;
		});

	</script>
	
	<style type="text/css" media="screen">
		body { height:100%; text-align:center; background-color: #000000; overflow:auto;}
		body { margin:0; padding:0; }
		.simplemodal-overlay {background-color:#FFF;}
		.simplemodal { font-size:Arial,FreeSans;display:none;padding:15px;width:600px;color:#FFF;font-size:12px;background:#000;border:2px solid #FFF; }
		.simplemodal .title {text-align: left;font-size:15px;font-weight:bold;}
		.simplemodal .cont {text-align: left;}
		.simplemodal .close {text-align:right;}
		.simplemodal .close a {color:#FFF;}
	</style>
</head>
<body>
	<div id="myContent" >
		<h1>Alternative content</h1>
		<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
	</div>
	<div id="help" class="simplemodal">
		<p class="close"><a href="#" class="simplemodal-close">Close [X]</a></p>
		<p class="title">Help</p>
		<div class="cont"></div>
	</div>
	<div id="privacy" class="simplemodal">
		<p class="close"><a href="#" class="simplemodal-close">Close [X]</a></p>
		<p class="title">Privacy Policy</p>
		<div class="cont"></div>
	</div>
</body>
</html>
