<?php
define('Ajaccess', TRUE);
 $data = array();
 $error = array();
  //connection
 require_once('../lib/config/config.php');
  //initialize session
  $user->launchSession();
 // save profile data
 if(isset($_POST['searchBus']) && !empty($_POST['searchBus']) && $_POST['searchBus']=='searchBus'){
   $userId = $_POST['userId'];
   $departFrom = $_POST['departFrom'];
  $departTo = $_POST['departTo'];
   $departDate= $_POST['departDate'];
   if(isset($userId) && $userId==''){
    $error['userId'] ='Phone number and email is required';
   }elseif(isset($departFrom) && $departFrom==''){
      $error['departFrom']="location you are travelling from is required"; 
   }elseif(isset($departDate) && $departDate==''){
      $error['departDate']="Departure Date is required"; 
   }elseif(isset($departTo) && $departTo==''){
      $error['departTo']="location you are travelling to is required"; 
   }
   
   if(empty($error)){
    $_SESSION['userId']=$userId;
    $_SESSION['departFrom']=$departFrom;
    $_SESSION['departTo']=$departTo;
    $_SESSION['departDate']=$departDate;    
    $data['success']='access';
   }else{
    $data['error']=$error;
    $data['success'] = false;
   }
  }elseif(isset($_POST['companyNameA']) && !empty($_POST['companyNameA']) && $_POST['companyNameA'] !='none'){
     if($user->searchBusByCompanyId($user->protectData($_POST['companyNameA']))=='noBus'){
      $data['success']='noBus';
      $data['message'] ='No bus attached to the transport compnay';
     }else{
      $data['success']='foundBus';
      $data['foundBus']=$user->searchBusByCompanyId($user->protectData($_POST['companyNameA']));
     }
   }elseif(isset($_POST['proceedSearch']) && !empty($_POST['proceedSearch']) && $_POST['proceedSearch']=='proceedSearch'){
    $companyName = $_POST['companyName'];
    $busName = $_POST['busName'];
    
    if(isset($companyName) && $companyName==''|| $companyName=='none'){
     $error['companyName'] ='Select company name';
    }elseif(isset($busName) && $busName=='' || $busName=='none'){
       $error['busName']="Select bus name"; 
    }
    if(empty($error)){
     if($user->searchBusById($user->protectData($_POST['companyName']),$user->protectData($_POST['busName']))=='noMatch'){
      $data['success']='noMatch';
      $data['message'] ='No bus search available for this destination';   
     }elseif($user->searchBusById($user->protectData($_POST['companyName']),$user->protectData($_POST['busName']))){
        $data['success']='foundMatch';
        $data['foundMatch']=$user->searchBusById($user->protectData($_POST['companyName']),$user->protectData($_POST['busName']));
     }
    }else{
     $data['error']=$error;
     $data['success'] = false;
    }
   }else{
    $data['success'] ='no';
   }
 echo json_encode($data); 
?>