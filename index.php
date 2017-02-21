<?php
require_once("vendor/autoload.php");
use App\Message\Message;
use App\Thread\Thread;
use App\User\User;
use App\Comment\Comment;

$data = array();
$objThread = new Thread();
$allData = $objThread->index("obj");

################## search  block1 start ##################
if(isset($_REQUEST['search']) )$allData =  $objThread->search($_REQUEST);

$availableKeywords = $objThread->getAllKeywords();
$comma_separated_keywords= '"'.implode('","',$availableKeywords).'"';
################## search  block1 end ##################

######################## pagination code block#1 of 2 start ######################################
$recordCount= count($allData);

if(isset($_REQUEST['Page']))   $page = $_REQUEST['Page'];
else if(isset($_SESSION['Page']))   $page = $_SESSION['Page'];
else   $page = 1;
$_SESSION['Page']= $page;

if(isset($_REQUEST['ItemsPerPage']))   $itemsPerPage = $_REQUEST['ItemsPerPage'];
else if(isset($_SESSION['ItemsPerPage']))   $itemsPerPage = $_SESSION['ItemsPerPage'];
else   $itemsPerPage = 3;
$_SESSION['ItemsPerPage']= $itemsPerPage;

$pages = ceil($recordCount/$itemsPerPage);
if ($_SESSION['Page'] > $pages) $page = 1;
$someData = $objThread->indexPaginator($page,$itemsPerPage);

$serial = (($page-1) * $itemsPerPage) +1;

####################### pagination code block#1 of 2 end #########################################

################## search  block2 start ##################

if(isset($_REQUEST['search']) ) {
    $someData = $objThread->search($_REQUEST);
    $serial = 1;
}
################## search  block2 end ##################

?>
<?php require_once "includes/header.php"; ?>
<section class="blog-content blog-standard">
<div class="">
    <table>
        <tr>
            <td width="250" height="50">
                    &nbsp; Show &nbsp;
                    <select  class="form-control"  name="ItemsPerPage" id="ItemsPerPage" onchange="javascript:location.href = this.value;" >
                        <?php
                        if($itemsPerPage==3 ) echo '<option value="?ItemsPerPage=3" selected > 3  </option>';
                        else echo '<option  value="?ItemsPerPage=3"> 3 </option>';

                        if($itemsPerPage==4 )  echo '<option  value="?ItemsPerPage=4" selected > 4  </option>';
                        else  echo '<option  value="?ItemsPerPage=4"> 4  </option>';

                        if($itemsPerPage==5 )  echo '<option  value="?ItemsPerPage=5" selected > 5  </option>';
                        else echo '<option  value="?ItemsPerPage=5"> 5  </option>';

                        if($itemsPerPage==6 )  echo '<option  value="?ItemsPerPage=6"selected > 6  </option>';
                        else echo '<option  value="?ItemsPerPage=6"> 6  </option>';

                        if($itemsPerPage==10 )   echo '<option  value="?ItemsPerPage=10"selected > 10  </option>';
                        else echo '<option  value="?ItemsPerPage=10"> 10  </option>';

                        if($itemsPerPage==15 )  echo '<option  value="?ItemsPerPage=15"selected > 15  </option>';
                        else    echo '<option  value="?ItemsPerPage=15"> 15  </option>';
                        ?>
                    </select>
                    Items Per Page &nbsp;
            </td>
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

    <!-- Start Single post -->
   <?php
    foreach($someData as $key => $values){
   ?>
    <div class="post">
        <div class="post-cat">
            <ul>
                <li><a href="#"><?php echo $values->category; ?></a></li>
            </ul>
        </div>
        <div class="post-title">
            <h2><a href="single.php?no=<?php echo $values->id; ?>"><?php echo $values->title; ?></a></h2>
        </div>
        <?php
            $objUser = new User();
            $author = $objUser->show($values->author_id);

            $objComment = new Comment();
            $comments = $objComment->index($values->id);
            $count = count($comments);
        ?>
        <div class="post-meta">
            <span class="author">
            <i class="pi-icon pi-icon-user"></i>
            By <a href="profile.php?id=<?php echo $author->id; ?>"><?php echo $author->user_name; ?></a>
            </span>
            <span class="date">
            <i class="pi-icon pi-icon-clock"></i>
            <a href="#"><?php echo date('F j, Y, g:i a', $values->time_date); ?></a>
            </span>
            <span class="comment">
                <i class="pi-icon pi-icon-comment"></i>
                <a href="single.php?no=<?php echo $values->id; ?>"><?php echo $count; ?> Comments</a>
            </span>
            <span class="btn-group">
                <!-- Single  caret button -->
                <ul class="navlist" style="z-index: 10;">
                    <li class="menu-item-has-children current-menu-parent">
                        <a href="#"><span class="caret"></a>
                        <ul class="sub-menu">
                            <li><a href="edit_thread.php?id=<?php echo $values->id; ?>">Edit</a></li>
                            <li><a href="delete_thread.php?id=<?php echo $values->id; ?>">Delete</a></li>
                        </ul>
                    </li>
                </ul>
                <!--Single caret end -->
            </span>
        </div>
        <div class="post-media">
            <div class="image-wrap">
                <img src="images/blog/<?php echo $values->image; ?>" alt="">
            </div>
        </div>
        <div class="post-body">
            <div class="post-entry">
                <p><?php  echo substr($values->thread_body, 0, 500); ?>
                </p>
            </div>
        </div>
        <div class="post-footer">
            <div class="post-link">
                <a href="single.php?no=<?php echo $values->id; ?>">Continue Reading...</a>
            </div>
        </div>
    </div>
        <?php
        $serial++;
    }
   ?>
    <!-- End of Single post -->

</div>
    <div class="pi-pagination">
            <?php if(!empty($pages)):

                if ($page > $pages){
                    echo "<span class=\"pagination-prev\"><i class=\"fa fa-angle-left\"></i></span>
                          <span class=\"current\">1</span>
                          <span class=\"pagination-next\"><i class=\"fa fa-angle-right\"></i></span>";
                }else {

                    if (($page == 1) && ($total_pages = 1)):?>
                        <span class="pagination-prev"><i class="fa fa-angle-left"></i></span>
                    <?php elseif ($page == $pages): ?>
                        <span class="pagination-next"><a href='index.php?Page=<?php echo $page - 1; ?>'> <i class="fa fa-angle-right"></i></a></span>
                    <?php else: ?>
                        <span class="pagination-next"><a href='index.php?Page=<?php echo $page - 1; ?>'> <i class="fa fa-angle-right"></i></a></span>
                    <?php endif; ?>
                    <?php
                    for ($i = 1; $i <= $pages; $i++):
                        ?>
                        <a class='<?php if ($i == $page) echo 'current'; ?>' href='index.php?Page=<?php echo $i; ?>'><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <?php
                    if ($page == $pages ): ?>
                        <span class="pagination-next"><i class="fa fa-angle-right"></i></span>
                    <?php else: ?>
                        <span class="pagination-next">
                            <a href='index.php?Page=<?php echo $page + 1; ?>'> <i class="fa fa-angle-right"></i></a>
                        </span>
                    <?php endif; ?>
                    <?php
                }
            endif;?>
    </div>
    <!--End of Pagination --->
</section>
    <script>

        $(function() {
            var availableTags = [

                <?php
                echo $comma_separated_keywords;
                ?>
            ];
            // Filter function to search only from the beginning of the string
            $( "#searchID" ).autocomplete({
                source: function(request, response) {

                    var results = $.ui.autocomplete.filter(availableTags, request.term);

                    results = $.map(availableTags, function (tag) {
                        if (tag.toUpperCase().indexOf(request.term.toUpperCase()) === 0) {
                            return tag;
                        }
                    });

                    response(results.slice(0, 15));

                }
            });


            $( "#searchID" ).autocomplete({
                select: function(event, ui) {
                    $("#searchID").val(ui.item.label);
                    $("#searchForm").submit();
                }
            });


        });

    </script>
    <script>
        function ConfirmDelete() {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }

        $('#message').show().delay(20).fadeOut();
        $('#message').show().delay(15).fadeIn();
        $('#message').show().delay(20).fadeOut();
        $('#message').show().delay(25).fadeIn();
        $('#message').show().delay(1200).fadeOut();
    </script>

<?php require_once "includes/footer.php"; ?>