<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Imet</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link type="text/css" rel="stylesheet" href="templates/default/css/style.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="templates/default/css/jquery.lightbox.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="templates/default/css/jquery.tooltip.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="templates/default/css/jquery.ui.datepicker.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="templates/default/css/jquery.ui.theme.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="templates/default/css/jquery.colorpicker.css" media="screen" />
	<!--[if lte IE 6]><link type="text/css" rel="stylesheet" href="templates/default/css/ie6.css" media="screen" /><![endif]-->
	<script type="text/javascript" src="templates/default/scripts/jquery.js"></script>
	<script type="text/javascript" src="templates/default/scripts/jquery.functions.js"></script>
</head>
<body>

	<div id="container">

		{include file="header.tpl"}
		{include file="sidebar.tpl"}
		
		<div id="content">
			{include file=$template}
		</div>
		<div class="clear"></div>

	</div><!-- container -->
	
	{include file="footer.tpl"}

	<script type="text/javascript" src="templates/default/scripts/jquery.lightbox.js"></script>
	<script type="text/javascript" src="templates/default/scripts/jquery.colorpicker.js"></script>
	<!--[if lte IE 6]><script type="text/javascript" src="templates/default/scripts/DD_belatedPNG.js"></script><![endif]-->
	
</body>
</html>