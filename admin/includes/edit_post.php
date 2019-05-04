<?PHP // Update if submited @$_POST['update_post']
updatePostSubmit();
?>


<?PHP showEditPost(); ?>

<h1 class="page-header">
    Edit Post
</h1>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input name="post_id" type="text" class="hidden" value="<?php echo $post_id; ?>">

        <label for="post_title">Post Title</label>
        <input name="post_title" type="text" class="form-control" value="<?php echo $post_title; ?>">
    </div>
    <div class="form-group">
        <label for="post_cat_id">Post Category</label>
        <select name="post_category_id" class="form-control">
            <?PHP showEditPostCategories(); ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_user">Post Users</label>
        <select name="post_user" class="form-control" required>
            <option value="" disabled>Select an User..</option>
            <?PHP showEditPostUsers(); ?>

        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="" class="form-control">
                <option value="<?php echo $post_status ?>"><?php echo $post_status ?></option>
                <?PHP showEditPostStatuses(); ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <div><img width="100" src="../images/<?php echo $post_image; ?>"></div>
        <input name="post_image" type="file">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input name="post_tags" type="text" class="form-control" value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" type="text" id="editor" class="form-control" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>
    <script>
    </script>

    <div class="form-group">
        <input name="update_post" type="submit" class="btn btn-primary" value="Update Post">
    </div>
</form>