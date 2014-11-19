<?php 
$message = array(); 
include '../../imet/config/config.php';

$verb = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI']);
if (isset($uri['query'])) {parse_str($uri['query']);}

$conn = connect_db(CSM_DB_NAME);
if (!$conn) {console_exit('Could not connect to database ' . CSM_DB_NAME . ' via function connect_db' . mysql_error());}

switch ($verb) {

	case "PUT":	
		if (!isset($table)){console_exit("No table parameter recieved in URI query.");}
		$design = file_get_contents("php://input",NULL,NULL,0,2047);
		$sql = "CREATE TABLE BFT_" . $table . " (" . $design . ");";
		$message[] = "Sent Query: " . $sql;
//			Suggested Schema:	
//			id			int(8) NOT NULL AUTO_INCREMENT FIRST,
//			
//			machine		  int(4),
//			datetime	  varchar(50),
//			createSeq	  int(4),
//			ra			  varchar(50),
//			participantID int(4),
//			keyname		  varchar(255),
//			value		  varchar(32000),
//			unique 		  (machine, datetime, createSeq)
//			primary key (id)
		$result = mysql_query($sql,$conn);
		if (!$result) {console_exit("Sent SQL command: " . $sql . " and got error: " . mysql_error());}
		$message[] = "Table " . $table .  " added to database " . CSM_DB_NAME . ".";
		echo json_encode($message);
		break;
		
	case "DELETE":		
		$sql = "SELECT * FROM DURABLE_BFTS WHERE name = 'BFT_" . $table . "';";
		$result = mysql_query($sql,$conn);
		if (!$result) {console_exit('Failed attempt to check DURABLE_BFTS to see if table is durable ' . mysql_error());}
		$numrows = mysql_num_rows($result);
		$message[] = "Durable status check for table BFT_" . $table . "yielded count = " . $numrows ;			
		if($numrows == '0'){	
			$sql = "DROP TABLE BFT_" . $table . ";";			
			$result = mysql_query($sql,$conn);
			if (!$result) {console_exit('Failed attempting to delete table: ' . mysql_error());}
			$message[] = "Table BFT_" . $table .  " dropped from database " . CSM_DB_NAME ;		
		} else {
			$message[] = "Table BFT_" . $table . " is durable and so it cannot be deleted from " . CSM_DB_NAME ;
		}
		echo json_encode($message);
		break;			

	case "POST": 
		$hasdata = FALSE;
		$data = file_get_contents("php://input");
		$data = json_decode($data,TRUE);	
		if (sizeof($data) > 0) {$hasdata = TRUE;}
		if (!isset($maxPostedRow)){console_exit("No 'maxPostedRow' parameter recieved in URI query.");}		
		if (!isset($postingMachine) && $hasdata){console_exit("No 'postingMachine' parameter recieved in URI query for saving data.");}	 
		$sql = "SHOW TABLES LIKE 'BFT_".$table."';";
		$result = mysql_query($sql,$conn);
		if (!$result) {console_exit('Failed attempting to show table' . mysql_error());}
		$hastable = mysql_num_rows($result);
		if ($hastable != "1") 
			{console_exit("There is no table named BFT_" . $table . " in database " . CSM_DB_NAME );}
		if (is_null($data) || $data == '') {$message[] = "Received no POST data";}
		//build INSERT string
		$row = array();
		$sql = "INSERT INTO BFT_" . $table . " "; 
		if ($hasdata) {
			foreach ($data as $row){
				$sql .= "(machine, " . implode(',',array_keys($row)) . ") VALUES ";
				break;		
			}
			$sqlrow = array();
			foreach ($data as $row){
				$row = array_map('mysql_real_escape_string', $row);			
				$sqlrow[] = "(". $postingMachine . ",'" . implode("','",array_values($row)) . "')"; //a row of data in form (val1,val2,...),
			}
			$sql .= implode (',',$sqlrow);		//glue all the rows together (with no trailing ',')
			$sql .= " ON DUPLICATE KEY UPDATE ID=ID;";	
			//Note: this prevents duplicate inserts if UNIQUE is defined while not throwing an error 
			// For example, the UNIQUE (POSTINGMACHINE, TIMESTAMP, CREATESEQ) will work
			// BUT those fields need to be defined as NOT NULL because
			// mysql has a problem where NULL is considered unique (?!)
			$result = mysql_query($sql);
			if (!$result) {console_exit('Failed attempting to save POST data - data were not saved. SQL command = '. $sql . ' mysql error: ' . mysql_error());}
			else { $message[] = "POST data were saved";}
		}
		$sql = "SELECT * FROM BFT_" . $table . " WHERE ";
		if(isset($postingMachine)) {$sql .= "machine != '" . $postingMachine . "' AND ";}
		$sql .= "id > " . $maxPostedRow . " ;";
		$result = mysql_query($sql,$conn);
		if (!$result) {console_exit('Failed in attempt to fetch data in response to POST request. mysql error:' . mysql_error());}
		$returnData = array();
		while($row = mysql_fetch_assoc($result)){
     		$returnData[] = $row;
		}
		$json = json_encode(array($message,$returnData));  //respond with messages and result in one json object
		echo $json;
		break;	
}
mysql_close($conn);

function connect_db($db)
	{
		if($conn=mysql_connect(DB_SERV,DB_USER,DB_PASS))
		{
			if(mysql_select_db($db,$conn))
			{
				mysql_query('set names utf8',$conn);
				return $conn;
			}
			else
			{
				$message[] = 'db select failed';
				exit();
			}
		}
		else 
		{
			$message[] = 'db connect failed';
			exit();
		}
	}

function console_exit($msg) {
header($_SERVER["SERVER_PROTOCOL"]." 400: BAD REQUEST");
	global $message;
	$message[] = "db.php Terminated. Error: " . $msg ;
	echo json_encode($message);
	exit;
}
?>
