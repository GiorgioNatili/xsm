
<?php
/*foreach($_POST as $key=>$value) {echo "<b>$key:</b> $value<br />rn";} */

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
die('submit-screen.php could not connect via function connectDB:' . mysql_error());
}
echo 'submit-screen.php connected successfully via function connectDB<br />'. $conn . '<br />';

$sql="INSERT INTO asus (
studyid,
age,
age16,
username,
p1_q1,
p1_q2,
p1_q3,
p1_q4,
p1_q5,
p1_q6,
p2a_q1,
p2a_q2,
p2b_q1,
p2c_q1,
p2c_q2,
p2d_q1,
p2d_q2,
p2d_q3,
p2d_q4,
p2d_q5,
p2e_q1,
p2e_q2,
p2e_q3,
p2e_q4,
p2e_q5,
p2e_q6,
c_Car,
c_Ride,
c_Drive,
c_Relax,
c_Alone,
c_Forget,
c_Family,
c_Trouble,
login1_t,
login2_t,
page0_t,
page1_t,
p1_q1_t,
p1_q2_t,
p1_q3_t,
p1_q4_t,
p1_q5_t,
p1_q6_t,
page2_t,
page2a_t,
p2a_q1_t,
p2a_q2_t,
page2b_t,
p2b_q1_t,
page2c_t,
p2c_q1_t,
p2c_q2_t,
page2d_t,
p2d_q1_t,
p2d_q2_t,
p2d_q3_t,
p2d_q4_t,
p2d_q5_t,
page2e_t,
p2e_q1_t,
p2e_q2_t,
p2e_q3_t,
p2e_q4_t,
p2e_q5_t,
p2e_q6_t,
page3_t,
c_Car_t,
c_Ride_t,
c_Drive_t,
c_Relax_t,
c_Alone_t,
c_Forget_t,
c_Family_t,
c_Trouble_t,
page,
crafft,
rafft,
use12,
use90,
admin,
site,
status,
session,
version
) VALUES (
'$_POST[studyid]',
'$_POST[age]',
'$_POST[age16]',
'$_POST[username]',
'$_POST[p1_q1]',
'$_POST[p1_q2]',
'$_POST[p1_q3]',
'$_POST[p1_q4]',
'$_POST[p1_q5]',
'$_POST[p1_q6]',
'$_POST[p2a_q1]',
'$_POST[p2a_q2]',
'$_POST[p2b_q1]',
'$_POST[p2c_q1]',
'$_POST[p2c_q2]',
'$_POST[p2d_q1]',
'$_POST[p2d_q2]',
'$_POST[p2d_q3]',
'$_POST[p2d_q4]',
'$_POST[p2d_q5]',
'$_POST[p2e_q1]',
'$_POST[p2e_q2]',
'$_POST[p2e_q3]',
'$_POST[p2e_q4]',
'$_POST[p2e_q5]',
'$_POST[p2e_q6]',
'$_POST[c_Car]',
'$_POST[c_Ride]',
'$_POST[c_Drive]',
'$_POST[c_Relax]',
'$_POST[c_Alone]',
'$_POST[c_Forget]',
'$_POST[c_Family]',
'$_POST[c_Trouble]',
'$_POST[login1_t]',
'$_POST[login2_t]',
'$_POST[page0_t]',
'$_POST[page1_t]',
'$_POST[p1_q1_t]',
'$_POST[p1_q2_t]',
'$_POST[p1_q3_t]',
'$_POST[p1_q4_t]',
'$_POST[p1_q5_t]',
'$_POST[p1_q6_t]',
'$_POST[page2_t]',
'$_POST[page2a_t]',
'$_POST[p2a_q1_t]',
'$_POST[p2a_q2_t]',
'$_POST[page2b_t]',
'$_POST[p2b_q1_t]',
'$_POST[page2c_t]',
'$_POST[p2c_q1_t]',
'$_POST[p2c_q2_t]',
'$_POST[page2d_t]',
'$_POST[p2d_q1_t]',
'$_POST[p2d_q2_t]',
'$_POST[p2d_q3_t]',
'$_POST[p2d_q4_t]',
'$_POST[p2d_q5_t]',
'$_POST[page2e_t]',
'$_POST[p2e_q1_t]',
'$_POST[p2e_q2_t]',
'$_POST[p2e_q3_t]',
'$_POST[p2e_q4_t]',
'$_POST[p2e_q5_t]',
'$_POST[p2e_q6_t]',
'$_POST[page3_t]',
'$_POST[c_Car_t]',
'$_POST[c_Ride_t]',
'$_POST[c_Drive_t]',
'$_POST[c_Relax_t]',
'$_POST[c_Alone_t]',
'$_POST[c_Forget_t]',
'$_POST[c_Family_t]',
'$_POST[c_Trouble_t]',
'$_POST[page]',
'$_POST[crafft]',
'$_POST[rafft]',
'$_POST[use12]',
'$_POST[use90]',
'$_POST[admin]',
'$_POST[site]',
'$_POST[status]',
'$_POST[session]',
'$_POST[version]'
)";

$result = mysql_query($sql,$conn);

if (!$result)
  {
  die('Error in submit-screen.php: ' . mysql_error());
  }
echo "1 record added to table screen";

$age16 = $_POST['age16'];
(string)$studyid = str_pad((int) $_POST['studyid'],5,"0",STR_PAD_LEFT);


$admin = $_POST['admin'];
if ($admin == "a") {
	$admin = "p";
}
else if ($admin == "p") {
	$admin = "a";
}

$paramList = "";

if ($_POST['status'] != "complete") {

	$paramList = '?studyid='.$studyid.'&status=complete&age16='.$age16.'&admin='.$admin;
}
$head = 'Location: https://myvyou.com/asus/';

switch($_POST['site']) {
	case 1:
		header( $head.'bmc.htm'.$paramList ) ;
		break;
	case 2:
		header( $head.'tufts.htm'.$paramList ) ;
		break;
	case 3:		
		header( $head.'cha.htm'.$paramList ) ;
		break;
	default:
		header( $head.'asus.htm'.$paramList ) ;
		break;
} 

mysql_close($conn);

?>

<script type="text/javascript">
function GetURLParameter(sParam)  {  
     	   var sPageURL = window.location.search.substring(1);  
 		   var sURLVariables = sPageURL.split('&');  
			
  		   for (var i = 0; i < sURLVariables.length; i++)   
  		   {  
    		     var sParameterName = sURLVariables[i].split('=');  
      		   	 
				 if (sParameterName[0] == sParam)   
      		     {  
        		     return sParameterName[1];  
       		     }  
    		 }  
 		 } 
		
var username = GetURLParameter('username');  
	
function toindex() {
		//var url = "crafft.asp?studyid=" + studyid;
		//openFullScreen(url, "crafft");
		window.open('s6.htm?='+username+'&status=complete', 'google', 'fullscreen=yes,location=no,toolbar=0,directories=no,status=no,menubar=no,scrollbars=no');
	}
</script>	
<html>
<head>
	<title>Submit Screen</title>
</head>

<body>

</body>
</html>
