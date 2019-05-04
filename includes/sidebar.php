<?php 

?>

<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">


<!-- Blog Search Well -->
<div class="well">
    <h4>Blog Search</h4>
    <form action="search.php" method="post">
        <div class="input-group">
            <input name="search" type="text" class="form-control">
            <span class="input-group-btn">
                <button name="submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </form>
    <!-- /.input-group -->
</div>


<!-- Login Form Well -->
<div class="well">
<?php if (isset($_SESSION['user_role'])): ?>
    <h4>Logged in as <?php echo $_SESSION['user_name'] ?></h4>
    <a class="btn btn-primary" href="includes/logout.php">Logout</a>

<?php else: ?>
    <h4>Sign In</h4>
        <form method="post">
            <div class="form-group">
                <!-- <label for="user_name">Login</label> -->
                <input name="user_name" type="text" class="form-control" placeholder="Login">
            </div>
            <div class="input-group">
                <input name="user_password" type="password" class="form-control" placeholder="Password">
                <span class="input-group-btn">
                    <button name="login" class="btn btn-primary" type="submit">
                        Sign in
                    </button>
                </span>
            </div>
            <div class="form-group">
                <a href="forgot.php?forgot=<?php echo uniqid(true);?>">Forgot your password ?</a>
            </div>
        </form>
        <!-- /.input-group -->
<?php endif; ?>
</div>





<!-- Blog Categories Well -->
<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
                <?php
                $query = "SELECT cat_id, cat_title FROM categories";
                $stmt = mysqli_prepare($connection, $query);
                confirmQuery($stmt);
              
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);

                
                
                while ($category = mysqli_stmt_fetch($stmt)) {
                    // $cat_title = $category['cat_title'];
                    // $cat_id    = $category['cat_id'];

                    echo 
                    '<li>
                        <a href="category.php?category='.$cat_id.'">'.$cat_title.'</a>
                    </li>';
                }
                ?>
            </ul>
        </div>       
        
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<?php include 'includes/widget.php' ?>

</div>