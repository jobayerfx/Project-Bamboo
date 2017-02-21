<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
require_once ("vendor/autoload.php");
use App\Thread\Thread;
use App\Utility\Utility;
use App\Message\Message;
use App\User\User;

$object = new Thread();
$object->setData($_GET);
$getAllData = $object->show();
if ($getAllData == false) {
    Utility::redirect("index.php");
}

$status = $object->isThreadAuthor($_GET['id'], $_SESSION['author_id']);

if ($status == false){
    Message::message("You Can't modified others Threads");
    Utility::redirect($_SERVER['HTTP_REFERER']);
}

$_SESSION['title'] = "Update Thread";
?>
<?php require_once "includes/header.php"; ?>

<section class="blog-content blog-standard">
    <div class="row">
        <div class="post">
            <div class="post-title">
                <h2>Update the Thread</h2>
            </div>
            <div class="post-body">
                <div class="contact-form">
                    <form action="update_thread.php" method="post" enctype="multipart/form-data">
                        <div class="form-item">
                            <select name="category" id="category" required="required">
                                <option disabled> --- Select a Category --- </option>
                                <option value="Politics" <?php if ($getAllData->category == 'Politics') echo 'selected'; ?>> Politics</option>
                                <option value="Education" <?php if ($getAllData->category == 'Education') echo 'selected'; ?>> Education</option>
                                <option value="Culture" <?php if ($getAllData->category == 'Culture') echo 'selected'; ?>> Culture</option>
                                <option value="Sports" <?php if ($getAllData->category == 'Sports') echo 'selected'; ?>> Sports</option>
                                <option value="Crime" <?php if ($getAllData->category == 'Crime') echo 'selected'; ?>> Crime</option>
                                <option value="Entertainment" <?php if ($getAllData->category == 'Entertainment') echo 'selected'; ?>>Entertainment</option>
                                <option value="Technology" <?php if ($getAllData->title == 'Technology') echo 'selected'; ?>> Technology</option>
                                <option value="Others" <?php if ($getAllData->category == 'Others') echo 'selected'; ?>> Others</option>
                            </select>
                        </div>
                        <div class="form-item"> Title:
                            <input type="text" placeholder="<?php echo $getAllData->title; ?>" name="title" required="required">
                        </div>
                        <p>Previous Poster:</p>
                        <div class="form-item form-captcha">
                            <img src="images/blog/<?php echo $getAllData->image ?>" height="75" width="88" alt="" class="wpcf7-captchac">
                        </div>
                        <div class="form-item">
                            <lebel for="image">Thread's Poster: </lebel>
                            <input type="file" name="image" id="image">
                        </div>

                        <div class="form-textarea"> Thread Body:
                            <textarea name="thread_body" style="resize: none; overflow-y: `roll;" placeholder=" <?php echo $getAllData->thread_body; ?>">
                                <?php echo $getAllData->thread_body; ?>
                            </textarea>
                        </div>
                        <input type="hidden" value="<?php echo $getAllData->id; ?>" name="id">
                        <div class="form-actions">
                            <input type="submit" value="Save" name="save">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
<?php
$objUser = new User();
if (isset($_SESSION['author_id']))
    $author = $objUser->show($_SESSION['author_id']);
?>
<?php require_once "includes/footer.php"; ?>