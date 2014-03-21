<!DOCTYPE HTML>
  <!--
	TXT 2.0 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->

<html>
	<head>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
			<div id="fb-root"></div>
<script>
  // Additional JS functions here
            window.fbAsyncInit = function() {
                  FB.init({
                  appId      : '154107674770730', // App ID
                  channelUrl : '192.168.190.129/htm/channel.php', // Channel File
                  status     : true, // check login status
                  cookie     : true, // enable cookies to allow the server to access the session
                  xfbml      : true  // parse XFBML
                         });
             };
        
    // Additional init code here

  

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
                
                                     
                           FB.logout(function (response) {
                           window.location = "http://192.168.190.129/htm/logout.php";
                                         });
                        
            });
        });
         </script>
         		<title>Left Sidebar - TXT by HTML5 UP</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700|Open+Sans+Condensed:700" rel="stylesheet" />
		<script src="js/jquery.min.js"></script>
		<script src="js/config.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		
		<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script> 
       
        <script type="text/javascript" src="js/jquery-search.js"></script> 
	
      
      

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/table.css" rel="stylesheet" media="screen">
      
		
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<!--[if lte IE 7]><link rel="stylesheet" href="css/ie7.css" /><![endif]-->
	</head>
	




	<body>
<?php
include '../fbaccess.php';

$my_url = "http://192.168.190.129/htm/left.php";   
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

  header('Location: http://192.168.190.129/htm/index.php');
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

		<!-- Header -->
			<header id="header">
				<div class="logo">
					<div>
						<h1><a href="#" id="logo">Select a Location</a></h1>
						
					</div>
				</div>
			</header>
<?php
$url = "http://54.251.246.31:8080/MoojicServer/getLocations";
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
$url = "http://54.251.246.31:8080/MoojicServer/getLocations";
$string = get_data($url);
$string = utf8_encode($string);
$json_a=json_decode($string,true);

$rest  = array();
$addr  = array();
$cont  = array();
$num   = array();
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

 for($j=1;$j<$i;$j++)$num[$j]=$j;
 mysql_close($conn);

 ?>
		<!-- /Header -->

		<!-- Nav -->
			<nav id="nav" class="skel-panels-fixed">
				<ul>
					<li><a id="index_page" href="index.html">Home</a></li>
					<li class="current_page_item"><a id="left" href="left-sidebar.html">Left Sidebar</a></li>
					 <?php 
					  if($user) {
				        $user_profile = $facebook->api('/me','GET');
				        echo "<li> <a id='profile' href='http://www.facebook.com/me'>".$user_profile['name']."</a></li>";
				        } 
		               ?>   				
					  <li><a id="logout" href="#" >Logout</a></li>
							
				</ul>
			</nav>
		<!-- /Nav -->
		
		<!-- Mai -->
			<div id="main-wrapper">
				<div id="main" class="container">
					<div class="row1">
							<div class="9u skel-cell-mainContent">
								<form id="search" style="padding-top:40px" class="form-search">
						             <input type="text" id="searchData" style="margin-left:15px;display:inline" class="input-medium search-query">
									  <button style="margin-left:;" type="submit" class="btn">Search</button>
							  </form> 
							<div class="content content-right" >
							
								<!-- Content -->
						
									<article class="is-page-content">

										<header id="hd">									
                              				 <div id="result"></div>
											<div class="col" id="c1">
                                                Restaurant Name   </div> <div id="c2"  class="col" >      address</div>
                                                  <div  style="width:310px;height:300px;overflow-y:scroll;overflow-x:none;">	
                                                 
                                                  <table  style="width:280px;margin-left:20px;" class="zebra">
												  <tbody id="results" style="height:80px;overflow-y:scroll;">
												  

												     

												  </tbody>
                                                
												</table>
										  </div>
										</header>

									</article>

								<!-- /Content -->
								
							</div>
						</div>
					</div>
					
				</div>
			</div>
		<!-- /Main -->

		<!-- Footer -->
			<footer id="footer" class="container">
								<div class="row">
					<div class="12u">

						<!-- Contact -->
							<section>
								<h2 class="major"><span>Get in touch</span></h2>
								<ul class="contact">
									<li><a href="#" class="facebook">Facebook</a></li>
									<li><a href="http://twitter.com/n33co" class="twitter">Twitter</a></li>
									<li><a href="http://n33.co/feed/" class="rss">RSS</a></li>
									<li><a href="http://dribbble.com/n33" class="dribbble">Dribbble</a></li>
									<li><a href="#" class="linkedin">LinkedIn</a></li>
									<li><a href="#" class="googleplus">Google+</a></li>
								</ul>
							</section>
						<!-- /Contct -->
					
					</div>
				</div>
				<div class="row">

					<!-- Copyright -->
						<div id="copyright">
							&copy; 2012 Untitled Something | Images: <a href="http://fotogrph.com">fotogrph</a> + <a href="http://iconify.it">Iconify.it</a> | Design: <a href="http://html5up.net/">HTML5 UP</a>
						</div>
					<!-- /Copyright -->

				</div>
			</footer>
		<!-- /Footer -->
		<script type="text/javascript">
          var pausecontent = new Array();
          var res = new Array();
          var ad = new Array();
          var co = new Array();
           <?php foreach($num as $key => $val){ ?>
           pausecontent.push('<?php echo $val; ?>');
           <?php } ?>
           <?php foreach($rest as $key => $val){ ?>
           res.push('<?php echo $val; ?>');
           <?php } ?>
           <?php foreach($addr as $key => $val){ ?>
           ad.push('<?php echo $val; ?>');
           <?php } ?>
           <?php foreach($cont as $key => $val){ ?>
           co.push('<?php echo $val; ?>');
           <?php } ?>
           var table = document.getElementById("results");
           var number = '<?php echo $i; $i=1;?>';
           for(var j=1;j<number;j++){
     
               var tr = table.insertRow();
               
               var td = tr.insertCell();
               td.innerHTML= res[j-1];
               td.className = "clour";
               var td =tr.insertCell();
               td.innerHTML= ad[j-1];
               td.className = "clour";
              
                 }

         </script>

	</body>
</html>
