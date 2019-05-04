<?php include "includes/admin_header.php"; ?>
    
    <div id="wrapper">
        <?php include "includes/admin_navigation.php"; ?>
        
        <div id="page-wrapper">
            
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12"> 
                    <h1 class="page-header">
                        Comments for post <?php echo $_GET['id']; ?>
                    </h1>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="info">
                                <th>ID</th>
                                <th>Author</th>
                                <th>Post ID</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>In Response To</th>
                                <th>Approve</th>
                                <th>Unapprove</th>
                                <th colspan="2">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = "SELECT * FROM comments WHERE comment_post_id = '".mysqli_real_escape_string($connection, $_GET['id'])."' ORDER BY comment_id DESC";
                            $select_all_comments_query = mysqli_query($connection, $query);
                            if (!$select_all_comments_query) 
                                exit("Query failed (" . mysqli_error($connection) . ")");

                            while ($comment = mysqli_fetch_assoc($select_all_comments_query)) {
                                $comment_id         = $comment['comment_id'];
                                $comment_post_id    = $comment['comment_post_id'];
                                $comment_author     = $comment['comment_author'];
                                $comment_content    = $comment['comment_content'];    
                                $comment_email      = $comment['comment_email'];
                                $comment_status     = $comment['comment_status'];    
                                // response_to is set below     
                                $comment_date       = $comment['comment_date'];    

                                // Get name of the comment's post ('In Response To')
                                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                                $select_comment_post_query = mysqli_query($connection, $query);
                                if (!$select_comment_post_query) 
                                    exit("Query failed (" . mysqli_error($connection) . ")");

                                $post = mysqli_fetch_assoc($select_comment_post_query);
                                $comment_response_title = $post['post_title'];

                                echo 
                                '<tr>
                                    <td>'.$comment_id.'</td>
                                    <td>'.$comment_author.'</td>
                                    <td>'.$comment_post_id.'</td>
                                    <td>'.$comment_email.'</td>
                                    <td>'.$comment_status.'</td>
                                    <td>'.$comment_date.'</td>
                                    <td><a href="../post.php?post_id='.$comment_post_id.'">'.$comment_response_title.'</a></td>
                                    <td><a href="post_comments.php?approve='.$comment_id.'&id='.$_GET['id'].'">Approve</a></td>
                                    <td><a href="post_comments.php?unapprove='.$comment_id.'&id='.$_GET['id'].'">Unapprove</a></td>
                                    <td><a href="post_comments.php?delete='.$comment_id.'&id='.$_GET['id'].'">Delete</a></td>
                                </tr>';
                            }
                            ?>

                            <?php 

                            if (isset($_GET['approve'])) {
                                $comment_approve_id = $_GET['approve'];

                                $query = "UPDATE comments SET ";
                                $query.= "comment_status = 'Approved' ";
                                $query.= "WHERE comment_id = '$comment_approve_id'";

                                $approve_comment_query = mysqli_query($connection, $query);
                                if (!$approve_comment_query) 
                                    echo "Query failed (" . mysqli_error($connection) . ")";
                                
                                header('Location: post_comments.php?id='. $_GET['id']);
                            }

                            if (isset($_GET['unapprove'])) {
                                $comment_unapprove_id = $_GET['unapprove'];

                                $query = "UPDATE comments SET ";
                                $query.= "comment_status = 'Unapproved' ";
                                $query.= "WHERE comment_id = '$comment_unapprove_id'";

                                $unapprove_comment_query = mysqli_query($connection, $query);
                                if (!$unapprove_comment_query) 
                                    echo "Query failed (" . mysqli_error($connection) . ")";
                                
                                header('Location: post_comments.php?id='. $_GET['id']);
                            }


                            if (isset($_GET['delete'])) {
                                $comment_del_id = $_GET['delete'];

                                $query = "DELETE FROM comments ";
                                $query.= "WHERE comment_id = '$comment_del_id'";

                                $delete_comment_query = mysqli_query($connection, $query);
                                if (!$delete_comment_query) 
                                    echo "Query failed (" . mysqli_error($connection) . ")";
                                
                                header('Location: post_comments.php?id='. $_GET['id']);
                            }
                            ?>

                        </tbody>   
                    </table>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>
