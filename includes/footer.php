
<aside class="sidebar-page">

    <header id="page-header">

        <div class="logo text-center">
            <a href="index.php"><img src="images/logo.png" alt=""></a>
        </div>


        <nav class="pi-navigation">
            <div class="nav-inner">
                <div class="open-menu">
                    <span class="item item-1"></span>
                    <span class="item item-2"></span>
                    <span class="item item-3"></span>
                </div>
                <h4>Navigation</h4>
                <ul class="navlist">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="create_thread.php">Create Thread</a></li>
                    <li><a href="registration.php">Registration</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                <div class="search-box">
                    <button class="icon-search" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                    <!--<form>
                        <input type="search" value="Search and hit enter">
                    </form> -->
                    <form id="searchForm" action="index.php"  method="get">
                        <input type="search" id="searchID" name="search" value="Search and hit enter">
                        <input hidden type="submit" class="btn-primary" value="search">
                    </form>
                </div>
            </div>
        </nav>

    </header>

    <div class="widget-wrapper">
        <?php
        use App\User\Auth;
        $auth= new Auth();
        $status = $auth->logged_in();
        if ($status){
        ?>
        <!-- Start About me Part -->
        <div class="widget widget_about">
            <h4>About me</h4>
            <div class="author-thumb">
                <img src="images/author/<?php echo $userAuth->profile_picture; ?>" alt="">
            </div>
            <h3 class="author-name"><a href="#"><?php echo $userAuth->user_name; ?></a>&nbsp;<a href="User/Authentication/logout.php">(Logout)</a></h3>
            <div class="desc">
                <p>In vitae ligula tristique, commodo justo sit amet, venenatis turpis. Maecenas condimentum, erat non fermentum facilisis.</p>
            </div>
            <div class="about-social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-google-plus"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-tumblr"></i></a>
            </div>
        </div>
        <!-- // End of About me Part -->
        <?php }else{ ?>
        <!-- // Start  Non Login Part -->
        <div>
            <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>

            <div id="id01" class="modal">

                <form class="modal-content animate" action="User/Authentication/login.php" method="post">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                        <img src="images/img_avatar2.png" alt="Avatar" class="avatar">
                    </div>

                    <div class="container">
                        <label style="float: left"><b>Username</b></label>
                        <input type="text" placeholder="Enter Email" name="e_mail" required>

                        <label style="float: left"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="password" required>

                        <button type="submit">Login</button>
                        <input type="checkbox" checked="checked"> Remember me
                    </div>

                    <div class="container" style="background-color:#f1f1f1;">
                        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                        <span class="psw">Forgot <a href="User/Profile/forgotten.php">password?</a> || If not Registered? <a href="#">Create new!</a></span>
                    </div>
                </form>
            </div>

            <script>
                // Get the modal
                var modal = document.getElementById('id01');

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script>
        </div>
        <!-- // End of Non Login Part -->
        <?php   }   ?>

    </div>


    <footer id="page-footer">
        <div class="page-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-pinterest"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <div class="copyright text-center">
            <p>Copyrights © 2017 All Rights Reserved by Jobayer Hossain</p>
        </div>
    </footer>

</aside>

</div>
</div>


<script type="text/javascript" src="js/lib/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/lib/jquery.owl.carousel.js"></script>
<script type="text/javascript" src="js/lib/theia-sticky-sidebar.js"></script>
<script type="text/javascript" src="js/lib/retina.min.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script>
    $('.alert').slideDown("slow").delay(5000).slideUp("slow");
</script>

</body>
</html>