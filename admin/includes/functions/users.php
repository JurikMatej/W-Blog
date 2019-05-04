<?PHP 

// ================= \\
// SHOW USER SECTION \\
Function showAllUsers() 
{
    global $connection;

    $query = "SELECT * FROM users ORDER BY user_id DESC";
    $select_all_users_query = mysqli_query($connection, $query);
    confirmQuery($select_all_users_query);

    while ($user = mysqli_fetch_assoc($select_all_users_query)) {
        $user_id        = $user['user_id'];
        $user_name      = $user['user_name'];
        $user_firstname = $user['user_firstname'];
        $user_lastname  = $user['user_lastname'];    
        $user_email     = $user['user_email'];
        $user_role      = $user['user_role'];       
        $created_at     = $user['created_at'];    

        echo 
        '<tr>
            <td>'.$user_id.'</td>
            <td>'.$user_name.'</td>
            <td>'.$user_firstname.'</td>
            <td>'.$user_lastname.'</td>
            <td>'.$user_email.'</td>
            <td>'.$user_role.'</td>
            <td>'.$created_at.'</td>
            <td><a class="btn btn-default" href="users.php?source=view_all&change=Subscriber&user='.$user_id.'">Make Subscriber</a></td>
            <td><a class="btn btn-default" href="users.php?source=view_all&change=Admin&user='.$user_id.'">Make Admin</a></td>
            <td><a class="btn btn-info" href="users.php?source=edit_user&edit='.$user_id.'">Edit</a></td>
            <td><a class="btn btn-danger" href="users.php?source=view_all&delete='.$user_id.'">Delete</a></td>
        </tr>';
    }
}


Function changeRoleSubmit() 
{
    global $connection;

    if (isset($_GET['change'])) {
        $user_update_id = $_GET['user'];
        $user_update_role = $_GET['change'];

        $query = "UPDATE users SET ";
        $query.= "user_role = '$user_update_role' ";
        $query.= "WHERE user_id = '$user_update_id'";

        $change_user_role_query = mysqli_query($connection, $query);
        confirmQuery($change_user_role_query);
        
        redirect('users.php?source=view_all');
    }

}


Function deleteUserSubmit()
{

    global $connection;

    if (isset($_GET['delete'])) {
        if (isAdmin()) {
            $user_del_id = $_GET['delete'];

            $query = "DELETE FROM users ";
            $query.= "WHERE user_id = '$user_del_id'";

            $delete_user_query = mysqli_query($connection, $query);
            confirmQuery($delete_user_query);
            
            redirect('users.php?source=view_all');
        }
    }
}


// =================== \\
// CREATE USER SECTION \\
Function createUserSubmit() 
{
    global $connection;

    if (isset($_POST['create_user'])) {

        $user_name      = $_POST['user_name'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname  = $_POST['user_lastname'];    
        $user_password  = $_POST['user_password']; 
        $user_image     = $_FILES['user_image']['name'];
        $user_image_tmp = $_FILES['user_image']['tmp_name'];
        $user_email     = $_POST['user_email'];
        $user_role      = $_POST['user_role'];        
    
        // hashing password
        $user_password = password_hash(
            $user_password,
            PASSWORD_BCRYPT, 
            ['cost' => 10]
        );
    
        if (!empty($user_image) && $user_image != '') {    
            move_uploaded_file($user_image_tmp, "../images/users/$user_image");
        } else $post_image = 'no-image.png';
    
        $query = "INSERT INTO users ";
        $query.= "(user_name, user_firstname, user_lastname, user_password, user_image, user_email, user_role) ";
        $query.= "VALUES ";
        $query.= "('$user_name', '$user_firstname', '$user_lastname', '$user_password', '$user_image', '$user_email', '$user_role')";
    
        $insert_new_user_query = mysqli_query($connection, $query);
        confirmQuery($insert_new_user_query);
            
        redirect('users.php?source=view_all');
    }
}


// ================= \\
// EDIT USER SECTION \\
Function showEditUser() 
{
    global $connection;

    if (!isset($_GET['edit'])) { 
        redirect('index.php');
    } 
    // load all info about the user to be edited
    $user_edit_id = $_GET['edit'];
    
    $query = "SELECT * FROM users ";
    $query.= "WHERE user_id = $user_edit_id";
    
    $select_edit_user = mysqli_query($connection, $query);
    confirmQuery($select_edit_user);
    
    while ($user = mysqli_fetch_assoc($select_edit_user)) {
        $GLOBALS['edit_user_name']      = $user['user_name'];
        $GLOBALS['edit_user_firstname'] = $user['user_firstname'];
        $GLOBALS['edit_user_lastname']  = $user['user_lastname'];    
        $GLOBALS['edit_user_email']     = $user['user_email'];
        $GLOBALS['edit_user_role']      = $user['user_role'];       
        $GLOBALS['edit_user_password']  = $user['user_password'];
        $GLOBALS['edit_user_image']     = $user['user_image'];
    }
}


Function showEditUserRoles() 
{
    global $edit_user_role;

    if ($edit_user_role == 'Admin')
        echo 
        '<option value="Subscriber">Subscriber</option>';
    else 
        echo 
        '<option value="Admin">Admin</option>';
}


Function updateUserSubmit()
{
    global $connection;

    if (isset($_POST['update_user']) && isset($_GET['edit'])) {

        $user_id        = $_GET['edit'];
        $user_name      = $_POST['user_name'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname  = $_POST['user_lastname'];    
        $user_password  = $_POST['user_password']; 
        $user_image     = $_FILES['user_image']['name'];
        $user_image_tmp = $_FILES['user_image']['tmp_name'];
        $user_email     = $_POST['user_email'];
        $user_role      = $_POST['user_role'];  
        $updated_at     = date('d-m-y');      


        if (!empty($user_image) && $user_image != '') {    
            // New Image
            move_uploaded_file($user_image_tmp, "../images/users/$user_image"); 
        } else {
            // Get current image from DB
            $query = "SELECT * FROM users ";
            $query.= "WHERE user_id = $user_id";
            $select_image_query = mysqli_query($connection, $query);
            confirmQuery($select_image_query);

            $user = mysqli_fetch_assoc($select_image_query);
            $user_image = $user['user_image']; // Default Image
        }

        if (!empty($user_password)) {
            $query = "SELECT user_password FROM users WHERE user_id = $user_id";
            $select_pw_query = mysqli_query($connection, $query);
            confirmQuery($select_pw_query);

            $db_password = mysqli_fetch_assoc($select_pw_query)['user_password'];
            if ($user_password != $db_password) {
                $user_password = password_hash($user_password, PASSWORD_BCRYPT, ['cost' => 10]);
            }
        }


        // Update 
        $query = "UPDATE users SET ";
        $query.= "user_name = '$user_name', ";
        $query.= "user_firstname = '$user_firstname', ";
        $query.= "user_lastname = '$user_lastname', ";
        $query.= "user_password = '$user_password', ";
        $query.= "user_image = '$user_image', ";
        $query.= "user_email = '$user_email', ";
        $query.= "user_role = '$user_role', ";
        $query.= "created_at = DEFAULT ";
        $query.= "WHERE user_id = $user_id";

        $update_user_query = mysqli_query($connection, $query);
        confirmQuery($update_user_query);
            
        redirect('users.php?source=view_all');
    }
}



?>