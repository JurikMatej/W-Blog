<?PHP 

// ================= \\
// ADD POST SECTION  \\
Function createPostSubmit()
{
    global $connection;

    if (isset($_POST['create_post'])) {

        $post_title         = $_POST['post_title'];
        $post_category_id   = $_POST['post_category_id'];
        $post_user        = $_POST['post_user'];
        $post_status        = $_POST['post_status']; 
    
        $post_image         = $_FILES['post_image']['name'];
        $post_image_temp    = $_FILES['post_image']['tmp_name']; 
    
        $post_tags          = $_POST['post_tags'];
        $post_content       = $_POST['post_content'];
    
    
        if ($post_status == '') $post_status = 'Draft';
        if (!empty($post_image) && $post_image != '') {    
            move_uploaded_file($post_image_temp, "../images/$post_image");
        } else $post_image = 'no-image.png';
    
        $query = "INSERT INTO posts ";
        $query.= "(post_title, post_category_id, post_user, post_status, post_image, post_tags, post_content) ";
        $query.= "VALUES ";
        $query.= "('$post_title', '$post_category_id', '$post_user', '$post_status', '$post_image', '$post_tags', '$post_content')";
    
        $insert_new_post_query = mysqli_query($connection, $query);
        confirmQuery($insert_new_post_query);
            
        redirect("posts.php?source=view_all");
    }
}


// ================= \\
// EDIT POST SECTION \\
Function updatePostSubmit() 
{
    global $connection;

    if (isset($_POST['update_post'])) {

        $post_id            = $_POST['post_id'];
        $post_title         = $_POST['post_title'];
        $post_category_id   = $_POST['post_category_id'];
        $post_user        = $_POST['post_user'];
        $post_status        = $_POST['post_status']; 
    
        $post_image         = $_FILES['post_image']['name'];
        $post_image_temp    = $_FILES['post_image']['tmp_name']; 
    
        $post_tags          = $_POST['post_tags'];
        $post_content       = $_POST['post_content'];
        $post_date          = date('d-m-y');
    
    
        if ($post_status == '') $post_status = 'Draft';
        if (!empty($post_image) && $post_image != '') {    
            move_uploaded_file($post_image_temp, "../images/$post_image");
        } else { // get current image in DB
            $query = "SELECT * FROM posts ";
            $query.= "WHERE post_id = $post_id";
            $select_image = mysqli_query($connection, $query);
            confirmQuery($select_image);
    
            $post = mysqli_fetch_assoc($select_image);
            $post_image = $post['post_image'];
        }
    
        $query = "UPDATE posts SET ";
        $query.= "post_title = '$post_title', ";
        $query.= "post_category_id = '$post_category_id', ";
        $query.= "post_user = '$post_user', ";
        $query.= "post_status = '$post_status', ";
        $query.= "post_image = '$post_image', ";
        $query.= "post_tags = '$post_tags', ";
        $query.= "post_content = '$post_content', ";
        $query.= "post_date = '$post_date' ";
        $query.= "WHERE post_id = $post_id";
    
        $insert_new_post_query = mysqli_query($connection, $query);
        confirmQuery($insert_new_post_query);
    
        redirect('posts.php?source=view_all');
    }
}


// ================= \\
// SHOW POST SECTION \\
Function showAllPosts()
{
    global $connection;

    $query = "SELECT posts.post_id, posts.post_user, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
    $query.= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";
    $query.= "FROM posts ";
    $query.= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ";
    $query.= "ORDER BY post_id DESC";

    $select_all_posts_query = mysqli_query($connection, $query);
    confirmQuery($select_all_posts_query);

    while ($post = mysqli_fetch_assoc($select_all_posts_query)) {
        $post_id    = $post['post_id'];
        $post_user = $post['post_user'];  
        $post_user  = $post['post_user'];
        $post_title = $post['post_title'];    
        $post_category = $post['post_category_id'];    
        $post_status = $post['post_status'];    
        $post_image = $post['post_image'];    
        $post_tags = $post['post_tags'];     
        $post_date = $post['post_date'];    
        $post_views = $post['post_views_count'];    
        $cat_id = $post['cat_id'];    
        $cat_title = $post['cat_title'];    

        // Get comment count based on number of rows 
        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
        $comments_query = mysqli_query($connection, $query);
        $comment_count = mysqli_num_rows($comments_query);
        $comment_id = mysqli_fetch_assoc($comments_query)['comment_id'];

        if (isset($post_user) && !empty($post_user)) {
            $author = $post_user;
        } 
        
        echo
        '<tr>
            <td><input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value="'.$post_id.'"></td>
            <td>'.$post_id.'</td>
            <td>'.$author.'</td>
            <td>'.$post_title.'</td>

            <td>'.$cat_title.'</td>
        
            <td>'.$post_status.'</td>
            <td><img  width="100" height="50" src="../images/'.$post_image.'"></td>
            <td>'.$post_tags.'</td>
            <td><a href="post_comments.php?id='.$post_id.'">'.$comment_count.'</a></td>
            <td>'.$post_date.'</td>
            <td><a onclick="return confirm(\'Do you really want to nuliffy the view counter of this post ?\');" href="posts.php?reset='.$post_id.'">'.$post_views.'x</a></td>
            <td><a class="btn btn-default" href="../post.php?post_id='.$post_id.'">View Post</a></td>
            <td><a class="btn btn-info" href="posts.php?source=edit_post&post_id='.$post_id.'"> Edit </a></td>

            <td class="delete_link"><input id="btnDel" type="BUTTON" value="Delete" class="btn btn-danger" rel="'.$post_id.'" ></td>                                     
        </tr>';

    }
}


Function showPostCategories()
{
    global $connection;

    $query = "SELECT * FROM categories";
    $select_all_categories_query = mysqli_query($connection, $query);
    confirmQuery($select_all_categories_query);

    while ($category = mysqli_fetch_assoc($select_all_categories_query)) {
        $cat_id = $category['cat_id'];
        $cat_title = $category['cat_title'];

        echo
        '<option value="'.$cat_id.'">'.$cat_title.'</option>';
    }
}


Function showPostUsers() 
{
    global $connection;

    $query = "SELECT * FROM users";
    $select_all_users_query = mysqli_query($connection, $query);
    confirmQuery($select_all_users_query);

    while ($category = mysqli_fetch_assoc($select_all_users_query)) {
        $user_id = $category['user_id'];
        $user_name = $category['user_name'];

        echo
        '<option value="'.$user_name.'">'.$user_name.'</option>';
    }
}


Function showEditPost()
{
    global $connection;

    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
    
        $query = "SELECT * FROM posts WHERE post_id = $post_id";
        $select_post_to_edit_query = mysqli_query($connection, $query);
        confirmQuery($select_post_to_edit_query);
        
        $post = mysqli_fetch_assoc($select_post_to_edit_query);
    
        $GLOBALS['post_id']     = $post['post_id'];
        $GLOBALS['post_user']   = $post['post_user'];    
        $GLOBALS['post_title']  = $post['post_title'];    
        $GLOBALS['post_category_id'] = $post['post_category_id'];    
        $GLOBALS['post_status'] = $post['post_status'];    
        $GLOBALS['post_image']  = $post['post_image'];    
        $GLOBALS['post_tags']   = $post['post_tags'];    
        $GLOBALS['post_content'] = $post['post_content'];    
    }
}


Function showEditPostCategories()
{
    global $connection;
    global $post_category;

    $query = "SELECT * FROM categories";
    $select_all_categories_query = mysqli_query($connection, $query);
    confirmQuery($select_all_categories_query);

    while ($category = mysqli_fetch_assoc($select_all_categories_query)) {
        $cat_id = $category['cat_id'];
        $cat_title = $category['cat_title'];

        if ($post_category != $cat_id) 
            echo
            '<option value="'.$cat_id.'">'.$cat_title.'</option>';
        else 
            echo
            '<option value="'.$cat_id.'" selected>'.$cat_title.'</option>';
    }
}

Function showEditPostUsers() 
{
    global $connection;

    $query = "SELECT * FROM users";
    $select_all_users_query = mysqli_query($connection, $query);
    confirmQuery($select_all_users_query);

    while ($category = mysqli_fetch_assoc($select_all_users_query)) {
        $user_id = $category['user_id'];
        $user_name = $category['user_name'];

        echo
        '<option value="'.$user_name.'">'.$user_name.'</option>';
    }
}


Function showEditPostStatuses()
{
    global $post_status;

    switch ($post_status) {
        case 'Published':
            echo '<option value="Draft">Draft</option>';
            break;
        case 'Draft':
            echo '<option value="Published">Published</option>';
            break;
    }
}


// =================== \\
// DELETE POST SECTION \\
Function deletePostSubmit()
{
    global $connection;

    if (isset($_POST['del_submit'])) {
        $post_del_id = $_POST['delete']; 

        $query = "DELETE FROM posts ";
        $query.= "WHERE post_id = '$post_del_id'";
        $delete_post_query = mysqli_query($connection, $query);
        confirmQuery($delete_post_query);
        redirect('posts.php?source=view_all');
    }
}


// ========== \\
// ADDITIONAL \\
Function resetViewCountSubmit() 
{
    global $connection;

    if (isset($_GET['reset'])) {
        $post_del_id = $_GET['reset'];

        $query = "UPDATE posts SET post_views_count = 0 ";
        $query.= "WHERE post_id = '$post_del_id'";
        $update_postViews_query = mysqli_query($connection, $query);
        confirmQuery($update_postViews_query);
        redirect('posts.php?source=view_all');
    }
}


Function getDeleteModal()
{
    include 'includes/delete_modal.php';
}


Function bulkOptionSubmit()
{
    global $connection;

    if (isset($_POST['checkBoxArray'])) {
        foreach ($_POST['checkBoxArray'] as $selected_post_id) {
            $bulk_option = $_POST['bulk_options'];

            switch ($bulk_option) {
                // Set status to either Published or Draft
                case 'Published':
                case 'Draft':
                    $query = "UPDATE posts SET post_status = '$bulk_option' ";
                    $query.= "WHERE post_id = '$selected_post_id'";

                    $update_post_status_query = mysqli_query($connection, $query);
                    confirmQuery($update_post_status_query);
                    break;               
                    
                // Mass Delete
                case 'Delete':
                    $post_del_id = $selected_post_id;

                    $query = "DELETE FROM posts ";
                    $query.= "WHERE post_id = '$post_del_id'";
                    $delete_post_query = mysqli_query($connection, $query);
                    confirmQuery($delete_post_query);
                    break;

                case 'Clone':
                    $query = "SELECT * FROM posts WHERE post_id = $selected_post_id ";
                    $select_post_query = mysqli_query($connection, $query);
                    confirmQuery($select_post_query);

                    while ($post = mysqli_fetch_assoc($select_post_query)) {
                        $post_id        = $post['post_id'];
                        $post_title     = $post['post_title'];
                        $post_category_id = $post['post_category_id'];
                        $post_date      = $post['post_date'];
                        $post_user    = $post['post_user'];
                        $post_status    = $post['post_status'];
                        $post_image     = $post['post_image'];
                        $post_tags      = $post['post_tags'];
                        $post_content   = $post['post_content'];
                    }

                    $query = "INSERT INTO posts(post_title, post_category_id, post_user, post_status, post_image, post_tags, post_content, post_date) ";
                    $query.= "VALUES ('$post_title', '$post_category_id','$post_user', '$post_status', '$post_image', '$post_tags', '$post_content', '$post_date')";
                    $insert_post_query = mysqli_query($connection, $query);
                    confirmQuery($insert_post_query);
                    break;

            }
        }
    }
}

?>