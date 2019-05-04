<?PHP 

Function authorizeAdmin() 
{
    if (!isAdmin($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
        redirect('../index.php');
    }
}

Function logoutSubmit() 
{    
    if (isset($_POST['logout'])) {
        $_SESSION['user_name']      = null;
        $_SESSION['user_firstname'] = null;
        $_SESSION['user_lastname']  = null;
        $_SESSION['user_role']      = null;

        redirect('../index');
    }
}

Function setUserName()
{
    if (isset($_SESSION['user_firstname'], $_SESSION['user_lastname'])) {
        return $user = $_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname'];
    } else{
        return "";
    }
}

?>