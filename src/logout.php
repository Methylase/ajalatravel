<?php
define('Ajaccess', TRUE);
// connection
require_once('../lib/config/config.php');
//initialize session 
$user->launchSession();
// logout
$user->logout();
//redirect to login page
header('Location:../tour/index.php');
?>