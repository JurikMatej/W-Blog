<?PHP 

// ========================= \\
// UPDATE CATEGORIES SECTION \\
Function getEditCategory()
{
    global $connection;

    if (isset($_GET['edit'])) {
        $cat_edit_id = $_GET['edit'];
        $query = "SELECT cat_id, cat_title FROM categories ";
        $query.= "WHERE cat_id = (?)";
        
        $stmt = mysqli_prepare($connection, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $cat_edit_id);
            mysqli_stmt_execute($stmt);
            confirmQuery($stmt);
            
            mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);
        }

        $category = mysqli_stmt_fetch($stmt);

        $GLOBALS['cat_id']  = $cat_id;
        $GLOBALS['cat_title'] = $cat_title;
    }
}


Function submitUpdateCategory()
{
    global $connection;
    
    $cat_edit_id = $_GET['edit'];

    if (isset($_POST['update'])) {
        $cat_edit_title = $_POST['cat_title_updater'];

        $query = "UPDATE categories ";
        $query.= "SET cat_title = '$cat_edit_title' "; 
        $query.= "WHERE cat_id = '$cat_edit_id'";

        $update_category_query = mysqli_query($connection, $query);
        confirmQuery($update_category_query);
        redirect('categories.php');
    }
    
}




?>