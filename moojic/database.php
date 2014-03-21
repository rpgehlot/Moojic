  <?php      
        session_start();    
        $consumerid = $_GET['consumerid'];
         $request_body = file_get_contents('php://input');
       $request_body1 = json_decode($request_body,true);
     /*   var_dump($request_body);
  //     echo "The consumerid is".$request_body['consumerId'];
     //   $consumerid = $request_body['consumerId'];
        $response_const = $request_body['responseConst'];*/
  //      $request_body = $request_body . $consumer;
          $response_const = $request_body1['responseConst'];
         $fh = fopen('data.txt','w');
        fwrite($fh,$request_body);
        fclose($fh);
        $res = array( 
        "GCM_TA" =>"Your song has been added to the playlist!",
        "GCM_TAR"=>"Your previous request is already in the queue. Please request again after your song is played.",
        "GCM_TAP"=>"Hey! You have requested a popular track  on Moojic and it is already in queue. Why dont you request another one?",
        "GCM_JNR"=>"Jukebox is not running currently, please ask Admin to start it.",
        "GCM_NO"=>"Jukebox not online.please try later.",
        "GCM_SF"=>"Our server failed, sorry for inconvenience."
                 
         );
        $dbhost = 'localhost:3306';
        $dbuser = 'root';
        $dbpass = 'root';
        $conn = mysql_connect($dbhost, $dbuser, $dbpass);
        if(! $conn )
        {
         die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('moojicwebapp');
        $response="";
        if($response_const=="GCM_TA"){
            $response = $res['GCM_TA'];}
        else if($response_const=="GCM_TAR"){
            $response = $res['GCM_TAR'];}
        else if($response_const=="GCM_TAP"){
            $response = $res['GCM_TAP'];}
        else if($response_const=="GCM_JNR"){
            $response = $res['GCM_JNR'];}
        else if($response_const=="GCM_NO"){
            $response = $res['GCM_NO'];}
        else if($response_const=="GCM_SF"){
            $response = $res['GCM_SF'];}
        else $response = "Some error happened!!we will be back soon.";
       
        $sql = "UPDATE response SET response = '".$response ."' WHERE consumerID ='". $consumerid."'";
        $result = mysql_query($sql , $conn) or die(mysql_error());
        if($result)
        echo "Database has been updated successfully\n";

?>
