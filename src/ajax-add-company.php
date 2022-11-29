<?php
define('Ajaccess', TRUE);
 $data = array();
 $error = array();
 // connection
 require_once('../lib/config/config.php');
 // save profile data
 if(isset($_POST['addCompany']) && !empty($_POST['addCompany']) && $_POST['addCompany']=='save'){
   $companyName = $_POST['companyName'];
   $companyEmail= $_POST['companyEmail'];
   $companyPhone = $_POST['companyPhone'];
   $companyDate = $_POST['companyDate'];
   $companyAddress1= $_POST['companyAddress1']; 
   $companyAddress2 = $_POST['companyAddress2'];
   $companyState = $_POST['companyState'];
   $companyLocalG = $_POST['companyLocalG'];

   if(isset($companyName) && $companyName==''){
    $error['companyName'] ='Company Name is required';
   }
   if(isset($companyEmail) && $companyEmail ==''){
    $error['companyEmail'] ='Company email is required';
   }
   if(!filter_var($companyEmail, FILTER_VALIDATE_EMAIL)){
    $error["companyEmail"]="Company email is not in the right format";
   }
   if(isset($companyPhone) && $companyPhone ==''){
    $error['companyPhone'] ='Company phone number is required';
   }
   if(!is_numeric($companyPhone)){
    $error['companyPhone'] ='Company phone number must be a number';
   }       
   if(isset($companyDate) && $companyDate==''){
    $error['companyDate'] ='Select Date';
   }
   $companyDate = date('Y-m-d', strtotime($companyDate));      
   if(isset($companyAddress1) && $companyAddress1==''){
    $error['companyAddress1'] ='Company address is required';
   }    
  
   if(isset($companyState) && $companyState =='' || $companyState =='none'){
    $error['companyState'] ='State is required';
   }
   if(isset($companyLocalG) && $companyLocalG =='' || $companyLocalG =='none'){
    $error['companyLocalG'] ='Local government is required';
   }

   if(empty($error)){
    if($user->transportCompany( $user->protectData($companyName), $user->protectData($companyEmail), $user->protectData($companyPhone), $user->protectData($companyAddress1),
                               $user->protectData($companyAddress2), $user->protectData($companyState), $user->protectData($companyLocalG), $user->protectData($companyDate))=='true'){
     $data['success'] = true;
     $data['message'] = 'Successfully saved '.$companyName.' tranport company details';
    }elseif($user->transportCompany( $user->protectData($companyName), $user->protectData($companyEmail), $user->protectData($companyPhone), $user->protectData($companyAddress1),
                               $user->protectData($companyAddress2), $user->protectData($companyState), $user->protectData($companyLocalG), $user->protectData($companyDate))=='exist'){
      $data['success'] = 'exist';
      $data['message'] = 'Company name '.$companyName.' already exist';
    }elseif($user->transportCompany( $user->protectData($companyName), $user->protectData($companyEmail), $user->protectData($companyPhone), $user->protectData($companyAddress1),
                               $user->protectData($companyAddress2), $user->protectData($companyState), $user->protectData($companyLocalG), $user->protectData($companyDate))=='emailExist'){
      $data['success'] = 'emailExist';
      $data['message'] = 'Email already exit';
    }else{
     $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
    $data['error']=$error;
    $data['success'] = false;
   }
  }elseif(isset($_POST['addCompanyA']) && !empty($_POST['addCompanyA']) && $_POST['addCompanyA']=='save'){
   $companyName = $_POST['name'];
   $companyEmail= $_POST['email'];
   $companyPhone = $_POST['phone'];
   $companyAddress1= $_POST['address'];
   $companyAddress2= "";
   $companyDate= date('Y-m-d', strtotime(date('Y/m/d')));;
   $companyState = $_POST['state'];
   $companyLocalG = $_POST['localG'];
   $companyId =$_POST['id'];
   
   if(isset($companyName) && $companyName==''){
    $error['companyName'] ='Company name cant be blank';
   }
   if(isset($companyEmail) && $companyEmail ==''){
    $error['companyEmail'] ='Email can"t be blank';
   }
   if(!filter_var($companyEmail, FILTER_VALIDATE_EMAIL)){
    $error['companyEmail']="Email is not in the right format";
   }
   if(isset($companyPhone) && $companyPhone ==''){
    $error['companyPhone'] ='Phone number can"t be blank';
   }
   if(!is_numeric($companyPhone)){
    $error['companyPhone'] ='Phone number must be a number';
   }       
   if(isset($companyDate) && $companyDate==''){
    $error['companyDate'] ='Select Date';
   }   
   if(isset($companyAddress1) && $companyAddress1==''){
    $error['companyAddress1'] ='Address can\'t be blank';
   }    
  
   if(isset($companyState) && $companyState =='' || $companyState =='none'){
    $error['companyState'] ='State is required';
   }
   if(isset($companyLocalG) && $companyLocalG =='' || $companyLocalG =='none'){
    $error['companyLocalG'] ='Local government is required';
   }

   if(empty($error)){
    if($user->transportCompanyUpdate( $user->protectData($companyName), $user->protectData($companyEmail), $user->protectData($companyPhone), $user->protectData($companyAddress1),
                               $user->protectData($companyAddress2), $user->protectData($companyState), $user->protectData($companyLocalG), $user->protectData($companyDate),$user->protectData($companyId))=='true'){
     $data['success'] = "true";
     $data['message'] = 'Successfully saved '.$companyName.' tranport company details';
    }elseif($user->transportCompanyUpdate( $user->protectData($companyName), $user->protectData($companyEmail), $user->protectData($companyPhone), $user->protectData($companyAddress1),
            $user->protectData($companyAddress2), $user->protectData($companyState), $user->protectData($companyLocalG), $user->protectData($companyDate),$user->protectData($companyId))=='noId'){
      $data['success'] = 'noId';
    }else{
     $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
    $data['error']=$error;
    $data['success'] = false;
   }
  }elseif(isset($_POST['companyId'])){
   if($user->deleteCompany($_POST['companyId'])=='true'){
      $data['message'] = 'The company has been deleted successfully';
      $data['success'] = 'true';
     
    }elseif($user->deleteCompany($_POST['companyId'])=='noId'){
      $data['success'] = 'noId';
     
    }elseif($user->deleteCompany($_POST['companyId'])=='notAllowed'){
      $data['success'] = 'notAllowed';
      $data['message'] = 'You can\'t delete a company that is already attached to a bus, please disengage the bus from the company';
    }else{
      $data['message'] = 'Ooop!!! something went wrong';
    }
   }else{
   $data['success'] = 'no';
  }
 echo json_encode($data); 
?>