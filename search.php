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
        if (isset($_POST['submit'])) {
            $search = $_POST['search'];

            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
            $search_query = mysqli_query($connection, $query);
            if (!$search_query) {
                exit('Search query failed (' . mysqli_error($connection) . ')');
            }

            $count = mysqli_num_rows($search_query);
            if ($count == 0) {
                echo '<h2>No results for: "<em>'.$search.' </em>"</h2>';
            } else {
                while ($post = mysqli_fetch_assoc($search_query)) {
                    $post_id    =   $post['post_id'];
                    $post_title =   $post['post_title'];
                    $post_user =  $post['post_user'];
                    $post_date =    $post['post_date'];
                    $post_image =   $post['post_image'];
                    $post_content = substr($post['post_content'], 0, 200);
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
    
