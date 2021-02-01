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
    <title>Ajalatravel Buses Table View</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/font-awesome/css/font-awesome.min.css">        
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
        $('.deleteBus').on('click', function(){
        var delBus = $(this).attr('id');
          delBus = delBus.split(' ');
         $('.del_bus').attr('id', 'del_bus'+delBus[1])
         $('#del_bus'+delBus[1]).on('click', function(){
          value= {
           busId: delBus[1]
          }
          $.ajax({
             type: "POST",
             url: "ajax-add-bus.php",
             data: value,
             dataType: 'json',
             encode:true
          }).done(function(result){
            if (result.success=='true'){
              $('#confirm-delete').modal('hide');
              $("#bus-message").prepend("<div class='status alert alert-danger text-center col-sm-9 col-sm-offset-1' style='font-size:small;margin-top:10px'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a><strong >" +result.message+"</strong></div>"); 
             setTimeout(function(){
              location.reload();
             }, 6000);
            }else if (result.success=='noId'){
              window.location.href="error-404.php";
            }else if (result.success=='no'){
              window.location.href="error-404.php";
            }   
          });
         });
        })      
    
        });
      
      function Edit(id){
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
       var ids=id;
       var  id_data1='data1.'+id;
       var  id_data2='data2.'+id;
       var  id_data3='data3.'+id;
       var  id_data4='data4.'+id;
       var  id_data5='data5.'+id;
       var  id_data6='data6.'+id;
       var  id_data7='data7.'+id;
       var  id_data8='data8.'+id;
       var  id_data9='data9.'+id;
       var save='save'+id;
       var edit='edit'+id;
       var delete1='delete'+id;
       var name='name' +id;
       var route='route' +id;
       var color='color' +id;
       var features='features' +id;
       var state='state' +id;
       var localG='localG' +id;
       var day='day'+id;
       var time='time'+id;
       var date='date'+id;
       var messName='messageName'+id;
       var messColor='messageColor'+id;
       var messFeatures='messageFeatures'+id;
       var messState='messageState'+id;
       var messLocalG='messageLocalG'+id;
       var messDay='messageDay'+id;
       var messTime='messageTime'+id;
       var messDate='messageDate'+id;
       var mess='message'+id;
       document.getElementById(messName).innerHTML='';
       document.getElementById(messColor).innerHTML='';
       document.getElementById(messFeatures).innerHTML='';
       document.getElementById(messState).innerHTML='';
       document.getElementById(messLocalG).innerHTML='';
       document.getElementById(messDay).innerHTML='';
       document.getElementById(messTime).innerHTML='';
       document.getElementById(messDate).innerHTML='';
       document.getElementById(mess).innerHTML='';
       var values1=document.getElementById(name).innerHTML;
       document.getElementById(name).innerHTML='<input type="text" class="form-control" style="float:left;width:120px;border-radius:2px" class="" id='+ id_data1 +  ' value='+values1+ '>';
       var values3=document.getElementById(color).innerHTML;
       document.getElementById(color).innerHTML='<input type="text" class="form-control" style="float:left;width:120px;border-radius:2px"  id='+ id_data3 +  ' value='+values3+ '>';
       var values4=document.getElementById(features).innerHTML;
       
        if (values4=="none" || values4==""){
          var options="<option value='Full-AC' >Full-AC</option>"+
                      "<option value='Non-AC' >Non-AC</option>"+
                      "<option value='Seater' >Seater</option>"+
                      "<option value='Sleeper' >Sleeper</option>"+
                      "<option value='Lead-TV' >Lead-TV</option>";
        }else{
          var featuresSelected = values4.split(',');
         
          var options="";
          featuresArr =['Full-AC','Non-AC','Seater','Sleeper','Lead-TV'];
          var previousSelect = Array();
          var value =featuresArr.some((val)=>featuresSelected.indexOf(val) !==-1);
          if (value){
            Array.prototype.diff=function(a){
              return this.filter(function(i){ return a.indexOf(i) < 0;});
            }
            var diff2 = featuresArr.diff(featuresSelected);
            for (var i =0; i < featuresSelected.length; i++){
              for (var j =0; j < featuresArr.length; j++){
                if (featuresSelected[i]==(featuresArr[j])){
                  options +="<option value="+featuresSelected[i]+" selected >"+featuresSelected[i]+"</option>";
                 
                }
              }
            }
            for (var k =0; k < diff2.length; k++){
                  options +="<option value="+diff2[k]+" >"+diff2[k]+"</option>";
            }
          }
         
        }
       document.getElementById(features).innerHTML='<select name="busFeatures" id="busFeatures" class="form-control"  style="width:120px;border-radius:2px" multiple>'+options+'</select>';
       var values5=document.getElementById(state).innerHTML;
       document.getElementById(state).innerHTML='<select name="busState" class="form-control" id="busState" style="width:120px;border-radius:2px" ><option value='+values5+' selected>'+values5+'</option></select>';
       var values6=document.getElementById(localG).innerHTML;
       document.getElementById(localG).innerHTML='<select name="busLocalG" class="form-control" id="busLocalG" style="width:120px;border-radius:2px" ><option value='+values6+' selected>'+values6+'</option></select>';
       var values7=document.getElementById(day).innerHTML;
       var days=document.getElementById(day).innerHTML='<select name="busPartDay" class="form-control" id='+id_data7+' style="width:120px;border-radius:2px" ><option value='+values7+' selected>'+values7+'</option>';
       if (values7=="morning") {
         days +='<option value="afternoon">Afternoon</option><option value="evening/night">Evening/Night</option>';
       }
       if (values7=="afternoon") {
         days +='<option value="morning">Morning</option><option value="evening/night">Evening/Night</option>';
       }
       if (values7=="evening/night") {
         days +='<option value="morning">Morning</option><option value="afternoon">Afternoon</option>';
       }
       days +='</select>';
       document.getElementById(day).innerHTML=days;
       var values8=document.getElementById(time).innerHTML;
       document.getElementById(time).innerHTML='<input type="text" name="busTime"  class="form-control" id="busTime" value='+values8+'style="width:120px;border-radius:2px" >';        
       var values9=document.getElementById(date).innerHTML;
       var todaysDate = new Date();
       var year = todaysDate.getFullYear();
       var month =('0'+ (todaysDate.getMonth() + 1)).slice(-2);
       var daySet =('0'+ todaysDate.getDate()).slice(-2);
       var maxDate = (year + '-' + month + '-' + daySet);
       $('#busDepartureDate input').attr('max',maxDate)
       document.getElementById(date).innerHTML='<input type="date" name="busDepartureDate"  value='+values9+' class="form-control" id="busDepartureDate" style="width:120px;border-radius:2px" >'; 
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
       var  id_data7='data7.'+id;
       var  id_data8='data8.'+id;
       var  id_data9='data9.'+id;       
       var save='save'+id;
       var edit='edit'+id;
       var delete1='delete'+id;
       var name='name' +id;
       var route='route' +id;
       var color='color' +id;
       var features='features' +id;
       var state='state' +id;
       var localG='localG' +id;
       var day='day'+id;
       var time='time'+id;
       var date='date'+id;
       var messName='messageName'+id;
       var messColor='messageColor'+id;
       var messFeatures='messageFeatures'+id;
       var messState='messageState'+id;
       var messLocalG='messageLocalG'+id;
       var messDay='messageDay'+id;
       var messTime='messageTime'+id;
       var messDate='messageDate'+id;       
       var mess='message'+id;
       var name1=document.getElementById(id_data1).value;
       var color1=document.getElementById(id_data3).value;
       features1 = new Array();
       $('#busFeatures option:selected').each(function(){
        features1.push($(this).val());
       
        });
       
       features1=features1.join(',');
       var state1=document.getElementById('busState').value;
       var localG1=document.getElementById('busLocalG').value;
       var day1=document.getElementById(id_data7).value;
       var time1=document.getElementById('busTime').value;
       var day1Array=['morning','afternoon','evening/night'];
       var timeArray =time1.split(':');
       if(timeArray[0] < 12 && day1==day1Array[0]){
         day1 = day1Array[0];
       }else if(timeArray[0] > 12 && day1 ==day1Array[1] ){
         day1 = day1Array[1];
       }else if(timeArray[0] >= 17 && timeArray[0] >= 19 && day1 ==day1Array[2] ){
         day1 = day1Array[2];
       }else{
        document.getElementById(messFeatures).innerHTML="";
        document.getElementById(messName).innerHTML="";
        document.getElementById(messColor).innerHTML="";
        document.getElementById(messTime).innerHTML="";         
        document.getElementById(messDate).innerHTML="";          
        document.getElementById(messDay).innerHTML="<span style='color:red;font-size:x-small'>Part of the day is not the time match</span>";
       }
       var todaysDate = new Date();
       var year = todaysDate.getFullYear();
       var month =('0'+ (todaysDate.getMonth() + 1)).slice(-2);
       var daySet =('0'+ todaysDate.getDate()).slice(-2);
       var date1=document.getElementById('busDepartureDate').value;
       dateArray =date1.split('-');
        if (name1==null || name1==''){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messDay).innerHTML="";
          document.getElementById(messTime).innerHTML="";
          document.getElementById(messDate).innerHTML="";
          document.getElementById(messName).innerHTML="<span style='color:red;font-size:x-small'>Name can't be blank</span>";
          
       }/*else if(!name1.match(/^[a-zA-Z]+$/)){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messColor).innerHTML="";
         document.getElementById(messName).innerHTML="<span style='color:red';margin-left:16px;font-size:x-small'>Name is not letters</span>";
       }*/else if(color1==false){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messDay).innerHTML="";
          document.getElementById(messTime).innerHTML="";
          document.getElementById(messDate).innerHTML="";          
          document.getElementById(messColor).innerHTML="<span style='color:red;font-size:x-small'>Color can't be empty</span>";
       }else if(state1==null || state1==''){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messState).innerHTML="<span style='color:red;font-size:x-small'>Select State</span>";
       }else if(localG1==null || localG1==''){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messDay).innerHTML="";
          document.getElementById(messTime).innerHTML="";
          document.getElementById(messDate).innerHTML="";          
          document.getElementById(messLocalG).innerHTML="<span style='color:red;font-size:x-small'>Select Local Govt</span>";
       }else if(day==null || day==''){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messTime).innerHTML="";
          document.getElementById(messDate).innerHTML="";          
          document.getElementById(messDay).innerHTML="<span style='color:red;font-size:x-small'>Select Departure Day</span>";
       }else if(time==null || time==''){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messDay).innerHTML="";         
          document.getElementById(messDate).innerHTML="";          
          document.getElementById(messTime).innerHTML="<span style='color:red;font-size:x-small'>Select Departure Time</span>";
       }else if(date==null || date==''){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messDay).innerHTML="";          
          document.getElementById(messTime).innerHTML="";          
          document.getElementById(messDate).innerHTML="<span style='color:red;font-size:x-small'>Select Departure Date</span>";
       }else if (dateArray[2] < daySet){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messDay).innerHTML="";          
          document.getElementById(messTime).innerHTML="";          
          document.getElementById(messDate).innerHTML="<span style='color:red;font-size:x-small'>Can't select previous day</span>";
       }/*else if (dateArray[2] > daySet){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messDay).innerHTML="";          
          document.getElementById(messTime).innerHTML="";          
          document.getElementById(messDate).innerHTML="<span style='color:red;font-size:x-small'>Can't select next day</span>";
       }*/else if ( dateArray[1] < month){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messDay).innerHTML="";          
          document.getElementById(messTime).innerHTML="";          
          document.getElementById(messDate).innerHTML="<span style='color:red;font-size:x-small'>Can't select previous month</span>";
       }else if (dateArray[1] > month){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messDay).innerHTML="";          
          document.getElementById(messTime).innerHTML="";          
          document.getElementById(messDate).innerHTML="<span style='color:red;font-size:x-small'>Can't select next month</span>";
       }else if (dateArray[0] < year){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messDay).innerHTML="";          
          document.getElementById(messTime).innerHTML="";          
          document.getElementById(messDate).innerHTML="<span style='color:red;font-size:x-small'>Can't select previous year</span>";
       }else if (dateArray[0] > year){
          document.getElementById(messFeatures).innerHTML="";
          document.getElementById(messName).innerHTML="";
          document.getElementById(messColor).innerHTML="";
          document.getElementById(messDay).innerHTML="";          
          document.getElementById(messTime).innerHTML="";          
          document.getElementById(messDate).innerHTML="<span style='color:red;font-size:x-small'>Can't select next year</span>";
       }else{
        var parameter="nameA=" + name1 + "&colorA=" + color1 + "&stateA=" + state1 + "&localGA=" + localG1 + "&featuresA=" + features1 + "&dayA=" + day1 + "&timeA=" + time1 + "&dateA=" + date1 +"&addBusA=" + 'save' + "&idA=" + ids;
        var  xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
          var response=JSON.parse(xmlhttp.responseText);
           if(JSON.parse(response.success=="true")){
             document.getElementById(messName).innerHTML="";
             document.getElementById(messColor).innerHTML="";
             document.getElementById(messFeatures).innerHTML="";
             document.getElementById(messDay).innerHTML="";
             document.getElementById(messTime).innerHTML="";
             document.getElementById(messDate).innerHTML="";             
             document.getElementById(mess).innerHTML='<span class="text-success" style="font-size:12px;float:left;clear:left"> record saved</span>';
             document.getElementById(name).innerHTML=name1;
             document.getElementById(color).innerHTML=color1;
             document.getElementById(features).innerHTML=features1
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
            }else if(response.success=="noRId"){
              window.location.href="error-404.php";
            }else if(response.success =="false"){
              if(JSON.parse(response.error.nameA !=undefined)){
                document.getElementById(messFeature).innerHTML='';
                document.getElementById(messColor).innerHTML='';
                document.getElementById(messState).innerHTML='';
                document.getElementById(messLocalG).innerHTML='';
                document.getElementById(messName).innerHTML='<span class="text-danger">'+response.error.nameA+'</span>';
              }else if(JSON.parse(response.error.colorA !=undefined)){
                document.getElementById(messState).innerHTML='';
                document.getElementById(messLocalG).innerHTML='';
                document.getElementById(messFeatures).innerHTML='';
                document.getElementById(messName).innerHTML='';
                document.getElementById(messColor).innerHTML='<span class="text-danger">'+response.error.colorA+'</span>'; 
              }else if(JSON.parse(response.error.featuresA !=undefined)){
                document.getElementById(messState).innerHTML='';
                document.getElementById(messLocalG).innerHTML='';
                document.getElementById(messColor).innerHTML='';
                document.getElementById(messName).innerHTML='';
                document.getElementById(messFeatures).innerHTML='<span class="text-danger">'+response.error.featuresA+'</span>'; 
              }else if(JSON.parse(response.error.stateA !=undefined)){
                document.getElementById(messLocalG).innerHTML='';
                document.getElementById(messColor).innerHTML='';
                document.getElementById(messLocalG).innerHTML='';
                document.getElementById(messFeatures).innerHTML='';
                document.getElementById(messName).innerHTML='';
                document.getElementById(messState).innerHTML='<span class="text-danger">'+response.error.stateA+'</span>'; 
              }else if(JSON.parse(response.error.localGA !=undefined)){
                document.getElementById(messState).innerHTML='';
                document.getElementById(messColor).innerHTML='';
                document.getElementById(messFeatures).innerHTML='';
                document.getElementById(messName).innerHTML='';
                document.getElementById(messLocalG).innerHTML='<span class="text-danger">'+response.error.localGA+'</span>'; 
              }
            }else if(response.success=="no"){
              window.location.href="error-404.php";
            } 
          }  
        }
        xmlhttp.open("POST","ajax-add-bus.php",true);
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
            <div class="row" id="bus-message">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body" style="overflow-x:scroll;background-color:ghostwhite;box-sizing:border-box; height:560px">
                    <h4 class="text-primary">Edit Table For All Buses</h4>
                    <p class="text-danger"> This  table is to make adjustment to any of<code class="text-primary">bus</code> information</p>
                    <table class="table table-striped" style="text-align:center;">
                      <?php
                          $user->getAllBuses();
                      ?>         
                  </div>
                  <div class="modal col-sm-8 col-sm-offset-4" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">                  
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title text-primary" id="Heading">Delete this bus</h4>
                        </div>
                        <div class="modal-body">
                          <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to delete this bus?</div>
                        </div>
                        <div class="modal-footer">
                          <button  class="btn btn-success del_bus"><span class="fa fa-check-circle"></span> Yes</button>
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
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="jqueryTimePicker/jquery.timepicker.min.js"></script>
    <!--<script src="assets/js/shared/misc.js"></script>-->
    <!-- endinject -->
    <!-- Custom js for this page-->
    <!-- End custom js for this page-->
  </body>
</html>               