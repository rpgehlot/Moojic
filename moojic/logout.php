
<?php
     include 'fbaccess.php';     
     $facebook->setAccessToken(null);
     $facebook->getuser = null;
     $facebook->destroysession();
     setcookie('fbs_'.$facebook->getAppId(), '', time()-100);
     session_unset();
     session_destroy();
     

header('Location: http://46.137.213.123/moojic-webapp/moojic1/moojic-new/index.php');

?>
