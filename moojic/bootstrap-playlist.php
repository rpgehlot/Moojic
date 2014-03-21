<?php
 include 'fbaccess.php';
 include 'tmhOAuth/examples/auth.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
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
      <?php

if(isset($_GET['cafeid'])){
$cafeid = stripslashes($_GET['cafeid']);
$cafeid = htmlentities($cafeid);
}
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root'; 
$db = "moojicwebapp"; 

function slash($str){
 

$state = false;
$buffer = '';
for ($l = 0, $lim = strlen($str); $l < $lim; $l += 1) {
  $char = $str[$l];

  switch ($char) {
    case ",":
      if (!$state) {
        $dst[] = $buffer;
        $buffer = '';
      }
      break;
    case '"':
    if(!$state){
      $dst[] = $buffer;
      $buffer = '';
    }
    break;

    case "'":
      $state = !$state;
      break;

    default:
      $buffer .= $char;
  }
}
return  $buffer;
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Request Songs</title>


<script type="text/javascript">
var n = $(".column td").length;
var w = (100/n);
$(".column td").width(w+'%');


  
    
</script>
 
<script src="js/newjs/bootstrap.min.js"></script>
<link href="css/newcss/bootstrap.css" rel="stylesheet" media="screen"/>
<link href="css/newcss/bootstrap-responsive.css" rel="stylesheet" media="screen"/>
<script type="text/javascript" src="js/postdata.js"></script>
<style>
@media (max-width: 220px) { 
 
    .current{
 
height: 600px; overflow-y: auto;
margin-top:0px;
padding: 0 0 0 0 ;
}
.title{
	font-size:24px;
	}
.desc{
	 font-size:12px;
	 display:table-cell;
	
	}
	.title1{
	font-size:20px;
	}
.desc1{
	 font-size:10px;
	 display:table-cell;
		}
 .request{
	 
	 padding:0 0 0 0;
	 width:33.33%;
	 }
	 .btn btn-primary{
		padding-top:20px;  
	     padding-bottom:0px;
		 width:100%; 
		 
		 }
}
@media (min-width: 500px) { 
  .btn btn-primary{
    height:100px;
    width:100px;
   }
.title{
	font-size:30px;
	}
.desc{
	 font-size:18px;
	 display:table-cell;
	
	}
.current{
 height: 600px; overflow-y: auto;
margin-top:0px;
padding: 0 0 0 0 ;
}
}
.table-striped tbody > tr:first-child {
  background-color: red;
 }
.image{
  margin-right: 10px;
height:100px;
width:100px;
}

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
    <?php if(isset($cafeid))echo '<a class="brand" href="#" >'.$cafeid.'</a>'; ?>
  <div class="nav-collapse">
   <ul class="nav">
       
       <li><a href="bootstrap-data.php">Back</a></li>
       <?php 

            if(!isset($resp->screen_name)&& $user) {
                $user_profile = $facebook->api('/me','GET');
                echo "<li> <a  href='http://www.facebook.com/me'>".$user_profile['name']."</a></li>";
                echo '<li><a id="logout" href="#" >Logout</a></li>';  
                } 
                if(isset($resp->screen_name)&& !$user){
             $link1 ="https://twitter.com/".$resp->screen_name;
               echo "<li> <a  href='".$link1."'>".$resp->screen_name."</a></li>";
               echo  '<li><a href="?wipe=1" >Logout</a>';
}
                   ?>  
        
              
      
     </ul>
     </div>
     </div>
</nav>   
    <div style="padding-top:5%;" class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
            <ul class="nav nav-tabs">
               <li class="active" ><a href="#current" data-toggle="tab" >Whats playing</a></li>            
               <li ><a href="#request" data-toggle="tab">Request songs</a></li>
            </ul>
            <div id = "alert_placeholder"></div>     
            <section class="tab-content">
            <article class="tab-pane active" id="current">
            
           
              <div >
          

<?php
$colink = mysql_connect($dbhost,$dbuser,$dbpass,$db) or die(mysql_error());
if($colink)
  mysql_select_db($db);
$sql = 'SELECT contact FROM restaurant WHERE restaurant_name="'.$cafeid.'"';
$result = mysql_query($sql , $colink) or die(mysql_error());
if($result){
  $rows = mysql_fetch_array($result);
  $contact = $rows['contact'];
}
else{
  echo "Could not be connected to the ".$cafeid ;
    $contact = NULL; 
}



$url = "http://54.251.100.200:8080/MoojicServer/whatsPlaying?jukebox=".$contact;
$string = file_get_contents($url);
$json_a=json_decode($string,true);
$whats_title = array();
$whats_Artist = array();
$whats_Album = array();
$whats_image = array();
$i=1;
if(isset($json_a['songList'])){

      foreach ( $json_a['songList'] as $array) 
   {
     
 
    if(isset($array['title']))$whats_title[$i] = slash($array['title']);
     if(isset($array['artist']))$whats_Artist[$i] = slash($array['artist']);
     if(isset($array['album'])){ $whats_Album[$i] = slash($array['album']);}
     if(isset($array['image']))$whats_image[$i] = slash($array['image']);
    $i=$i+1;

   }
}?>
              <table class="table table-striped">

              <tbody >
                <?php 
                if($i==1){  echo '<tr >
                    <td ><strong>'.$cafeid.' is offline right now!!! try after some time.</strong></td>                    
                                     
               </tr>';}
                  for($k=1;$k<$i;$k++){
                 
                
                    if($k==1){
                   echo ' 
                     <tr >
                    <td ><img class="image" src="'.$whats_image[$k].'" /></td>
                  
                   <td ></td>
                   <td ><p class="title">'.$whats_title[$k].'</p><span class="desc">'.$whats_Album[$k].' '.$whats_Artist[$k].'</span></td>
                                     
               </tr>';
             }
               else{
                 echo ' 
                     <tr>
                    <td ><img class="image" src="'.$whats_image[$k].'" /></td>
                  
                   <td ></td>
                   <td ><p class="title">'.$whats_title[$k].'</p><span class="desc">'.$whats_Album[$k].' '.$whats_Artist[$k].'</span></td>
                                     
               </tr>';
               }
               
             }
                ?>
                
              </tbody>
           </table>
           </div>
            </article>
             <article class="tab-pane" id="request">
             
             <div id="request" class="current">
              <?php
$j=1;
$request_title = array();
$request_artist = array();
$request_album= array();
$request_image = array();
$request_track =array();

$url = "http://54.251.100.200:8080/MoojicServer/getPlaylist?jukebox=".$contact;
$string = file_get_contents($url);
$json_a=json_decode($string,true);
if(isset($json_a['songList'])){

      foreach ($json_a['songList'] as $array) 
   {
     
  
     if(isset($array['title']) && $array['title']!="")  { $request_title[$j] =slash($array['title']);}
     else{$request_title[$j] = "Not available";}
     if(isset($array['artist']) && $array['artist']!="") { $request_artist[$j] = slash($array['artist']);}
     else{$request_artist[$j] = "Not available";}
     if(isset($array['album']) && $array['album']!="")  {$request_album[$j] = slash($array['album']);}
     else{$request_album[$j] = "Not available";}
     if(isset($array['image']) && $array['image']!="")  {$request_image[$j] = slash($array['image']);}
     else{$request_image[$j] = "Not available";}
     if(isset($array['trackNo']))$request_track[$j]=$array['trackNo'];
   
    
  
    $j=$j+1;

   
 
    }
  
}?>
              <table id="a" class="table table-striped">
              <tbody class="current">
              <?php 
                  for($k=1;$k<$j;$k++){
                   echo '<tr>
                    <td class="column"><img class="image" src="'.$request_image[$k].'" /></td>
                  
                
                   <td class="column" ><p class="title1"><strong>'.$request_title[$k].'</strong></p><span class="desc1">'.$request_album[$k].' '.$request_artist[$k].'</span></td>
                           <td class="column"><button style="margin-top:20px;height:50px;width:80px;" id="'.$request_track[$k].'" class="btn btn-primary req" type="button">Request</button></td>          
               </tr>';
             }
                ?>
              
              </tbody>
           </table>
           </div>
             
             </article>
            </section>
            </div>
            </div>
            </div>
</body>
<script type="text/javascript">
 var contactid = '<?php echo $contact; ?>';
</script>
</html>
