<?php
include_once('../../vendor/autoload.php');
use App\User\User;
use App\User\Auth;
use App\Message\Message;
use App\Utility\Utility;
$auth= new Auth();
$auth->setData($_POST);// this setData() is equivalent to setData()
$status =   $auth->is_exist();
if($status){
    Message::setMessage("<div class='alert alert-danger'>
    <strong>Taken!</strong> Email has already been taken. </div>");
    return Utility::redirect($_SERVER['HTTP_REFERER']);
}else{
    if ($_POST["password"] !== $_POST["password1"] ){
        Message::message(' <div class="alert alert-info">
             <strong>Alert!</strong> Your Password does not match. Please try again.
              </div>');
        Utility::redirect('../../registration.php');
        exit();
    }

    $_POST['e_mail_token'] = md5(uniqid(rand()));

    $obj= new User();
    $obj->setData($_POST); // this setData() is equivalent to setData()
    $obj->setData($_FILES);
    $obj->store();
    require '../../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host       = "smtp.gmail.com";
    $mail->Port       = 465;
    $mail->AddAddress($_POST['e_mail']);
    $mail->Username="jobayer136501@gmail.com";               
    $mail->Password="bitm136501";
    $mail->SetFrom('no-reply@gmail.com','User Management');
    $mail->AddReplyTo("no-reply@gmail.com","User Management");
    $mail->Subject    = "Your Account Activation Link";
    $message =  "Please click this link to verify your account: 
       http://localhost/Bamboo/User/Profile/emailverification.php?e_mail=".$_POST['e_mail']."&e_mail_token=".$_POST['e_mail_token'];
    $mail->MsgHTML($message);
    $mail->Send();
    Utility::redirect('../../registration.php');
}
