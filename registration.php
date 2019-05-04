<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php 
// Setting language variables

if (isset($_GET['lang'])) {
    $langs = [
        'en',
        'sk'
    ];
    
    $_SESSION['lang'] = $_GET['lang'];

    if (!in_array($_SESSION['lang'], $langs)) {
        redirect("registration?lang=en");
    } else {
        switch (isset($_SESSION['lang'])) {
            case true: 
                @include "includes/languages/" . $_SESSION['lang'] . ".php";
                break;

            case false:
                @include "includes/languages/en.php";
                break;
        }
    }
}

$options = array(
    'cluster' => 'eu',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
    getenv('APP_KEY'),
    getenv('APP_SECRET'),
    getenv('APP_ID'),
    $options
);


if (!isset($_POST['submit'])) {
    $message = null;
} else {
    $user_name = trim(mysqli_real_escape_string($connection, $_POST['username']));
    $user_password = trim(mysqli_real_escape_string($connection, $_POST['password']));
    $user_email = trim(mysqli_real_escape_string($connection, $_POST['email']));

    $error = [
        'user_name' => '',
        'user_email' => '',
        'user_password' => ''
    ];

    if (strlen($user_name) < 4) {
        $error['user_name'].= 'Username must be at least 4 characters long! <br>';
    }

    if ($user_name == '') {
        $error['user_name'].= 'Username field cannot be empty! <br>';
    }

    if (username_exists($user_name)) {
        $error['user_name'].= "Username already taken! <br>";
    }

    if ($user_email == '') {
        $error['user_email'].= 'User email field cannot be empty! <br>';
    }

    if (email_exists($user_email)) {
        $error['user_email'].= "Email specified is already taken by an existing account! <br>";
    }

    if ($user_password == '') {
        $error['user_password'].= 'User password field cannot be empty! <br>';
    }

    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);    
        }   

        if (empty($error)) {
            register_user($user_name, $user_email, $user_password);
            
            // Pusher notifications
            $data['message'] = $user_name;
            $pusher->trigger('notifications', 'new user', $data);


            // login_user($user_name, $user_password);
        }

    }

}


?>

<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

<form class="navbar-form navbar-right" method="get" id="lang">
    <div class="form-group">
        <label for="lang">Select language </label>
        <select name="lang" class="form-control" onchange="changeLanguage()">
            <option value="en" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') ? 'selected' : '' ;?>>English</option>
            <option value="sk" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] == 'sk') ? 'selected' : '' ;?>>Slovak</option>
        </select>
    </div>
</form>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1><?PHP echo _REGISTER; ?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <!-- <h4 class="<?php // echo $msgclass; ?>"><?php // echo $message; ?></h4> -->
                        <div style="margin-bottom: 17px;" class="form-group ">
                            <h4><label for="username" class=""><?PHP echo _USERNAME_LABEL; ?></label></h4>
                            <input type="text" name="username" id="username" class="form-control input-lg" placeholder="<?PHP echo _USERNAME; ?>"
                                autocomplete="on" value="<?php echo isset($user_name) ? $user_name : '' ?>">
                        </div>
                        <p class="text-center <?php echo (isset($error['user_name']) && $error['user_name'] != '') ? 'alert alert-danger' : ''; ?>">
                            <?php echo isset($error['user_name']) ? $error['user_name'] : '' ?>
                        </p>

                        <div style="margin-bottom: 17px;" class="form-group " >
                            <h4><label for="email" class=""><?PHP echo _EMAIL_LABEL; ?></label></h4>
                            <input type="email" name="email" id="email" class="form-control input-lg" placeholder="<?PHP echo _EMAIL; ?>"
                                autocomplete="on" value="<?php echo isset($user_email) ? $user_email : '' ?>">
                        </div>
                        <p class="text-center <?php echo (isset($error['user_email']) && $error['user_email'] != '') ? 'alert alert-danger' : ''; ?>">
                            <?php echo isset($error['user_email']) ? $error['user_email'] : '' ?>
                        </p>
                        
                        <div style="margin-bottom: 17px;" class="form-group ">
                            <h4><label for="password" class=""><?PHP echo _PASSWORD_LABEL; ?></label></h4>
                            <input type="password" name="password" id="key" class="form-control input-lg" placeholder="<?PHP echo _PASSWORD; ?>">
                        </div>
                        <p class="text-center <?php echo (isset($error['user_password']) && $error['user_name'] != '') ? 'alert alert-danger' : ''; ?>">
                            <?php echo isset($error['user_password']) ? $error['user_password'] : '' ?>
                        </p>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="<?PHP echo _SUBMIT; ?>">
                    </form>
                
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


<hr>



<?php include "includes/footer.php";?>

<script>

function changeLanguage() {
    document.getElementById('lang').submit();
}

</script>