<?php
define('Ajaccess', TRUE);
 $data = array();
 $error = array();
 // connection
 require_once('../lib/config/config.php');
 // save profile data
 if(isset($_POST['addPark']) && !empty($_POST['addPark']) && $_POST['addPark']=='save'){
   $parkName = $_POST['parkName'];
   $parkDate = $_POST['parkDate'];
 
   if(isset($parkName) && $parkName==''){
    $error['parkName'] ='Company park name is required';
   }
   if(isset($parkDate) && $parkDate=='none' || $parkDate==''){
    $error['parkDate'] ='Select Date';
   }
   $parkDate = date('Y-m-d', strtotime($parkDate));   
   if(empty($error)){
    if($user->companyPark($user->protectData($parkName), $user->protectData($parkDate))=='true'){
     $data['success'] = true;
     $data['message'] = 'Successfully created a company park name';
    }elseif($user->companyPark($user->protectData($parkName), $user->protectData($parkDate))=='exist'){
     $data['success'] = 'exist';
     $data['message'] = 'Company park name '.$parkName.' already exist';
    }else{
     $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
    $data['error']=$error;
    $data['success'] = false;
   }
  }elseif(isset($_POST['addParkA']) && !empty($_POST['addParkA']) && $_POST['addParkA']=='save'){
   $parkName = $_POST['name'];
   $parkId = $_POST['id'];
   if(isset($parkName) && $parkName==''){
    $error['parkName'] ='Comapny park name can\'t be blank';
   }
   $parkDate = date('Y-m-d', strtotime(date('Y/m/d')));   
   if(empty($error)){
    if($user->companyParkUpdate($user->protectData($parkName), $user->protectData($parkDate),$user->protectData($parkId))=='true'){
     $data['success'] ='true';
     $data['message'] = 'Successfully created a company park name';
    }elseif($user->companyParkUpdate($user->protectData($parkName), $user->protectData($parkDate),$user->protectData($parkId))=='noId'){
     $data['success'] = 'noId';
    }else{
     $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
    $data['error']=$error;
    $data['success'] = 'false';
   }    
  }elseif(isset($_POST['parkId'])){
   if($user->deletePark($_POST['parkId'])=='true'){
      $data['message'] = 'The company park name has been deleted successfully';
      $data['success'] = 'true';
     
    }elseif($user->deletePark($_POST['parkId'])=='noId'){
      $data['success'] = 'noId';
     
    }elseif($user->deletePark($_POST['parkId'])=='notAllowed'){
      $data['success'] = 'notAllowed';
      $data['message'] = 'You can\'t delete a company park that is already attached to a company, please disengage the route from the bus';
    }else{
      $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
   $data['success'] = 'no';
  }
 echo json_encode($data); 
?>