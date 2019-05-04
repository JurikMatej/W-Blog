<?PHP
showEditUser();
updateUserSubmit();
?>

<h1 class="page-header">
    Edit User
</h1>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group row">
        <div class="col-sm-6">
            <label for="user_firstname">First Name</label>
            <input name="user_firstname" type="text" class="form-control" value="<?php echo $edit_user_firstname; ?>" required>
        </div>
        <div class="col-sm-6">
            <label for="user_lastname">Last Name</label>
            <input name="user_lastname" type="text" class="form-control" value="<?php echo $edit_user_lastname; ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="user_name">Nick Name</label>
        <input name="user_name" type="text" class="form-control" value="<?php echo $edit_user_name; ?>" required>
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="user_role" class="form-control" >
            <option value="<?php echo $edit_user_role; ?>" selected><?php echo $edit_user_role; ?></option>  
            <?PHP showEditUserRoles(); ?>
        </select>
    </div>
    <div class="form-group row">
        <div class="col-sm-6">
            <label for="user_password">Password</label>
            <input name="user_password" type="password" class="form-control" autocomplete="off" required>
        </div>
        <div class="col-sm-6">
            <label for="user_password_c">Confirm Password</label>
            <input name="user_password_c" type="password" class="form-control" autocomplete="off" required>
        </div>
    </div>
    <div class="form-group">
        <label for="user_image">Profile Picture</label>
        <div><img width="125" src="../images/<?php echo $edit_user_image; ?>"></div>
        <input name="user_image" type="file">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input name="user_email" type="email" class="form-control" value="<?php echo $edit_user_email; ?>" required>
    </div>
    <div class="form-group">
        <input name="update_user" type="submit" class="btn btn-primary" value="Update User">
    </div>
</form>