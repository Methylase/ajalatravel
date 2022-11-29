<?php
define('Ajaccess', TRUE);
  //connection
 require_once('../lib/config/config.php');
 $username="superadmin";
 $password=md5("wanted1986");
 $checker = 1;
 $checker2 ="Super Admin";
 $user->autoCreateAccess($username,$password, $checker, $checker2)
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Ajalatravel</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
  <!-- Favicons -->
  <link href="img/ajalatravel-mini.jpg" rel="icon">
  <link href="img/ajalatravel-mini.jpg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">
  <script type="text/javascript" src="../src/assets/js/bootstrap.min.js"></script>  
  <script type="text/javascript" src="../src/assets/js/jquery.js"></script>
  <script>
        $(document).ready(function(){
            $("#search").hide('fast');
             $("#searchMessage").hide('fast');
             $("#noSearchMessage").hide('fast');
             $("#sentMessage").hide('fast');             
            $("#proceed").click(function(){
                  $('.userId-group').removeClass('has-error');
                  $('.departFrom-group').removeClass('has-error');
                  $('.departDate-group').removeClass('has-error');
                  $('.departTo-group').removeClass('has-error');    
                  $('.help-block').remove(); // remove the error text                  
                  $('.userId-group').removeClass('has-error');
                  $('.help-block').remove(); // remove the error text
                  var re =/\S+@\S+\.\S+/;
                  var userId, departFrom, departTo, departDate;                  
                  userId = $('#userId').val();
                  departFrom =$('#departFrom').val();
                  departDate =$('#departDate').val();
                  departTo =$('#departTo').val();     
                  var form_data = {
                        userId: userId,
                        departFrom: departFrom,
                        departTo: departTo,
                        departDate: departDate,
                        searchBus: 'searchBus',
                        is_ajax: 1
                 };
                 $.ajax({
                        type: "POST",
                        url: 'ajax-search-bus.php',
                        data: form_data,
                        dataType: 'json',
                  }).done(function (data){
                        if(!data.success){
                            if(data.error.userId){
                                    $('.userId-group').addClass('has-error');
                                    $('.userId-group').append('<div class="help-block" style="font-size:small">' + data.error.userId + '</div>'); // add the actual error message under our input
                            }else{
                                    if(data.error.departFrom){
                                          $('.departFrom-group').addClass('has-error');
                                          $('.departFrom-group').append('<div class="help-block" style="font-size:small">' + data.error.departFrom + '</div>'); // add the actual error message under our input
                                    }else{
                                          if(data.error.departDate){
                                                $('.departDate-group').addClass('has-error');
                                                $('.departDate-group').append('<div class="help-block" style="font-size:small">' + data.error.departDate + '</div>'); // add the actual error message under our input
                                          }else{
                                                if(data.error.departTo){
                                                      $('.departTo-group').addClass('has-error');
                                                      $('.departTo-group').append('<div class="help-block" style="font-size:small">' + data.error.departTo + '</div>'); // add the actual error message under our input
                                                }                               
                                          }
                                     }
                            }   
                        }else if(data.success =='no'){
                              window.location.href="error-404.php";
                        }else if(data.success =='access'){
                               $("#booking").hide('fast'); 
                              $("#search").show('fast');
                              $("#searchMessage").hide('fast');
                              $("#noSearchMessage").hide('fast');
                              $("#sentMessage").hide('fast');
                              
                               
                        }     
                 });                  
            });
            $('#cancelSearch').click(function(){
                  $("#search").hide('fast');
                   $("#booking").show('fast');
                   $("#noSearchMessage").hide('fast');
                   $("#sentMessage").hide('fast');
                   
            });
            $('#companyNameA').change(function(){
                   $('.companyNameA-group').removeClass('has-error');
                    $('.busNameA-group').removeClass('has-error');  
                  $('.help-block').remove(); // remove the error text  
                  var form_data={companyNameA: $('#companyNameA').val()}
                  $.ajax({
                        type: "POST",
                        url: 'ajax-search-bus.php',
                        data: form_data,
                        dataType: 'json',
                  }).done(function (data){
                        if (data.success=='foundBus') {
                            $('.busNameA-group').empty();
                             $('.busNameA-group').append(data.foundBus);
                        }else if(data.success =='noBus'){
                               $('.companyNameA-group').addClass('has-error');
                              $('.companyNameA-group').append('<div class="help-block" style="font-size:small">' + data.message + '</div>'); // add the actual error message under our input
                              $('#busNameA').empty();
                             $('#busNameA').append('<option value="none">Select bus name</optiion>');
                        }else if(data.success =='no'){
                              $('.companyNameA-group').addClass('has-error');
                              $('.companyNameA-group').append('<div class="help-block" style="font-size:small">Select a company name</div>'); // add the actual error message under our input
                              $('#busNameA').empty();
                             $('#busNameA').append('<option value="none">Select bus name</optiion>');
                             
                        }
                        });  
                  });
                  $("#proceedSearch").click(function(){
                         $(".append").empty();
                        $('.companyNameA-group').removeClass('has-error');
                        $('.busNameA-group').removeClass('has-error');
                        $('.help-block').remove(); // remove the error text
                        if ($('#companyNameA').val()==null || $('#companyNameA').val() =='' || $('#companyNameA').val() =='none' ) {
                              $('.companyNameA-group').addClass('has-error');
                              $('.companyNameA-group').append('<div class="help-block" style="font-size:small">Select company name</div>');
                        }else{
                              if ($('#busNameA').val()==null || $('#busNameA').val()=='' || $('#busNameA').val()=='none') {
                                    $('.busNameA-group').addClass('has-error');
                                    $('.busNameA-group').append('<div class="help-block" style="font-size:small"> Select bus name</div>');
                              }else{
                                    var companyName =$('#companyNameA').val();
                                    var busName =$('#busNameA').val();
                                    var form_data = {
                                          companyName: companyName,
                                          busName: busName,
                                          proceedSearch:'proceedSearch'
                                    }
                                    $.ajax({
                                          type: "POST",
                                          url: 'ajax-search-bus.php',
                                          data: form_data,
                                          dataType: 'json',
                                          }).done(function (data){
                                                if(!data.success){
                                                     if(data.error.companyName){
                                                             $('.companyNameA-group').addClass('has-error');
                                                             $('.companyNameA-group').append('<div class="help-block" style="font-size:small">' + data.error.companyName + '</div>'); // add the actual error message under our input
                                                      }else{
                                                            if(data.error.busName){
                                                                   $('.companyNameA-group').addClass('has-error');
                                                                   $('.busNameA-group').append('<div class="help-block" style="font-size:small">' + data.error.busName + '</div>'); // add the actual error message under our input
                                                            }
                                                      }   
                                                }else if(data.success =='no'){
                                                       window.location.href="error-404.php";
                                                }else if(data.success =='noMatch'){
                                                      $("#booking").show('fast'); 
                                                      $("#search").hide('fast');
                                                      $("#searchMessage").hide('fast');
                                                      $("#noSearchMessage").show('fast');
                                                      $("#noSearchMessage").append('<div class="help-block" ><strong>' + data.message + '</strong></div>');
                                                      setTimeout(function(){
                                                            location.reload();
                                                      }, 3000);                                                        
                                                }else if(data.success =='foundMatch'){
                                                        $("#booking").show('fast'); 
                                                       $("#search").hide('fast');
                                                       $("#noSearchMessage").hide('fast');
                                                        $("#searchMessage").show('fast');
                                                       $(".append").prepend(data.foundMatch);                                                   
                                                }
                                          });                                     
                              }
                             
                        }                       
                  });
                  $('#generatePayment').click(function(){
                        $(".append").empty();
                        $("#searchMessage").hide('fast');
                        $("#sentMessage").empty();
                        var form_data = {
                               generatePayment: 'generatePayment',
                               is_ajax: 1
                        };
                        $.ajax({
                               type: "POST",
                               url: 'ajax-payment-code.php',
                               data: form_data,
                               dataType: 'json',
                         }).done(function (data){
                              if(data.success =='notSent'){
                                    $("#booking").show('fast'); 
                                    $("#search").hide('fast');                                    
                                    $("#sentMessage").show('fast');
                                    $("#sentMessage").append('<div class="help-block" ><strong>' + data.message + '</strong></div>');                                                  
                                    setTimeout(function(){
                                          location.reload();
                                    }, 3000);                                    
                              }else if(data.success =='sent'){
                                    $("#booking").show('fast'); 
                                    $("#search").hide('fast');                                    
                                    $("#sentMessage").show('fast');
                                    $("#sentMessage").append('<div class="help-block" ><strong>' + data.message + '</strong></div>');
                                    setTimeout(function(){
                                          location.reload();
                                    }, 3000);
                              }else if(data.success =='no'){
                                     window.location.href="error-404.php";
                              }    
                        });                        
                  });
      });
        
  </script>
</head>
<body>

  <!--==========================
  Header
  ============================-->
  <header id="header" class="fixed-top">
    <div class="container">

      <div class="logo float-left">
        <!-- Uncomment below if you prefer to use an image logo -->
        <h1 class="text-light"><a href="index.php"><span>Ajalatravel</span></a></h1> 
         <!--<a href="#intro" class="scrollto"><img src="img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav class="main-nav float-right d-none d-lg-block">
        <ul>
          <li class="active"><a href="#intro">Home</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#contact">Contact Us</a></li>
        </ul>
      </nav><!-- .main-nav -->
      
    </div>
  </header><!-- #header -->

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro" class="clearfix">
    <div class="container">

      <div class="intro-img">
        <img src="img/ajalabuspark.png"   alt="" class="img-fluid">
      </div>
      <div class="intro-info">
        <h2>Why go to the park to book a bus?<br><span>get your ticket</span><br>at your convinience now!!!</h2>
      <div>
          <a href="#about" class="btn-get-started scrollto">Get Started</a>
          <a href="#services" class="btn-services scrollto">Our Services</a>
        </div>
      </div>

    </div>
  </section><!-- #intro -->

  <main id="main">

    <!--==========================
      About Us Section
    ============================-->
    <section id="about">
      <div class="container">
        <header class="section-header">
          <h3>Book A Bus</h3>
        </header>
        <div class="row about-container">
          <div class="col-lg-6 content order-lg-1 order-2">
            <p>
              Ajalatravel is a platform that gives you the opportunity to book a bus any where, anytime at your convenience.
            </p>
            <div class="icon-box wow fadeInUp">
              <div class="icon"><i class="fa fa-arrow-right"></i></div>
              <h4 class="title"><a href="">Step One</a></h4>
              <p class="description">Enter your email or phone number, your location and travel destination.</p>
            </div>
            <div class="icon-box wow fadeInUp" data-wow-delay="0.2s">
              <div class="icon"><i class="fa fa-arrow-right"></i></div>
              <h4 class="title"><a href="">Step two</a></h4>
              <p class="description">Select the transport company you want to travel with and choose your departure date, then proceed.</p>
            </div>
            <div class="icon-box wow fadeInUp" data-wow-delay="0.4s">
              <div class="icon"><i class="fa fa-arrow-right"></i></div>
              <h4 class="title"><a href="">Step Three</a></h4>
              <p class="description">Rightly from the dropdown search, choose the transport company you will
              like to travel with and your destination route or stopping terminal and proceed, then an email
              or text message containing 6 digit code you can use for payment will be sent to you and after payment has been made, ticket you
              will take to the park will be generated and send to you.</p>
            </div>
          </div>
          <div class="col-lg-6 background order-lg-2 order-1 wow fadeInUp">
            <img src="img/payment.png" class="img-fluid" alt="">
          </div>
        </div>
        <div class="about-extra wow bounceInUp" id="booking" style="background-color: #004a99;border-radius:3px;color:white">
        <form style="padding-bottom:50px">
          <div class="container">
            <h3 class="text-center">Bus Booking</h3>
           <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">User-Id</label>
                <div class="col-sm-9 userId-group">
                  <input type="text" name="userId" id="userId" class="form-control" placeholder="Enter Your Email/ Phone Number "  />
                </div>
              </div>
            </div>
           <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Depart From</label>
                  <div class="col-sm-9 departFrom-group">
                    <input type="text" name="departFrom" id="departFrom" class="form-control" placeholder="From: Ikeja" data-rule="minlen:4" data-msg="Please enter at least 4 chars"/>
                  </div>
                </div>
              </div>
          </div>
           <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Departure Date</label>
                <div class="col-sm-9 departDate-group">
                  <input type="date" name="departDate" id="departDate" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Depart To</label>
                  <div class="col-sm-9 departTo-group">
                    <input type="text" name="departTo" id="departTo" class="form-control" placeholder="To: Abeokuta" />
                  </div>
                </div>
            </div>
            </div>
          </div>
          <div class="text-center">
            <button type="button" name="proceed" id="proceed"  style="background: #007bff;border: 0;border-radius: 20px;padding: 8px 30px;color: #fff;transition: 0.3s" >Proceed</button>
          </div>     
        </form>
      
        </div>
            <div class="about-extra  text-center"  id="search" style="background-color: #004a99;border-radius:3px;color:white;margin-top:10px;padding-top:20px;padding:20px 0px 20px;" >
                  <div class="container">
                        <h3 class="text-center">Choose transport company and select a bus</h3>
                        <div class="row" >
                              <div class="col-md-6">
                                    <div class="form-group row">
                                          <label class="col-sm-3 col-form-label">Company Name</label>
                                          <div class="col-sm-9 companyNameA-group">          
                                                <?php echo $user->companyNames() ?>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <div class="form-group row">
                                          <label class="col-sm-3 col-form-label">Buses</label>
                                          <div class="col-sm-9 busNameA-group">
                                            <select name="busNameA" id="busNameA" class="form-control">
                                                <?php echo $user->busNames() ?>
                                          </div>
                                    </div>
                              </div>
                        </div>                        
                  </div>
                  <div class="text-center">
                        <button type="button" name="proceedSearch" id="proceedSearch"  style="background: #007bff;border: 0;border-radius: 20px;padding: 8px 30px;color: #fff;transition: 0.3s" >Proceed</button>
                        <button type="button" name="cancelSearch" id="cancelSearch"  style="background: #007bff;border: 0;border-radius: 20px;padding: 8px 30px;color: #fff;transition: 0.3s" >Cancel</button>
                  </div>    

            </div>                        
            <div class="about-extra  text-center"  id="searchMessage" style="background-color: #004a99;border-radius:3px;color:white;margin-top:10px;padding-top:20px;padding:20px 0px 20px;">
                  <h4 class="text-center">We found a match for your travel destination</h4>
                  <div class="container-fluid" style="background-color:#ecf5ff;padding-top:25px; padding-bottom:25px;color:#004A99;border-radius:3px">
                        
                        <div class="row append">  
             
                        </div>
                        <div class="text-center col-md-12">
                              <button type="button" name="generatePayment" id="generatePayment"  style="background: #007bff;border: 0;box-shadow:grey 5px 5px 5px; border-radius: 20px;padding: 8px 30px;color: #fff;transition: 0.3s" >Generate Payment Code</button>
                        </div>                                   
                   </div>
            </div>
            <div class="about-extra  text-center"  id="noSearchMessage" style="background-color: #004a99;border-radius:3px;color:white;margin-top:10px;padding-top:20px;padding:20px 0px 20px;">
            </div>
            <div class="about-extra  text-center"  id="sentMessage" style="background-color: #004a99;border-radius:3px;color:white;margin-top:10px;padding-top:20px;padding:20px 0px 20px;">
            </div>
      </div>
    </section><!-- #about -->

    <!--==========================
      Services Section
    ============================-->
    <section id="services" class="section-bg">
      <div class="container">

        <header class="section-header">
          <h3>Core value</h3>
          <p>We offer, amazing transport services that will always give you second thought of coming back</p>
        </header>

        <div class="row">
          <div class="col-md-6 col-lg-5 offset-lg-1 wow bounceInUp" data-wow-duration="1.4s">
            <div class="box">
              <div class="icon"><i class="fa fa-reply-all" style="color: #ff689b;"></i></div>
              <h4 class="title"><a href="">Qick Response</a></h4>
              <p class="description">We are always swift in attending to our customers on any issues to be treated</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-5 wow bounceInUp" data-wow-duration="1.4s">
            <div class="box">
              <div class="icon"><i class="fa fa-book" style="color: #e9bf06;"></i></div>
              <h4 class="title"><a href="">Customers Management</a></h4>
              <p class="description">We are very keen in treating any of our customers request and issues without delay</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-5 offset-lg-1 wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
            <div class="box">
              <div class="icon"><i class="fa fa-circle-o-notch" style="color: #3fcdc7;"></i></div>
              <h4 class="title"><a href="">Efficiency</a></h4>
              <p class="description">We try as much as possible to be more efficient and on point</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-5 wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
            <div class="box">
              <div class="icon"><i class="fa fa-trophy" style="color:#41cf2e;"></i></div>
              <h4 class="title"><a href="">Comfort</a></h4>
              <p class="description">The main aim of this platform is to bring comfort to transport service system and make the people feel homely</p>
            </div>
          </div>
        </div>

      </div>
    </section><!-- #services -->

    <!--==========================
      Why Us Section
    ============================-->
    <section id="why-us" class="wow fadeIn">
      <div class="container">
        <header class="section-header">
          <h3>Why choose us?</h3>
          <p>This are the reseason why those that use our platform keep coming back.</p>
        </header>

        <div class="row row-eq-height justify-content-center">

          <div class="col-lg-4 mb-4">
            <div class="card wow bounceInUp">
                <i class="fa fa-support"></i>
              <div class="card-body">
                <h5 class="card-title"> Individual Customer Solution</h5>
                <p class="card-text">We approach every customer's complain individually. We will recommend the best and most effective solution for the situation given, whether it’s transportation or other logistic services. Our individual approach is also applied when dealing with payment terms.</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-4">
            <div class="card wow bounceInUp">
                <i class="fa fa-language"></i>
              <div class="card-body">
                <h5 class="card-title"> Our Attitude to Work</h5>
                <p class="card-text"> We believe in giving the right attitude to work and also the best of services to all our client or customer, and that will always be our priority</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 mb-4">
            <div class="card wow bounceInUp">
                <i class="fa fa-object-group"></i>
              <div class="card-body">
                <h5 class="card-title"> Quality Of Service</h5>
                <p class="card-text"> We give the best of service to all our customers, in short a stress free traveling they can not get any where </p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!--==========================
      Clients Section
    ============================-->
    <section id="contact">
      <div class="container-fluid">

        <div class="section-header">
          <h3>Contact us</h3>
        </div>

        <div class="row wow fadeInUp">

          <div class="col-lg-6">
            <div class="map mb-4 mb-lg-0">
              <iframe src="" alt="Not available"></iframe>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="row">
              <div class="col-md-5 info">
                <i class="ion-ios-location-outline"></i>
                <p>Nil</p>
              </div>
              <div class="col-md-4 info">
                <i class="ion-ios-email-outline"></i>
                <p>info@example.com</p>
              </div>
              <div class="col-md-3 info">
                <i class="ion-ios-telephone-outline"></i>
                <p>Nil</p>
              </div>
            </div>

            <div class="form">
              <div id="sendmessage">Your message has been sent. Thank you!</div>
              <div id="errormessage"></div>
              <form action="" method="post" role="form" class="contactForm">
                <div class="form-row">
                  <div class="form-group col-lg-6">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                    <div class="validation"></div>
                  </div>
                  <div class="form-group col-lg-6">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                    <div class="validation"></div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                  <div class="validation"></div>
                </div>
                <div class="text-center"><button type="submit" title="Send Message">Send Message</button></div>
              </form>
            </div>
          </div>

        </div>

      </div>
    </section><!-- #contact -->

  </main>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6 footer-info">
            <h3>AjalaTravel</h3>
            <p>This platform, is the here to reduce the stress people go through during boarding of tranportation from one city or region to another. </p>
          </div>

          <div class="col-lg-4 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><a href="#home">Home</a></li>
              <li><a href="#about">About us</a></li>
              <li><a href="#services">Services</a></li>
              <li><a href="#contact">Contatc us</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              Nil <br>
             Nil<br>
              Nigeria <br>
              <strong>Phone:</strong> Nil<br>
              <strong>Email:</strong> info@example.com<br>
            </p>

            <div class="social-links">
              <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
              <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
              <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
              <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
              <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
            </div>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
       <?php echo  Date('Y'); ?> &copy; Copyright <strong>Ajalatravel</strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <!-- Uncomment below i you want to use a preloader -->
  <!-- <div id="preloader"></div> -->

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/mobile-nav/mobile-nav.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/counterup/counterup.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/isotope/isotope.pkgd.min.js"></script>
  <script src="lib/lightbox/js/lightbox.min.js"></script>
  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>
  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

</body>
</html>
