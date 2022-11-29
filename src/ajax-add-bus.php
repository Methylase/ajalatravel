<?php
define('Ajaccess', TRUE);
 $data = array();
 $error = array();
 // connection
 require_once('../lib/config/config.php');
 // save profile data
 if(isset($_POST['addBuses']) && !empty($_POST['addBuses']) && $_POST['addBuses']=='save'){
   $busName = $_POST['busName'];
   $busColor = $_POST['busColor'];
   $busState = $_POST['busState'];
   $busLocalG= $_POST['busLocalG'];
   $busPartDay= $_POST['busPartDay'];
   $busDepartureDate= $_POST['busDepartureDate'];
   $busTime= $_POST['busTime'];
   $busSeatNo= $_POST['busSeatNo'];   
   $busPartDaysArray =['morning','afternoon','evening/night'];
   if(isset($busName) && $busName==''){
    $error['busName'] ='Bus name is required';
   }
   if(isset($busPartDay) && $busPartDay=='' || $busPartDay =='none' ){
    $error['busPartDay'] ='Select part of the day';
   }elseif(isset($busPartDay) && !in_array($busPartDay, $busPartDaysArray)){
    $error['busPartDay'] ='Select the right part of the day';
   }
   if(isset($busTime) && $busTime==''){
    $error['busTime'] ='Select Departure Time';
   }
   if(isset($busSeatNo) && $busSeatNo=='' || !is_numeric($busSeatNo)  || $busSeatNo == 0 || $busSeatNo < 0){
    $error['busSeatNo'] ='Bus total seat number is required';
   }   
    $busTime = date('H:i',strtotime($busTime));
   if( $busTime < 12 && $busPartDay==$busPartDaysArray[0]){
    $busPartDay=$busPartDaysArray[0];
   }elseif($busTime > 12 && $busTime < 17 && $busPartDay==$busPartDaysArray[1]){
     $busPartDay=$busPartDaysArray[1];
   }elseif($busTime >= 17 && $busTime >= 19 && $busPartDay==$busPartDaysArray[2]){
     $busPartDay=$busPartDaysArray[2];
   }else{
     $error['busPartDay'] ='Part of the day is not the time match';
   }
   if(isset($busDepartureDate) && $busDepartureDate==''){
    $error['busDepartureDate'] ='Select Bus Departure Date';
   }
   if(isset($busColor) && $busColor ==''){
    $error['busColor'] ='Bus color is required';
   }

   if(isset($busState) && $busState=='' || $busState =='none'){
    $error['busState'] ='Select State';
   }      
   if(isset($busLocalG) && $busLocalG=='' || $busLocalG =='none'){
    $error['busLocalG'] ='Select local govt';
   }
   if(isset($_POST['busFeatures'])){
   $busFeatures=implode(",",$_POST['busFeatures']);
   }else{
    $busFeatures="Non";
   }

   if(empty($error)){
    if($user->buses( $user->protectData($busName), $user->protectData($busColor), $user->protectData($busState),
       $user->protectData($busLocalG),$user->protectData($busFeatures), $user->protectData($busPartDay), $user->protectData($busDepartureDate), $user->protectData($busTime), $user->protectData($busSeatNo))=="true"){
     $data['success'] = true;
     $data['message'] = 'Successfully saved '.$busName.' bus details';
    }else if($user->buses( $user->protectData($busName), $user->protectData($busColor), $user->protectData($busState),
       $user->protectData($busLocalG),$user->protectData($busFeatures),$user->protectData($busPartDay), $user->protectData($busDepartureDate), $user->protectData($busTime), $user->protectData($busSeatNo))=="exist"){
      $data['success'] = 'exist';
      $data['message'] = 'Bus name '.$busName.' already exist';
     }else{
       $data['success'] = 'wrong';
     $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
    $data['error']=$error;
    $data['success'] = false;
   }
  }elseif(isset($_POST['addBusA']) && !empty($_POST['addBusA']) && $_POST['addBusA']=='save'){
   $busName = $_POST['nameA'];
   $busColor = $_POST['colorA'];
   $busState= $_POST['stateA'];
   $busFeatures= $_POST['featuresA'];
   $busLocalG = $_POST['localGA'];
   $busDay = $_POST['dayA'];
   $busTime = $_POST['timeA'];
   $busDate = $_POST['dateA'];   
   $busId =$_POST['idA'];
   
   if(isset($busName) && $busName==''){
    $error['nameA'] ='name cant be blank';
   }

   if(isset($busFeatures) && $busFeatures=='' || $busFeatures =='none'){
    $busFeatures ='none';
   }
   if(isset($busColor) && $busColor ==''){
    $error['colorA'] ='bus color can"t be blank';
   }
  
   if(isset($busState) && $busState =='' || $busState =='none'){
    $error['stateA'] ='State is required';
   }
   if(isset($busLocalG) && $busLocalG =='' || $busLocalG =='none'){
    $error['LocalGA'] ='Local government is required';
   }
   if(isset($busDay) && $busDay==''){
    $error['dayA'] ='Departure part of the day is required';
   }
    if(isset($busTime) && $busTime==''){
    $error['timeA'] ='Departure time is required';
   }
   if(isset($busDate) && $busDate=='' || $busDate=='none'){
    $error['dateA'] ='Departure date is required';
   }
   if(empty($error)){
    if($user->busUpdate( $user->protectData($busName), $user->protectData($busColor), $user->protectData($busState), $user->protectData($busLocalG), $user->protectData($busFeatures),$user->protectData($busDay), $user->protectData($busTime), $user->protectData($busDate), $user->protectData($busId))=='true'){
     $data['success'] = "true";
     $data['message'] = 'Successfully saved '.$busName.' bus details';
    }elseif($user->busUpdate( $user->protectData($busName), $user->protectData($busColor), $user->protectData($busState), $user->protectData($busLocalG), $user->protectData($busFeatures), $user->protectData($busDay), $user->protectData($busTime), $user->protectData($busDate), $user->protectData($busId))=='noId'){
      $data['success'] = 'noId';
    }elseif($user->busUpdate( $user->protectData($busName), $user->protectData($busColor), $user->protectData($busState), $user->protectData($busLocalG), $user->protectData($busFeatures), $user->protectData($busDay), $user->protectData($busTime), $user->protectData($busDate), $user->protectData($busId))=='noRId'){
      $data['success'] = 'noRId';
    }else{
     $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
    $data['error']=$error;
    $data['success'] = false;
   }
  }elseif(isset($_POST['busId'])){
   if($user->deleteBus($_POST['busId'])=='true'){
      $data['message'] = 'The bus has been deleted successfully';
      $data['success'] = 'true';
     
    }elseif($user->deleteBus($_POST['busId'])=='noId'){
      $data['success'] = 'noId';
     
    }else{
      $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
   $data['success'] = 'no';
  }
 echo json_encode($data); 
?>