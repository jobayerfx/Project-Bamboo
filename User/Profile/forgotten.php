<?php
if(!isset($_SESSION) )session_start();
include_once('../../vendor/autoload.php');

use App\User\User;
use App\Utility\Utility;
use App\Message\Message;

if(isset($_POST['e_mail'])) {
    $obj= new User();
    $obj->setData($_POST);
    $singleUser = $obj->view();

    $passwordResetLink = $singleUser->password ;

    require '../../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host       = "smtp.gmail.com";
    $mail->Port       = 465;
    $mail->AddAddress($_POST['e_mail']);
    $mail->Username="jobayer136501@gmail.com";     //   your gmail id here
    $mail->Password="bitm136501";                      //  your gmail password here
    $mail->SetFrom('no-reply@gmail.com','User Management');
    $mail->AddReplyTo("no-reply@gmail.com","User Management");
    $mail->Subject    = "Your Password Reset Link";
    $message =  "Please click this link to reset your password: 
       http://localhost/Bamboo/User/Profile/resetpassword.php?e_mail=".$_POST['e_mail']."&code=".$singleUser->password;
    $mail->MsgHTML($message);
    if($mail->Send()){

        Message::message("
                <div class=\"alert alert-success\">
                            <strong>Email Sent!</strong> Please check your email for password reset link.
                </div>");
    }

}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Need help with your password?</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="../../css/lib/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/lib/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/style.css">

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

</head>
<body>
<!-- Top content -->
<div class="top-content">
    <div class="container" >
        <table>
            <tr>
                <td width='230' >

                <td width='600' height="50" >


                    <?php  if(isset($_SESSION['message']) )if($_SESSION['message']!=""){ ?>

                        <div  id="message" class="form button"   style="font-size: smaller  " >
                            <center>
                                <?php if((array_key_exists('message',$_SESSION)&& (!empty($_SESSION['message'])))) {
                                    echo "&nbsp;".Message::message();
                                }
                                Message::message(NULL);
                                ?></center>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        </table>
        <br><br> <br><br> <br>
        <div class="row" >
            <div class="col-sm-12">


                <div class="form-box" style="margin-top: 0%">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Need help with your password?</h3>
                            <p>Please provide us your varified email</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-key"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="" method="post" class="login-form">
                            <div class="form-group">
                                <label class="sr-only" for="e_mail">Email</label>
                                <input type="text" name="e_mail" placeholder="Email..." class="form-email form-control" id="form-email">
                            </div>

                            <button type="submit" class="btn"> Click Here >> Please Email Me The Password Reset Link << Click Here</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-1 middle-border"></div>
            <div class="col-sm-1"></div>
        </div>

    </div>
</div>

<script src="../../js/lib/jquery-1.11.2.min.js"></script>
</body>

<script>
    $('.alert').slideDown("slow").delay(10000).slideUp("slow");
</script>

</html>

