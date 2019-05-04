<?php 
createUserSubmit();
?>

<h1 class="page-header">
    Add A New User
</h1>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group row">
        <div class="col-sm-6">
            <label for="user_firstname">First Name</label>
            <input name="user_firstname" type="text" class="form-control" required>
        </div>
        <div class="col-sm-6">
            <label for="user_lastname">Last Name</label>
            <input name="user_lastname" type="text" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <label for="user_name">Nick Name</label>
        <input name="user_name" type="text" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="user_role" class="form-control">
            <option value="Subscriber" selected>Select an Option..</option>
            <option value="Subscriber">Subscriber</option>
            <option value="Admin">Admin</option>
        </select>
    </div>
    <div class="form-group row">
        <div class="col-sm-6">
            <label for="user_password">Password</label>
            <input name="user_password" type="password" class="form-control" required>
        </div>
        <div class="col-sm-6">
            <label for="user_password_c">Confirm Password</label>
            <input name="user_password_c" type="password" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <label for="user_image">Profile Picture</label>
        <input name="user_image" type="file">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label required>
        <input name="user_email" type="email" class="form-control">
    </div>
    <!-- <div class="form-group">                       USER BIO
        <label for="post_content">Post Content</label>
        <textarea name="post_content" type="text" class="form-control" cols="30" rows="10"></textarea>
    </div> -->
    <div class="form-group">
        <input name="create_user" type="submit" class="btn btn-primary" value="Create New User">
    </div>
</form>