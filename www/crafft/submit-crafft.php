
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
die('submit-crafft.php could not connect via function connectDB:' . mysql_error());
}
echo 'submit-crafft.php connected successfully via function connectDB<br />'. $conn . '<br />';

$sql="INSERT INTO screen (w1_t, w2_t, w3_t, q1, q1_t, q2, q2_t, q3, q3_t, q4, q4_t, q5, q5_t, q6, q6_t, q7, q7_t, q8, q8_t, q9, q9_t, q10, q10_t, q11, q11_t, q12, q12_t,
q13, q13_t, q14, q14_t, q15, q15_t, q16, q16_t, q17, q17_t, q18, q18_t, q19, q19_t, q20, q20_t, q21, q21_t, q22, q22_t, q23, q23_t, q24, q24_t, q25, q25_t,
q26, q26_t, q27, q27_t, q28, q28_t, q29, q29_t, q30, q30_t, q31, q31_t, q32, q32_t, q33, q33_t, q34, q34_t, q35, q35_t, q36, q36_t, q37, q37_t, q38, q38_t,
q39, q39_t, q40, q40_t, q41, q41_t, q42, q42_t, q43, q43_t, q44, q44_t, score, score1_t,level, 
info1_t, info2_t, info3_t, info4_t, info5_t, info6_t, info7_t, info8_t, info9_t, info10_t, info11_t)
VALUES
('$_POST[w1_t]','$_POST[w2_t]','$_POST[w3_t]','$_POST[q1]','$_POST[q1_t]','$_POST[q2]','$_POST[q2_t]','$_POST[q3]','$_POST[q3_t]','$_POST[q4]','$_POST[q4_t]',
'$_POST[q5]','$_POST[q5_t]','$_POST[q6]','$_POST[q6_t]','$_POST[q7]','$_POST[q7_t]','$_POST[q8]','$_POST[q8_t]','$_POST[q9]','$_POST[q9_t]','$_POST[q10]','$_POST[q10_t]',
'$_POST[q11]','$_POST[q11_t]','$_POST[q12]','$_POST[q12_t]','$_POST[q13]','$_POST[q13_t]','$_POST[q14]','$_POST[q14_t]','$_POST[q15]','$_POST[q15_t]','$_POST[q16]',
'$_POST[q16_t]','$_POST[q17]','$_POST[q17_t]','$_POST[q18]','$_POST[q18_t]','$_POST[q19]','$_POST[q19_t]','$_POST[q20]','$_POST[q20_t]','$_POST[q21]','$_POST[q21_t]',
'$_POST[q22]','$_POST[q22_t]','$_POST[q23]','$_POST[q23_t]','$_POST[q24]','$_POST[q24_t]','$_POST[q25]','$_POST[q25_t]','$_POST[q26]','$_POST[q26_t]','$_POST[q27]',
'$_POST[q27_t]','$_POST[q28]','$_POST[q28_t]','$_POST[q29]','$_POST[q29_t]','$_POST[q30]','$_POST[q30_t]','$_POST[q31]','$_POST[q31_t]','$_POST[q32]','$_POST[q32_t]',
'$_POST[q33]','$_POST[q33_t]','$_POST[q34]','$_POST[q34_t]','$_POST[q35]','$_POST[q35_t]','$_POST[q36]','$_POST[q36_t]','$_POST[q37]','$_POST[q37_t]','$_POST[q38]',
'$_POST[q38_t]','$_POST[q39]','$_POST[q39_t]','$_POST[q40]','$_POST[q40_t]','$_POST[q41]','$_POST[q41_t]','$_POST[q42]','$_POST[q42_t]',
'$_POST[q43]','$_POST[q43_t]','$_POST[q44]','$_POST[q44_t]','$_POST[score]','$_POST[score1_t]','$_POST[level]','$_POST[info1_t]','$_POST[info2_t]','$_POST[info3_t]',
'$_POST[info4_t]','$_POST[info5_t]','$_POST[info6_t]','$_POST[info7_t]','$_POST[info8_t]','$_POST[info9_t]','$_POST[info10_t]','$_POST[info11_t]')";

$result = mysql_query($sql,$conn);

if (!$result)
  {
  die('Error in submit-crafft.php: ' . mysql_error());
  }
echo "1 record added to table Test";

mysql_close($conn);

   header( 'Location: http://myvyou.com/crafft/index.html?status=complete' ) ;
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
		window.open('index.html?username='+username+'&status=complete, 'google', 'fullscreen=yes,location=no,toolbar=0,directories=no,status=no,menubar=no,resizable=no,scrollbars=no');
	}
</script>	
<html>
<head>
	<title>Submit crafft</title>
</head>

<body onload="toindex()">



</body>
</html>
