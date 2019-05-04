<?PHP createPostSubmit(); ?>

<h1 class="page-header">
    Add a Post
</h1>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input name="post_title" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_cat_id">Post Category</label>
        <select name="post_category_id" class="form-control" required>
            <option value="" disabled>Select a Category..</option>
            <?PHP showPostCategories(); ?>

        </select>
    </div>

    <div class="form-group">
        <label for="post_user">Post Users</label>
        <select name="post_user" class="form-control" required>
            <option value="" disabled>Select an User..</option>
            <?PHP showPostUsers(); ?>

        </select>
    </div>

    <!-- <div class="form-group">
        <label for="post_user">Post Author</label>
        <input name="post_user" type="text" class="form-control">
    </div> -->
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="" class="form-control">
            <option value="Draft">Select an Option..</option>
            <option value="Published">Published</option>
            <option value="Draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input name="post_image" type="file">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input name="post_tags" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" type="text" id="editor" class="form-control" cols="30" rows="10"></textarea>
    </div>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

    <div class="form-group">
        <input name="create_post" type="submit" class="btn btn-primary" value="Publish Post">
    </div>
</form>