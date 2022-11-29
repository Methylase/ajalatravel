<?php
 if(!defined('Ajaccess')){
   die('<h2> No access contact the administrator</h2>');
 }
class Profile extends User
 {
    private $db;
   public function __construct($db)
   {
   return parent::__construct($db);
      
   }
    function profileId($username){
       return  $this->getId($username);
    }
    function profileUserId($username){
       return  $this->getUserId($username);
    }
   function profileUserDetails($username){
      return $this->getUserDetails($username);
   }
   function profileInformationImage($userInformationId){
      return $this->getProfileInformationImage($userInformationId);
   }
    function profileUser($username){
       return $this->getUser($username);
    }
    function profileIdChecker($id){
     return  $this->confirmUserId($id);
    }
     public function checkProfileId($pid){
      return  $this->checkProfileId($pid);
     }
    function getProfileAccess($id){
     return  $this->getAccess($id);
    }
    function getProfileDetails($id){
     return  $this->getProfileDetails($id);
    }
    function getEditProfileDetails($id){
     return  $this->editProfileDetails($id);
    }
    function saveProfileDetails(
   $firstname,
   $middlename,
   $lastname,
   $gender,
   $email,
   $phone,
   $state,
   $localG,
   $address1,
   $address2,
   $image,
   $id){
     return  $this->saveProfileDetail(
   $firstname,
   $middlename,
   $lastname,
   $gender,
   $email,
   $phone,
   $state,
   $localG,
   $address1,
   $address2,
   $image,
   $id);
    }
    function updateProfileDetails(
   $firstname,
   $middlename,
   $lastname,
   $gender,
   $email,
   $phone,
   $state,
   $localG,
   $address1,
   $address2,
   $image,
   $id){
     return  $this->updateProfileDetail(
   $firstname,
  $middlename,
  $lastname,
  $gender,
  $email,
  $phone,
  $state,
  $localG,
  $address1,
  $address2,
  $image,
  $id);
    }
    
   function profileImage($id){
        return   $this->getProfileImage($id);
   }
    function getAllPackages(){
         return   $this->getPackages();
    }
 } 
?>