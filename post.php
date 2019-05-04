<?php 
include 'includes/db.php';
include 'includes/header.php'; 
include 'includes/navigation.php';
 ?>

<!-- AJAX -->
<?PHP // Ajax Likes funcrionality

// Unlike button click
if (isset($_POST['unliked'])) {
    // Init values
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    
    // Fetch the right post
    $query = "SELECT post_likes FROM posts ";
    $query.= "WHERE post_id = '$post_id' ";
    $select_post_likes = mysqli_query($connection, $query);
    confirmQuery($select_post_likes);
    
    // Update (decrement) the number of likes
    $query = "UPDATE posts SET post_likes = post_likes - 1 ";
    $query.= "WHERE post_id = '$post_id'";
    $update_post_likes = mysqli_query($connection, $query);
    confirmQuery($update_post_likes);

    // Delete likes from post
    $query = "DELETE FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id' ";
    $delete_like = mysqli_query($connection, $query);
    confirmQuery($create_like);
    exit();


}


// Like button click
if (isset($_POST['liked'])) {
    // Init values
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    // Fetch the right post
    $query = "SELECT post_likes FROM posts ";
    $query.= "WHERE post_id = '$post_id' ";
    $select_post_likes = mysqli_query($connection, $query);
    confirmQuery($select_post_likes);

    if (mysqli_num_rows($select_post_likes) > 0) {
        $current_post_likes = mysqli_fetch_assoc($select_post_likes)['post_likes'];
        echo "<h1>'$current_post_likes'</h1>";
    }
    
    // Update (increment) the number of likes
    $query = "UPDATE posts SET post_likes = post_likes + 1 ";
    $query.= "WHERE post_id = '$post_id' ";
    $update_post_likes = mysqli_query($connection, $query); 
    confirmQuery($update_post_likes);

    // Create likes for post
    $query = "INSERT INTO likes(user_id, post_id) ";
    $query.= "VALUES('$user_id', '$post_id')";

    $create_like = mysqli_query($connection, $query);
    confirmQuery($create_like);
    exit();
}
?>


<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php 

            if (isset($_GET['post_id'])) {

                $post_id = $_GET['post_id'];

                $views_query = "UPDATE posts SET post_views_count = post_views_count + 1 ";
                $views_query.= "WHERE post_id = '$post_id'";

                $update_views_query = mysqli_query($connection, $views_query);
                confirmQuery($update_views_query);


                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
                    $query = "SELECT * FROM posts WHERE post_id = $post_id";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id = $post_id AND post_status = 'Published'";
                }

                $select_post = mysqli_query($connection, $query);
                confirmQuery($select_post);

                if (mysqli_num_rows($select_post) < 1) {
                    echo '<h2 class="text-center page-header">Sorry, there are no posts at this time.</h2>';
                    echo '</div>';
                } else {

                    while ($post = mysqli_fetch_assoc($select_post)) {
                        $post_title =   $post['post_title'];
                        $post_user =    $post['post_user'];
                        $post_date =    $post['post_date'];
                        $post_image =   $post['post_image'];
                        $post_content = $post['post_content'];
                    ?>
                        <h2>
                            <p><?php echo $post_title; ?></p>
                        </h2>
                        <p class="lead">
                            by <a href="author_posts.php?author=<?php echo $post_user; ?>&post_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>                    </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <hr>

                        <?PHP if (isLoggedIn()): ?>

                        <!-- Likes -->
                        <div class="row" style="font-size: 3rem">
                            <p id="<?PHP echo userLikesPost($post_id) ? 'btnUnlike' : 'btnLike'; ?>" class="pull-right">
                                <a href="">
                                    <span   
                                        class="glyphicon glyphicon-thumbs-up" data-toggle="tooltip" data-placement="top" 
                                        title="<?PHP echo userLikesPost($post_id) ? 'I like this' : 'Like'; ?>"
                                    ></span> 
                                    <?PHP echo userLikesPost($post_id) ? ' Unlike' : ' Like'; ?>
                                    
                                </a>
                            </p>
                        </div>
                        
                        <div class="row" style="font-size: 3rem">
                            <p class="pull-right">Likes: <?PHP echo getPostLikes($post_id); ?></p>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <?PHP else: ?>
                        <div class="row" style="font-size: 3rem">
                            <p class="pull-right">You need to <a href="/blog/login.php">login</a> to leave a like.</p>
                        </div>
                        <div class="row" style="font-size: 3rem">
                            <p class="pull-right">Likes: <?PHP echo getPostLikes($post_id); ?></p>
                        </div>

                        <?PHP endif; ?>
                        <!-- /.Likes -->
                <?php 
                    } 
                ?>
                <!-- /.Blog entries -->

                <!-- Blog Comments -->

                    <?php 
                    if (isset($_POST['create_comment'])) {

                        $comment_post_id    = $_GET['post_id'];
                        $comment_author     = $_POST['comment_author'];
                        $comment_email      = $_POST['comment_email'];
                        $comment_content    = $_POST['comment_content'];
                        $comment_status     = 'Draft';
                        $comment_date       = date('d-m-y');

                        if (empty($comment_author) || empty($comment_content) || empty($comment_email)) {
                            echo '<script>alert("These fields cannot be empty!")</script>';
                        } else {
                            $query = "INSERT INTO comments ";
                            $query.= "(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                            $query.= "VALUES ";
                            $query.= "('$comment_post_id', '$comment_author', '$comment_email', '$comment_content', '$comment_status', '$comment_date')";

                            $insert_comment_query = mysqli_query($connection, $query);
                            confirmQuery($insert_comment_query);

                        }
                    }   
                    ?>

                    <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form role="form" action="post.php?post_id=<?PHP echo $_GET['post_id']; ?>" method="post">
                            <div class="form-group">
                                <label for="comment_author">Name:</label>
                                <input name="comment_author" type="text" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="comment_email">Email:</label>
                                <input name="comment_email" type="email" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="comment_email">Your Comment:</label>
                                <textarea name="comment_content" class="form-control" rows="3" required></textarea>
                            </div>
                            <button name="create_comment" type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    </div>

                    <hr>

                    <!-- Posted Comments -->

                    <?php 
                    $query = "SELECT * FROM comments ";
                    $query.= "WHERE comment_post_id = $post_id ";
                    $query.= "AND comment_status = 'Approved' ";
                    $query.= "ORDER BY comment_id DESC";
                    
                    $select_approved_comments_query = mysqli_query($connection, $query);
                    confirmQuery($select_approved_comments_query);
                    
                    while ($comment = mysqli_fetch_assoc($select_approved_comments_query)) {
                        $comment_date       = $comment['comment_date'];
                        $comment_content    = $comment['comment_content'];
                        $comment_author     = $comment['comment_author'];
                    ?>

                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small>
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                
            </div>
            <?php 
                }
            }
            ?>
        <?php 
        include 'includes/sidebar.php';
         ?>

    </div>
    <!-- /.row -->

    <hr>
    <?php 
    include "includes/footer.php"; 
     ?>

<script>

$(document).ready(function() {
    // Like function
    $('#btnLike').on('click', function() {

        let post_id = <?PHP echo $post_id; ?>;
        let user_id = <?PHP echo userLoggedIn_GetId(); ?>;

        $.ajax({
            type: "post",
            url: "/blog/post.php?post_id=" + post_id,
            data: {
                'liked': 1,
                'post_id': post_id,
                'user_id': user_id
            },
            success: function (response) {
                
            }
        });
    });

    // Unlike function
    $('#btnUnlike').on('click', function() {

        let post_id = <?PHP echo $post_id; ?>;
        let user_id = <?PHP echo userLoggedIn_GetId(); ?>;

        $.ajax({
            type: "post",
            url: "/blog/post.php?post_id=" + post_id,
            data: {
                'unliked': 1,
                'post_id': post_id,
                'user_id': user_id
            },
            success: function (response) {
                
            }
        });
    });

    // Like onmouseover tooltip toggle 
    $('[data-toggle="tooltip"]').tooltip();

});
</script>
    
