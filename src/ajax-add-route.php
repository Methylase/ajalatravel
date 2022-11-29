<?php
define('Ajaccess', TRUE);
 $data = array();
 $error = array();
 // connection
 require_once('../lib/config/config.php');
 // save profile data
 if(isset($_POST['addRoute']) && !empty($_POST['addRoute']) && $_POST['addRoute']=='save'){
   $routeName = $_POST['routeName'];
   $routeDate = $_POST['routeDate'];
 
   if(isset($routeName) && $routeName==''){
    $error['routeName'] ='Route Name is required';
   }
   if(isset($routeDate) && $routeDate==''){
    $error['routeDate'] ='Select Date';
   }
   $routeDate = date('Y-m-d', strtotime($routeDate));   
   if(empty($error)){
    if($user->busRoute($user->protectData($routeName), $user->protectData($routeDate))=='true'){
     $data['success'] = true;
     $data['message'] = 'Successfully created a bus route';
    }elseif($user->busRoute($user->protectData($routeName), $user->protectData($routeDate))=='exist'){
     $data['success'] = 'exist';
     $data['message'] = 'Route name '.$routeName.' already exist';
    }else{
     $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
    $data['error']=$error;
    $data['success'] = false;
   }
  }elseif(isset($_POST['addRouteA']) && !empty($_POST['addRouteA']) && $_POST['addRouteA']=='save'){
   $routeName = $_POST['name'];
   $routeId = $_POST['id'];
   if(isset($routeName) && $routeName==''){
    $error['routeName'] ='Route name can\'t be blank';
   }
   $routeDate = date('Y-m-d', strtotime(date('Y/m/d')));   
   if(empty($error)){
    if($user->busRouteUpdate($user->protectData($routeName), $user->protectData($routeDate),$user->protectData($routeId))=='true'){
     $data['success'] ='true';
     $data['message'] = 'Successfully updated a bus route';
    }elseif($user->busRouteUpdate($user->protectData($routeName), $user->protectData($routeDate),$user->protectData($routeId))=='noId'){
     $data['success'] = 'noId';
    }else{
     $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
    $data['error']=$error;
    $data['success'] = 'false';
   }    
  }elseif(isset($_POST['routeId'])){
   if($user->deleteRoute($_POST['routeId'])=='true'){
      $data['message'] = 'The route has been deleted successfully';
      $data['success'] = 'true';
     
    }elseif($user->deleteRoute($_POST['routeId'])=='noId'){
      $data['success'] = 'noId';
     
    }elseif($user->deleteRoute($_POST['routeId'])=='notAllowed'){
      $data['success'] = 'notAllowed';
      $data['message'] = 'You can\'t delete a route that is already attached to a bus, please disengage the route from the bus';
    }elseif($user->deleteRoute($_POST['routeId'])=='noRoute'){
      $data['success'] = 'noRoute';
      $data['message'] = 'No Route is available for delete';
    }else{
      $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
   $data['success'] = 'no';
  }
 echo json_encode($data); 
?>