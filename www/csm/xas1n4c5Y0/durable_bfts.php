<?php
$request = $_SERVER['REQUEST_METHOD'];
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
include '../imet/config/config.php';
echo $url;
echo $request;



function connectCSM_DB()
	{
		if($conn=mysql_connect(DB_SERV,DB_USER,DB_PASS))
		{
			if(mysql_select_db(CSM_DB_NAME,$conn))
			{
				mysql_query('set names utf8',$conn);
				return $conn;
			}
			else
			{
				echo 'db select failed';
				exit();
			}
		}
		else 
		{
			echo 'db connect failed';
			exit();
		}
	}
	
$conn = connectCSM_DB();
if (!$conn) {
die('durable_bfts.php could not connect via function connectDB:' . mysql_error());
}
echo 'durable_bfts.php connected successfully via function connectCSM_DB<br />'. $conn . '<br />';









$head = 'Location: https://myvyou.com/csm/';


mysql_close($conn);

?>

<!DOCTYPE html>	
<html>
<head>
<meta lang="en" />
<meta name="robots" content="NOINDEX, NOFOLLOW">
<title>Durable BFTS</title>
</head>

<body>

Create DURABLE_BFTS table

</body>
</html>
