<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="color: #efefef" href="index">Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection, $query);
                while ($category = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_title = $category['cat_title'];
                    $cat_id = $category['cat_id'];

                    $category_class = '';
                    $registration_class = '';
                    $contact_class = '';
                    $login_class = '';

                    $pagename = basename($_SERVER['PHP_SELF']);
                    $registration = 'registration.php';
                    $contact = 'contact.php';
                    $login = 'login.php';

                    if (isset($_GET['category']) && $_GET['category'] == $cat_id ) {
                        $category_class = 'active';
                    } elseif ($pagename == $registration) {
                        $registration_class = 'active';
                    } elseif ($pagename == $contact) {
                        $contact_class = 'active';
                    } elseif ($pagename == $login) {
                        $login_class = 'active';
                    }

                    // echo
                    '<li class="'.$category_class.'">
                        <a href="#">'.$cat_title.'</a>
                    </li>';
                }
                 ?>
                 <li class="<?php echo $contact_class; ?>">
                    <a href="contact">Contact</a>
                </li>

                <?php if (!isLoggedIn()): ?>
                    <li class="<?php echo $login_class; ?>">
                        <a href="login">Login</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="admin">Admin</a>
                    </li>
                <?php endif; ?>

                <li class="<?php echo $registration_class; ?>">
                    <a href="registration.php?lang=en">Register</a>
                </li>

                

                
                

                <?php // Do if admin is logged in 
                if (isset($_SESSION['user_role']) ) {
                    if (isset($_GET['post_id']) && isAdmin($_SESSION['user_name'])) { 
                        $source = 'edit_post';
                        $id     = $_GET['post_id'];

                        echo 
                        '<li>
                            <a href="admin/posts.php?source='.$source.'&post_id='.$id.'">Edit Post</a>
                        </li>';
                    }
                }
                ?>
                    
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>