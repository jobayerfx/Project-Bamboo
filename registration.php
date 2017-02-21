<?php
include_once('vendor/autoload.php');

if(!isset($_SESSION) ) session_start();
use App\Message\Message;

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Bamboo Creative Blog</title>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="css/set1.css">

  <!--Google Fonts-->
  <link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>

</head>

<body>
<div id="main-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 left-side">
        <header>
          <span>Need an account?</span>
          <h3>Create Account<br>Add Contributions</h3>
        </header>
      </div>


      <div class="col-md-6 right-side">

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
        
        <form action="User/Profile/registration.php" method="post" enctype="multipart/form-data">
        <span class="input input--hoshi">
          <input class="input__field input__field--hoshi" type="text" name="user_name" id="name" required="required"/>
          <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="name">
            <span class="input__label-content input__label-content--hoshi">Name</span>
          </label>
        </span>
        <span class="input input--hoshi">
          <input class="input__field input__field--hoshi" type="text" name="e_mail" id="email" required="required"/>
          <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="email">
            <span class="input__label-content input__label-content--hoshi">E-mail</span>
          </label>
        </span>
        <span class="input input--hoshi">
          <input class="input__field input__field--hoshi" type="text" name="phone" id="phone" required="required"/>
          <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="phone">
            <span class="input__label-content input__label-content--hoshi">Phone</span>
          </label>
        </span>
        <span class="input input--hoshi">
          <input class="input__field input__field--hoshi" type="file" name="profile_picture" id="picture" required="required"/>
          <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="picture">
            <span class="input__label-content--hoshi">Image</span>
          </label>
        </span>
        <span class="input input--hoshi">
          <input class="input__field input__field--hoshi" type="password" name="password" id="password" required="required"/>
          <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="password">
            <span class="input__label-content input__label-content--hoshi">Password</span>
          </label>
        </span>
        <span class="input input--hoshi">
          <input class="input__field input__field--hoshi" type="password" name="password1" id="password1" required="required"/>
          <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="password1">
            <span class="input__label-content input__label-content--hoshi">Repeat Passowrd</span>
          </label>
        </span>
        <div class="cta">
          <button class="btn btn-primary pull-left" type="submit" name="reg">
            Sign-Up Now
          </button>
          <span><a href="index.php">I am already a member</a></span>
        </div>
      </div>
      </form>
    </div>
  </div>

</div> <!-- end #main-wrapper -->

<!-- Scripts -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/scripts1.js"></script>
<script src="js/classie.js"></script>
<script>
  (function() {
    // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
    if (!String.prototype.trim) {
      (function() {
        // Make sure we trim BOM and NBSP
        var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
        String.prototype.trim = function() {
          return this.replace(rtrim, '');
        };
      })();
    }

    [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
      // in case the input is already filled..
      if( inputEl.value.trim() !== '' ) {
        classie.add( inputEl.parentNode, 'input--filled' );
      }

      // events:
      inputEl.addEventListener( 'focus', onInputFocus );
      inputEl.addEventListener( 'blur', onInputBlur );
    } );

    function onInputFocus( ev ) {
      classie.add( ev.target.parentNode, 'input--filled' );
    }

    function onInputBlur( ev ) {
      if( ev.target.value.trim() === '' ) {
        classie.remove( ev.target.parentNode, 'input--filled' );
      }
    }
  })();
</script>
<script>
  $('.alert').slideDown("slow").delay(5000).slideUp("slow");
</script>
</body>
</html>