<?php
 require('php-sendgrid/class.phpmailer.php');
                 require('php-sendgrid/class.smtp.php');
                  
                       $mail = new PHPMailer(); // create a new object
                       $mail->IsSMTP(); // enable SMTP
                       $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
                       $mail->SMTPAuth = true; // authentication enabled
                       $mail->SMTPSecure = 'ssl';
                       $mail->Host = "smtp.gmail.com";
                       $mail->Port = 465; // or tsl 587 or ssl 465
                       $mail->isHTML(true);
                       $mail->Username = "methyl2007@gmail.com";
                       $mail->Password = "wanted1811";
                       $mail->SetFrom("methyl2007@gmail.com");
                       $mail->Subject = "Feedback Verification";
                       $mail->AddAddress("methyl2007@gmail.com");
                       $mail->Body = "<div style='padding:auto;width:95%;text-align:center;background-color:e8e8e8;border:1px solid grey;box-shadow:5px 10px 8px 10px #888888'>
                        <h4 style='background-color:blue;font-weight:bold;text-align:center'>Password Reset-link</h4>
                       <p style='color:green'>Good day  please click on this link below to reset your password </p></div>";
                        if(!$mail->Send()) {
                             echo 'not sent';
                        }else{
                            echo 'sent';
                        }
                 
?>