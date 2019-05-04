<?PHP

// ===================== \\
// SHOW COMMENTS SECTION \\
Function showAllComments() 
{
    global $connection;

    $query = "SELECT * FROM comments ORDER BY comment_id DESC";
    $select_all_comments_query = mysqli_query($connection, $query);
    confirmQuery($select_all_comments_query);

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
        confirmQuery($select_comment_post_query);


        if (mysqli_num_rows($select_comment_post_query) > 0) {
            $post = mysqli_fetch_assoc($select_comment_post_query);
            $comment_response_title = $post['post_title'];
            $in_response_to = '<td><a href="../post.php?post_id='.$comment_post_id.'">'.$comment_response_title.'</a></td>';
        } else {
            $comment_response_title = "Post Deleted!";
            $in_response_to = '<td>'.$comment_response_title.'</td>';
        }

        echo 
        '<tr>
            <td>'.$comment_id.'</td>
            <td>'.$comment_author.'</td>
            <td>'.$comment_post_id.'</td>
            <td>'.$comment_email.'</td>
            <td>'.$comment_status.'</td>
            <td>'.$comment_date.'</td>
            '   .$in_response_to.   '
            <td><a class="btn btn-default" href="comments.php?approve='.$comment_id.'">Approve</a></td>
            <td><a class="btn btn-default" href="comments.php?unapprove='.$comment_id.'">Unapprove</a></td>
            <td><a class="btn btn-danger" href="comments.php?delete='.$comment_id.'">Delete</a></td>
        </tr>';
    }
}


// ======================= \\
// UPDATE COMMENTS SECTION \\
Function commentApprovalSubmit() 
{
    global $connection;

    if (isset($_GET['approve'])) {
        $comment_approve_id = $_GET['approve'];

        $query = "UPDATE comments SET ";
        $query.= "comment_status = 'Approved' ";
        $query.= "WHERE comment_id = '$comment_approve_id'";

        $approve_comment_query = mysqli_query($connection, $query);
        confirmQuery($approve_comment_query);
        
        redirect('comments.php?source=view_all');
    }

    if (isset($_GET['unapprove'])) {
        $comment_unapprove_id = $_GET['unapprove'];

        $query = "UPDATE comments SET ";
        $query.= "comment_status = 'Unapproved' ";
        $query.= "WHERE comment_id = '$comment_unapprove_id'";

        $unapprove_comment_query = mysqli_query($connection, $query);
        confirmQuery($unapprove_comment_query);
        
        redirect('comments.php?source=view_all');
    }
}


// ======================= \\
// DELETE COMMENTS SECTION \\
Function deleteCommentSubmit()
{
    global $connection;

    if (isset($_GET['delete'])) {
    $comment_del_id = $_GET['delete'];

    $query = "DELETE FROM comments ";
    $query.= "WHERE comment_id = '$comment_del_id'";

    $delete_comment_query = mysqli_query($connection, $query);
    confirmQuery($delete_comment_query);
    
    redirect('comments.php?source=view_all');
    }
}


?>