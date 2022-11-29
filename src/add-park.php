<?php
define('Ajaccess', TRUE);
  //connection
  require_once('../lib/config/config.php');
  //initialize session
  $user->launchSession();
  //check if not logged in
  if(!$user->is_logged_in()){
    header('Location:../tour/login.php');
  }
    if(isset($_SESSION['userId'])){
       
        if($profile->profileImage($profile->profileId($_SESSION['userId']))!=""){
          $image =$profile->profileImage($profile->profileId($_SESSION['userId']));
          $image = "data:image;base64,".$image;
        
        }else{
            $image= 'assets/images/faces/images.png';

        }
    }
    
    if(!empty($profile->profileUser($_SESSION['userId']))){
        $username='<p class="profile-name">'.$profile->profileUser($_SESSION['userId']).'</p>';
    }else{
        $username='<p class="profile-name">Ajala@ajalatravel</p>';
    }
    
    if(!empty($profile->profileUserDetails($_SESSION['userId']))){
        $details=$profile->profileUserDetails($_SESSION['userId']);
    }else{
        $details='<p class="mb-1 mt-3 font-weight-semibold text-primary">Ajala@ajalatravel</p>
                  <p class="font-weight-light text-muted mb-0">Ajala@ajalatravel.com</p>';
    }                      
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ajalatravel Add Park</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/font-awesome/css/font-awesome.min.css">        
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">    
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <script src="assets/js/jquery.js"></script>
    <script>
      function dateTime(){
        var date = new Date();
        var h = date.getHours();
        var m = date.getMinutes();
        if (h > 12) {
          h -= 12;
        }else if (h ===0){
          h = 12
        }
        var s =date.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        var  result = h+':'+ m +':'+s;
        document.getElementById('time').innerHTML = result;
        var t =setTimeout(dateTime,1000);
      }
      function checkTime(i) {
        if (i < 10) {
           i = "0" + i;
        }
        return i;
      }      
      $(document).ready(function(){
        $("#createPark").click(function(){
            $('#createSection').toggle();
        });              
        $("#addPark").click(function(){
            $('#parkSection').toggle();
        });        
         // onclick of the sumbit park form
        $("#park").click(function(e){
          e.preventDefault();
           $("#park-message").empty();
          $('.parkName-group').removeClass('has-error');
          $('.parkDate-group').removeClass('has-error');         
          $('.help-block').remove(); // remove the error text          
          var form_data = {
           parkName: $('#parkName').val(),
           parkDate: $('#parkDate').val(),
           addPark: 'save',
           is_ajax: 1
          };
          $.ajax({
              type: "POST",
              url: 'ajax-add-park.php',
              data: form_data,
              dataType: 'json',
          }).done(function (data){
             if(!data.success){
               if(data.error.parkName) {
                 $('.parkName-group').addClass('has-error');
                 $('.parkName-group').append('<div class="help-block" style="font-size:small">' + data.error.parkName + '</div>'); // add the actual error message under our input
               }else{
                 if(data.error.parkDate){
                   $('.parkDate-group').addClass('has-error');
                   $('.parkDate-group').append('<div class="help-block" style="font-size:small">' + data.error.parkDate + '</div>'); // add the actual error message under our input
                 } 
               }   
             }else if(data.success =='no'){
               window.location.href="error-404.php";
             }else if(data.success =='exist'){   
               $("#park-message").prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
               setTimeout(function(){
                    location.reload();
               }, 6000);
             }else{
               $("#park-message").prepend("<div class='status alert alert-success text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
               setTimeout(function(){
                    location.reload();
               }, 6000);
             }      
          });          
        });
         // onclick of the sumbit attach park to company form
        $("#addParkA").click(function(e){
          e.preventDefault();
          $('#company-park-message').empty('');        
          $('.companyNameA-group').removeClass('has-error');
          $('.parkNameA-group').removeClass('has-error');         
          $('.help-block').remove(); // remove the error text          
          var form_data = {
           companyNameA: $('#companyNameA').val(),
           parkNameA: $('#parkNameA').val(),
           companyName: $('#companyNameA option:selected').text(),
           parkName: $('#parkNameA option:selected').text(),           
           addParkA: 'save',
           is_ajax: 1
          };

          $.ajax({
              type: "POST",
              url: 'ajax-add-company-park.php',
              data: form_data,
              dataType: 'json',
          }).done(function (data){
             if(!data.success){
               if(data.error.companyNameA){
                 $('.companyNameA-group').addClass('has-error');
                 $('.companyNameA-group').append('<div class="help-block" style="font-size:small">' + data.error.companyNameA + '</div>'); // add the actual error message under our input
               }else{
                 if(data.error.busNameA){
                   $('.parkNameA-group').addClass('has-error');
                   $('.parkNameA-group').append('<div class="help-block" style="font-size:small">' + data.error.parkNameA + '</div>'); // add the actual error message under our input
                 } 
               }   
             }else if(data.success =='no'){
               window.location.href="error-404.php";
             }else if(data.success =='exist'){   
               $("#company-park-message").prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
               setTimeout(function(){
                    location.reload();
               }, 6000);
             }else{
               $("#company-park-message").prepend("<div class='status alert alert-success text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
               setTimeout(function(){
                    location.reload();
               }, 6000);
             }      
          });          
        });        
      });
    </script>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="../src/index.php">
            <img src="assets/images/ajalatravel.jpg" alt="logo" style="border-radius:5px;" /> </a>
          <a class="navbar-brand brand-logo-mini" href="../src/index.php">
            <img src="assets/images/ajalatravel-mini.jpg" alt="logo" style="border-radius:5px;"/> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block bg-danger" style="padding:8px;color:white;border-radius:3px" id="time"></li>
             <marquee class="mb-1 mt-3 font-weight-semibold text-center text-primary" style="font-size:small;font-weight:300;font-style:italic">Ajalatravel your one sure way to your travel destination.....</marquee>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-bell-outline"></i>
                <span class="count">7</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
                <a class="dropdown-item py-3">
                  <p class="mb-0 font-weight-medium float-left">You have 7 unread mails </p>
                  <span class="badge badge-pill badge-primary float-right">View all</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="assets/images/faces/face10.jpg" alt="image" class="img-sm profile-pic"> </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis font-weight-medium text-dark">Marian Garner </p>
                    <p class="font-weight-light small-text"> The meeting is cancelled </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="assets/images/faces/face12.jpg" alt="image" class="img-sm profile-pic"> </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis font-weight-medium text-dark">David Grey </p>
                    <p class="font-weight-light small-text"> The meeting is cancelled </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="assets/images/faces/face1.jpg" alt="image" class="img-sm profile-pic"> </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis font-weight-medium text-dark">Travis Jenkins </p>
                    <p class="font-weight-light small-text"> The meeting is cancelled </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="mdi mdi-email-outline"></i>
                <span class="count bg-success">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
                <a class="dropdown-item py-3 border-bottom">
                  <p class="mb-0 font-weight-medium float-left">You have 4 new notifications </p>
                  <span class="badge badge-pill badge-primary float-right">View all</span>
                </a>
                <a class="dropdown-item preview-item py-3">
                  <div class="preview-thumbnail">
                    <i class="mdi mdi-alert m-auto text-primary"></i>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal text-dark mb-1">Application Error</h6>
                    <p class="font-weight-light small-text mb-0"> Just now </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item py-3">
                  <div class="preview-thumbnail">
                    <i class="mdi mdi-settings m-auto text-primary"></i>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal text-dark mb-1">Settings</h6>
                    <p class="font-weight-light small-text mb-0"> Private message </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item py-3">
                  <div class="preview-thumbnail">
                    <i class="mdi mdi-airballoon m-auto text-primary"></i>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal text-dark mb-1">New user registration</h6>
                    <p class="font-weight-light small-text mb-0"> 2 days ago </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item dropdown d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="<?php echo $image; ?>" style="width:45px;height:45px" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="<?php echo $image; ?>" alt="Profile image">
                  <?php echo $details ?>
                </div>
                <a class="dropdown-item text-primary" href="../src/view-profile.php?id=<?php if(isset($_SESSION['userId'])){ echo $profile->profileId($_SESSION['userId']); } ?>" title="View Profile"><i class="fa fa-user"></i> My Profile</a>
                <a class="dropdown-item text-primary" href="../src/edit-profile.php?id=<?php if(isset($_SESSION['userId'])){ echo $profile->profileId($_SESSION['userId']); } ?>" title="Edit Profile"><i class="fa fa-edit"></i> Edit Profile </a>
                <a class="dropdown-item text-primary" title="Messages"><i class="fa fa-envelope-square"></i> Messages<span class="badge badge-pill badge-danger">1</span></a>
                <a class="dropdown-item text-primary" href="../src/logout.php" title="logout"> <i class="fa fa-sign-out "></i> Logout</a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a  href="../src/index.php" class="nav-link">
                <div class="profile-image">
                  <img src="<?php echo $image; ?>" class="img-xs rounded-circle"  style="width:45px;height:45px" alt="profile image" />
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                    <?php echo $username ?>
                    <p class="designation">Super Admin</p>
                </div>
              </a>
            </li>
            <li class="nav-item nav-category">Main Menu</li>
            <li class="nav-item" title="dashboard">
              <a class="nav-link" href="../src/index.php">
                <i class="typcn typcn-home"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-company" aria-expanded="false" aria-controls="ui-company">
                <i class="typcn typcn-th-list"></i>
                <span class="menu-title">Company</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-company">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="../src/add-company.php"><i class="typcn typcn-plus"></i> Add Company</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../src/companies-table-view.php"><i class="typcn typcn-eye"></i> View Companies Table</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../src/routes-table-view.php"><i class="typcn typcn-eye"></i> View Routes Table</a>
                  </li>              
                </ul>
              </div>
            </li>            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-bus" aria-expanded="false" aria-controls="ui-basic">
                <i class="typcn typcn-th-list"></i>
                <span class="menu-title">Bus</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-bus">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="../src/add-bus.php"><i class="typcn typcn-plus"></i> Add Bus</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../src/bus-table-view.php"><i class="typcn typcn-eye"></i>View Bus Table</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-park" aria-expanded="false" aria-controls="ui-basic">
                <i class="typcn typcn-th-list"></i>
                <span class="menu-title">Park</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-park">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="../src/add-park.php"><i class="typcn typcn-plus"></i> Add Park</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../src/parks-table-view.php"><i class="typcn typcn-eye"></i>View Park Table</a>
                  </li>
                </ul>
              </div>
            </li>              
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="row" id="park-message"></div>
                  <div class="card-body" style="background-color:ghostwhite">
                    <h4 class=" text-center text-primary"> Create Company Park</h4>
                    <div class="row well well-sm">
                      <button type="button" class="btn btn-danger col-sm-10 col-sm-offset-1" id="createPark"><i class="typcn typcn-plus"></i> Create Company's Park</button>
                        <div class="col-sm-12" id="createSection" style="display:block"><br>
                          <p class="card-description text-danger">This section of the application is to create company's park name.</p>
                          <p class="card-description text-primary"><strong>Company's Park Information:</strong></p>
                          <form class="form-sample">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Park Name</label>
                                <div class="col-sm-9 parkName-group">
                                  <input type="text" name="parkName" id="parkName" class="form-control" />
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date created</label>
                                <div class="col-sm-9 parkDate-group">
                                  <input type="date" name="parkDate" id="parkDate" class="form-control" />
                                </div>
                              </div>
                            </div>      
                          </div>
                        </form>
                        <div class="col-md-12 col-sm-12">
                          <button type="button" name="park" id="park" class="btn btn-success col-sm-4 col-sm-offset-8" style="float:right" ><i class="fa fa-save"></i>Save</button>
                        </div> 
                      </div>
                    </div>
                     <div class="row" id="company-park-message" ></div>
                    <h4 class=" text-center text-primary"> Add Park To Company </h4>
                    <div class="row well well-sm">
                      <button type="button" class="btn btn-danger col-sm-10 col-sm-offset-1" id="addPark"><i class="typcn typcn-plus"></i> Add Company's Park</button>
                        <div class="col-sm-12" id="parkSection" style="display:block"><br>
                          <p class="card-description text-danger">This section of the application is to create company's park name.</p>
                          <p class="card-description text-primary"><strong>Company's Park Information:</strong></p>
                          <form class="form-sample">
                            <div class="row" >
                                <div class="col-sm-6">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Company</label>
                                    <div class="col-sm-9 companyNameA-group">          
                                      <?php echo $user->companyNames() ?>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">park</label>
                                    <div class="col-sm-9 parkNameA-group">
                                       <?php echo $user->parkNames() ?>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12 col-sm-12">
                          <button type="button" name="addParkA" id="addParkA" class="btn btn-success col-sm-4 col-sm-offset-8" style="float:right" ><i class="fa fa-save"></i>Save</button>
                        </div> 
                      </div>
                    </div>                      
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?php  echo date('Y'); ?> <a href="../src/index.php" target="_blank"> Ajalatravel</a>. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i>
              </span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script> window.onload=dateTime();</script>    
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="assets/js/shared/off-canvas.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>    
    <!--<script src="assets/js/shared/misc.js"></script>-->
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->
  </body>
</html>               