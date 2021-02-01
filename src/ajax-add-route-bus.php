<?php
define('Ajaccess', TRUE);
 $data = array();
 $error = array();
 // connection
 require_once('../lib/config/config.php');
 // save profile data
 if(isset($_POST['addRouteA']) && !empty($_POST['addRouteA']) && $_POST['addRouteA']=='save'){
   $routeNameA = $_POST['routeNameA'];
   $busNameA = $_POST['busNameA'];
   $routeName = $_POST['routeName'];
   $busName = $_POST['busName'];
   if(isset($routeNameA) && $routeNameA=='none' || $routeNameA==''){
    $error['routeNameA'] ='Select route name';
   }
   if(isset($busNameA) && $busNameA=='none' || $busNameA==''){
    $error['busNameA'] ='Select bus name';
   }
   if(empty($error)){
    if($user->routeBusAttach($user->protectData($routeNameA), $user->protectData($busNameA))=="true"){
     $data['success'] = true;
     $data['message'] = $busName.' bus successfully attach to '.$routeName;
    }elseif($user->routeBusAttach($user->protectData($routeNameA), $user->protectData($busNameA))=="exist"){
     $data['success'] = 'exist';
     $data['message'] = $busName.' bus has already been attach to '.$routeName;
    }else{
     $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
    $data['error']=$error;
    $data['success'] = false;
   }
  }else{
   $data['success'] = 'no';
  }
 echo json_encode($data); 
?>