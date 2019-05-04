<?php 
include 'includes/db.php';
include 'includes/header.php'; 
include 'includes/navigation.php';
 ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php 

            if (isset($_GET['post_id'])) {

                $post_id = $_GET['post_id'];
                $post_user = $_GET['author'];

                if (!isAdmin($_SESSION['user_name'])) 
                    $query = "SELECT * FROM posts WHERE post_user = '$post_user' AND post_status = 'Published'";
                else 
                    $query = "SELECT * FROM posts WHERE post_user = '$post_user'";
                
                $select_post = mysqli_query($connection, $query);
                if (!$select_post) 
                    exit('Query failed (' . mysqli_error($connection) . ')');

                while ($post = mysqli_fetch_assoc($select_post)) {
                    $post_id    =   $post['post_id'];
                    $post_title =   $post['post_title'];
                    $post_user =  $post['post_user'];
                    $post_date =    $post['post_date'];
                    $post_image =   $post['post_image'];
                    $post_content = $post['post_content'];
                ?>
                    <h2>
                        <a href="post.php?post_id=<?php echo $post_id ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        Post by <?php echo $post_user; ?>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <!-- <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a> -->
                    <hr>
            <?php 
                }
            }
            ?>

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
                    if (!$insert_comment_query) 
                        exit('Query failed (' . mysqli_error($connection) . ')');


                    $query = "UPDATE posts SET ";
                    $query.= "post_comment_count = post_comment_count + 1 ";    
                    $query.= "WHERE post_id = $comment_post_id";    

                    $increment_post_comments_query = mysqli_query($connection, $query);
                    if (!$increment_post_comments_query) 
                        exit('Query failed (' . mysqli_error($connection) . ')');
                }
            }

            ?>

            
            <!-- Comment -->
            <div class="media">
                
            </div>
        </div>

            
        <?php 
        include 'includes/sidebar.php';
         ?>

    </div>
    <!-- /.row -->

    <hr>
    <?php 
    include "includes/footer.php"; 
     ?>
    
