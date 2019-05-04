<?PHP 

Function authorizeAdmin() 
{
    if (!isAdmin($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
        redirect('../index.php');
    }
}




?>