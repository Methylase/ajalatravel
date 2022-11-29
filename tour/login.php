<?php
define('Ajaccess', TRUE);
 //connection
 require_once('../lib/config/config.php');
 // if user is already logged in redirect to the dashboard
 $user->launchSession(); 
 if($user->is_logged_in()){
      header('Location:../../ajalatravel/src/index.php');
 }
  $username='';
  $password='';
  if(isset($_POST['submit'])){
  $checker= 1;
  if($checker !="1"){
     header('Location:error-404.php');
  }
    $username = $user->protectData($_POST['username']);
    $password = $user->protectData($_POST['password']);
  
    if($username == ''){
      $error['username'] ='please username is required';
    }else{
     if($password==''){
      $error['password'] ='please password is required';
     }else{
     if(isset($_POST['rememberMe']) && trim($_POST['rememberMe']) =='1'){
      $remember_me = $user->protectData($_POST['rememberMe']);
      
     }else{
      $remember_me ="";
     }
     }
    }
    if(!isset($error)){
     if($user->login($username, $password, $remember_me, $checker) =="Super Admin"){
       $_SESSION['userId']= $username;
      header('Location:../../ajalatravel/src/index.php');
     }elseif($user->login($username, $password, $remember_me, $checker)=="User"){
       $_SESSION['userId']= $username;
      header('Location:tutor/');
     }else{
      $message1="<strong>$username</strong>  sorry you dont have the right login detail to<strong> Ajalatravel</strong>";
     }
    }
  
  }
         ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ajalatravel Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../../../../../../ajalatravel/src/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../../../../../../ajalatravel/src/assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="../../../../../../../ajalatravel/src/assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="../../../../../../../ajalatravel/src/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../../../../../../ajalatravel/src/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../../../../../../ajalatravel/src/assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">     
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../../../../../../ajalatravel/src/assets/css/shared/style.css">
    <!-- endinject -->
   <link href="img/ajalatravel-mini.jpg" rel="icon">
  <link href="img/ajalatravel-mini.jpg" rel="apple-touch-icon">
    <style>
 @media (max-width: 320px){
.tutor-logo{
    width:100%;
}

 form{
    width:80%;
    margin: auto;
    padding-bottom: 40px;
 }
 .auto-form-wrapper-new{
  width:90%;
  margin-top:10px;
  margin-left:5%;
  margin-right:5%;
}
     }
               
  @media (min-width: 321px) and (max-width: 480px){
.tutor-logo{
    width:100%;
}

form{
    width:100%;
    margin: auto;
    padding-bottom: 40px;
 }
 .auto-form-wrapper-new{
  width:90%;
  margin-top:10px;
  margin-left:5%;
  margin-right:5%;
}
      }
@media (min-width: 481px) and (max-width: 767px) {
.tutor-logo{
    width:40%;
    margin-left:30%;
    margin-right:30%;
}

form{
  width:100%;
  padding-bottom: 40px;
  
}
.auto-form-wrapper-new{
  width:70%;
  margin-top:10px;
  margin-left:15%;
  margin-right:15%;
}
      } 
@media (min-width: 768px) and (max-width: 1024px) {
.tutor-logo{
    width:30%;
    margin-left:40%;
    margin-right:40%;
}
form{
  width:100%;
  padding-bottom: 40px;
  
}
.auto-form-wrapper-new{
  width:50%;
  margin-top:10px;
  margin-left:25%;
  margin-right:25%;
}
     } 
@media (min-width: 1024px) {    
      .tutor-logo{
          width:40%;
          margin-left:30%;
          margin-right:30%;
      }
      
      form{
        width:100%;
        padding-bottom: 40px;
        
      }
      .auto-form-wrapper-new{
        margin-top:10px;
      }
     }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
              
            <div class="col-lg-4 mx-auto auto-form-wrapper-new">
               <?php
                    if(isset($message1)){
                         echo "<div class=' alert alert-danger alert-dismissable ' style='text-align:center;font-size:small'>
                                   <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>"
                                   .$message1.
                              "</div>";
                    }
               ?>
              <div class="auto-form-wrapper" >
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autoComplete="off">
                   <img class="tutor-logo img-circle" src="img/ajalatravel-mini.jpg" alt="" width="50" height="100" style="border-radius:8px;">
                  <div class="form-group">
                    <label class="label">Username</label>
                    <div class="input-group">
                      <input type="text" name="username" class="form-control" placeholder="Username" autoComplete="off">                    
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>                    
                    </div>
                    <?php if(isset($error['username'])){ echo "<span class='text-danger' style='font-size:small'>". $error['username']."</span>"; } ?>
                  </div>
                  <div class="form-group">
                    <label class="label">Password</label>
                    <div class="input-group">
                      <input type="password" name="password" class="form-control" placeholder="*********">  
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>                      
                    </div>
                     <?php if(isset($error['password'])){ echo "<span class='text-danger' style='font-size:small'>". $error['password']."</span>"; } ?>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary submit-btn btn-block">Login</button>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                    <div class="form-check form-check-flat mt-0">
                      <label class="form-check-label">
                        <input type="checkbox" name="rememberMe" value="1" class="form-check-input" checked> Keep me signed in </label>
                    </div>
                    <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
                  </div>
                    <!--<div class="form-group">
                    <button class="btn btn-block g-login">
                      <img class="mr-3" src="../../../../../../../ajalatravel/src/assets/images/file-icons/icon-google.svg" alt="">Log in with Google</button>
                  </div>
                  <div class="text-block text-center my-3">
                    <span class="text-small font-weight-semibold">Not a user ?</span>
                    <a href="signup.php" class="text-black text-small">Get started</a>
                  </div>-->
                </form>
              </div>
              <ul class="auth-footer">
                <li>
                  <a href="#">Conditions</a>
                </li>
                <li>
                  <a href="#">Help</a>
                </li>
                <li>
                  <a href="#">Terms</a>
                </li>
              </ul>
              <p class="footer-text text-center">copyright © <?php  echo date('Y'); ?> Ajalatravel. All rights reserved.</p>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../../../../../../ajalatravel/src/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../../assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../../../../../../../ajalatravel/src/assets/js/shared/off-canvas.js"></script>
    <!--<script src="../../../../../../../ajalatravel/src/assets/js/shared/misc.js"></script>-->
    <!-- endinject -->
  </body>
</html>