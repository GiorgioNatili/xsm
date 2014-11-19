<html>
<head>
<title>iMET PHP Test</title>
</head>
<body>

<form action="SaveTest.php" method="post">
Name: <input type="text" name="student" />
Score: <input type="text" name="score" />
<input type="submit" />
</form>


<?php 
//phpinfo(); 
?>
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
die('test.php could not connect via function connectDB:' . mysql_error());
}
echo 'test.php connected successfully via function connectDB<br />'. $conn . '<br />';

$result = mysql_query('select * from sites',$conn);

while($row = mysql_fetch_array($result))
  {
  echo $row['name'] . " " . $row['code'];
  echo "<br />";
  }

  
  
  
  
  
mysql_close($conn);


?>
</body>
</html>
