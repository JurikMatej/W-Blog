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
            <h1 class="page-header">
                Posts
            </h1>

            <?php 

            if (isset($_GET['category'])) {
                $cat_id = $_GET['category'];

                if (isAdmin($_SESSION['user_name'])) {

                    $stmt = mysqli_prepare(
                        $connection, 
                        "SELECT post_id, post_title, post_user, post_date, post_image, post_content
                         FROM posts WHERE post_category_id = ?"
                    );
                    if (isset($stmt)) {
                        mysqli_stmt_bind_param($stmt, 's', $cat_id);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
                    }

                } else {

                    $stmt = mysqli_prepare(
                        $connection,
                        "SELECT post_id, post_title, post_user, post_date, post_image, post_content
                         FROM posts WHERE post_category_id = ? AND post_status = ?"
                    );
                    $published = "Published";

                    if (isset($stmt)) {
                        mysqli_stmt_bind_param($stmt, 'is', $cat_id, $published);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
                    }
                }

                confirmQuery($stmt);

                echo mysqli_stmt_num_rows($stmt);

                if (mysqli_stmt_num_rows($stmt) < 1) {
                    echo '<h2 class="text-center">Sorry, there are no posts at this time.</h2>';
                } else {

                    $count = mysqli_stmt_num_rows($stmt);
                    if ($count == 0) {
                        echo '<h2>No results</h2>';
                    } else {           
                        while ($post = mysqli_stmt_fetch($stmt)) {
                            // $post_id =      $post['post_id'];
                            // $post_title =   $post['post_title'];
                            // $post_user =  $post['post_user'];
                            // $post_date =    $post['post_date'];
                            // $post_image =   $post['post_image'];
                            // $post_content = substr($post['post_content'], 0, 200);
                        ?>
                            <h2>
                                <a href="post.php?post_id=<?php echo $post_id ?>"><?php echo $post_title; ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="author_posts.php?author=<?php echo $post_user; ?>&post_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>                        </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                            <hr>
                            <p><?php echo $post_content; ?></p>
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>
            <?php 
                        }
                    }
                }
            } else {
                redirect('index.php');
            }
            ?>
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
    
