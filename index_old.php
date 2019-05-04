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
                Welcome to W-Blog !
            </h1>

            <?php 
            $query = "SELECT * FROM posts WHERE post_status = 'Published' ORDER BY post_id DESC";
            $select_all_posts_query = mysqli_query($connection, $query);
            
            $post_count = 0;

            if (mysqli_num_rows($select_all_posts_query) == 0) 
                    echo '<h2 class="text-center">Sorry, there are no posts at this time.</h2>';
            
            while ($post = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id =      $post['post_id'];
                $post_title =   $post['post_title'];
                $post_author =  $post['post_author'];
                $post_date =    $post['post_date'];
                $post_image =   $post['post_image'];
                $post_content = substr($post['post_content'], 0, 200);
                $post_status =  $post['post_status'];
                

                if ($post_status == 'Published') {
                    $post_count++
             ?>
                    <h2>
                        <a href="post.php?post_id=<?php echo $post_id ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_author; ?>&post_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <hr>
                    <a href="post.php?post_id=<?php echo $post_id ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
            <?php 
                }
            
                if (mysqli_num_rows($select_all_posts_query) == $post_count) {
                    echo '<h2 class="text-center">Sorry, there are no more posts at this time.</h2>';
                }
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
    
