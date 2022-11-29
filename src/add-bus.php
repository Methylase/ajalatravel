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
    <title>Ajalatravel Add Bus</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/font-awesome/css/font-awesome.min.css">       
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="jqueryTimePicker/jquery.timepicker.min.css" rel="stylesheet">
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
          
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  
    <script type="text/javascript" src="assets/js/jquery.js"></script>

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
      $(function(){
        $('#busTime').timepicker({
          timeFormat:'h:mm p',
          interval:30,
          minHour:1,
          defaultTime:'now',
          dynamic:false,
          dropdown:true,
          scrollbar:true
          });
        });
        $(document).ready(function(){
            $("#addBus").click(function(){
                $('#busSection').toggle();
                });
            $("#addFeature").click(function(){
                $('#featureSection').toggle();
                });
            $("#addBC").click(function(){
                $('#addBCSection').toggle();
                });
            $("#addRB").click(function(){
                $('#addRBSection').toggle();
                });
            $("#addTF").click(function(){
                $('#addTFSection').toggle();
                });             
            // json to get state and local government to fill state and local goverment dropdown
            $.getJSON('states-localgovts/states-localgovts.json',function(states){
              $.each(states.states, function(key, value){
                $('#busState').append($("<option></option>").attr('value', states.states[key].state).text(value.state));
                $('#busState').on('change', function(){
                  var state =$(this).val();
                  if (states.states[key].state == state){
                  //$('#state').find("option:gt(0)").remove();
                    $('#busLocalG').children("option").not(':first').remove();
                    $.each(states.states[key].local, function(key, value){
                    $('#busLocalG').append($("<option></option>").attr('value', value).text(value));
                  });
                  }
                })
              });                
            });
            // onclick of the sumbit transport company form
            $("#addBuses").click(function(e){
                e.preventDefault();
                $("#bus-message").empty();
                 $('.busName-group').removeClass('has-error');
                 $('.busColor-group').removeClass('has-error');
                 $('.busState-group').removeClass('has-error');
                 $('.busLocalG-group').removeClass('has-error');
                 $('.busPartDay-group').removeClass('has-error');
                 $('.busSeatNo-group').removeClass('has-error');                 
                $('.busDepartureDate-group').removeClass('has-error');
                $('.busTime-group').removeClass('has-error');
                 $('.help-block').remove(); // remove the error text
                 var features = new Array();
                 $("input[name='bus[]']:checked").each(function(){
                    features.push($(this).val());
                  })
                 var form_data = {
                  busName: $('#busName').val(),
                  busColor: $('#busColor').val(),
                  busState: $('#busState').val(),
                  busLocalG: $('#busLocalG').val(),
                  busPartDay:$('#busPartDay').val(),
                  busSeatNo: $('#busSeatNo').val(),                  
                  busDepartureDate: $('#busDepartureDate').val(),
                  busTime:$('#busTime').val(),
                  busFeatures: features,
                  addBuses: 'save',
                  is_ajax: 1
                 };
                 $.ajax({
                     type: "POST",
                     url: 'ajax-add-bus.php',
                     data: form_data,
                     dataType: 'json',
                 }).done(function (data){
                    if(!data.success){
                      if(data.error.busName){
                        $('.busName-group').addClass('has-error');
                        $('.busName-group').append('<div class="help-block" style="font-size:small">' + data.error.busName + '</div>'); // add the actual error message under our input
                      }else{
                        if(data.error.busPartDay){
                          $('.busPartDay-group').addClass('has-error');
                          $('.busPartDay-group').append('<div class="help-block" style="font-size:small">' + data.error.busPartDay + '</div>'); // add the actual error message under our input
                        }else{
                          if(data.error.busDepartureDate){
                            $('.busDepartureDate-group').addClass('has-error');
                            $('.busDepartureDate-group').append('<div class="help-block" style="font-size:small">' + data.error.busDepartureDate + '</div>'); // add the actual error message under our input
                          }else{
                            if(data.error.busColor){
                              $('.busColor-group').addClass('has-error');
                              $('.busColor-group').append('<div class="help-block" style="font-size:small">' + data.error.busColor + '</div>'); // add the actual error message under our input
                            }else{
                              if(data.error.busState){
                                $('.busState-group').addClass('has-error');
                                $('.busState-group').append('<div class="help-block" style="font-size:small">' + data.error.busState + '</div>'); // add the actual error message under our input
                              }else{
                                if(data.error.busTime){
                                  $('.busTime-group').addClass('has-error');
                                  $('.busTime-group').append('<div class="help-block" style="font-size:small">' + data.error.busTime + '</div>'); // add the actual error message under our input
                                }else{
                                  if(data.error.busLocalG){
                                    $('.busLocalG-group').addClass('has-error');
                                    $('.busLocalG-group').append('<div class="help-block" style="font-size:small">' + data.error.busLocalG + '</div>'); // add the actual error message under our input
                                  }else{
                                    if(data.error.busSeatNo){
                                      $('.busSeatNo-group').addClass('has-error');
                                      $('.busSeatNo-group').append('<div class="help-block" style="font-size:small">' + data.error.busSeatNo + '</div>'); // add the actual error message under our input
                                    }                                    
                                  }
                                }
                              }
                            }                               
                          }
                        }
                        
                      }   
                    }else if(data.success =='no'){
                      window.location.href="error-404.php";
                    }else if(data.success =='wrong'){
                      $("#bus-message").prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
                      setTimeout(function(){
                           location.reload();
                      }, 6000);                      
                    }else if(data.success =='exist'){
                      $("#bus-message").prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
                      setTimeout(function(){
                           location.reload();
                      }, 6000);                      
                    }else{
                      $("#bus-message").prepend("<div class='status alert alert-success text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
                      setTimeout(function(){
                           location.reload();
                      }, 6000);
                    }      
                 });
            });
         // onclick of the sumbit attach bus to company form
        $("#addCompanyA").click(function(e){
          e.preventDefault();
          $('#company-bus-message').empty('');      
          $('.companyNameA-group').removeClass('has-error');
          $('.busNameA-group').removeClass('has-error');
          $('.parkNameA-group').removeClass('has-error');
          $('.busTravelFeeA-group').removeClass('has-error');
          $('.help-block').remove(); // remove the error text
          var form_data = {
           companyNameA: $('#companyNameA').val(),
           busNameA: $('#busNameCA').val(),
           companyName: $('#companyNameA option:selected').text(),
           busName: $('#busNameCA option:selected').text(),
           parkNameA: $('#parkNameA').val(),
           parkName: $('#parkNameA option:selected').text(),
           busTravelFeeA: $('#busTravelFeeA').val(),
           busTravelFee: $('#busTravelFeeA option:selected').text(),
           addCompanyA: 'save',
           is_ajax: 1
          };
          $.ajax({
              type: "POST",
              url: 'ajax-add-company-bus.php',
              data: form_data,
              dataType: 'json',
          }).done(function (data){
             if(!data.success){
               if(data.error.companyNameA){
                 $('.companyNameA-group').addClass('has-error');
                 $('.companyNameA-group').append('<div class="help-block" style="font-size:small">' + data.error.companyNameA + '</div>'); // add the actual error message under our input
               }else{
                 if(data.error.busNameA){
                   $('.busNameA-group').addClass('has-error');
                   $('.busNameA-group').append('<div class="help-block" style="font-size:small">' + data.error.busNameA + '</div>'); // add the actual error message under our input
                 }else{
                    if(data.error.parkNameA){
                      $('.parkNameA-group').addClass('has-error');
                      $('.parkNameA-group').append('<div class="help-block" style="font-size:small">' + data.error.parkNameA + '</div>'); // add the actual error message under our input
                    }else{
                        if(data.error.busTravelFeeA){
                          $('.busTravelFeeA-group').addClass('has-error');
                          $('.busTravelFeeA-group').append('<div class="help-block" style="font-size:small">' + data.error.busTravelFeeA + '</div>'); // add the actual error message under our input
                        }                      
                      } 
                  }
               }   
             }else if(data.success =='no'){
               window.location.href="error-404.php";
             }else if(data.success =='exist'){   
               $("#company-bus-message").prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
               setTimeout(function(){
                    location.reload();
               }, 6000);
             }else if(data.success =='noId'){   
               $('.parkNameA-group').prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
             }else{
               $("#company-bus-message").prepend("<div class='status alert alert-success text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
               setTimeout(function(){
                    location.reload();
               }, 6000);
             }      
          });          
        });
         // onclick of the sumbit bus fee form
        $("#addTravelFee").click(function(e){
          e.preventDefault();
          $('.busTravelFee-group').val('');
          $('.dateCreated-group').val('');          
          $('.busTravelFee-group').removeClass('has-error');
          $('.dateCreated-group').removeClass('has-error');         
          $('.help-block').remove(); // remove the error text          
          var form_data = {
           busTravelFee: $('#busTravelFee').val(),
           dateCreated: $('#dateCreated').val(),
           addTravelFee: 'save',
           is_ajax: 1
          };
          $.ajax({
              type: "POST",
              url: 'ajax-add-bus-fee.php',
              data: form_data,
              dataType: 'json',
          }).done(function (data){
             if(!data.success){
               if(data.error.busTravelFee) {
                 $('.busTravelFee-group').addClass('has-error');
                 $('.busTravelFee-group').append('<div class="help-block" style="font-size:small">' + data.error.busTravelFee + '</div>'); // add the actual error message under our input
               }else{
                 if(data.error.dateCreated){
                   $('.dateCreated-group').addClass('has-error');
                   $('.dateCreated-group').append('<div class="help-block" style="font-size:small">' + data.error.dateCreated + '</div>'); // add the actual error message under our input
                 } 
               }   
             }else if(data.success=='exist'){
               $("#bus-travel-fee-message").prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
               setTimeout(function(){
                    location.reload();
               }, 6000);              
              }else{
               $("#bus-travel-fee-message").prepend("<div class='status alert alert-success text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
               setTimeout(function(){
                    location.reload();
               }, 6000);
             }      
          });          
        });                 
            // onclick of the sumbit attach route to bus form
           $("#addRouteA").click(function(e){
             e.preventDefault();
             $('#route-bus-message').empty('');
             $('.routeNameA').val('');
             $('.busNameA').val('');          
             $('.routeNameA-group').removeClass('has-error');
             $('.busNameA-group').removeClass('has-error');         
             $('.help-block').remove(); // remove the error text          
             var form_data = {
              routeNameA: $('#routeNameA').val(),
              busNameA: $('#busNameA').val(),
              routeName: $('#routeNameA option:selected').text(),
              busName: $('#busNameA option:selected').text(),           
              addRouteA: 'save',
              is_ajax: 1
             };
             $.ajax({
                 type: "POST",
                 url: 'ajax-add-route-bus.php',
                 data: form_data,
                 dataType: 'json',
             }).done(function (data){
                if(!data.success){
                  if(data.error.routeNameA){
                    $('.routeNameA-group').addClass('has-error');
                    $('.routeNameA-group').append('<div class="help-block" style="font-size:small">' + data.error.routeNameA + '</div>'); // add the actual error message under our input
                  }else{
                    if(data.error.busNameA){
                      $('.busNameA-group').addClass('has-error');
                      $('.busNameA-group').append('<div class="help-block" style="font-size:small">' + data.error.busNameA + '</div>'); // add the actual error message under our input
                    } 
                  }   
                }else if(data.success =='no'){
                  window.location.href="error-404.php";
                }else if(data.success =='exist'){   
                  $("#route-bus-message").prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
                  setTimeout(function(){
                       location.reload();
                  }, 6000);
                }else{
                  $("#route-bus-message").prepend("<div class='status alert alert-success text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +data.message+"</strong></div>"); 
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
                  <div class="row" id="bus-message"></div>
                  <div class="card-body" style="background-color:ghostwhite">
                    <div class="row well well-sm">
                        <button type="button" class="btn btn-danger col-sm-10 col-sm-offset-1" id="addBus"><i class="typcn typcn-plus"></i> Add Bus</button>
                        <div class="col-sm-12" id="busSection" ><br>
                            <p class="card-description text-danger">This section of the application is to add buses.</p>
                            <p class="card-description text-primary"><strong>Bus Information:</strong></p>
                            <form class="form-sample">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Bus Name</label>
                                      <div class="col-sm-9 busName-group">
                                        <input type="text" name="busName" id="busName" placeholder="Bus Name" class="form-control" />
                                      </div>
                                    </div>
                                  </div>
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Part Of The Day</label>
                                      <div class="col-sm-9 busPartDay-group">
                                        <select  name="busPartDay" id="busPartDay" class="form-control" >
                                          <option value="none">Select part of the day</option>
                                          <option value="morning">Morning</option>
                                          <option value="afternoon">Afternoon</option>
                                          <option value="evening/night">Evening/Night</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Bus Departure Date</label>
                                      <div class="col-sm-9 busDepartureDate-group">
                                        <input type="date" name="busDepartureDate" id="busDepartureDate" class="form-control"/>
                                      </div>
                                    </div>
                                  </div>                                        
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Bus Color</label>
                                      <div class="col-sm-9 busColor-group">
                                          <input type="text" name="busColor" id="busColor" placeholder="Bus Color" class="form-control" />
                                      </div>
                                    </div>
                                  </div>      
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">State</label>
                                      <div class="col-sm-9 busState-group">          
                                          <select name="busState" id="busState" class="form-control">
                                              <option value="none">Select State</option>   
                                          </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Time</label>
                                        <div class="col-sm-9 busTime-group">
                                         <input type="text" name="busTime" id="busTime" class="form-control" placeholder="Time">
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Local Govt</label>
                                      <div class="col-sm-9 busLocalG-group">          
                                          <select name="busLocalG" id="busLocalG" class="form-control">
                                              <option value="none">Select Local Govt</option>   
                                          </select>
                                      </div>
                                    </div>
                                  </div>                                  
                                   <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Seat Number</label>
                                        <div class="col-sm-9 busSeatNo-group">
                                         <input type="number" name="busSeatNo" id="busSeatNo" class="form-control" placeholder="Seat Number">
                                        </div>
                                    </div>                                    
                                    </div>                                                                       
                                </div>
                                <div class="col-md-12 col-sm-12">
                                     <button type="button" name="addBuses" id="addBuses" class="btn btn-success col-sm-4 col-sm-offset-8" style="float:right;margin-bottom:10px" ><i class="fa fa-save"></i>Save</button>
                                                          
                                </div>  
                                <button type="button" class="btn btn-danger col-sm-10 col-sm-offset-1" id="addFeature"><i class="typcn typcn-plus"></i> Additional Features</button><br><br>
                                <div class="col-md-12 row" id="featureSection" style="padding-top:20px">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class=" form-check-flat">
                                              <label class="form-check-label">
                                                <input type="checkbox" name="bus[]" id="busF1" value="Full-AC" > Full AC </label>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="form-check-flat">
                                              <label class="form-check-label">
                                                <input type="checkbox" name="bus[]" id="busF2" value="Non-AC"> Non AC </label>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class=" form-check-flat">
                                              <label class="form-check-label">
                                                <input type="checkbox" name="bus[]" id="busF3" value="Seater"> Seater </label>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class=" form-check-flat">
                                              <label class="form-check-label">
                                                <input type="checkbox" name="bus[]" id="busF4" value="Sleeper"> Sleeper </label>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class=" form-check-flat">
                                              <label class="form-check-label">
                                                <input type="checkbox" name="bus[]" id="busF5" value="Led-TV"> Led TV </label>
                                            </div>
                                        </div> 
                                    </div>  
                                </div> 
                            </form><br><br>
                            <button type="button" class="btn btn-danger col-sm-10 col-sm-offset-1" id="addTF" style="margin-bottom:20px"><i class="typcn typcn-plus"></i> Attach Travel Fee To A Bus</button>
                            <div class="col-sm-12" id="addTFSection" style="padding-top:20px">
                                 <p class="card-description text-danger">This section of the application is to create travel fee for buses.</p>
                            <p class="card-description text-primary"><strong> Create Travel Fee To Bus:</strong></p>
                             <div class="row" id="bus-travel-fee-message"></div>
                                <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"> Bus Travel Fee</label>
                                      <div class="col-sm-9 busTravelFee-group">
                                        <input type="text" name="busTravelFee" id="busTravelFee" placeholder="Bus Travel Fee" class="form-control" />
                                      </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Date Created</label>
                                        <div class="col-sm-9 dateCreated-group">
                                          <input type="date" name="dateCreated" id="dateCreated" class="form-control" />
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" name="addTravelFee" id="addTravelFee" class="btn btn-success col-sm-4 col-sm-offset-8" style="float:right;margin-bottom:10px" ><i class="fa fa-save"></i>Save</button>
                                </div>                                                                   
                            </div>
                            <button type="button" class="btn btn-danger col-sm-10 col-sm-offset-1" id="addRB" style="margin-bottom:20px"><i class="typcn typcn-plus"></i> Attach Route To Bus</button>
                            <div class="col-sm-12" id="addRBSection" style="padding-top:20px">
                                 <p class="card-description text-danger">This section of the application is to attach route to a bus.</p>
                            <p class="card-description text-primary"><strong> Attach Route To Bus:</strong></p>
                             <div class="row" id="route-bus-message"></div>
                                <div class="row">
                                 
                                    <div class="col-sm-6">
                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Route Name</label>
                                        <div class="col-sm-9 routeNameA-group">          
                                          <?php echo $user->routeNames() ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Buses</label>
                                        <div class="col-sm-9 busNameA-group">
                                          <select name="busNameA" id="busNameA" class="form-control">
                                           <?php echo $user->busNames() ?>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" name="addRouteA" id="addRouteA" class="btn btn-success col-sm-4 col-sm-offset-8" style="float:right;margin-bottom:10px" ><i class="fa fa-save"></i>Save</button>
                                </div>                                                                   
                            </div>                             
                            <button type="button" class="btn btn-danger col-sm-10 col-sm-offset-1" id="addBC"><i class="typcn typcn-plus"></i> Attach Bus To Company</button>
                            <div class="col-sm-12" id="addBCSection" style="padding-top:20px">
                                 <p class="card-description text-danger">This section of the application is to attach buses to a transport company.</p>
                            <p class="card-description text-primary"><strong> Attach Bus To Company:</strong></p>
                             <div class="row" id="company-bus-message"></div>
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
                                        <label class="col-sm-3 col-form-label">Buses</label>
                                        <div class="col-sm-9 busNameA-group">
                                          <select name="busNameA" id="busNameCA" class="form-control">
                                           <?php echo $user->busNames() ?>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Park</label>
                                      <div class="col-sm-9 parkNameA-group">
                                         <?php echo $user->parkNames() ?>
                                      </div>
                                    </div>
                                  </div>                                  
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <label class="col-sm-3 col-form-label">Bus Travel Fee</label>
                                      <div class="col-sm-9 busTravelFeeA-group">
                                         <?php echo $user->allBusFee() ?>
                                      </div>
                                    </div>
                                  </div>                                                                                                            
                                </div>
                                <div class="col-md-12 col-sm-12">
                                     <button type="button" name="addCompanyA" id="addCompanyA" class="btn btn-success col-sm-4 col-sm-offset-8" style="float:right;margin-bottom:10px" ><i class="fa fa-save"></i>Save</button>
                                </div><br><br>                                        
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
    <script type="text/javascript" src="jqueryTimePicker/jquery.timepicker.min.js"></script>
    <!--<script src="assets/js/shared/misc.js"></script>-->
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->
  </body>
</html>               