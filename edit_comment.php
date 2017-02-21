<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
require_once("vendor/autoload.php");
use App\Message\Message;
use App\Utility\Utility;
use App\User\User;
use App\Thread\Thread;
use App\Comment\Comment;

$objComment = new Comment();
$objComment->setData($_GET);
$data = $objComment->show();

if ($data == false) {
    Utility::redirect("index.php");
}
$status = $objComment->isCommentAuthor($_GET['no'], $_SESSION['author_id']);

if ($status == false){
    Message::message("You Can't modified others Comments");
    Utility::redirect($_SERVER['HTTP_REFERER']);
}

$objThread = new Thread();
$thread = $objThread->view($data->thread_id);

$_SESSION['title'] = "Update Comment";
?>
<?php require_once "includes/header.php"; ?>

    <section class="blog-content blog-standard">
        <table>
            <tr>
                <td width='600' height="50" >
                    <?php if(isset($_SESSION['message']) )if($_SESSION['message'] != ""){ ?>

                        <div  id="message" class="form button" style="font-size: smaller">
                            <center>
                                <?php if((array_key_exists('message',$_SESSION) && (!empty($_SESSION['message'])))) {
                                    echo "&nbsp;".Message::message();
                                }
                                Message::message(NULL);
                                ?>
                            </center>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        </table>
        <div class="post">
            <div class="post-title">
                <h2><a href="single.php?no=<?php echo $thread->id; ?>"><?php echo $thread->title; ?></a></h2>
            </div>
        </div>

        <div id="respond">
            <div class="reply-title">
                <h3 class="h4">Update your comment</h3>
            </div>

            <form action="update_comment.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <?php
                    use App\User\Auth;
                    $auth= new Auth();
                    $loggedIn = $auth->logged_in();
                    if (!$loggedIn){
                        ?>
                        <div class="col-md-4">
                            <div class="form-item form-name">
                                <input type="text" name="user_name" value="<?php echo $status->user_name ?>" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-item form-email">
                                <input type="text" name="user_email" value="<?php echo $status->user_email ?> " required="required">
                            </div>
                        </div>
                    <?php } ?>
                    <p>Previous Poster:</p>
                    <div class="form-item form-captcha">
                        <img src="images/comment/<?php echo $status->photo ?>" height="75" width="88" alt="no image" class="wpcf7-captchac">
                    </div>
                    <div class="col-md-4">
                        <div class="form-item">
                            <input type="file" name="photo">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-item form-textarea-wrapper">
                            <textarea required="required" name="comment_body" placeholder="<?php echo $status->comment_body ?>">
                                <?php echo $status->comment_body ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $status->id ?>" >
                    <div class="form-actions">
                        <input type="submit" value="Save" class="pi-btn">
                    </div>
                </div>
            </form>

        </div>

    </section>
<?php
$objUser = new User();
if (isset($_SESSION['author_id']))
    $author = $objUser->show($_SESSION['author_id']);
?>
<?php require_once 'includes/footer.php'; ?>