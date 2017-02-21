<?php
    require_once("vendor/autoload.php");
    use App\Message\Message;
    use App\Thread\Thread;
    use App\Utility\Utility;
    use App\User\User;
    use App\Comment\Comment;

    $objComment = new Comment();
    $objThread = new Thread();
    $objThread->setData($_GET);
    $data = $objThread->show();
    //Utility::dd($data);
    if ($data == false) {
        Utility::redirect("index.php");
    }

?>
<?php require_once "includes/header.php"; ?>

<section class="blog-content blog-standard">
    <table>
        <tr>
            <td width='600' height="50" >
                <?php if(isset($_SESSION['message']) )if($_SESSION['message'] != ""){ ?>

                    <div  id="message" class="form button" style="font-size: larger">
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
        <div class="post-cat">
            <ul>
                <li><a href="#"><?php echo $data->category; ?></a></li>
            </ul>
        </div>
        <div class="post-title">
            <h2><a href="single.php?no=<?php echo $data->id; ?>"><?php echo $data->title; ?></a></h2>
        </div>
        <?php
        $objUser = new User();
        $author = $objUser->show($data->author_id);

        $comments = $objComment->index($data->id, 'obj');
        $count = count($comments);
        ?>
        <div class="post-meta">
            <span class="author">
            <i class="pi-icon pi-icon-user"></i>
            By <a href="profile.php?id=<?php echo $author->id; ?>"><?php echo $author->user_name; ?></a>
            </span>
            <span class="date">
            <i class="pi-icon pi-icon-clock"></i>
            <a href="#"><?php echo date('F j, Y, g:i a', $data->time_date); ?></a>
            </span>
            <span class="comment">
                <i class="pi-icon pi-icon-comment"></i>
                <a href="#"><?php echo $count; ?> Comments</a>
            </span>
            <span class="btn-group">
                <!-- Single  caret button -->
                <ul class="navlist" style="z-index: 10;">
                    <li class="menu-item-has-children current-menu-parent">
                        <a href="#"><span class="caret"></a>
                        <ul class="sub-menu">
                            <li><a href="edit_thread.php?id=<?php echo $data->id; ?>" onclick="CheckAuth();">Edit</a></li>
                            <li><a href="delete_thread.php?id=<?php echo $data->id; ?>">Delete</a></li>
                        </ul>
                    </li>
                </ul>
                <!--Single caret end -->
            </span>
        </div>
        <div class="post-media">
            <div class="image-wrap">
                <img src="images/blog/<?php echo $data->image; ?>" alt="">
            </div>
        </div>
        <div class="post-body">
            <div class="post-entry">
                <p><?php echo $data->thread_body; ?>
                </p>
            </div>
        </div>
    </div>
 
<div id="comments">
    <div class="comments-inner-wrap">
        <h3 id="comments-title" class="h4">( <?php echo $count; ?> ) Comments</h3>
        <ul class="commentlist">
           <?php
            foreach ($comments as $key => $comment){
                //$objUser = new User();
                $author = $objUser->show($comment->author_id);
           ?>

            <li class="comment">
                <div class="comment-box">
                    <div class="comment-author">
                        <?php if($comment->user_name != NULL){
                            echo "<a href=\"#\"><img src=\"images/img_avatar2.png\" alt=\"\"></a>";
                        ?>
                        </div>
                        <div class="comment-body">
                            <cite class="fn"><a href="#"><?php echo $comment->user_name; ?></a></cite>
                        <?php
                        }else{
                            if ($author->profile_picture == ""){
                                echo "<a href=\"#\"><img src=\"images/img_avatar2.png\" alt=\"\"></a>";
                            }else {
                                echo "<a href=\"#\"><img src=\"images/author/" . $author->profile_picture . "\" alt=\"\"></a>";
                            }
                        ?>
                    </div>

                    <div class="comment-body">
                        <cite class="fn"><a href="#"><?php echo $author->user_name; ?></a></cite>
                        <?php } ?>
                        <div class="comment-meta">
                            <span><?php echo date('F j, Y, g:i a', $comment->time_date); ?></span>
                        </div><br />
                        <?php if ($comment->photo != ""){ ?>
                        <div class="comment">
                            <a href="#"><img src="images/comment/<?php echo $comment->photo; ?>" height="120" width="140" alt="No Photo"></a>
                        </div><br />
                        <?php } ?>
                        <p><?php echo $comment->comment_body; ?></p>
                        <div class="comment-abs">
                            <a href="edit_comment.php?no=<?php echo $comment->id; ?>" class="comment-edit-link">Edit</a>
                            <a href="delete_comment.php?no=<?php echo $comment->id; ?>" class="comment-reply-link">Delete</a>
                        </div>
                    </div>
                </div>
            </li>
            <?php } ?>
            
        </ul>
    </div>
</div>
 
 
<div id="respond">
    <div class="reply-title">
        <h3 class="h4">Leave your comment</h3>
    </div>

    <form action="store_comment.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <?php
                use App\User\Auth;
                $auth= new Auth();
                $loggedIn = $auth->logged_in();
                if (!$loggedIn){
             ?>
            <div class="col-md-4">
                <div class="form-item form-name">
                    <input type="text" name="user_name" value="Your name *" required="required">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-item form-email">
                    <input type="text" name="user_email" value="Your email *" required="required">
                </div>
            </div>
                <?php } ?>
           <div class="col-md-4">
                <div class="form-item">
                    <input type="file" name="photo">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-item form-textarea-wrapper">
                    <textarea required="required" name="comment_body">Message</textarea>
                </div>
            </div>
            <input type="hidden" name="thread_id" value="<?php echo $data->id; ?>" >
            <div class="form-actions">
                <input type="submit" value="Comment" class="pi-btn">
            </div>
        </div>
    </form>
 
</div>
 
</section>
<?php
    $objUser = new User();
if (isset($_SESSION['author_id']))
    $author = $objUser->show($_SESSION['author_id']); ?>
<?php require_once 'includes/footer.php'; ?>