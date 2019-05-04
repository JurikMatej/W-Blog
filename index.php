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
            
            $postPerPage = 7;
            
            if (isset($_GET['page'])) {

                $page = $_GET['page'];
            } else {
                $page = '';
            }

            if ($page == '' || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $postPerPage) - $postPerPage;  
            }


            // get the num of all posts
            $query = "SELECT * FROM posts";
            $find_count_query = mysqli_query($connection, $query);
            $page_count = mysqli_num_rows($find_count_query);
            $page_count = ceil($page_count / $postPerPage);

            // get and write out all posts

            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
                $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1, $postPerPage";
            } else {
                $query = "SELECT * FROM posts WHERE post_status = 'Published' ORDER BY post_id DESC LIMIT $page_1, $postPerPage";
            }

            $select_all_posts_query = mysqli_query($connection, $query);
            
            // initialised to check if a post is the last one
            $post_count = 0;

            if (mysqli_num_rows($select_all_posts_query) < 1) 
                echo '<h2 class="text-center">Sorry, there are no posts at this time.</h2>';          
            else {
            while ($post = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id =      $post['post_id'];
                $post_title =   $post['post_title'];
                $post_user =  $post['post_user'];
                $post_date =    $post['post_date'];
                $post_image =   $post['post_image'];
                $post_content = substr($post['post_content'], 0, 200);
                $post_status =  $post['post_status'];
                
                $post_count++
             ?>
                <h2>
                    <a href="post.php?post_id=<?php echo $post_id ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_user; ?>&post_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>                    </p>
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
            
                // if (mysqli_num_rows($select_all_posts_query) == $post_count) 
                    // echo '<h2 class="text-center">Sorry, there are no more posts at this time.</h2>';
                
            }
             ?>
        </div>

            
        <?php 
        include 'includes/sidebar.php';
         ?>

    </div>
    <!-- /.row -->

    <hr>

    <ul class="pager">
        <?php 
        for ($i=1; $i<=$page_count; $i++) {
            if ($i == $page) {
                echo 
                '<li><a class="active_link" href="index.php?page='.$i.'">'.$i.'</a></li>';
            } else
                echo 
                '<li><a href="index.php?page='.$i.'">'.$i.'</a></li>';
        }

        ?>
    </ul>

    <?php 
    include "includes/footer.php"; 
     ?>
    
