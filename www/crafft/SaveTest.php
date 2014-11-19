<html>
<head>
<title>iMET Save PHP Test</title>
</head>
<body>
<?php
include '../imet/config/config.php';

function connectDB()
	{
		//echo DB_NAME;
		if($conn=mysql_connect(DB_SERV,DB_USER,DB_PASS))
		{
			if(mysql_select_db(DB_NAME,$conn))
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
$conn = connectDB();
if (!$conn) {
die('SaveTest.php could not connect via function connectDB:' . mysql_error());
}
echo 'SaveTest.php connected successfully via function connectDB<br />'. $conn . '<br />';


$sql="INSERT INTO test (student, score)
VALUES
('$_POST[student]','$_POST[score]')";

if (!mysql_query($sql,$conn))
  {
  die('Error in SaveTest.php: ' . mysql_error());
  }
echo "1 record added to table Test";

mysql_close($conn);



?>	

