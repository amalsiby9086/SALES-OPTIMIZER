<?php
                    include "db.php";
                    session_start();
                    if (isset($_POST["reset_button"]) && (!empty($_POST["email"]))) {
                        $email = $_POST["email"];
                        $emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
                        if(empty($email) )
                        {
                            echo "<script type='text/javascript'>
                            window.location.href = 'http://localhost/sales1/forgotpassword.php?reset=invaid'</script>";
                            exit();
                        }
                             
                     else {
                        if(!preg_match($emailValidation,$email)){
                            echo "<script type='text/javascript'>
                            window.location.href = 'http://localhost/sales1/forgotpassword.php?reset=invaid'</script>";
                            exit();
                        }
                        $sql = "SELECT user_id FROM user_info WHERE email = '$email' LIMIT 1" ;
                        $check_query = mysqli_query($con,$sql);
                        $count_email = mysqli_num_rows($check_query);
                        if($count_email == 0){ 
                                echo "<script type='text/javascript'>
window.location.href = 'http://localhost/sales1/forgotpassword.php?reset=notfound'</script>";
exit();
                            }
                         else {

                            $output = '';

                            $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
                            $expDate = date("Y-m-d H:i:s", $expFormat);
                            $key = md5(time());
                            $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
                            $key = $key . $addKey;
                            // Insert Temp Table
                            mysqli_query($con, "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`) VALUES ('" . $email . "', '" . $key . "', '" . $expDate . "');");


                            $output.='<p>Please click on the following link to reset your password.</p>';
                            //replace the site url
                            $output.='<p><a href="http://localhost/sales1/reset-password.php?key=' . $key . '&email=' . $email . '&action=reset" target="_blank">http://localhost/sales1/reset-password.php?key=' . $key . '&email=' . $email . '&action=reset</a></p>';
                            $body = $output;
                            $subject = "Password Recovery";

                            $email_to = $email;


                            //autoload the PHPMailer
                            require("vendor/autoload.php");
                            $mail = new PHPMailer\PHPMailer\PHPMailer();
                            $mail->IsSMTP();
                            $mail->Host = "smtp.gmail.com"; // Enter your host here
                            $mail->SMTPAuth = true;
                            $mail->Username = "amal281217@gmail.com"; // Enter your email here
                            $mail->Password = "isknefjasxtoizfq"; //Enter your passwrod here
                            $mail->Port = 587;
                            $mail->IsHTML(true);
                            $mail->From = "amal281217@gmail.com";
                            $mail->FromName = "Sales Optimizer";

                            $mail->Subject = $subject;
                            $mail->Body = $body;
                            $mail->AddAddress($email_to);
                            if (!$mail->Send()) {
                                echo "Mailer Error: " . $mail->ErrorInfo;
                                exit();
                            } else {
                               // echo "An email has been sent";
                                echo "<script type='text/javascript'>
window.location.href = 'http://localhost/sales1/forgotpassword.php?reset=success'</script>";
exit();
                            }
                       exit();
                         } 
                        }
                    }
                    ?>