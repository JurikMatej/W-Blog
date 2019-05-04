<?PHP // Update query
submitUpdateCategory();
?> 
<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Selected Category</label>

        <?PHP getEditCategory(); ?>
        <input 
            name="cat_title_updater" type="text" class="form-control" autocomplete="off" required
            value="<?php if(isset($cat_title)) echo $cat_title ?>"
        >
    </div>
    <div class="form-group">
        <input name="update" type="submit" class="btn btn-primary" value="Update">
    </div>
</form>