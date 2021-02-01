<?php
define('Ajaccess', TRUE);
 $data = array();
 $error = array();
  //connection
 require_once('../lib/config/config.php'); 
  //initialize session
  $user->launchSession();
  // generate payemnt code
 if(isset($_POST['generatePayment']) && !empty($_POST['generatePayment']) && $_POST['generatePayment']=='generatePayment'){     
    if(!$user->confirmIdSession( $_SESSION['companyId'], $_SESSION['busId'], $_SESSION['parkId'], $_SESSION['routeId'], $_SESSION['busTravelFeeId'])){
     $data['success']='notSent';
     $data['message'] ='Your Payment code is not successful, please try again';     
    }else{
     $ids =$user->confirmIdSession($_SESSION['companyId'], $_SESSION['busId'], $_SESSION['parkId'], $_SESSION['routeId'], $_SESSION['busTravelFeeId']);
    }
    if(isset($_SESSION['userId']) && is_numeric($_SESSION['userId'])){
     $paymentCode=$user->paymentCode(6);
     $phoneNumber = '+234'.ltrim($_SESSION['userId'],'0');
     //$phoneNumber = $_SESSION['userId'];
     if($user->sendPaymentCodeBySms($paymentCode, $phoneNumber)){
        if($user->customerTransaction($_SESSION['userId'], $ids['companyId'],$ids['parkId'], $ids['routeId'], $ids['busId'], $ids['busTravelFeeId'], $paymentCode)){
         $data['success']='sent';
         $data['message'] ='Kind use the code sent to your phone to make payment'; 
        }else{
        
         $data['success']='notSent';
         $data['message'] ='Your Payment code is not successful, please try again';              
        }               
     }else{
      $data['success']='notSent';
      $data['message'] ='Your Payment code is not successful, please try again';        
     }
    }else{
     $email = $_SESSION['userId'];
     $paymentCode=$user->paymentCode(6);
     if($user->sendPaymentCodeByEmail($paymentCode, $email)){
       if($user->customerTransaction($_SESSION['userId'], $ids['companyId'],$ids['parkId'], $ids['routeId'], $ids['busId'], $ids['busTravelFeeId'], $paymentCode)){
        $data['success']='sent';
        $data['message'] ='Kind use the code sent to your email to make payment'; 
       }else{
        $data['success']='notSent';
        $data['message'] ='Your Payment code is not successful, please try again';              
       }                    
     }else{
      $data['success']='notSent';
      $data['message'] ='Your Payment code is not successful, please try again';        
     }
    }
 
 }else{
    $data['success'] ='no';
 }
 echo json_encode($data); 
?>