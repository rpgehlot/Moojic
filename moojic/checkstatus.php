 <?php 
        session_start();       
        $limit = 20;
        set_time_limit($limit);
 

        $_SESSION['jukeboxid'] = $_GET['jukeboxid'];
	$_SESSION['trackid'] = $_GET['trackid'];

        include 'update.php';
 //  echo $_SESSION['consumerID'];
        $dbhost = 'localhost:3306';
	$dbuser = 'root';
	$dbpass = 'root'; 
	$db = "moojicwebapp"; 


	$link = mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
	mysql_select_db($db);
        //  echo "consumer id in checkstatus".$_SESSION['consumerID'];
	$sql = "SELECT response FROM response WHERE consumerID='".$_SESSION['consumerID']."'";
	$result = mysql_query($sql , $link) or die(mysql_error());

	$row = mysql_fetch_array($result);

	$initialdata = $row['response'];
	$finaldata   = $row['response'];

	
	while ($initialdata == $finaldata) // check if the data file has been modified
	{
		usleep(10000); // sleep 10ms to unload the CPU

		$result= mysql_query($sql , $link) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$finaldata = $row['response'];
        
	}


	$response = array();
	$response['msg'] = $finaldata;
	echo json_encode($response);
        flush();  
 	
 
?>
