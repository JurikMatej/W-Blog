<?php include "includes/admin_header.php"; ?>

    <?php 
    if (!isAdmin($_SESSION['user_name'])) {
        redirect('index.php');
    }
    ?>

    

    
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
                            case 'view_all':
                                include 'includes/view_users.php';
                                break;

                            case 'add_user':
                                include 'includes/add_user.php';
                                break;
                            
                            case 'edit_user':
                                include 'includes/edit_user.php';
                                break;

                            default:
                                include "includes/view_users.php";
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
