<?php
 include 'fbaccess.php';
 include 'tmhOAuth/examples/auth.php';
 if($user) require 'login.php'; 
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Request Songs</title>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>



<div id="fb-root"></div>
<script>
  
            window.fbAsyncInit = function() {
                  FB.init({
                  appId      : '154107674770730', // App ID
                  channelUrl : 'http://46.137.213.123/moojic-webapp/moojic1/moojic-new/channel.php', // Channel File
                  status     : true, // check login status
                  cookie     : true, // enable cookies to allow the server to access the session
                  xfbml      : true  // parse XFBML
                         });
             };
        
   

  

  // Load the SDK asynchronously
         (function(d){
             var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement('script'); js.id = id; js.async = true;
             js.src = "//connect.facebook.net/en_US/all.js";
             ref.parentNode.insertBefore(js, ref);
             }(document));
         </script>
         <script>
           $(document).ready(function(){
            $("#logout").click(function(){
                
                              alert('hiii');       
                        FB.logout(function (response) {
                           window.location = "http://46.137.213.123/moojic-webapp/moojic1/moojic-new/logout.php";
                                        });
                          
                        
            });
        });
         </script>
    
         <script  src="js/search.js"></script> 
        <script src="js/newjs/bootstrap.min.js"></script>	
	<link href="css/newcss/bootstrap.css" rel="stylesheet" media="screen"/>
	<link href="css/newcss/bootstrap-responsive.css" rel="stylesheet" media="screen"/>
        <style>
  @media (max-width: 480px) { 

   #header{
    text-align:center;
font-size:27px;
font-family:"Times New Roman",Georgia,Serif;
line-height:20px;
   } 
.desc{
	 font-size:12px;
	 display:table-cell;
	 color:black;
	}
 .span12{
 
height: 400px; overflow-y: auto;
margin-top:0px;
padding: 0 0 0 0 ;
}
#results{
width:100%;
height:4%;
}
#searchData{

      margin-left:20%;padding-left:10%;
   }
}
   @media(min-width: 500px){
     #main{
    padding-top:1%;}
   

    #header {
    text-align:center;
    font-size:34px;
    font-family:"Times New Roman",Georgia,Serif;
   line-height:20px;
   }
   .desc{
         font-size:12px;
         display:table-cell;
         color:black;
        }
   #searchData{
      margin-top:7%;    
      margin-left:40%;padding-left:10%;
   }}
         </style>




</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" >
<div class="navbar-inner">
  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
  <span class="icon-bar"></span> 
  <span class="icon-bar"></span> 
  <span class="icon-bar"></span> 
  </a>
   <a class="brand" href="#" >Select a Location </a>
  <div class="nav-collapse">
   <ul class="nav">
       
      
       <?php 

                  if(!isset($resp->screen_name) && $user) {
                $user_profile = $facebook->api('/me','GET');
                echo "<li> <a  href='http://www.facebook.com/me'>".$user_profile['name']."</a></li>";
               echo '<li><a id="logout" href="#" >Logout</a></li>';
                                } 

             if(isset($resp->screen_name)&& !$user){
             $link1 ="https://twitter.com/".$resp->screen_name;
               echo "<li> <a  href='".$link1."'>".$resp->screen_name."</a></li>";
               echo  '<li><a href="?wipe=1" >logout</a>';
               }
               //  echo $resp->screen_name ."-----".$user;
                   ?>  
                   
       
     </ul>
     </div>
     </div>
</nav>


     <?php

function get_data($url) {
  $ch = curl_init();
  $timeout = 50;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
  }
$url = "http://54.251.100.200:8080/MoojicServer/getLocations";
$string = get_data($url);

$string = utf8_encode($string);
$json_a=json_decode($string,true);

$rest  = array();
$addr  = array();
$cont  = array();

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$i=1;

$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
mysql_select_db('moojicwebapp');
$string = "TRUNCATE TABLE restaurant";
$delete = mysql_query($string,$conn) or die(mysql_error());

if(empty($json_a['restaurantList']))
{echo"<p>There's nothing in the array.....</p>";}
else
{

foreach($json_a["restaurantList"] as $link) 
{ 

  $res = "restaurantName";
  if(!isset($link[$res]) || !isset($link['address']) || !isset($link['jukeboxPhoneNo'])){
               
                 $rest[$i]="Cafe name not available";
                 $addr[$i]="Cafe address not available";
                 $cont[$i]="Cafe jukeboxPhoneNo not available";
    
                 if(isset($link[$res])){
                          $rest[$i]=$link['restaurantName'];
                                       } 
                 if(isset($link['address'])){
                          $addr[$i]=$link['address'];
                                       }
                 if(isset($link['jukeboxPhoneNo'])){
                          $cont[$i]=$link['jukeboxPhoneNo'];
                                       }
                 if(isset($link['restaurantName'])&&$link['address']){
                      $sql2 = "INSERT INTO restaurant ".
                      "(restaurant_name,address,contact) ".
                      "VALUES('$rest[$i]','$addr[$i]', 'null')";
                      $a = mysql_query($sql2,$conn)or die(mysql_error());
                                        }
 
                   $i++;continue;
  
}
    else{
            $rest[$i] = $link['restaurantName'];
            $addr[$i] = $link['address'];
            $cont[$i] = $link['jukeboxPhoneNo'];
            $i++;
        }
       
if(! get_magic_quotes_gpc() )
  {
   $var = "'".$link['restaurantName']."'";
   $_SESSION[$var] = $link['jukeboxPhoneNo'];
   $emp_name    = addslashes ($link['restaurantName']);
   $emp_address = addslashes ($link['address']);
   $emp_contact = addslashes ($link['jukeboxPhoneNo']);
   
   }
   
else
{  
   $var = "'".$link['restaurantName']."'";
   $_SESSION[$var] = $link['jukeboxPhoneNo'];
   $emp_name = $link['restaurantName'];
   $emp_address = $link['address'];
   $emp_contact =  $link['jukeboxPhoneNo'];
 
 }

 
$sql = "INSERT INTO restaurant (restaurant_name,address,contact) VALUES ('$emp_name','$emp_address', '$link[jukeboxPhoneNo]')";
$retval = mysql_query( $sql, $conn )or die(mysql_error());

}
}

 ?>
 
        
  <form class="form-search">
  <input  id="searchData" type="text" class="input-medium search-query" >
  </form>
   <div style="text-align:center;" id="result"></div>

      <div id="main" class="container-fluid">
 
           <div class="row-fluid">
                <div class="span12">
               
              <table style="margin-top:1%;border='2';" class="table table-striped">
                  <?php //echo $resp->screen_name ."-----".$user; ?>   
                      <tbody id="results">
                   <?php 
                               for($k=1;$k<$i;$k++){
                         echo '<tr url="http://46.137.213.123/moojic-webapp/moojic1/moojic-new/bootstrap-playlist.php?cafeid='.$rest[$k].'" id="'.$rest[$k].'">
                        <td style="padding-left:10%;letter-spacing:1px;font-size:20px;color:#0080FF;">'.$rest[$k].'<span class="desc">'.$addr[$k].' '.$cont[$k].'</span></td>
                          </tr> ';
                        }

                      mysql_close($conn);
                    ?>
                        </tbody>
                </table>
                </div>
           </div> 
      </div>
</body>
</html>













