<?php
//   echo "THE FLAG VALUE IS ".$_SESSION['flag'];

  if( $_SESSION['flag']=='FALSE'){
    $consumerID = md5(uniqid(rand(), true));
    $_SESSION['consumerID']= $consumerID; 
    
    }
  $jukeboxaddress = $_SESSION['jukeboxid'];
  $trackid = $_SESSION['trackid'];
  $serveripaddr = "http://46.137.213.123/moojic-webapp/moojic1/moojic-new/database.php?consumerid=".$_SESSION['consumerID'];
  $title="";$image="";
  $url = "http://54.251.100.200:8080/MoojicServer/getPlaylist?jukebox=".$jukeboxaddress;
  $input=file_get_contents($url);
  $json = json_decode($input,true);
  $results = count($json['songList']);
  for($r = 0;$r<$results;$r++){
        if($json['songList'][$r]['trackNo'] == $trackid){
        if(isset($json['songList'][$r]['title']))  $title = $json['songList'][$r]['title'];  
        if(isset($json['songList'][$r]['image']))  $image = $json['songList'][$r]['image'];
          break;
     }

  }

  $dbhost = 'localhost:3306';
  $dbuser = 'root';
  $dbpass = 'root'; 
  $db = "moojicwebapp"; 
  
  $link = mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
  mysql_select_db($db);
 if($_SESSION['flag']=='FALSE'){
  $sql = "INSERT INTO response "."(consumerID,response) "."VALUES('$_SESSION[consumerID]','empty')";
  $result = mysql_query($sql , $link) or die(mysql_error());
  $_SESSION['flag']= 'TRUE';
 }
  // echo "consumer id in update ".$_SESSION['consumerID']."</br>";

   /* curl request to android jukebox*/
   $url = 'http://54.251.100.200:8080/MoojicServer/queueRequest/';
   $curl = curl_init();
   if (!$curl) {
    die("Couldn't initialize a cURL handle");
    }
// set some cURL options
   curl_setopt($curl, CURLOPT_URL,            $url);
   curl_setopt($curl, CURLOPT_HEADER,         1);
   curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl, CURLOPT_TIMEOUT,        30);
   curl_setopt($curl, CURLOPT_POST, true);
     
   $parameters = array('consumerId' => $_SESSION['consumerID'] ,'trackId' => $trackid , 'trackName' => $title , 'image' => $image ,
    'gcm_Id' => $serveripaddr , 'fb_Id' => '' , 'twitter_Id' => '' , 'locationId' => $jukeboxaddress , 'deviceType' => 'browser');
   $json = json_encode($parameters);
   curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
   $response = curl_exec($curl);
   if (empty($response)) {
    die(curl_error($curl));
    curl_close($curl); 
} else {
    $info = curl_getinfo($curl);
  //  if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === '200') echo "CURLINFO_HTTP_CODE returns a string.";
   // if(curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200) echo "CURLINFO_HTTP_CODE returns an integer.";
    curl_close($curl); 
      
    if (empty($info['http_code'])) {
     //       die("No HTTP code was returned"); 
    } else {
        
       // echo "</br>The server responded: <br />";
       // echo $info['http_code'];
           }

 }
// var_dump($response);
   
  // Convert the result from JSON format to a PHP array 
 // $result = json_decode($response);
  ?>

