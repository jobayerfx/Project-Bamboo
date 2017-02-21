<?php require_once "includes/header.php"; ?>


<section class="blog-content blog-standard">
    <div class="row">
        <div class="post">
            <div class="post-title">
                <h2>Create a new thread</h2>
            </div>
            <div class="post-body">
                <div class="contact-form">
                    <form action="store_thread.php" method="post" enctype="multipart/form-data">
                        <div class="form-item">
                            <select name="category" id="category" required="required">
                                <option selected disabled> --- Select a Category --- </option>
                                <option value="Politics"> Politics</option>
                                <option value="Education"> Education</option>
                                <option value="Culture"> Culture</option>
                                <option value="Sports"> Sports</option>
                                <option value="Crime"> Crime</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Technology"> Technology</option>
                                <option value="Others"> Others</option>
                            </select>
                        </div><br /><br /><br /><br />
                        <div class="form-item">
                            <input type="text" value="Thread Title *" name="title" required="required">
                        </div><br /><br /><br /><br /><br /><br />

                        <div class="form-item">
                            <lebel for="image">Thread's Poster</lebel>
                            <input type="file" name="image" id="image" required="required">
                        </div>
                        <!--
                        <div class="form-item form-captcha">
                            <img src="images/captcha-demo.png" alt="" class="wpcf7-captchac">
                            <span class="wpcf7-form-control-wrap">
                            <input type="text" value="Captcha">
                            </span>
                        </div>-->
                        <div class="form-textarea">
                            <textarea name="thread_body" required="required">Thread body . . .</textarea>
                        </div>
                        <div class="form-actions">
                            <input type="submit" value="Add" name="create">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>




<?php require_once "includes/footer.php"; ?>
