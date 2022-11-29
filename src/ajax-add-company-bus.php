<?php
define('Ajaccess', TRUE);
 $data = array();
 $error = array();
 // connection
 require_once('../lib/config/config.php');
 // save profile data
 if(isset($_POST['addCompanyA']) && !empty($_POST['addCompanyA']) && $_POST['addCompanyA']=='save'){
   $companyNameA = $_POST['companyNameA'];
   $busNameA = $_POST['busNameA'];
   $companyName = $_POST['companyName'];
   $busName = $_POST['busName'];
   $parkNameA = $_POST['parkNameA'];
   $parkName = $_POST['parkName'];
   $busTravelFeeA = $_POST['busTravelFeeA'];
   $busTravelFee = $_POST['busTravelFee'];    
   if(isset($companyNameA) && $companyNameA=='none' || $companyNameA=='' || !is_numeric($companyNameA)){
    $error['companyNameA'] ='Select company name';
   }
   if(isset($busNameA) && $busNameA=='none' || $busNameA==''|| !is_numeric($busNameA) ){
    $error['busNameA'] ='Select bus name';
   }
   if(isset($parkNameA) && $parkNameA=='none' || $parkNameA=='' || !is_numeric($parkNameA)){
    $error['parkNameA'] ='Select park name';
   }
   if(isset($busTravelFeeA) && $busTravelFeeA=='none' || $busTravelFeeA=='' || !is_numeric($busTravelFeeA)){
    $error['busTravelFeeA'] ='Select bus travel fee';
   }      
   if(empty($error)){
    if($user->companyBusAttach($user->protectData($companyNameA), $user->protectData($busNameA), $user->protectData($parkNameA), $user->protectData($busTravelFeeA))=="true"){
     $data['success'] = true;
     $data['message'] = $busName.' bus with travel fee of '.$busTravelFee.' successfully attach to '.$companyName.' transport company';
    }elseif($user->companyBusAttach($user->protectData($companyNameA), $user->protectData($busNameA), $user->protectData($parkNameA), $user->protectData($busTravelFeeA))=="exist"){
     $data['success'] = 'exist';
     $data['message'] = $busName.' bus with travel fee of '.$busTravelFee.' has already been attach to '.$companyName.' transport company';
    }elseif($user->companyBusAttach($user->protectData($companyNameA), $user->protectData($busNameA), $user->protectData($parkNameA), $user->protectData($busTravelFeeA))=="noId"){
     $data['success'] = 'exist';
     $data['message'] = $parkName.' park is not yet attached to '.$companyName.' transport company';
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