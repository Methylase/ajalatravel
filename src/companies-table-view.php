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
    <title>Ajalatravel Companies Table View</title>
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
      $(document).ready(function(){
        $("#addBus").click(function(){
            $('#busSection').toggle();
        });
               
        $('.deleteCompany').on('click', function(){
         delCompany = $(this).attr('id');
         delCompany = delCompany.split(' ');
         $('.del_company').attr('id', 'del_company'+delCompany[1])
         $('#del_company'+delCompany[1]).on('click', function(){
          value= {
           companyId: delCompany[1]
          }
          $.ajax({
             type: "POST",
             url: "ajax-add-company.php",
             data: value,
             dataType: 'json',
             encode:true
          }).done(function(result){
            if (result.success=='true'){
              $('#confirm-delete').modal('hide');
              $("#company-message").prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
             setTimeout(function(){
              location.reload();
             }, 6000);
            }else if (result.success=='noId'){
              window.location.href="error-404.php";
            }else if (result.success=='no'){
              window.location.href="error-404.php";
            }else if(result.success=='notAllowed'){
              $('#confirm-delete').modal('hide');
              $("#company-message").prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
             setTimeout(function(){
              location.reload();
             }, 6000);
            }         
          });
         });
        })      
              
        });
      
      function Edit(id){
          // json to get state and local government to fill state and local goverment dropdown
          $.getJSON('states-localgovts/states-localgovts.json',function(states){
            $.each(states.states, function(key, value){
              $('#companyState').append($("<option></option>").attr('value', states.states[key].state).text(value.state));
              $('#companyState').on('change', function(){
                var state =$(this).val();
                if (states.states[key].state == state){
                  //$('#state').find("option:gt(0)").remove();
                  $('#companyLocalG').children("option").not(':first').remove();
                  $.each(states.states[key].local, function(key, value){
                    $('#companyLocalG').append($("<option></option>").attr('value', value).text(value));
                  });
                }
              })
            });                
          });
       var ids=id;
       var  id_data1='data1.'+id;
       var  id_data2='data2.'+id;
       var  id_data3='data3.'+id;
       var  id_data4='data4.'+id;
       var  id_data5='data5.'+id;
       var  id_data6='data6.'+id;
       var save='save'+id;
       var edit='edit'+id;
       var delete1='delete'+id;
       var name='name' +id;
       var email='email' +id;
       var phone='phone' +id;
       var address='address' +id;
       var state='state' +id;
       var localG='localG' +id;
       var messName='messageName'+id;
       var messEmail='messageEmail'+id;
       var messPhone='messagePhone'+id;
       var messAdd='messageAdd'+id;
       var messState='messageState'+id;
       var messLocalG='messageLocalG'+id;
       var mess='message'+id;
       document.getElementById(messName).innerHTML='';
       document.getElementById(messEmail).innerHTML='';
       document.getElementById(messPhone).innerHTML='';
       document.getElementById(messAdd).innerHTML='';
       document.getElementById(messState).innerHTML='';
       document.getElementById(messLocalG).innerHTML='';
       document.getElementById(mess).innerHTML='';
       var values1=document.getElementById(name).innerHTML
       document.getElementById(name).innerHTML='<input type="text" class="form-control" style="float:left;width:120px;border-radius:2px" class="" id='+ id_data1 +  ' value='+values1+ '>';
       var values2=document.getElementById(email).innerHTML
       document.getElementById(email).innerHTML='<input type="text" class="form-control" style="float:left;width:120px;border-radius:2px" class="" id='+ id_data2 +  ' value='+values2+ '>';
       var values3=document.getElementById(phone).innerHTML
       document.getElementById(phone).innerHTML='<input type="text" class="form-control" style="float:left;width:120px;border-radius:2px"  id='+ id_data3 +  ' value='+values3+ '>';
       var values4=document.getElementById(address).innerHTML
       document.getElementById(address).innerHTML='<textarea  class="form-control" style="float:left;width:120px;border-radius:2px" id='+ id_data4 + '>'+values4+ '</textarea>';
       var values5=document.getElementById(state).innerHTML
       document.getElementById(state).innerHTML='<select name="companyState" class="form-control" id="companyState" style="width:120px;border-radius:2px" ><option value='+values5+' selected>'+values5+'</option></select>';
       var values6=document.getElementById(localG).innerHTML
       document.getElementById(localG).innerHTML='<select name="companyLocalG" class="form-control" id="companyLocalG" style="width:120px;border-radius:2px" ><option value='+values6+' selected>'+values6+'</option></select>';
       document.getElementById(edit).style.display='none';
       document.getElementById(delete1).style.display='none';
       document.getElementById(save).style.display='block';
       document.getElementById(save).style.width='100px'; 
      }
      function Save(id) {
       var ids=id;
       var  id_data1='data1.'+id;
       var  id_data2='data2.'+id;
       var  id_data3='data3.'+id;
       var  id_data4='data4.'+id;
       var  id_data5='data5.'+id;
       var  id_data6='data6.'+id;
       var save='save'+id;
       var edit='edit'+id;
       var delete1='delete'+id;
       var name='name' +id;
       var email='email' +id;
       var phone='phone' +id;
       var address='address' +id;
       var state='state' +id;
       var localG='localG' +id;
       var messName='messageName'+id;
       var messEmail='messageEmail'+id;
       var messPhone='messagePhone'+id;
       var messAdd='messageAdd'+id;
       var messState='messageState'+id;
       var messLocalG='messageLocalG'+id;
       var mess='message'+id;
       var filter=/^([a-zA-Z0-9_\.\-]+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4}))+$/;
       var name1=document.getElementById(id_data1).value;
       var email1=document.getElementById(id_data2).value;
       var phone1=document.getElementById(id_data3).value;
       var address1=document.getElementById(id_data4).value;
       var state1=document.getElementById('companyState').value;
       var localG1=document.getElementById('companyLocalG').value;
          
        if (name1==null || name1=='') {
          document.getElementById(messAdd).innerHTML="";
          document.getElementById(messPhone).innerHTML="";
          document.getElementById(messEmail).innerHTML="";
          document.getElementById(messName).innerHTML="<span style='color:red;font-size:x-small'>Company name can't be blank</span>";
          
       }else if(!name1.match(/^[a-zA-Z]+$/)){
          document.getElementById(messAdd).innerHTML="";
          document.getElementById(messPhone).innerHTML="";
          document.getElementById(messEmail).innerHTML="";
         document.getElementById(messName).innerHTML="<span style='color:red';font-size:x-small'> Company name is not letters</span>";
       }else if(email1==null || email1==''){
          document.getElementById(messAdd).innerHTML="";
          document.getElementById(messPhone).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messEmail).innerHTML="<span style='color:red;font-size:x-small'>Email can not be blank</span>";
       }else if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})$/.test(email1)==false){
          document.getElementById(messAdd).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messPhone).innerHTML="";
          document.getElementById(messEmail).innerHTML="<span style='color:red;font-size:x-small'>Email is not in the right format</span>";
       }else if(phone1==null || phone1==''){
          document.getElementById(messAdd).innerHTML="";
          document.getElementById(messEmail).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messPhone).innerHTML="<span style='color:red;font-size:x-small'>Phone can not be blank</span>";
       }else if(!Number(phone1)){
          document.getElementById(messAdd).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messEmail).innerHTML="";
          document.getElementById(messPhone).innerHTML="<span style='color:red;font-size:x-small'> Amount must be number</span>";
       }else if(address1==null || address1==''){
          document.getElementById(messPhone).innerHTML="";
          document.getElementById(messEmail).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messAdd).innerHTML="<span style='color:red;font-size:x-small'>Address can't be blank</span>";
       }else{
        var parameter="name=" + name1 + "&email=" + email1 + "&phone=" + phone1 + "&address=" + address1 + "&state=" + state1 + "&localG=" + localG1 + "&addCompanyA=" + 'save' + "&id=" + ids;
        var  xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
          var response=JSON.parse(xmlhttp.responseText);
           if(JSON.parse(response.success=="true")){
             document.getElementById(messName).innerHTML="";
             document.getElementById(messEmail).innerHTML="";
             document.getElementById(messPhone).innerHTML="";
             document.getElementById(messAdd).innerHTML="";
             document.getElementById(mess).innerHTML='<span class="text-success" style="font-size:12px;float:left;clear:left"> record saved</span>';
             document.getElementById(name).innerHTML=name1;
             document.getElementById(email).innerHTML=email1
             document.getElementById(phone).innerHTML=phone1;
             document.getElementById(address).innerHTML=address1
             document.getElementById(state).innerHTML=state1;
             document.getElementById(localG).innerHTML=localG1
             document.getElementById(save).style.display='none';
             document.getElementById(delete1).style.display='block';
             document.getElementById(edit).style.display='block';
              setTimeout(function(){
                         location.reload();
                    }, 3000);      
             
            }else if(response.success=="noId"){
              window.location.href="error-404.php";
            }else if(response.success =="false"){
              if(JSON.parse(response.error.companyName !=undefined)){
                document.getElementById(messState).innerHTML='';
                document.getElementById(messAdd).innerHTML='';
                document.getElementById(messEmail).innerHTML='';
                document.getElementById(messPhone).innerHTML='';
                document.getElementById(messName).innerHTML='<span class="text-danger">'+response.error.companyName+'</span>';
              }else if(JSON.parse(response.error.companyEmail !=undefined)){
                document.getElementById(messState).innerHTML='';
                document.getElementById(messAdd).innerHTML='';
                document.getElementById(messPhone).innerHTML='';
                document.getElementById(messName).innerHTML='';
                document.getElementById(messEmail).innerHTML='<span class="text-danger">'+response.error.companyEmail+'</span>'; 
              }else if(JSON.parse(response.error.companyPhone !=undefined)){
                document.getElementById(messState).innerHTML='';
                document.getElementById(messAdd).innerHTML='';
                document.getElementById(messEmail).innerHTML='';
                document.getElementById(messName).innerHTML='';
                document.getElementById(messPhone).innerHTML='<span class="text-danger">'+response.error.companyPhone+'</span>'; 
              }else if(JSON.parse(response.error.companyAddress1 !=undefined)){
                document.getElementById(messState).innerHTML='';
                document.getElementById(messPhone).innerHTML='';
                document.getElementById(messEmail).innerHTML='';
                document.getElementById(messName).innerHTML='';
                document.getElementById(messAdd).innerHTML='<span class="text-danger">'+response.error.companyAddress1+'</span>'; 
              }else if(JSON.parse(response.error.companyState !=undefined)){
                document.getElementById(messLocalG).innerHTML='';
                document.getElementById(messAdd).innerHTML='';
                document.getElementById(messPhone).innerHTML='';
                document.getElementById(messEmail).innerHTML='';
                document.getElementById(messName).innerHTML='';
                document.getElementById(messState).innerHTML='<span class="text-danger">'+response.error.companyState+'</span>'; 
              }else if(JSON.parse(response.error.companyLocalG !=undefined)){
                document.getElementById(messState).innerHTML='';
                document.getElementById(messAdd).innerHTML='';
                document.getElementById(messPhone).innerHTML='';
                document.getElementById(messEmail).innerHTML='';
                document.getElementById(messName).innerHTML='';
                document.getElementById(messLocalG).innerHTML='<span class="text-danger">'+response.error.companyLocalG+'</span>'; 
              }
            }else if(response.success=="no"){
              window.location.href="error-404.php";
            } 
          }  
        }
        xmlhttp.open("POST","ajax-add-company.php",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(parameter);
     }
       
     }
    </script>
    <style>
     /* tr th{
        font-size:11px !important;
        width: 50px !important;
        padding-top:12px !important;
        padding-bottom: 12px !important;
      }
       tr td{
        font-size:11px !important;
        width: 50px !important;
        padding-top:12px !important;
        padding-bottom: 12px !important;
       
      }
      table{
        width:100% !important;
        padding-top:12px !important;
        padding-bottom: 12px !important;
        
      }*/
     tr th, td{
      font-weight:300 !important;
     }

    </style>
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
            <div class="row" id="company-message">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body" style="overflow-x:scroll;background-color:ghostwhite;box-sizing:border-box;height:560px">
                    <h4 class="text-primary">Edit Table For All Companies</h4>
                    <p class="text-danger"> This this table is to make adjustment to any of<code class="text-primary">company</code> information</p>
                    <table class="table table-striped" style="text-align:center;">
                      <?php
                          $user->getAllCompanies();
                      ?>         
                  </div>
                  <div class="modal col-sm-8 col-sm-offset-4" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">                  
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title text-primary" id="Heading">Delete this compnay</h4>
                        </div>
                        <div class="modal-body">
                          <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to delete this company?</div>
                        </div>
                        <div class="modal-footer">
                          <button  class="btn btn-success del_company"><span class="fa fa-check-circle"></span> Yes</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
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

    <!--<script src="assets/js/shared/misc.js"></script>-->
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->
  </body>
</html>               