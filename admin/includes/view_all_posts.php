<?PHP 
    getDeleteModal();
    bulkOptionSubmit();
?>
<!-- Header -->
<h1 class="page-header">
    Posts
</h1>

<label for="">Bulk Options</label>

    <!-- Bulk Manager -->
<form action="" method="post">
    
    <!-- Main Content -->
    <table class="table table-bordered table-hover">
        
        <div id="bulkOptionsContainer" class="col-xs-4 form-group">
            <!-- <label for="">Bulk Options</label> -->
            <select name="bulk_options" id="" class="form-control">
                <option value="Published">Select an Option..</option>
                <option value="Published">Publish</option>
                <option value="Draft">Draft</option>
                <option value="Delete">Delete</option>
                <option value="Clone">Clone</option>
            </select>
        </div>
        <div class="col-xs-4 form-group">
            <input type="submit" name="submit_bulk" value="Apply" class="btn btn-success">
            <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
        </div>

        <thead class="thead-dark">
            <tr class="info">
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>ID</th>
                <th>User</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?PHP // Get and write out posts data
            showAllPosts();
            deletePostSubmit();
            resetViewCountSubmit();           
            ?>
        </tbody>   
    </table>
</form>

<script>
    $(document).ready(function() {
        $('.delete_link').on('click', function() {
            let id = $(this).children('#btnDel').attr('rel');
            
            $('#modal_id').val(id);

            $('#myModal').modal('show');
        });
    });
</script>