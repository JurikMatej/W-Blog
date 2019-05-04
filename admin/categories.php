<?php include "includes/admin_header.php"; ?>
    
    <div id="wrapper">
        <?php include "includes/admin_navigation.php"; ?>
        
        <div id="page-wrapper">
            
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Categories
                        </h1>
                         
                        <div class="col-xs-6">

                            <?php insertCategories(); // @$_POST['submit'] ?> 
                            <?php deleteCategories(); // @$_GET['delete']  ?>
                            
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat-title">Add a Category</label>
                                    <input name="cat_title" type="text" class="form-control" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <input name="submit" type="submit" class="btn btn-primary" value="Submit">
                                </div>

                            </form>
                            
                            <?php  // update section
                            if (isset($_GET['edit'])) {
                                include "includes/update_categories.php";
                            }
                            ?>
                        </div> <!-- /Add category div -->  
                        
                        <div class="col-xs-6">

                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr class="info">
                                        <th>Id</th>
                                        <th>Category Title</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php // Find all categories query
                                        showCategories();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>
