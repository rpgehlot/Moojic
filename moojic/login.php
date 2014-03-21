<?php
include 'fbaccess.php';
$my_url = "http://46.137.213.123/moojic-webapp/moojic1/moojic-new/bootstrap-data.php";   
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root'; 
$db = "moojicwebapp"; 
$c = mysql_connect($dbhost,$dbuser,$dbpass,$db) or die(mysql_error());


if($c && $user)
{

                 
                
                 $sql = "SELECT accesstoken FROM userdata  WHERE userid = '". $user."'";
                 mysql_select_db( $db);
                 $result = mysql_query($sql, $c) or die(mysql_error());
                 $row = mysql_fetch_array($result);
                 if(isset($row['accesstoken']))
         {
                              
                              $access_token = $row['accesstoken'];
                              $graph_url = "https://graph.facebook.com/me?" . "access_token=" . $access_token;
                              $response = file_get_contents($graph_url);
                              $decoded_response =json_decode($response,true);
                             
                              if($decoded_response){
                                $facebook->setAccessToken($access_token);
                              }
                              
                              if(!$decoded_response && $_SESSION['j']==1)
                              {
                                 $code = $_REQUEST['code'];
                                

                                       if(isset($code))
                                       {
                                
                                $token_url="https://graph.facebook.com/oauth/access_token?client_id="
                                          . $app_id . "&redirect_uri=" . urlencode($my_url) 
                                          . "&client_secret=" . $app_secret 
                                          . "&code=" . $code . "&display=popup";
                                
                                $response = file_get_contents($token_url);
                                $decoded_response = json_decode($response,true);
                                $params = null;
                                parse_str($response, $params);
                              
                                $access_token = $params['access_token'];
                            
                                $graph_url = "https://graph.facebook.com/me?"
                                . "access_token=" . $access_token;
                                 $response = file_get_contents($graph_url);
                                 $decoded_response = (array)json_decode($response);
                               if (isset($decoded_response)) {
                                   
                                     mysql_query("DELETE FROM userdata WHERE userid = '".$_SESSION['user']."'",$c) or die(mysql_error());
                                     $sql = "INSERT INTO userdata "."(userid,accesstoken,exptime) "."VALUES('$_SESSION[user]','$params[access_token]', '$params[expires]')";
                                     $ret = mysql_query($sql ,$c) or die(mysql_error());
                                    
                                                           }                 
                                               }


                                  
                             } 
                                
                                                           
                     $_SESSION['j'] =  $_SESSION['j'] + 1;                                      
                     if (isset($decoded_response->error)) {
               
                                if ($decoded_response->error->type == "OAuthException") {
                                    
                                     $dialog_url= "https://www.facebook.com/dialog/oauth?". "client_id=" . $app_id. "
                                     redirect_uri=" .urlencode($my_url);
                                     echo("<script> top.location.href='" . $dialog_url 
                                           . "'</script>");
                                        
                                     }
                               else { echo "other error has happened";}
                                                  
                                                  }
             else {
  
               $token = $facebook->getAccessToken();
            
               $facebook->setAccessToken($token);
               $_SESSION['access_token'] = $token;
              
                  

               
                
              }
      }

else{
         $_SESSION['j'] =  $_SESSION['j'] + 1;
         
      
        $_SESSION['accesstoken']=$facebook->getAccessToken() ;
      
        $sql = "INSERT INTO userdata "."(userid,accesstoken,exptime) "."VALUES('$user','$_SESSION[accesstoken]', 'null')";
        $ret = mysql_query($sql ,$c) or die(mysql_error());
       
                
        
       
   }


 
}

else {

  header('Location: http://46.137.213.123/moojic-webapp/moojic1/moojic-new/index.php');
}

  function curl_get_file_contents($URL) {
                                  $c = curl_init();
                                  curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                                  curl_setopt($c, CURLOPT_URL, $URL);
                                  $contents = curl_exec($c);
                                  $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
                                  curl_close($c);
                                 return $contents;
                                }

mysql_close($c);
?>
