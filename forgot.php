<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php require './vendor/phpmailer/phpmailer/src/PHPMailer.php'; ?>
<?php require "./classes/config.php"; ?>

<?php 

use PHPMailer\PHPMailer\PHPMailer;

$error = '';

if (!isMethod('get') && !isset($_GET['forgot'])) {
    redirect('index');
} 

if (isMethod('post')) {
    
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        

        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        if ($email == '') {
            $error = 'No account registered with specified email exists';
        } elseif (email_exists($email)) {
            $query = "UPDATE users SET token = ? WHERE user_email = ?";

            $stmt = mysqli_prepare($connection, $query);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ss', $token, $email);
                mysqli_stmt_execute($stmt);
                confirmQuery($stmt);
                mysqli_stmt_close($stmt);
                
                /**
                 * Configure PHP Mailer 
                 */

                $mail = new PHPMailer();
                
                $mail->isSMTP();
                $mail->Host = Config::SMTP_HOST; 
                $mail->Username =  Config::SMTP_USER;
                $mail->Password =  Config::SMTP_PASSWORD;
                $mail->Port = Config::SMTP_PORT;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->isHTML(true);

                /**
                 * Set mail paramaters
                 */
                $mail->setFrom(Config::USER_FROM);
                $mail->addAddress($email); // submited mail
                $mail->Subject = 'Forgotten Password';
                $mail->Body = "Sample mail body";

                try {
                    if ($mail->send()) {
                        echo "<h2 class='text-center'>Email was sent!</h2>";
                    } else {
                        echo "<h2 class='text-center'>Error! Email was not sent!</h2>";
                    }
                } catch (Error $e) {
                    echo "<h2 class='text-center'>Something went terribly wrong!</h2>";
                }

            
            } else { // Email filled in && not matching any registered users
                $error = 'No account registered with specified email exists';
            }
        }
    }
} 

?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <?php 
                                        if ($error !='') 
                                            echo '<p class="alert alert-danger">'.$error.'</p>';
                                    ?>
                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control input-lg"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- /.Body -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

