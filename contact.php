<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php 
if (!isset($_POST['submit'])) {
    $message = null;
    $msgclass = null;    
} else {
    $to = mysqli_real_escape_string($connection, 'wimko.kun@gmail.com');
    $subject = mysqli_real_escape_string($connection, $_POST['subject']);
    $body = wordwrap(mysqli_real_escape_string($connection, $_POST['body']), 70);
    $header = 'From: ' . $_POST['email'];

    try {
        mail($to, $subject, $body, $header);
        $message = 'Mail sent.';
        $msgclass = 'alert alert-success';
    } catch (Exception $e) {
        $message = 'Your mail could not be sent.';
        $msgclass = 'alert alert-danger';
    }
}   
?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact Page</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                        <h4 class="<?php echo $msgclass; ?>"><?php echo $message; ?></h4>
                        
                        <div class="form-group">
                            <h4><label for="email" >Email</label></h4>
                            <input type="email" name="email" id="email" class="form-control input-lg" placeholder="...">
                        </div>
                        <div class="form-group">
                            <h4><label for="subject" >Subject</label></h4>
                            <input type="text" name="subject" id="subject" class="form-control input-lg" placeholder="...">
                        </div>
                        <div class="form-group">
                            <h4><label for="body"  class="">Content</label></h4>
                            <textarea class="form-control input-lg" name="body" cols="30" rows="10" placeholder="..."></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
