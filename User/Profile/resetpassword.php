<?php
if(!isset($_SESSION) )session_start();
include_once('../../vendor/autoload.php');
use App\User\User;
use App\Utility\Utility;
use App\Message\Message;

if(isset($_POST['new_password']) &&  isset($_POST['confirm_new_password'])) {

    if($_POST['new_password'] ==  $_POST['confirm_new_password']) {

        $obj = new User();
        $_POST['password'] = $_POST['new_password'];
        $obj->setData($_GET);
        $obj->setData($_POST);
        $obj->change_password();
        Message::message("
                <div class=\"alert alert-success\">
                     <strong>Success!</strong> Password reset has been completed, Please login!
                </div>");
        Utility::redirect('../../index.php');
        return;
    }
    else{
        Message::message("
                <div class=\"alert alert-danger\">
                            <strong>Error!</strong> Password doesn't match!
                </div>");
    }
}

if(isset($_GET['e_mail'])) {
    $obj= new User();
    $obj->setData($_GET);
    $singleUser = $obj->view();

     if($singleUser->password != $_GET['code']   ){

        Message::message("
                <div class=\"alert alert-danger\">
                            <strong>Error!</strong> Invalid Password Reset Link.
                </div>");
        Utility::redirect('../../index.php');
          return;
    }

}
else{
    Utility::redirect('../../index.php');
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
                            <h3>Please set a new password and confirm it!</h3>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-key"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="" method="post" class="login-form">

                            <input type="hidden" name="email" value="<?php echo $_GET['e_mail']?>">

                            <div class="form-group">
                                <label class="sr-only" for="new_password">New Password</label>
                                <input type="password" name="new_password" placeholder="New Password" class="form-password form-control" id="form-password">
                            </div>

                            <div class="form-group">
                                <label class="sr-only" for="new_password">Confirm New Password</label>
                                <input type="password" name="confirm_new_password" placeholder="Confirm New Password" class="form-password form-control" id="form-password">
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


<!-- Javascript -->
<script src="../../js/lib/jquery-1.11.2.min.js"></script>

</body>

<script>
    $('.alert').slideDown("slow").delay(2000).slideUp("slow");
</script>

</html>

