<?php include "includes/admin_header.php"; ?>
    
    <div id="wrapper">
        <?php include "includes/admin_navigation.php"; ?>
        
        <div id="page-wrapper">
            
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $source = (isset($_GET['source']))  ?  $_GET['source']  :  '';
                        switch ($source) {
                            case 'add_post':
                                include 'includes/add_post.php';
                                break;

                            case 'view_all':
                                include 'includes/view_all_posts.php';
                                break;

                            case 'edit_post':
                                include 'includes/edit_post.php';
                                break;

                            default:
                                include 'includes/view_all_posts.php';
                                break;
                        }
                        ?>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php"; ?>
