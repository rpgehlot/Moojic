<?php
if(!session_id())
session_start();
$app_id		= "154107674770730";
$app_secret	= "ee75325ebdeca14b89dc19869694f08a";
$site_url	= "http://46.137.213.123/moojic-webapp/moojic1/moojic-new/index.php" ;
$redirecturi    = "http://46.137.213.123/moojic-webapp/moojic1/moojic-new/bootstrap-data.php";

try{
	include_once "src/facebook.php";
}catch(Exception $e){
	error_log($e);
}
// Create our application instance
$facebook = new Facebook(array(
	'appId'		=> $app_id,
	'secret'	=> $app_secret,
	));
 
// Get User ID
$user = $facebook->getUser();
$_SESSION['user'] = $user;

$_SESSION['flag'] = 'FALSE';
$isloggedin = true; 


// We may or may not have this data based
// on whether the user is logged in.
// If we have a $user id here, it means we know
// the user is logged into
// Facebook, but we don’t know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.
 

if($user){
//==================== Single query method ======================================
	
	try{
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
	}catch(FacebookApiException $e){
		error_log($e);
		$user = NULL;
	}
//==================== Single query method ends =================================
}
 
if($user){
	// Get logout URL
	
    $params = array( 'next' => 'http://46.137.213.123/moojic-webapp/moojic1/moojic-new/logout.php' ,'access_token'=>$facebook->getAccessToken());

	$logoutUrl = $facebook->getLogoutUrl($params);
      //access_token=$facebook->getAccessToken()
} 
else{
	// Get login URL
	$loginUrl = $facebook->getLoginUrl(array(
		'scope'		=> ' user_location, user_actions.music, user_photos',
		'redirect_uri'	=> $redirecturi,
		));
	
  
}
 
?>
