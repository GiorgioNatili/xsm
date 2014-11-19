<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Untitled</title>
</head>

<body>

</head>
<body>

<form action="Selftest.php" method="post">
Student Name: <input type="text" name="student" />
Score: <input type="text" name="score" />
<input type="submit" name="flag" value="Save" />
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

//Example displaying rows from SELECT query
$result = mysql_query('select * from sites',$conn);

while($row = mysql_fetch_array($result))
  {
  echo $row['name'] . " " . $row['code'];
  echo "<br />";
  }
//Example of saving form data to database using INSERT Query from same form  


if(isset ($_POST['flag']))
	{
		$student = $_POST['student'];
		$score = $_POST['score'];
		echo "student".$student;
		if ((!$student) || (!$score))  //Example validation - require some value for both
			{
			echo "Enter both Name and Score!";
			}
		else
			{  
			$sql="INSERT INTO test (student, score)
				 VALUES
				 ('$student','$score')";
			if (!mysql_query($sql,$conn))
  				{
  				die('Error in SaveTest.php: ' . mysql_error());
  				}
			echo "1 record added to table Test";
 			}
	}
mysql_close($conn);

?>
</body>
</html>


