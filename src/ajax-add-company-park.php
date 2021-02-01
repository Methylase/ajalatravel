<?php
define('Ajaccess', TRUE);
 $data = array();
 $error = array();
 // connection
 require_once('../lib/config/config.php');
 // save profile data
 if(isset($_POST['addParkA']) && !empty($_POST['addParkA']) && $_POST['addParkA']=='save'){
   $companyNameA = $_POST['companyNameA'];
   $parkNameA = $_POST['parkNameA'];
   $companyName = $_POST['companyName'];
   $parkName = $_POST['parkName'];
   if(isset($companyNameA) && $companyNameA=='none' || $companyNameA==''){
    $error['companyNameA'] ='Select company name';
   }
   if(isset($parkNameA) && $parkNameA=='none' || $parkNameA==''){
    $error['parkNameA'] ='Select park name';
   }
   if(empty($error)){
    if($user->companyParkAttach($user->protectData($companyNameA), $user->protectData($parkNameA))=="true"){
     $data['success'] = true;
     $data['message'] = $parkName.' park successfully attach to '.$companyName.' transport company';
    }elseif($user->companyParkAttach($user->protectData($companyNameA), $user->protectData($parkNameA))=="exist"){
     $data['success'] = 'exist';
     $data['message'] = $parkName.' park has already been attach to '.$companyName.' transport company';
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