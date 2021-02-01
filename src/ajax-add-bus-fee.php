<?php
define('Ajaccess', TRUE);
 $data = array();
 $error = array();
 // connection
 require_once('../lib/config/config.php');
 // save profile data
 if(isset($_POST['addTravelFee']) && !empty($_POST['addTravelFee']) && $_POST['addTravelFee']=='save'){
   $busTravelFee = $_POST['busTravelFee'];
   $dateCreated = $_POST['dateCreated'];
 
   if(isset($busTravelFee) && $busTravelFee==''){
    $error['busTravelFee'] ='Travel fee for the bus is required';
   }else if( !is_numeric($busTravelFee)){
    $error['busTravelFee'] ='Travel fee for the bus must be a number';    
   }
   if(isset($dateCreated) && $dateCreated==''){
    $error['dateCreated'] ='Select Date';
   }
   $dateCreated = date('Y-m-d', strtotime($dateCreated));   
   if(empty($error)){
    if($user->busTravelFee($user->protectData($busTravelFee), $user->protectData($dateCreated))=='true'){
     $data['success'] = true;
     $data['message'] = 'Successfully created a bus travel fee of &#8358;'.$busTravelFee;
    }elseif($user->busTravelFee($user->protectData($busTravelFee), $user->protectData($dateCreated))=='exist'){
     $data['success'] = 'exist';
     $data['message'] = 'Bus travel fee of &#8358;'.$busTravelFee.' already exist';
    }else{
     $data['success'] = 'false'; 
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