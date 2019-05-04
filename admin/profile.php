<?php include "includes/admin_header.php"; ?>

<?php 
if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];

    $query = "SELECT * FROM users WHERE user_name = '$user_name'";
    $select_user_query = mysqli_query($connection, $query);
    confirmQuery($select_user_query);

    while ($user = mysqli_fetch_assoc($select_user_query)) {
        $user_id        = $user['user_id']; #
        $user_name      = $user['user_name'];
        $user_firstname = $user['user_firstname'];
        $user_lastname  = $user['user_lastname'];
        $user_role      = $user['user_role'];
        $user_password  = $user['user_password'];
        $user_email     = $user['user_email'];
        $user_image     = $user['user_image'];
    }
}

if (isset($_POST['update_profile'])) {

    $user_id        = $user_id;             #
    $user_name      = $_POST['user_name'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname  = $_POST['user_lastname'];
    $user_password  = $_POST['user_password'];
    $user_image     = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    $user_email     = $_POST['user_email'];
    // $user_role      = $_POST['user_role'];
    $updated_at     = date('d-m-y');


    if (!empty($user_image) && $user_image != '') {    
        move_uploaded_file($user_image_tmp, "../images/users/$user_image"); // New Image
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

    $query = "UPDATE users SET ";
    $query.= "user_name = '$user_name', ";
    $query.= "user_firstname = '$user_firstname', ";
    $query.= "user_lastname = '$user_lastname', ";
    $query.= "user_password = '$user_password', ";
    $query.= "user_image = '$user_image', ";
    $query.= "user_email = '$user_email', ";
    // $query.= "user_role = '$user_role', ";
    $query.= "created_at = DEFAULT ";
    $query.= "WHERE user_id = $user_id";

    $update_user_query = mysqli_query($connection, $query);
    confirmQuery($update_user_query);
        
    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_firstname'] = $user_firstname;
    $_SESSION['user_lastname'] = $user_lastname;
    // $_SESSION['user_role'] = $user_role;

    redirect('users.php?source=view_all');
}
?>

    <div id="wrapper">
        <?php include "includes/admin_navigation.php"; ?>
        
        <div id="page-wrapper">
            
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Your Profile
                        </h1>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="user_firstname">First Name</label>
                                    <input name="user_firstname" type="text" class="form-control" value="<?php echo $user_firstname; ?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="user_lastname">Last Name</label>
                                    <input name="user_lastname" type="text" class="form-control" value="<?php echo $user_lastname; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user_name">Nick Name</label>
                                <input name="user_name" type="text" class="form-control" value="<?php echo $user_name; ?>" required>
                            </div>
                            <div class="form-group">
                                <!-- <label for="user_role">Role</label> -->
                                <!-- Role select -->
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="user_password">New Password</label>
                                    <input name="user_password" type="password" class="form-control" autocomplete="off" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="user_password_c">Confirm Password</label>
                                    <input name="user_password_c" type="password" class="form-control" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user_image">Profile Picture</label>
                                <div><img width="125" src="../images/<?php echo $user_image; ?>"></div>
                                <input name="user_image" type="file">
                            </div>
                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input name="user_email" type="email" class="form-control" value="<?php echo $user_email; ?>" required>
                            </div>
                            <div class="form-group">
                                <input name="update_profile" type="submit" class="btn btn-primary" value="Update Profile">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>
