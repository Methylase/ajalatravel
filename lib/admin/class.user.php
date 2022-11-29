<?php
 if(!defined('Ajaccess')){
   die('<h2> No access contact the administrator</h2>');
 }
class User{
 private $db;
 public function __construct($db){
 $this->db=$db;
        
 }
  public function launchSession(){
  session_start();
 }
 public function is_logged_in(){
  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
   return true;
  }
 }
 public function is_session_super(){
  if(isset( $_SESSION['super']) &&  $_SESSION['super']==true){
   return true;
  }
 }
 public function is_session_user(){
  if(isset( $_SESSION['user']) &&  $_SESSION['user']==true){
     return true;
  }
 }
 public function pass_update($password,$user){
  try{
   $stmt ="UPDATE admin_user SET password='$password',  WHERE username='$user'";
   $stmt=$db->prepare($stmt);
   if($stmt->execute()){
      return true;
   }      
  } catch(PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
 }
  public function emailChecker($companyEmail){
    $stmt = $this->db->prepare('SELECT company_email FROM ajalatravel_company WHERE company_email = :company_email');
  $stmt->execute(array('company_email' => $companyEmail));
  
  if( $stmt->rowCount()==1){
   return true;
  }
  }
   public function autoCreateAccess($username,$password, $checker, $checker2)
 {
  try{
    $stmt = $this->db->prepare('SELECT * FROM ajalatravel_users WHERE username = :username');
    $stmt->execute(array(':username'=>$username));
    $rowCount= $stmt->rowCount();
    if($rowCount !=1){
     $stmt = $this->db->prepare('INSERT INTO ajalatravel_users
                              (username, password, checker, checker2 )
                               VALUES (:username, :password, :checker, :checker2 )');
     $stmt->execute(array(':username'=>$username, ':password'=> $password, 'checker'=> $checker, ':checker2'=>$checker2));
     return true;                
   }
  }catch (PDOException $e)
  {
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
               
 }
 public function transportCompany(
   $companyName,
   $companyEmail,
   $companyPhone,
   $companyAddress1,
   $companyAddress2,
   $companyState,
   $companyLocalG,
   $companyDate
  ){
  try{
   if($this->emailChecker($companyEmail)){
    return 'emailExist';
   }
   $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company WHERE company_name = :company_name');
   $stmt->execute(array('company_name' => $companyName));
   if( $stmt->rowCount()==1){
    return "exist";
   }
   $stmt = $this->db->prepare('INSERT INTO ajalatravel_company(company_name, company_email, company_phone,
                              company_address1, company_address2, company_state, company_localG, company_date)VALUES
                              (:company_name, :company_email, :company_phone, :company_address1,
                               :company_address2, :company_state, :company_localG, :company_date)');
                              if($stmt->execute(array(':company_name'=>$companyName, ':company_email'=>$companyEmail, ':company_phone'=>$companyPhone, ':company_address1'=>$companyAddress1,
                               ':company_address2'=>$companyAddress2, ':company_state'=>$companyState, ':company_localG'=>$companyLocalG, ':company_date'=>$companyDate))){
                               return "true";
                              }
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
  public function transportCompanyUpdate(
   $companyName,
   $companyEmail,
   $companyPhone,
   $companyAddress1,
   $companyAddress2,
   $companyState,
   $companyLocalG,
   $companyDate,
   $companyId
  ){
  try{
  
   $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company WHERE company_id = :company_id');
   $stmt->execute(array('company_id' => $companyId));
   if( $stmt->rowCount() !=1){
    return "noId";
   }

     $stmt ="UPDATE ajalatravel_company SET company_name='$companyName', company_email='$companyEmail', company_phone='$companyPhone', company_address1='$companyAddress1',
     company_address2='$companyAddress2', company_state ='$companyState', company_localG ='$companyLocalG', company_date ='$companyDate' WHERE company_id = :company_id";
     $stmt=$this->db->prepare($stmt);
     $stmt->execute(array(':company_id'=>$companyId));
     return "true";              
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
 public function companyNames(){
  try{
  $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company');
  $stmt->execute();
 $companyNames= '<select name="companyNameA" id="companyNameA" class="form-control">';
    if($stmt->rowCount() ==0){
   $companyNames .='<option value="none">Select Company Name</option>';
  }else{
   $companyNames .=' <option value="none">Select Company Name</option>';
    while($rows= $stmt->fetch()){
     $companyNames .= '<option value="'.$rows['company_id'].'">'.$rows['company_name'].'</option>';
    }
  }
  return  $companyNames.='</select>'; 
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
  public function busNames(){
  try{
  $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus');
  $stmt->execute();
  $busNames ='';
  if($stmt->rowCount() ==0){
   $busNames .='<option value="none">Select Bus Name</option>';
  }else{
   $busNames .='<option value="none">Select Bus Name</option>';
   while($rows= $stmt->fetch()){
    $busNames .= '<option value="'.$rows['bus_id'].'">'.$rows['bus_name'].'</option>';
   }
  }
  return  $busNames .='</select>'; 
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
 public function busRoute(
   $routeName,
   $routeDate 
  ){
  try{
   $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus_route WHERE route_name = :route_name');
   $stmt->execute(array('route_name' => $routeName));
   if( $stmt->rowCount()==1){
    return "exist";
   }
   $stmt = $this->db->prepare('INSERT INTO ajalatravel_bus_route(route_name, route_date)VALUES
                              (:route_name, :route_date)');
                              $stmt->execute(array(':route_name'=>$routeName, ':route_date'=>$routeDate));
   return "true";            
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
  public function busTravelFee(
   $busTravelFee,
   $dateCreated 
  ){
  try{
   $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus_travel_fee WHERE bus_travelFee = :bus_travelFee');
   $stmt->execute(array('bus_travelFee' => $busTravelFee));
   if( $stmt->rowCount()==1){
    return "exist";
   }
   $stmt = $this->db->prepare('INSERT INTO ajalatravel_bus_travel_fee(bus_travelFee, dateCreated)VALUES
                              (:bus_travelFee, :dateCreated)');
                              $stmt->execute(array(':bus_travelFee'=>$busTravelFee, ':dateCreated'=>$dateCreated));
   return "true";            
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
  public function allBusFee(){
  try{
  $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus_travel_fee');
  $stmt->execute();
  $busTravelFees ='<select name="busTravelFeeA" id="busTravelFeeA" class="form-control">';
  if($stmt->rowCount() ==0){
   $busTravelFees .='<option value="none">Select Bus Travel Fee</option>';
  }else{
   $busTravelFees.='<option value="none">Select Bus Travel Fee</option>';
   while($rows= $stmt->fetch()){
    $busTravelFees .= '<option value="'.$rows['bus_travel_fee_id'].'">&#8358;'.$rows['bus_travelFee'].'</option>';
   }
  }
  return  $busTravelFees .='</select>'; 
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
  public function busRouteUpdate(
   $routeName,
   $routeDate,
   $routeId
  ){
  try{
  
   $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus_route WHERE route_id = :route_id');
   $stmt->execute(array('route_id' => $routeId));
   if( $stmt->rowCount() !=1){
    return "noId";
   }
   
   $stmt ="UPDATE ajalatravel_bus_route SET route_name='$routeName' WHERE route_id = :route_id";
   $stmt=$this->db->prepare($stmt);
   $stmt->execute(array(':route_id'=>$routeId));
   return "true";
  
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
 public function getAllCompanies(){
  try{
     if(isset($_GET['page'])){
      $page=$_GET['page'];
      if($page < 1){
       $page=1;
      }
     }else{
      $page=1;
     }
     if($page==""){
      header("location:error-404.php");
     }
     $page_max=10;
     $page_limit= ($page-1) * $page_max;
     echo "<div id='message'></div>";
     $stmt = $this->db->prepare("SELECT * FROM ajalatravel_company ORDER  BY company_id LIMIT $page_limit,$page_max");
     $stmt->execute();
     $Company = "<tr class='text-light bg-danger'><th>S/n</th><th>Name</th><th>Email</th><th>Phone No</th><th>Address</th><th>State</th><th>Local Govt</th><th>Action</th></tr>";
     $rowCount= $stmt->rowCount();
     if($rowCount < 1){
      echo $Company ='<div class="text-danger well well-small text-center" >No company is available</div>';
     }else
     {
     $i = 1;
     while($rows= $stmt->fetch())
     {
      $name=ucfirst($rows['company_name']);
      $email=$rows['company_email'];
      $phone = $rows['company_phone'];
      $address=$rows['company_address1'];
      $state = $rows['company_state'];
      $localG = $rows['company_localG'];
      
      $company_id=$rows['company_id'];
       $checked ='';
     
      $save='save'.$company_id;
      $edit='edit'.$company_id;
      $delete='delete'.$company_id;
      $row='row'.$company_id;
      $name_id='name'.$company_id;
      $email_id='email'.$company_id;
      $phone_id='phone'.$company_id;
      $address_id='address'.$company_id;
      $state_id='state'.$company_id;
      $localG_id='localG'.$company_id;
      $messName='messageName'.$company_id;
      $messEmail='messageEmail'.$company_id;
      $messPhone='messagePhone'.$company_id;
      $messAdd='messageAdd'.$company_id;
      $messState='messageState'.$company_id;
      $messLocalG='messageLocalG'.$company_id;
      $mess='message'.$company_id;

      $Company.="<tr id='$row'> <td>".$i."</td><td ><span id='$name_id'>$name</span><span  id='$messName' style='float:left;clear:left'></span></td ><td><span id='$email_id' >$email</span><span  id='$messEmail' style='float:left;clear:left'></span></td ><td><span id='$phone_id'>$phone</span><span  id='$messPhone' style='float:left;clear:left'></span></td>
      <td ><span id='$address_id'>$address</span><span  id='$messAdd' style='float:left;clear:left'></span></td ><td ><span id='$state_id'>$state</span><span  id='$messState' style='float:left;clear:left'></span></td ><td><span id='$localG_id'>$localG</span><span  id='$messLocalG' style='float:left;clear:left'></span></td>
      <td style='width:150px; margin-left:20px;text-align:center'><span id='$edit' style='text-align:center'><a href='javascript:void(0)' onclick='Edit($company_id)'  ><i style='color:blue' class='fa fa-edit fa-lg' aria-hidden='true'></i></a>
      </span><span style='display:none;float:left; ' id='$save' >
      <a  style='color:blue;width:40px; margin-right:5px' href='javascript:void(0)' onclick='Save($company_id)' ><i  class='fa fa-save fa-lg' aria-hidden='true'></i></a>
      </span><span style='float:left' id='$delete'>
      <a href='javascript:void(0)' class='deleteCompany' id='del ".$company_id."' data-title='Delete' data-toggle='modal' data-target='#confirm-delete'> <i style='color:red' class='fa fa-trash-o fa-lg' aria-hidden='true'></i></a></span><span  id='$mess' ></span></td ></tr >";
      $i++;
     }
     echo $Company  .="</table>";
     $div="<div style='width:90%'>";
     $stmt = $this->db->prepare("select count(*) as total from ajalatravel_company");
     $stmt->execute();
     $rows= $stmt->fetch();
     $totals=$rows['total'];
     $lastpage=ceil($totals/$page_max);
     if($page<1){
        $page=1;
     }
     if($page>$lastpage){
        $page=$lastpage;
     }
     if($page==1){
        $div .="<ul class='pagination'><li><a  href='companies-table-view.php?page=1' style='background-color:#2196f3;color:white;boder-radius:2px'>First </a></li>";
     }else{
      $prev=$page-1;#2196f3
      $div .="<ul class='pagination'><li><a href='companies-table-view.php?page=$prev' style='background-color:#2196f3;color:white;boder-radius:2px'>Previous</a></li>";
     }
     $div .="";
     for($j=0; $j<$totals; $j++){
      if($page==$j){
        $div .="<li><a href='companies-table-view.php?page=$j' style='background-color:#2196f3;color:white;boder-radius:2px'>$j</a></li>";
      }
     }
     "</ul>";
     if($page==$lastpage){
      $div .="<li> <a href='companies-table-view.php?page=$lastpage' style='background-color:#2196f3;color:white;boder-radius:2px'>Last</a></li>";
     }else{
      $next=$page+1;
      $div .="<li><a href='companies-table-view.php?page=$next' style='background-color:#2196f3;color:white;boder-radius:2px'>Next </a></li>";
     }
       echo $div .="<ul></div>"; 
    }
   }catch (PDOException $e){
     echo '<p class="text-danger">'.$e->getMessage().'</p>';
    }  
 }
    public function deleteCompany($companyId){
    try{
       $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company WHERE company_id = :company_id');
       $stmt->execute(array('company_id' => $companyId));
       if( $stmt->rowCount() ==0){
        return "noId";
       }
       $stmt = $this->db->prepare('SELECT bus_id FROM ajalatravel_company_bus WHERE company_id = :company_id');
       $stmt->execute(array('company_id' => $companyId));
       if( $stmt->rowCount() !=0){
        return "notAllowed";
       }else{
        $row= $stmt->fetch();
        $stmt ="DELETE FROM ajalatravel_company WHERE company_id = :company_id";
        $stmt=$this->db->prepare($stmt);
        $stmt->execute(array(':company_id'=>$companyId));
          return "true";
       }
      } catch(PDOException $e)
      {
       echo '<p class="text-danger">'.$e->getMessage().'</p>';
      }
  }
  public function getAllRoutes(){
  try{
     if(isset($_GET['page'])){
      $page=$_GET['page'];
      if($page < 1){
       $page=1;
      }
     }else{
      $page=1;
     }
     if($page==""){
      header("location:error-404.php");
     }
     $page_max=10;
     $page_limit= ($page-1) * $page_max;
     $stmt = $this->db->prepare("SELECT * FROM ajalatravel_bus_route ORDER  BY route_id LIMIT $page_limit,$page_max");
     $stmt->execute();
     $Routes= "<tr class='text-light bg-danger'><th>S/n</th><th>Name</th><th>Action</th></tr>";
     $rowCount= $stmt->rowCount();
     if($rowCount < 1){
      echo $Routes ='<div class="text-danger well well-small text-center" >No Route is available</div>';
     }else
     {
     $i = 1;
     while($rows= $stmt->fetch())
     {
      $name=$rows['route_name'];
      $route_id=$rows['route_id'];
       $checked ='';
     
      $save='save'.$route_id;
      $edit='edit'.$route_id;
      $delete='delete'.$route_id;
      $row='row'.$route_id;
      $name_id='name'.$route_id;
      $messName='messageName'.$route_id;
      $mess='message'.$route_id;
      $Routes.="<tr id='$row'> <td>".$i."</td><td ><span id='$name_id'>$name</span><span  id='$messName' style='float:left;clear:left'></span></td >
      <td style='width:150px; margin-left:20px;text-align:center'><span id='$edit' style='text-align:center'><a href='javascript:void(0)' onclick='Edit($route_id)'  ><i style='color:blue' class='fa fa-edit fa-lg' aria-hidden='true'></i></a>
      </span><span style='display:none;float:left; ' id='$save' >
      <a  style='color:blue;width:40px; margin-right:5px' href='javascript:void(0)' onclick='Save($route_id)' ><i  class='fa fa-save fa-lg' aria-hidden='true'></i></a>
      </span><span style='float:left' id='$delete'>
      <a href='javascript:void(0)' class='deleteRoute' id='del ".$route_id."'    data-title='Delete' data-toggle='modal' data-target='#confirm-delete'> <i style='color:red' class='fa fa-trash-o fa-lg' aria-hidden='true'></i></a></span><span  id='$mess' ></span></td ></tr >";
      $i++;
     }
     echo $Routes.="</table>";
     $div="<div style='width:90%'>";
     $stmt = $this->db->prepare("select count(*) as total from ajalatravel_bus_route");
     $stmt->execute();
     $rows= $stmt->fetch();
     $totals=$rows['total'];
     $lastpage=ceil($totals/$page_max);
     if($page<1){
        $page=1;
     }
     if($page>$lastpage){
        $page=$lastpage;
     }
     if($page==1){
        $div .="<ul class='pagination'><li><a  href='routes-table-view.php?page=1' style='background-color:#2196f3;color:white;boder-radius:2px'>First </a></li>";
     }else{
      $prev=$page-1;#2196f3
      $div .="<ul class='pagination'><li><a href='routes-table-view.php?page=$prev' style='background-color:#2196f3;color:white;boder-radius:2px'>Previous</a></li>";
     }
     $div .="";
     for($j=0; $j<$totals; $j++){
      if($page==$j){
        $div .="<li><a href='routes-table-view.php?page=$j' style='background-color:#2196f3;color:white;boder-radius:2px'>$j</a></li>";
      }
     }
     "</ul>";
     if($page==$lastpage){
      $div .="<li> <a href='routes-table-view.php?page=$lastpage' style='background-color:#2196f3;color:white;boder-radius:2px'>Last</a></li>";
     }else{
      $next=$page+1;
      $div .="<li><a href='routes-table-view.php?page=$next' style='background-color:#2196f3;color:white;boder-radius:2px'>Next </a></li>";
     }
       echo $div .="<ul></div>"; 
    }
   }catch (PDOException $e){
     echo '<p class="text-danger">'.$e->getMessage().'</p>';
    }  
 }
  public function deleteRoute($routeId){
    try{
       $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus_route WHERE route_id = :route_id');
       $stmt->execute(array('route_id' => $routeId));
       if( $stmt->rowCount() ==0){
        return "noId";
       }
       $stmt = $this->db->prepare('SELECT route_id FROM ajalatravel_bus_to_route WHERE route_id = :route_id');
       $stmt->execute(array('route_id' => $routeId));
       if( $stmt->rowCount() !=0){
        return "notAllowed";
       }else{
        $row= $stmt->fetch();
        $stmt ="DELETE FROM ajalatravel_bus_route WHERE route_id = :route_id";
        $stmt=$this->db->prepare($stmt);
        $stmt->execute(array(':route_id'=>$routeId));
          return "true";
       }
      } catch(PDOException $e)
      {
       echo '<p class="text-danger">'.$e->getMessage().'</p>';
      }
  }
  public function companyBusAttach(
   $companyNameA,
   $busNameA,
   $parkNameA,
   $busTravelFeeA
  ){
  try{
    $stmt = $this->db->prepare('SELECT * FROM ajalatravel_park_to_company WHERE park_id = :park_id');
    $stmt->execute(array('park_id' => $parkNameA));
    if( $stmt->rowCount() ==0){
     return "noId";
    }   
   $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company_bus WHERE company_id = :company_id AND bus_id = :bus_id AND park_id = :park_id AND bus_travel_fee_id = :bus_travel_fee_id');
   $stmt->execute(array('company_id' => $companyNameA,'bus_id' => $busNameA, 'park_id' => $parkNameA,'bus_travel_fee_id' => $busTravelFeeA));
   if( $stmt->rowCount()==1){
    return "exist";
   }
   $stmt = $this->db->prepare('INSERT INTO ajalatravel_company_bus(company_id, bus_id, park_id, bus_travel_fee_id)VALUES
                              (:company_id, :bus_id, :park_id, :bus_travel_fee_id)');
                              $stmt->execute(array(':company_id'=>$companyNameA, ':bus_id'=>$busNameA, 'park_id' => $parkNameA, 'bus_travel_fee_id' => $busTravelFeeA));
   return "true";            
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
  public function buses(
   $busName,
   $busColor,
   $busState,
   $busLocalG,
   $busFeatures,
   $busPartDay,
   $busDepartureDate,
   $busTime,
   $busSeatNo
  ){
  try{
    $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus WHERE bus_name = :bus_name');
    $stmt->execute(array('bus_name' => $busName));
  
  if( $stmt->rowCount()==1){
   return "exist";
  }
   $stmt = $this->db->prepare('INSERT INTO ajalatravel_bus(bus_name, bus_color,
                              bus_state, bus_localG, bus_features,bus_day,bus_time, bus_seatNo, bus_date)
                              VALUES(:bus_name, :bus_color, :bus_state, :bus_localG, :bus_features, :bus_day, :bus_time, :bus_seatNo, :bus_date)');
                              if($stmt->execute(array(':bus_name'=>$busName,':bus_color'=> $busColor, ':bus_state'=>$busState, ':bus_localG'=>$busLocalG,
                              ':bus_features'=>$busFeatures, ':bus_day'=>$busPartDay,':bus_time'=>$busTime, ':bus_seatNo'=>$busSeatNo, ':bus_date'=>$busDepartureDate) )){
                                return 'true'; 
                               }
             
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
 public function getAllBuses(){
  try{
     if(isset($_GET['page'])){
      $page=$_GET['page'];
      if($page < 1){
       $page=1;
      }
     }else{
      $page=1;
     }
     if($page==""){
      header("location:error-404.php");
     }
     $page_max=10;
     $page_limit= ($page-1) * $page_max;
     $stmt = $this->db->prepare("SELECT * FROM ajalatravel_bus ORDER  BY bus_id LIMIT $page_limit,$page_max");
     $stmt->execute();
     $routes = array();
     $Buses= "<tr class='text-light bg-danger'><th>S/n</th><th>Name</th><th>Color</th><th>State</th><th>Local Govt</th><th>Features</th><th>Departure Day</th><th>Departure Time</th><th>Departure Date</th><th>Action</th></tr>";
     $rowCount= $stmt->rowCount();
     if($rowCount < 1){
      echo $Routes ='<div class="text-danger well well-small text-center" >No Bus is available</div>';
     }else
     {
     $i = 1;
     while($rows= $stmt->fetch())
     {
      
      $bus_id=$rows['bus_id'];
      $name=$rows['bus_name'];
      $color=$rows['bus_color'];
      $state=$rows['bus_state'];
      $localG=$rows['bus_localG'];
      $features=$rows['bus_features'];
      $day=$rows['bus_day'];
      $time=$rows['bus_time'];
      $date=$rows['bus_date']; 
      if($features==''){
       $features= 'Non';
      }
      $save='save'.$bus_id;
      $edit='edit'.$bus_id;
      $delete='delete'.$bus_id;
      $row='row'.$bus_id;
      $name_id='name'.$bus_id;
      $color_id='color'.$bus_id;
      $state_id='state'.$bus_id;
      $localG_id='localG'.$bus_id;
      $features_id='features'.$bus_id;
      $day_id='day'.$bus_id;
      $time_id='time'.$bus_id;
      $date_id='date'.$bus_id;
      $messName='messageName'.$bus_id;
      $messColor='messageColor'.$bus_id;
      $messState='messageState'.$bus_id;
      $messLocalG='messageLocalG'.$bus_id;
      $messFeatures='messageFeatures'.$bus_id;
      $messDay='messageDay'.$bus_id;
      $messTime='messageTime'.$bus_id;
      $messDate='messageDate'.$bus_id;
      $mess='message'.$bus_id;
      $Buses.="<tr id='$row'> <td>".$i."</td><td ><span id='$name_id'>$name</span><span  id='$messName' style='float:left;clear:left'></span></td >
      <td ><span id='$color_id'>$color</span><span  id='$messColor' style='float:left;clear:left'></span></td><td ><span id='$state_id'>$state</span><span  id='$messState' style='float:left;clear:left'></span></td>
      <td ><span id='$localG_id'>$localG</span><span  id='$messLocalG' style='float:left;clear:left'></span></td ><td ><span id='$features_id'>$features</span><span  id='$messFeatures' style='float:left;clear:left'></span></td >
      <td ><span id='$day_id'>$day</span><span  id='$messDay' style='float:left;clear:left'></span></td ><td ><span id='$time_id'>$time</span><span  id='$messTime' style='float:left;clear:left'></span></td >
       <td ><span id='$date_id'>$date</span><span  id='$messDate' style='float:left;clear:left'></span></td>
      <td style='width:150px; margin-left:20px;text-align:center'><span id='$edit' style='text-align:center'><a href='javascript:void(0)' onclick='Edit($bus_id)'  ><i style='color:blue' class='fa fa-edit fa-lg' aria-hidden='true'></i></a>
      </span><span style='display:none;float:left; ' id='$save' >
      <a  style='color:blue;width:40px; margin-right:5px' href='javascript:void(0)' onclick='Save($bus_id)' ><i  class='fa fa-save fa-lg' aria-hidden='true'></i></a>
      </span><span style='float:left' id='$delete'>
      <a href='javascript:void(0)' class='deleteBus' id='del ".$bus_id."'    data-title='Delete' data-toggle='modal' data-target='#confirm-delete'> <i style='color:red' class='fa fa-trash-o fa-lg' aria-hidden='true'></i></a></span><span  id='$mess' ></span></td ></tr >";
      $i++;
     }
     echo $Buses.="</table>";
     $div="<div style='width:90%'>";
     $stmt = $this->db->prepare("select count(*) as total from ajalatravel_bus");
     $stmt->execute();
     $rows= $stmt->fetch();
     $totals=$rows['total'];
     $lastpage=ceil($totals/$page_max);
     if($page<1){
        $page=1;
     }
     if($page>$lastpage){
        $page=$lastpage;
     }
     if($page==1){
        $div .="<ul class='pagination'><li><a  href='bus-table-view.php?page=1' style='background-color:#2196f3;color:white;boder-radius:2px'>First </a></li>";
     }else{
      $prev=$page-1;#2196f3
      $div .="<ul class='pagination'><li><a href='bus-table-view.php?page=$prev' style='background-color:#2196f3;color:white;boder-radius:2px'>Previous</a></li>";
     }
     $div .="";
     for($j=0; $j<$totals; $j++){
      if($page==$j){
        $div .="<li><a href='bus-table-view.php?page=$j' style='background-color:#2196f3;color:white;boder-radius:2px'>$j</a></li>";
      }
     }
     "</ul>";
     if($page==$lastpage){
      $div .="<li> <a href='bus-table-view.php?page=$lastpage' style='background-color:#2196f3;color:white;boder-radius:2px'>Last</a></li>";
     }else{
      $next=$page+1;
      $div .="<li><a href='bus-table-view.php?page=$next' style='background-color:#2196f3;color:white;boder-radius:2px'>Next </a></li>";
     }
       echo $div .="<ul></div>"; 
    }
   }catch (PDOException $e){
     echo '<p class="text-danger">'.$e->getMessage().'</p>';
    }  
 }
   public function busUpdate(
   $busName,
   $busColor,
   $busState,
   $busLocalG,
   $busFeatures,
   $busDay,
   $busTime,
   $busDate,
   $busId
  ){
  try{
   $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus WHERE bus_id = :bus_id');
   $stmt->execute(array('bus_id' => $busId));
   if( $stmt->rowCount() !=1){
    return "noId";
   }

     $stmt ="UPDATE ajalatravel_bus SET bus_name='$busName', bus_color='$busColor', bus_state ='$busState', bus_localG ='$busLocalG', bus_features ='$busFeatures', bus_day ='$busDay', bus_time ='$busTime', bus_date ='$busDate' WHERE bus_id = :bus_id";
     $stmt=$this->db->prepare($stmt);
     $stmt->execute(array(':bus_id'=>$busId));
     return "true";              
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
 public function deleteBus($busId){
 try{
    $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus WHERE bus_id = :bus_id');
    $stmt->execute(array('bus_id' => $busId));
    if( $stmt->rowCount() ==0){
     return "noId";
    }

     $row= $stmt->fetch();
     $stmt ="DELETE FROM ajalatravel_bus WHERE bus_id = :bus_id";
     $stmt=$this->db->prepare($stmt);
     $stmt->execute(array(':bus_id'=>$busId));
       return "true";
   
   } catch(PDOException $e)
   {
    echo '<p class="text-danger">'.$e->getMessage().'</p>';
   }
  }
   public function searchBus($departFrom, $departDate, $departTo){
     $data = array();
     $parkId='';
     
     $stmtPark = $this->db->prepare('SELECT park_id FROM ajalatravel_company_park WHERE park_name = :park_name');
     $stmtPark->execute(array('park_name' => $departFrom));
     
     
     if( $stmtPark->rowCount() ==0 ){
      return "noSearch";
     
     }elseif($stmtPark->rowCount() ==1){
       $rowPark= $stmtPark->fetch();
       $parkId =$rowPark['park_id'];
     }
     
     $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company_bus WHERE park_id = :park_id');
     $stmt->execute(array('park_id' => $parkId));
     $parkIds='';
     $busIds ='';
     $companyIds='';
     while($rows=$stmt->fetch()){
      $parkId=$rows['park_id'];
      $busIds .=$rows['bus_id'].'';
      $companyIds .= $rows['company_id'].'';
     }
     $busIdsArray =explode('',$busIds);
     $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company_bus WHERE park_id = :park_id');
     $stmt->execute(array('park_id' => $parkId));
     //$_SESSION['parkIds']= $parkIds;
     //$_SESSION['busIds']=  $busIds;
     //$_SESSION['company_id']= $companyIds;
     return "exist";
   }
 public function allBusRouteName(){
      $stmtsAR = $this->db->prepare('SELECT * FROM ajalatravel_bus_route');
      $stmtsAR->execute();
      $allRoute ='';
      while($rowsAR=$stmtsAR->fetch()){
        $allRoute .='<option get-id="'.$rowsAR['route_id'].'" value="'.$rowsAR['route_name'].'">'.$rowsAR['route_name'].'</option>';
      }
      return $allRoute;
 }
 public function routeNames(){
  try{
  $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus_route');
   $stmt->execute();
    $routeNames ='<select name="routeNameA" id="routeNameA" class="form-control">';
  if($stmt->rowCount() ==0){
   $routeNames .='<option value="none">Select Route</option>';
  }else{
   $routeNames .='<option value="none">Select Route</option>';
   while($rows= $stmt->fetch()){
    $routeNames .= '<option value="'.$rows['route_id'].'">'.$rows['route_name'].'</option>';
   }
  }
  return  $routeNames .='</select>'; 
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }                                           
 public function routeBusAttach(
   $routeNameA,
   $busNameA 
  ){
  try{
   $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus_to_route WHERE route_id = :route_id AND bus_id = :bus_id');
   $stmt->execute(array('route_id' => $routeNameA,'bus_id' => $busNameA));
   if( $stmt->rowCount()==1){
    return "exist";
   }
   $stmt = $this->db->prepare('INSERT INTO ajalatravel_bus_to_route(route_id, bus_id)VALUES
                              (:route_id, :bus_id)');
                              $stmt->execute(array(':route_id'=>$routeNameA, ':bus_id'=>$busNameA));
   return "true";            
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
  public function companyPark(
   $parkName,
   $parkDate 
  ){
  try{
   $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company_park WHERE park_name = :park_name');
   $stmt->execute(array('park_name' => $parkName));
   if( $stmt->rowCount()==1){
    return "exist";
   }
   $stmt = $this->db->prepare('INSERT INTO ajalatravel_company_park(park_name, park_date)VALUES
                              (:park_name, :park_date)');
                              $stmt->execute(array(':park_name'=>$parkName, ':park_date'=>$parkDate));
   return "true";            
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
   public function companyParkUpdate(
   $parkName,
   $parkDate,
   $parkId
  ){
  try{
  
   $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company_park WHERE park_id = :park_id');
   $stmt->execute(array('park_id' => $parkId));
   if( $stmt->rowCount() !=1){
    return "noId";
   }
   
   $stmt ="UPDATE ajalatravel_company_park SET park_name='$parkName' WHERE park_id = :park_id";
   $stmt=$this->db->prepare($stmt);
   $stmt->execute(array(':park_id'=>$parkId));
   return "true";
  
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
 
 public function parkNames(){
  try{
  $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company_park');
  $stmt->execute();
  $parkNames ='<select name="parkNameA" id="parkNameA" class="form-control">';
  if($stmt->rowCount() ==0){
   $parkNames .='<option value="none">Select Park Name</option>';
  }else{
   $parkNames .='<option value="none">Select Park Name</option>';
   while($rows= $stmt->fetch()){
    $parkNames .= '<option value="'.$rows['park_id'].'">'.$rows['park_name'].'</option>';
   }
  }
  return  $parkNames .='</select>'; 
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
 
 public function getAllParks(){
  try{
     if(isset($_GET['page'])){
      $page=$_GET['page'];
      if($page < 1){
       $page=1;
      }
     }else{
      $page=1;
     }
     if($page==""){
      header("location:error-404.php");
     }
     $page_max=10;
     $page_limit= ($page-1) * $page_max;
     $stmt = $this->db->prepare("SELECT * FROM ajalatravel_company_park ORDER  BY park_id LIMIT $page_limit,$page_max");
     $stmt->execute();
     $Parks= "<tr class='text-light bg-danger'><th>S/n</th><th>Name</th><th>Action</th></tr>";
     $rowCount= $stmt->rowCount();
     if($rowCount < 1){
      echo $Parks ='<div class="text-danger well well-small text-center" >No Parks is available</div>';
     }else
     {
     $i = 1;
     while($rows= $stmt->fetch())
     {
      $name=$rows['park_name'];
      $park_id=$rows['park_id'];
       $checked ='';
     
      $save='save'.$park_id;
      $edit='edit'.$park_id;
      $delete='delete'.$park_id;
      $row='row'.$park_id;
      $name_id='name'.$park_id;
      $messName='messageName'.$park_id;
      $mess='message'.$park_id;
      $Parks.="<tr id='$row'> <td>".$i."</td><td ><span id='$name_id'>$name</span><span  id='$messName' style='float:left;clear:left'></span></td >
      <td style='width:150px; margin-left:20px;text-align:center'><span id='$edit' style='text-align:center'><a href='javascript:void(0)' onclick='Edit($park_id)'  ><i style='color:blue' class='fa fa-edit fa-lg' aria-hidden='true'></i></a>
      </span><span style='display:none;float:left; ' id='$save' >
      <a  style='color:blue;width:40px; margin-right:5px' href='javascript:void(0)' onclick='Save($park_id)' ><i  class='fa fa-save fa-lg' aria-hidden='true'></i></a>
      </span><span style='float:left' id='$delete'>
      <a href='javascript:void(0)' class='deletePark' id='del ".$park_id."'    data-title='Delete' data-toggle='modal' data-target='#confirm-delete'> <i style='color:red' class='fa fa-trash-o fa-lg' aria-hidden='true'></i></a></span><span  id='$mess' ></span></td ></tr >";
      $i++;
     }
     echo $Parks.="</table>";
     $div="<div style='width:90%'>";
     $stmt = $this->db->prepare("select count(*) as total from ajalatravel_company_park");
     $stmt->execute();
     $rows= $stmt->fetch();
     $totals=$rows['total'];
     $lastpage=ceil($totals/$page_max);
     if($page<1){
        $page=1;
     }
     if($page>$lastpage){
        $page=$lastpage;
     }
     if($page==1){
        $div .="<ul class='pagination'><li><a  href='parks-table-view.php?page=1' style='background-color:#2196f3;color:white;boder-radius:2px'>First </a></li>";
     }else{
      $prev=$page-1;#2196f3
      $div .="<ul class='pagination'><li><a href='parks-table-view.php?page=$prev' style='background-color:#2196f3;color:white;boder-radius:2px'>Previous</a></li>";
     }
     $div .="";
     for($j=0; $j<$totals; $j++){
      if($page==$j){
        $div .="<li><a href='parks-table-view.php?page=$j' style='background-color:#2196f3;color:white;boder-radius:2px'>$j</a></li>";
      }
     }
     "</ul>";
     if($page==$lastpage){
      $div .="<li> <a href='parks-table-view.php?page=$lastpage' style='background-color:#2196f3;color:white;boder-radius:2px'>Last</a></li>";
     }else{
      $next=$page+1;
      $div .="<li><a href='parks-table-view.php?page=$next' style='background-color:#2196f3;color:white;boder-radius:2px'>Next </a></li>";
     }
       echo $div .="<ul></div>"; 
    }
   }catch (PDOException $e){
     echo '<p class="text-danger">'.$e->getMessage().'</p>';
    }  
 }
 public function deletePark($parkId){
  try{
     $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company_park WHERE park_id = :park_id');
     $stmt->execute(array('park_id' => $parkId));
     if( $stmt->rowCount() ==0){
      return "noId";
     }
     $stmt = $this->db->prepare('SELECT park_id FROM ajalatravel_park_to_company WHERE park_id = :park_id');
     $stmt->execute(array('park_id' => $parkId));
     if( $stmt->rowCount() !=0){
      return "notAllowed";
     }else{
      $row= $stmt->fetch();
      $stmt ="DELETE FROM ajalatravel_company_park WHERE park_id = :park_id";
      $stmt=$this->db->prepare($stmt);
      $stmt->execute(array(':park_id'=>$parkId));
        return "true";
     }
    } catch(PDOException $e)
    {
     echo '<p class="text-danger">'.$e->getMessage().'</p>';
    }
  }
  
  public function companyParkAttach(
   $companyNameA,
   $parkNameA 
  ){
  try{
    $stmt = $this->db->prepare('SELECT * FROM ajalatravel_park_to_company WHERE company_id = :company_id AND park_id = :park_id');
   $stmt->execute(array('company_id' => $companyNameA,'park_id' => $parkNameA));
   if( $stmt->rowCount()==1){
    return "exist";
   }
   $stmt = $this->db->prepare('INSERT INTO ajalatravel_park_to_company(company_id, park_id)VALUES
                              (:company_id, :park_id)');
                              $stmt->execute(array(':company_id'=>$companyNameA, ':park_id'=>$parkNameA));
   return "true";            
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
 public function searchBusByCompanyId($companyId){
  try{
  $stmt = $this->db->prepare('SELECT DISTINCT bus_id, park_id FROM ajalatravel_company_bus WHERE company_id =:company_id GROUP BY bus_id');
  $stmt->execute(array('company_id' => $companyId));
  $busIds ='';
  $parkIds =''; 
  if($stmt->rowCount() ==0){
   return 'noBus';
  }
  while($rows= $stmt->fetch()){
   $busIds .= $rows['bus_id'];
   $parkIds .=$rows['park_id'];
  }
  $busNames='';
  $busIdArray=str_split($busIds);
  $busNames .='<select name="busNameA" id="busNameA" class="form-control"><option value="none">Select bus name</option>';
  for($i=0; $i <sizeof($busIdArray); $i++){
 
   $stmt = $this->db->prepare('SELECT DISTINCT bus_id, bus_name FROM ajalatravel_bus WHERE bus_id =:bus_id');
   $stmt->execute(array('bus_id' =>$busIdArray[$i]));
   if($stmt->rowCount() ==0){
    $busNames.='<option value="none">Select bus name</option>';
   }else{
    while($rows= $stmt->fetch()){
     $busNames.='<option value='.$rows['bus_id'].'>'.$rows['bus_name'].'</option>';
    }
   }
  }
   return $busNames .='</select>';
 
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
 public function searchBusById($companyId,$busId){
  try{
  $stmt = $this->db->prepare('SELECT company_name FROM ajalatravel_company WHERE company_id ="'.$companyId.'"');
  $stmt->execute();
  while($rows= $stmt->fetch()){
   $companyName =$rows['company_name'];
  }   
  $stmt = $this->db->prepare('SELECT DISTINCT park_id FROM ajalatravel_company_bus WHERE company_id ="'.$companyId.'" AND bus_id="'.$busId.'"');
  $stmt->execute();
  $parkIds =''; 
  if($stmt->rowCount() ==0){
   return 'noMatch';
  }
  while($rows= $stmt->fetch()){
   $parkIds .=$rows['park_id'];
  }
  $parkIdArray=str_split($parkIds);
  $stmt = $this->db->prepare('SELECT DISTINCT route_id FROM ajalatravel_bus_to_route WHERE bus_id="'.$busId.'"');
  $stmt->execute();
  $routeIds='';
  if($stmt->rowCount() ==0){
   return 'noMatch';
  }
  while($rows= $stmt->fetch()){
   $routeIds .=$rows['route_id'];
  }
  $routeIdArray=str_split($routeIds);
  $routeIdArrayEx=str_split($routeIds);
  if(isset($parkIdArray) && isset($routeIdArray)){
  for($i=0; $i < sizeof($parkIdArray); $i++){
   $stmt = $this->db->prepare('SELECT park_name, park_id FROM ajalatravel_company_park WHERE park_id ='.$parkIdArray[$i]);
   $stmt->execute();
   if($stmt->rowCount() ==0){
     return "noMatch";
   }else{
    while($rows= $stmt->fetch()){
     if($rows['park_name'] == $_SESSION['departFrom']){
       $parkName = $rows['park_name'];
       $parkId = $rows['park_id'];
       $stmt = $this->db->prepare('SELECT bus_travel_fee_id FROM ajalatravel_company_bus WHERE company_id ='.$companyId.' AND bus_id='.$busId.' AND park_id ='.$parkId);
       $stmt->execute();        
       $row = $stmt->fetch();
       $busTravelFeeId = $row['bus_travel_fee_id'];
     }else{
       return "noMatch";          
     }
    }
    $stmt = $this->db->prepare('SELECT bus_travelFee FROM ajalatravel_bus_travel_fee WHERE bus_travel_fee_id ='.$busTravelFeeId);
    $stmt->execute();         
    $row = $stmt->fetch();
    $busTravelFee = $row['bus_travelFee'];
   }     
  }
  if(isset($parkName)){
   for($i=0; $i <sizeof($routeIdArray); $i++){
      $stmt = $this->db->prepare('SELECT route_name, route_id FROM ajalatravel_bus_route WHERE route_id ='.$routeIdArray[$i]);
      $stmt->execute();
    if($stmt->rowCount() ==0){
      return "noMatch";
    }else{
     $routeNames='';   
     while($rows= $stmt->fetch()){
      if($rows['route_name']==$_SESSION['departTo']){
       $routeName = $rows['route_name'];
       $routeId = $rows['route_id'];
       for($i=0; $i <sizeof($routeIdArrayEx); $i++){
        $stmt = $this->db->prepare('SELECT route_name FROM ajalatravel_bus_route WHERE route_id ='.$routeIdArrayEx[$i]);
        $stmt->execute();
        while($rows= $stmt->fetch()){
         $routeNames .=$rows['route_name'].',';
        }
       }
      }
     }
    }     
   }   
  }
  $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus WHERE bus_id="'.$busId.'"');
  $stmt->execute();
  $row= $stmt->fetch();
  $bus_date = $row['bus_date'];
  $busDateDay= explode('-',$row['bus_date']);
  $busDateDaySess= explode('-',$_SESSION['departDate']);
  if($busDateDay[2]==$busDateDaySess[2] || strtotime($row['bus_date']) == time()){
   $busName = $row['bus_name'];
   $busTime = $row['bus_time'];
   $busDay = $row['bus_day'];
   $busDate = date(' l F d',strtotime($row['bus_date']));   
   $busColor = $row['bus_color'];
   $busFeatures = preg_replace('/[,]+/',' | ',$row['bus_features']);
   $routeNames = preg_replace('/[,]+/',' | ',$routeNames);
   if(isset($parkName) && isset($routeName) && isset($companyName) && isset($busDateDay[2])){
    $_SESSION['companyId']=$companyId;
    $_SESSION['busId']=$busId;
    $_SESSION['parkId']=$parkId;
    $_SESSION['routeId']=$routeId;
    $_SESSION['busTravelFeeId'] = $busTravelFeeId;
   return $busSearch ='<div class="col-md-6" style="padding:0px 20px 0px;margin-bottom:15px">
                        <div class="row">
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Transport Company:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$companyName.'</label>
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Bus Name:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$busName.'</label>                   
                        </div>
                       </div>
                       <div class="col-md-6" style="padding:0px 20px 0px;margin-bottom:15px;">
                        <div class="row">
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Bus Color:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$busColor.'</label>
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Travel Time:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$busTime.'</label>                
                        </div>
                       </div>                 
                       <div class="col-md-6" style="padding:0px 20px 0px;margin-bottom:15px">
                        <div class="row">
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Travel Date:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px;margin-top:2px">'.$busDate.'</label>
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Part of Day:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$busDay.'</label>                   
                        </div>
                       </div>
                       <div class="col-md-6" style="padding:0px 20px 0px;margin-bottom:12px">
                        <div class="row">
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Bus Features:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$busFeatures.'</label>                
                        </div>
                       </div>
                       <div class="col-md-6" style="padding:0px 20px 0px;margin-bottom:12px">
                        <div class="row">
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px"> Droping Points:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$routeNames .'</label>
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px"> Bus Ticket Fee:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px"> &#8358;'.$busTravelFee.'</label>  
                        </div>
                       </div>';
   }else{
    return 'noMatch';
   }   
  }else if($busDateDay[2]==$busDateDaySess[2] || strtotime($row['bus_date']) > time()){
   $busName = $row['bus_name'];
   $busTime = $row['bus_time'];
   $busDay = $row['bus_day'];
   $busDate = date(' l F d',strtotime($row['bus_date']));   
   $busColor = $row['bus_color'];
   $busFeatures = preg_replace('/[,]+/',' | ',$row['bus_features']);
   $routeNames = preg_replace('/[,]+/',' | ',$routeNames);
   if(isset($parkName) && isset($routeName) && isset($companyName) && isset($busDateDay[2])){
    $_SESSION['companyId']=$companyId;
    $_SESSION['busId']=$busId;
    $_SESSION['parkId']=$parkId;
    $_SESSION['routeId']=$routeId;
    $_SESSION['busTravelFeeId'] = $busTravelFeeId;
   return $busSearch ='<div class="col-md-6" style="padding:0px 20px 0px;margin-bottom:15px">
                        <div class="row">
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Transport Company:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$companyName.'</label>
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Bus Name:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$busName.'</label>                   
                        </div>
                       </div>
                       <div class="col-md-6" style="padding:0px 20px 0px;margin-bottom:15px;">
                        <div class="row">
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Bus Color:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$busColor.'</label>
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Travel Time:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$busTime.'</label>                
                        </div>
                       </div>                 
                       <div class="col-md-6" style="padding:0px 20px 0px;margin-bottom:15px">
                        <div class="row">
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Travel Date:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px;margin-top:2px">'.$busDate.'</label>
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Part of Day:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$busDay.'</label>                   
                        </div>
                       </div>
                       <div class="col-md-6" style="padding:0px 20px 0px;margin-bottom:12px">
                        <div class="row">
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px">Bus Features:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$busFeatures.'</label>                
                        </div>
                       </div>
                       <div class="col-md-6" style="padding:0px 20px 0px;margin-bottom:12px">
                        <div class="row">
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px"> Droping Points:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px">'.$routeNames .'</label>
                         <label class="col-form-label" style="margin-right:10px;background-color:#004A99;color:#ecf5ff;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;font-weight:bold;margin-top:2px"> Bus Ticket Fee:</label>
                         <label class="col-form-label text-primary" style="margin-right:10px;height:25px;box-shadow:grey 5px 5px 5px;padding:3px;border-radius:3px;margin-top:2px"> &#8358;'.$busTravelFee.'</label>  
                        </div>
                       </div>';
   }else{
    return 'noMatch';
   }   
  }else{
   return 'noMatch';
  }

  }
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
  public function confirmIdSession($companyId, $parkId, $routeId, $busId, $busTravelFeeId){
   $stmt = $this->db->prepare('SELECT company_id, bus_id, bus_travel_fee_id, park_id FROM ajalatravel_company_bus WHERE company_id ='.$companyId.' AND bus_id ='.$busId.' AND park_id ='.$parkId.' AND bus_travel_fee_id ='.$busTravelFeeId);
  $stmt->execute();
  $row= $stmt->fetch();
  if($stmt->rowCount() ==0){
   return false;
  }else{
   
    $companyId = $row['company_id'];
    $busId = $row['bus_id'];
    $parkId =$row['park_id'];
    $busTravelFeeId = $row['bus_travel_fee_id'];
    $stmt = $this->db->prepare('SELECT route_id FROM ajalatravel_bus_to_route WHERE bus_id ='. $busId.' AND route_id ='.$_SESSION['routeId']);
    $stmt->execute();      
    $row= $stmt->fetch();
    if($stmt->rowCount() ==0){
      return false;   
    }else{     
     $routeId = $row['route_id'];
    }
    $ids= array('companyId'=>$companyId, 'busId'=>$busId, 'parkId'=>$parkId, 'busTravelFeeId'=>$busTravelFeeId, 'routeId'=>$routeId);
    return $ids;
  }     
 }
  public function customerTransaction($customerId, $companyId, $parkId, $routeId, $busId, $busTravelFeeId,$paymentCode){
      $stmt = $this->db->prepare('INSERT INTO ajalatravel_company_transaction(customer_id, company_id, park_id, route_id, bus_id, bus_travel_fee_id, paymentCode, payment )VALUES
      (:customer_id, :company_id, :park_id, :route_id, :bus_id, :bus_travel_fee_id, :paymentCode, :payment)');
      if($stmt->execute(array('customer_id'=>$customerId, ':company_id'=>$companyId, ':park_id'=>$parkId, ':route_id'=>$routeId, ':bus_id'=>$busId, ':bus_travel_fee_id'=>$busTravelFeeId, ':paymentCode'=>$paymentCode, ':payment'=>'no'))){
       return true;
      }else{
       return false;
      }
 }
 public function paymentCode($length){
  $key='';
  $keys = array_merge(range(0,9), range('a', 'z'));
  for($i =0; $i < $length; $i++){
   $key .=$keys[array_rand($keys)];
  }
  return $key;
 }
 public function sendPaymentCodeByEmail($paymentCode, $email){
 require('../lib/php-sendgrid/class.phpmailer.php');
 require('../lib/php-sendgrid/class.smtp.php');
  
       $mail = new PHPMailer(); // create a new object
       $mail->IsSMTP(); // enable SMTP
       $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
       $mail->SMTPAuth = true; // authentication enabled
       $mail->SMTPSecure = 'ssl';
       $mail->Host = "smtp.gmail.com";
       $mail->Port = 465; // or tsl 587 or ssl 465
       $mail->isHTML(true);
       $mail->Username = "methyl2007@gmail.com";
       $mail->Password = "wanted19861118.";
       $mail->SetFrom("methyl2007@gmail.com");
       $mail->Subject = "Ajalatravel Payment code";
       $mail->AddAddress($email);
       $mail->Body = "<div style='padding:20px;width:90%;text-align:center;background-color:#ecf5ff;box-shadow:5px 10px 8px 10px #888888;border-radius:3px'>
        <h1 style='background-color:#004A99;font-weight:bold;text-align:center;color:#ecf5ff;padding:20px'>Ajalatravel Payment Code</h1>
       <h3 style='color:green;font-size:bold;padding:20px'>Please kindly use this code: $paymentCode to make payment on our platform </h3></div>";
        if($mail->Send()){
         
             return true;
        }else{
            return false;
        }
 }
  public function sendPaymentCodeBySms($paymentCode, $phoneNumber){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://termii.com/api/sms/send",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => '{"sms":"Ajalatravel,Kindly use this shortcode: '.$paymentCode.' to make payment on our platform",
    "to":"'.$phoneNumber.'","from":"OTPAlert",
    "api_key":"TTGq8IvkQurXV3AdgFLnnJH0TiFeIjjpcIAfgkf9p6KrWjFymOl0XYgC3HZXmk",
    "channel":"dnd","type":"plain"}',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
  ));

   $response = curl_exec($curl);
   $err = curl_error($curl);
   
   curl_close($curl);
   
   if ($err){
     return false;
   } else {
     if($response){
      return true;
     }else{
      return false;
     }
   }
 }
 public function create_hash($value){
  return $hash=md5($value);
 }
 public function getUser($username)
 {
  try{
   $stmt = $this->db->prepare('SELECT user_id FROM ajalatravel_users WHERE username = :username');
   $stmt->execute(array(':username'=>$username));
   $row= $stmt->fetch();
   $userId =$row['user_id'];
   $stmt = $this->db->prepare('SELECT firstname, lastname FROM ajalatravel_user_information WHERE user_id = :user_id');
   $stmt->execute(array(':user_id'=>$userId));
   $row= $stmt->fetch();
   if($stmt->rowCount() ==0){
    return '';
   }else{
    if(empty($row['firstname']) || empty($row['lastname'])){
     return '';
    }
    return ucfirst($row['firstname']).'@'.strtolower($row['lastname']);
   }
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }             
 }
 public function getUserDetails($username){
   try{
   $stmt = $this->db->prepare('SELECT user_id FROM ajalatravel_users WHERE username = :username');
   $stmt->execute(array(':username'=>$username));
   $row= $stmt->fetch();
   $userId =$row['user_id'];
   $stmt = $this->db->prepare('SELECT firstname, lastname, email FROM ajalatravel_user_information WHERE user_id = :user_id');
   $stmt->execute(array(':user_id'=>$userId));
   $row= $stmt->fetch();
   if($stmt->rowCount() ==0){
    return '';
   }else{
    if(empty($row['firstname']) || empty($row['lastname'])){
     return '';
    }
   return  $details='<p class="mb-1 mt-3 font-weight-semibold text-primary">'.ucfirst($row['firstname']).'@'.strtolower($row['lastname']).'</p>
                  <p class="font-weight-light text-muted mb-0">'.strtolower($row['email']).'</p>';
   }
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }        
 }
 public function verify_hash($password, $hash){
  return $hash==md5($password);
 }
 public function verify_user($user){
  if($user=="Super Admin"){
   return "Super Admin";
  }else if($user=="User"){
   return "User";
  }else{
   return "";
  } 
 }
 public function get_user_hash($username,$checker){
  try{
  $stmt = $this->db->prepare('SELECT password, checker2 FROM ajalatravel_users WHERE username = :username AND checker = :checker');
  $stmt->execute(array(':username'=>$username,':checker'=>$checker));
  $row= $stmt->fetch();
  return $row['password'];    
 }catch (PDOException $e){
  echo '<p class="text-danger">'.$e->getMessage().'</p>';
 }
   
 }

 public function get_user($username,$checker){
  try{
   $stmt = $this->db->prepare('SELECT password, checker2, reg_id FROM admin_users WHERE username = :username AND checker = :checker');
   $stmt->execute(array(':username'=>$username,':checker'=>$checker));
   $row= $stmt->fetch();
   $_SESSION['regSessId']=$row['checker2'];
   $_SESSION['regId'] =$row['reg_id'];
   return $row['checker2'];  
 }catch (PDOException $e){
  echo '<p class="text-danger">'.$e->getMessage().'</p>';
 }

}
 public function getId($username){
  try{
   $stmt = $this->db->prepare('SELECT user_id FROM ajalatravel_users WHERE username= :username');
   $stmt->execute(array(':username'=> $username));
   $row= $stmt->fetch();
   return $row['user_id'];
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
 }
 public function getUserId($username){
  try{
   $stmt = $this->db->prepare('SELECT reg_id FROM admin_users WHERE username= :username');
   $stmt->execute(array(':username'=> $username));
   $row= $stmt->fetch();
   echo $row['reg_id'];
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
}
 function protectData($data){
  return   strip_tags(trim($data));
 }
 function protectMessage($data){
  return    htmlentities(trim($data),ENT_NOQUOTES);
 }
 public function login($username, $password, $checker ){
  $hashed = $this->get_user_hash($username, $checker);     
  if($this->verify_hash($password, $hashed)==1){
   $user = $this->get_user($username, $checker);
   if($this->verify_user($user)){
   $_SESSION['loggedin'] = true;
      $_SESSION['super'] =true;  
   }
   $_SESSION['loggedin'] = true;
   return true;
  }                      
 }
 public function saveProfileDetail(
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
  $id
 ){
  try{
   $stmt = $this->db->prepare('INSERT INTO ajalatravel_user_information
   (firstName, middlename, lastname,  gender, email, phonenumber, state, localG,
   address1, address2, image, user_id)VALUES (:firstName, :middlename, :lastname,  :gender, :email,
   :phonenumber, :state, :localG, :address1, :address2, :image, :user_id)');
   $stmt->execute(array(':firstName'=>$firstname, ':middlename'=> $middlename, ':lastname'=>$lastname,
                        ':gender'=> $gender, ':email'=> $email, ':phonenumber'=> $phone, ':state'=>$state,
                        ':localG'=>$localG, ':address1'=>$address1, ':address2'=>$address2, ':image'=>$image, ':user_id'=>$id));
   return true;            
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
              
 }
 public function updateProfileDetail(
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
  $id
 ){
   try{
       $stmt ="UPDATE ajalatravel_user_information SET firstname='$firstname',middlename='$middlename',
       lastname='$lastname', phonenumber='$phone', gender='$gender', email='$email', state='$state', localG='$localG',
       address1='$address1', address2='$address2', image='$image' WHERE user_id = :user_id";
       $stmt=$this->db->prepare($stmt);
       $stmt->execute(array(':user_id'=>"$id"));
          return true;               
      } catch(PDOException $e)
      {
       echo '<p class="text-danger">'.$e->getMessage().'</p>';
      }
  }
  
 public function confirmUserId($id){
   try{
   $stmt = $this->db->prepare('SELECT user_id FROM ajalatravel_users WHERE user_id = :user_id');
   $stmt->execute(array(':user_id'=>$id));
   $rowCount= $stmt->rowCount();
   if($rowCount > 0){
    return true;
   }                  
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';           
 }
 }
 public function getRegId($id){  
  try {
   $stmt = $this->db->prepare('SELECT reg_id FROM admin_users WHERE reg_id = :reg_id');
   $stmt->execute(array(':reg_id'=>$id));
   $row= $stmt->fetch();
   return $row['reg_id'];
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
 }
 public function getAccess($id){
  try{
   $stmt = $this->db->prepare('SELECT checker2 FROM admin_users WHERE reg_id = :reg_id');
   $stmt->execute(array(':reg_id'=>$id));
   $row= $stmt->fetch();
   return $row['checker2'];
  }catch (PDOException $e){
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
 }
 public function checkProfileId($pid){
  try{
   $stmt = $this->db->prepare('SELECT profile_id FROM user_profile_details WHERE profile_id = :profile_id');
   $stmt->execute(array(':profile_id'=>$pid));
   $rowCount= $stmt->rowCount();
    if($rowCount > 0){
       return true;
    }                  
  }catch (PDOException $e)
  {
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }         
 }

						
 public function contactUs($name,$subject, $email, $message )
 {
  try{
    $stmt = $this->db->prepare('SELECT * FROM user_profile_details WHERE email = :email');
    $stmt->execute(array(':email'=>$email));
    $rowCount= $stmt->rowCount();
    if($rowCount ==1){
     $stmt = $this->db->prepare('INSERT INTO contact_us
                              (name,subject, email, message )
                               VALUES (:name, :subject, :email, :message )');
     $stmt->execute(array(':name'=>$name, ':subject'=> $subject, 'email'=> $email, ':message'=>$message));
     return true;                
   }else{
     return "Oops";
    }
  }catch (PDOException $e)
  {
   echo '<p class="text-danger">'.$e->getMessage().'</p>';
  }
               
 }
   public function editProfileDetails($id)
  {
   try{
     $stmt = $this->db->prepare('SELECT * FROM ajalatravel_user_information WHERE user_id = :user_id');
       $stmt->execute(array(':user_id'=>$id));
       $editProfileDetail="";
       $rowCount= $stmt->rowCount();
       $firstname= "";
        $middlename= "";
        $lastname= "";
        $phoneNumber= "";
        $gender= "";
        $email= "";
        $description= "";
        $address= "";
        $image= "";

         if($rowCount !== 1){
          return $editProfileDetail ='<div class="col-sm-12"><br>
                            <p class="card-description text-danger">Update your profile information</p>
                            <p class="card-description text-primary"><strong>Profile Information:</strong></p>
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"> Profile Image</label>
                                            <div class="col-sm-9 profileImage-group">
                                                <input type="file" name="profileImage" class="form-control  img pull-left"/>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">First Name</label>
                                      <div class="col-sm-9 firstName-group">
                                        <input type="text" name="firstName" id="firstName" placeholder="First Name" class="form-control" />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Middle Name</label>
                                      <div class="col-sm-9 middleName-group">
                                        <input type="text" name="middleName" id="middleName" placeholder="Middle Name" class="form-control" />
                                      </div>
                                    </div>
                                  </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"> Last Name</label>
                                            <div class="col-sm-9 lastName-group">
                                                <input type="text" name="lastName" id="lastName" placeholder="Last Name" class="form-control" />
                                            </div>
                                        </div>
                                    </div>                                       
                                    <div class="col-md-4 col-md-offset-2">
                                        <div class="form-group row">
                                            <div class="form-radio gender-group"  style="margin-left:10px">
                                              <label>
                                                <input type="radio"  name="gender" id="gender1" value="male" > Male
                                              </label>
                                            </div>
                                            <div class="form-radio gender-group" style="margin-left:10px">
                                                <label>
                                                    <input type="radio"  name="gender" id="gender2" value="female"> Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9 email-group">
                                                <input type="email" name="email" id="email" placeholder="Email" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Phone Number</label>
                                            <div class="col-sm-9 phone-group">
                                                <input type="phone" name="phone" id="phone" placeholder="Phone Number" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">State</label>
                                            <div class="col-sm-9 state-group">          
                                                  <select name="state" id="state" class="form-control">
                                                        <option value="none">Select State</option>   
                                                  </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Local Govt</label>
                                            <div class="col-sm-9 localG-group">          
                                                <select name="localG" id="localG" class="form-control">
                                                    <option value="none">Select Local Govt</option>   
                                                </select>
                                            </div>
                                        </div>
                                    </div>     
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Address 1</label>
                                            <div class="col-sm-9 address1-group">          
                                                <input type="text" name="address1" id="address1" class="form-control" placeholder="Address 1">
                                            </div>
                                        </div>
                                    </div>                                  
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Address 2</label>
                                                <div class="col-sm-9 address2-group">
                                                    <input type="text" name="address2" id="address2" class="form-control" placeholder="Address 2">
                                                </div>
                                        </div>                                    
                                    </div>                                                                       
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <button type="submit" name="save" id="save" class="btn btn-success col-sm-4 col-sm-offset-8" style="float:right;margin-bottom:10px" value="Save"><i class="fa fa-save"></i>Save</button>                  
                                </div>  
                            </form><br><br>
                        </div>';
         }else{
          while($rows= $stmt->fetch()){
            $firstname= $rows['firstname'];
            $middlename= $rows['middlename'];
            $lastname= $rows['lastname'];
            $phoneNumber= $rows['phonenumber'];
            $gender= $rows['gender'];
            $email= $rows['email'];
            $state= $rows['state'];
            $local =$rows['localG'];
            $address1 =$rows['address1'];
            $address2= $rows['address2'];
            $userInformationId= $rows['user_information_id'];
          
            if($gender =="male"){
             $checked= 'checked';
             
            }else if($gender =="female"){
             $checked= 'checked';
            }else{
              $checked="";
            }
            if($image==""){
             $image= "image/images.png";
            }else{
           $image =$rows['image'];
            }
                     
            $editProfileDetail='<div class="col-sm-12"><br>
                              <p class="card-description text-danger">Update your profile information</p>
                              <p class="card-description text-primary"><strong>Profile Information:</strong></p>
                              <form method="post" action="" enctype="multipart/form-data">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group row">
                                              <label class="col-sm-3 col-form-label"> Profile Image</label>
                                              <div class="col-sm-9 profileImage-group">
                                                  <input type="file" name="profileImage" class="form-control  img pull-left"/>
                                                  <input type="hidden" name="img" class="form-control  img pull-left" value="'.$userInformationId.'"/>
                                              </div>
                                          </div>
                                      </div>                                    
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">First Name</label>
                                        <div class="col-sm-9 firstName-group">
                                          <input type="text" name="firstName" id="firstName" placeholder="First Name" class="form-control" value="'.$firstname.'"/>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Middle Name</label>
                                        <div class="col-sm-9 middleName-group">
                                          <input type="text" name="middleName" id="middleName" placeholder="Middle Name" class="form-control" value="'.$middlename.'"/>
                                        </div>
                                      </div>
                                    </div> 
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group row">
                                              <label class="col-sm-3 col-form-label"> Last Name</label>
                                              <div class="col-sm-9 lastName-group">
                                                  <input type="text" name="lastName" id="lastName" placeholder="Last Name" class="form-control" value="'.$lastname.'"/>
                                              </div>
                                          </div>
                                      </div>                                       
                                      <div class="col-md-4 col-md-offset-2">
                                          <div class="form-group row">';
                                          if($gender =="male"){
                                             $checked= 'checked';
                                             $editProfileDetail.='<div class="form-radio gender-group" style="margin-left:10px">
                                                              <label>
                                                <input type="radio"  name="gender" id="gender1" checked="'.$checked.'" value="'.$gender.'"> Male
                                              </label>
                                            </div>
                                            <div class="form-radio gender-group" style="margin-left:10px">
                                                <label>
                                                    <input type="radio"  name="gender" id="gender2" value="female"> Female
                                                </label>
                                            </div>';
                                            }
                                            if($gender =="female"){
                                             $checked= 'checked';
                                             $editProfileDetail.='<div class="form-radio gender-group" style="margin-left:10px">
                                                              <label>
                                                <input type="radio"  name="gender" id="gender1" value="male" > Male
                                              </label>
                                            </div>
                                            <div class="form-radio gender-group" style="margin-left:10px">
                                                <label>
                                                    <input type="radio"  name="gender" id="gender2" checked="'.$checked.'" value="'.$gender.'"> Female
                                                </label>
                                            </div>';
                                            }
                                           if($gender ==""){
                                             $editProfileDetail.='<div class="form-radio gender-group"  style="margin-left:10px">
                                              <label>
                                                <input type="radio"  name="gender" id="gender1" value="male" > Male
                                              </label>
                                            </div>
                                            <div class="form-radio gender-group" style="margin-left:10px">
                                                <label>
                                                    <input type="radio"  name="gender" id="gender2" value="female"> Female
                                                </label>
                                            </div>';
         }
                                              $editProfileDetail.='</div>
                                                                   </div>
                                                                   </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group row">
                                              <label class="col-sm-3 col-form-label">Email</label>
                                              <div class="col-sm-9 email-group">
                                                  <input type="email" name="email" id="email" placeholder="Email" class="form-control" value="'.$email.'"/>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group row">
                                              <label class="col-sm-3 col-form-label">Phone Number</label>
                                              <div class="col-sm-9 phone-group">
                                                  <input type="phone" name="phone" id="phone" placeholder="Phone Number" class="form-control" value="'.$phoneNumber.'"/>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">';
                                  if(isset($state) && $state !='' && $state !='none'){
                                             $editProfileDetail.='<div class="col-md-6">
                                          <div class="form-group row">
                                              <label class="col-sm-3 col-form-label">State</label>
                                              <div class="col-sm-9 state-group">          
                                                    <select name="state" id="state" class="form-control">
                                                          <option value="'.$state.'">'.$state.'</option>   
                                                    </select>
                                              </div>
                                          </div>
                                      </div>';
                                            }else{
                                             $editProfileDetail.= '<div class="col-md-6">
                                          <div class="form-group row">
                                              <label class="col-sm-3 col-form-label">State</label>
                                              <div class="col-sm-9 state-group">          
                                                    <select name="state" id="state" class="form-control">
                                                          <option value="none">Select State</option>   
                                                    </select>
                                              </div>
                                          </div>
                                      </div>';
                                            }
                                  if(isset($local) && $local !='' && $local !='none'){
                                             $editProfileDetail.= '<div class="col-md-6">
                                          <div class="form-group row">
                                              <label class="col-sm-3 col-form-label">Local Govt</label>
                                              <div class="col-sm-9 localG-group">          
                                                  <select name="localG" id="localG" class="form-control">
                                                      <option value="'.$local.'">'.$local.'</option>   
                                                  </select>
                                              </div>
                                          </div>
                                      </div>';         
                                            }else{
                                             $editProfileDetail.= '<div class="col-md-6">
                                          <div class="form-group row">
                                              <label class="col-sm-3 col-form-label">Local Govt</label>
                                              <div class="col-sm-9 localG-group">          
                                                  <select name="localG" id="localG" class="form-control">
                                                      <option value="none">Select Local Govt</option>   
                                                  </select>
                                              </div>
                                          </div>
                                      </div>';         
                                            }                                           
                                 return $editProfileDetail.='</div>
                                  <div class="row">
                                     <div class="col-md-6">
                                          <div class="form-group row">
                                              <label class="col-sm-3 col-form-label">Address 1</label>
                                              <div class="col-sm-9 address1-group">          
                                                  <input type="text" name="address1" id="address1" class="form-control" value="'.$address1.'">
                                              </div>
                                          </div>
                                      </div>                                  
                                      <div class="col-md-6">
                                          <div class="form-group row">
                                              <label class="col-sm-3 col-form-label">Address 2</label>
                                                  <div class="col-sm-9 address2-group">
                                                      <input type="text" name="address2" id="address2" class="form-control" value="'.$address2.'">
                                                  </div>
                                          </div>                                    
                                      </div>                                                                       
                                  </div>
                                  <div class="col-md-12 col-sm-12">
                                      <button type="submit" name="update" value="Update"  id="update" class="btn btn-success col-sm-4 col-sm-offset-8" style="float:right;margin-bottom:10px" ><i class="fa fa-save"></i>Update</button>                  
                                  </div>  
                              </form><br><br>
                          </div>';
          }             
         }           

    }catch (PDOException $e)
     {
      echo '<p class="text-danger">'.$e->getMessage().'</p>';
     }
              
 }
  public function getEditProfileDetails($id){
      $stmt = $this->db->prepare('SELECT username FROM ajalatravel_users WHERE user_id = :user_id');
      $stmt->execute(array(':user_id'=>$id));
       $row=$stmt->fetch();
       $username=$row['username'];
      $stmt = $this->db->prepare('SELECT * FROM ajalatravel_user_information WHERE user_id = :user_id');
      $stmt->execute(array(':user_id'=>$id));
      $rowCount= $stmt->rowCount();
       $rows=$stmt->fetch();
       $image='data:image;base64,'.$rows['image'];
        $profile ="";
       if($rowCount > 0){
   return $profile .='<div style="width:50%;margin:auto">
                        <img src='.$image.' class="img-circle img-responsive center-block" width="120" height="120" style="border-color:blue;"/>
                       <ul style="text-align: center;padding:0;margin:0">
                        <p class="font-weight-light text-muted mb-0"><label class="text-danger">'.$rows['firstname'].' '.$rows['lastname'].'</label></p>
                        <p class="font-weight-semibold text-primary"><a href="">'.$rows['email'].'</a></p>
                       </ul>
                      </div>
                     <div class="col-sm-12">
                       <fieldset>
                       <legend>
                       Personal Information
                       </legend>
                       <div class="row">
                         <div class="col-md-4">
                           <div class="row">
                             <label class="col-sm-1 text-danger"><span class="fa fa-user-circle" style="font-size:x-large"></span></label>
                             <div class="col-sm-8 text-primary">
                               <label>
                              '.ucfirst($rows['firstname'].' '.$rows['lastname']).'
                              </label>
                             </div>
                           </div>
                         </div>
                         <div class="col-md-3">
                           <div class="row">
                             <label class="col-sm-1 text-danger"><span class="fa fa-intersex" style="font-size:x-large"></span></label>
                             <div class="col-sm-8 text-primary">
                              <label>
                              '.ucfirst($rows['gender']).'
                              </label>
                             </div>
                           </div>
                         </div>
                         <div class="col-md-5">
                           <div class="row">
                             <label class="col-sm-1 text-danger"><span class="fa fa-envelope-o" style="font-size:x-large"></span></label>
                             <div class="col-sm-8 text-primary">
                              <label>
                              '.ucfirst($rows['email']).'
                              </label>
                             </div>
                           </div>
                         </div>                          
                       </div>
                       <div class="row">
                         <div class="col-md-4">
                           <div class="row">
                             <label class="col-sm-1 text-danger"><span class="fa fa-phone-square" style="font-size:x-large"></span></label>
                             <div class="col-sm-8 text-primary">
                               <label>
                              '.ucfirst($rows['phonenumber']).'
                              </label>
                             </div>
                           </div>
                         </div>
                         <div class="col-md-3">
                           <div class="row">
                             <label class="col-sm-2 text-danger"><span class="fa fa-location-arrow" style="font-size:x-large"></span></label>
                             <div class="col-sm-8 text-primary">
                              <label>
                               '.ucfirst($rows['state']).'
                              </label>
                             </div>
                           </div>
                         </div>
                         <div class="col-md-5">
                           <div class="row">
                             <label class="col-sm-1 text-danger"><span class="fa fa-location-arrow" style="font-size:x-large"></span></label>
                             <div class="col-sm-8 text-primary">
                              <label>
                              '.ucfirst($rows['localG']).'
                              </label>
                             </div>
                           </div>
                         </div>                          
                       </div>                      
                       </fieldset>
                       <fieldset>
                       <legend>
                       Other Information
                       </legend>
                       <div class="row">
                         <div class="col-md-4">
                           <div class="row">
                             <label class="col-sm-1 text-danger"><span class="fa fa-user-circle-o" style="font-size:x-large"></span></label>
                             <div class="col-sm-8 text-primary">
                               <label>
                              '.ucfirst($username).'
                              </label>
                             </div>
                           </div>
                         </div>
                         <div class="col-md-4">
                           <div class="row">
                             <label class="col-sm-2 text-danger"><span class="fa fa-address-card-o" style="font-size:x-large"></span></label>
                             <div class="col-sm-10 text-primary">
                              <label>
                              '.ucfirst($rows['address1']).'
                              </label>
                             </div>
                           </div>
                         </div>
                         <div class="col-md-4">
                           <div class="row">
                             <label class="col-sm-2 text-danger"><span class="fa fa-address-card-o" style="font-size:x-large"></span></label>
                             <div class="col-sm-10 text-primary">
                              <label>
                              '.ucfirst($rows['address2']).'
                              </label>
                             </div>
                           </div>
                         </div>                          
                       </div>
                       </fieldset>
                      </div>
                      ';
       }else{
         return $profile .='<div style="width:60%;margin:auto"><h2 class="bg-primary">No profile Information available for any user</h2></div>';
       }

 }
 public function getProfileImage($userId)
 {
  try{
      $stmt = $this->db->prepare('SELECT image FROM ajalatravel_user_information WHERE user_id = :user_id');
      $stmt->execute(array(':user_id'=>$userId));
      $row= $stmt->fetch();
      return $row['image'];
   
     }catch (PDOException $e)
     {
      echo '<p class="text-danger">'.$e->getMessage().'</p>';
     }
              
 } 
 public function getProfileInformationImage($userInformationId)
 {
  try{
      $stmt = $this->db->prepare('SELECT image FROM ajalatravel_user_information WHERE user_information_id = :user_information_id');
      $stmt->execute(array(':user_information_id'=>$userInformationId));
      $row= $stmt->fetch();
      if($stmt->rowCount() ==0){
        return "noId";
      }else{
        $row['image'];
       return $row['image'];
      }
     }catch (PDOException $e)
     {
      echo '<p class="text-danger">'.$e->getMessage().'</p>';
     }
              
 }
  public function getAllCreatedBus()
 {
  try{
      $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus');
      $stmt->execute();
      $row= $stmt->fetch();
      if($stmt->rowCount() ==0){
        return 0;
      }else{
        
       return $stmt->rowCount();
      }
     }catch (PDOException $e)
     {
      echo '<p class="text-danger">'.$e->getMessage().'</p>';
     }
              
 }
   public function getAllCreatedCompanies()
 {
  try{
      $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company');
      $stmt->execute();
      $row= $stmt->fetch();
      if($stmt->rowCount() ==0){
        return 0;
      }else{
        
       return $stmt->rowCount();
      }
     }catch (PDOException $e)
     {
      echo '<p class="text-danger">'.$e->getMessage().'</p>';
     }
              
 }
    public function getAllCreatedRoutes()
 {
  try{
      $stmt = $this->db->prepare('SELECT * FROM ajalatravel_bus_route');
      $stmt->execute();
      $row= $stmt->fetch();
      if($stmt->rowCount() ==0){
        return 0;
      }else{
        
       return $stmt->rowCount();
      }
     }catch (PDOException $e)
     {
      echo '<p class="text-danger">'.$e->getMessage().'</p>';
     }
              
 }
  public function getAllCreatedParks()
 {
  try{
      $stmt = $this->db->prepare('SELECT * FROM ajalatravel_company_park');
      $stmt->execute();
      $row= $stmt->fetch();
      if($stmt->rowCount() ==0){
        return 0;
      }else{
        
       return $stmt->rowCount();
      }
     }catch (PDOException $e)
     {
      echo '<p class="text-danger">'.$e->getMessage().'</p>';
     }
              
 }
 public function logout(){
  session_destroy();
 }
 }
 ?>