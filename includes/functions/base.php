<?PHP

/**
 * Users online functionality for
 * AJAX $.get() call 
 * 
 * Based on the 'time()' function
 */
function users_online() {

    if (isset($_GET['onlineusers'])) {

        global $connection;

        if (!$connection) {
            session_start();
            include '../includes/db.php';

        }

        $session = session_id(); 
        $time    = time();
        $time_out_in_seconds = 60;          
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'"; 
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

        // new user insert or already set user update
        if ($count == NULL) {
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session', '$time') ");
        } else {
            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");     
        }

        // filter users active in past 60 seconds
        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        $count = mysqli_num_rows($users_online_query);

        echo $count;
    }
}

users_online(); // AJAX required function call for 'Users Online:' functionality

/**
 * Add a new category in
 * 'categories.php'
 */
function insertCategories() {
    global $connection;

    if (isAdmin()) {
        if (isset($_POST['submit'])) {
            $cat_title = $_POST['cat_title'];
            $cat_author = $_SESSION['user_name'];
            if (!empty($cat_title) && $cat_title != "") {
                $query = "INSERT INTO categories(cat_author, cat_title) VALUES (?, ?) ";

                $stmt = mysqli_prepare($connection, $query);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'ss', $cat_author, $cat_title);
                    mysqli_stmt_execute($stmt);
                    confirmQuery($stmt);
                    mysqli_stmt_free_result($stmt);
                }  
            } 
        }
    }
}

/**
 * Delete functionality for categories
 * in 'categories.php'
 */
function deleteCategories() {
    global $connection;

    if (isset($_GET['delete'])) {
        $cat_del_id = $_GET['delete'];

        $query = "DELETE FROM categories ";
        $query.= "WHERE cat_id = '$cat_del_id'";
        $delete_category_query = mysqli_query($connection, $query);
        if (!$delete_category_query) 
            exit("Query failed (" . mysqli_error($connection) . ")");
        header('Location: categories.php');
    }
    
}


/**
 * Echo out all the categories to the
 * 'categories.php' section
 */
function showCategories() {
    global $connection;

    $query = "SELECT * FROM categories";
    $select_all_categories_query = mysqli_query($connection, $query);
    if (!$select_all_categories_query) 
        exit("Query failed (" . mysqli_error($connection) . ")");

    while ($category = mysqli_fetch_assoc($select_all_categories_query)) {
        $cat_id    = $category['cat_id'];
        $cat_title = $category['cat_title'];

        echo 
            '<tr>
                <td>'.$cat_id.'</td>
                <td>'.$cat_title.'</td>
                <td>
                    <a class="btn btn-info" href="categories.php?edit='.$cat_id.'">Edit</a>
                </td>
                <td>
                    <a class="btn btn-danger" href="categories.php?delete='.$cat_id.'">Delete</a>
                </td>
            </tr>';
    }
}


/**
 * Get the total number of records in a specific
 * table
 */

function recordCount($Tname) {
    $query = "SELECT * FROM " . $Tname;
    $select_records_query = SQLquery($query);
    confirmQuery($select_records_query);

    $result = countRecords($select_records_query);

    return $result;
}
/**
 * User specific total number of records in 
 * a given table
 */
function userRecordCount($Tname) {
    if (isAdmin()) {
        switch ($Tname) {
            case 'posts':
                $post_user = $_SESSION['user_name'];

                $query = "SELECT * FROM posts WHERE post_user = '$post_user'";
                $select_records_query = SQLquery($query);
                confirmQuery($select_records_query);

                $result = countRecords($select_records_query);

                return $result;
                break;

            case 'comments':
                $post_user = $_SESSION['user_name'];

                $query = "SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id ";
                $query.= "WHERE post_user = '$post_user' ";
                $select_records_query = SQLquery($query);
                confirmQuery($select_records_query);

                $result = countRecords($select_records_query);

                return $result;
                break;

            case 'categories':
                $cat_author = $_SESSION['user_name'];
                $query = "SELECT * FROM categories WHERE cat_author = '$cat_author'";
                $select_records_query = SQLquery($query);
                confirmQuery($select_records_query);

                $result = countRecords($select_records_query);

                return $result;
                break;  
        }
    return null;

        
    }
}

function confirmQuery($resulted_query) {
    global $connection;

    if (!$resulted_query) {
        exit('Query failed (' . mysqli_error($connection) . ')');
    }
}

function isAdmin() {
    global $connection;

    if (isLoggedIn()) {
        $query = "SELECT user_role FROM users WHERE user_id = '".$_SESSION['user_id']."' ";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);

        $user = fetchRecords($result);
        if ($user['user_role'] == 'Admin') {
            return true;
        }
    }
    return false;
}


function username_exists($user_name) {

    global $connection;

    $query = "SELECT user_name FROM users WHERE user_name = '$user_name'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;

}


function email_exists($user_email) {

    global $connection;

    $query = "SELECT user_email FROM users WHERE user_email = '$user_email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;

}


function redirect($uri) {
    header("Location: " . $uri);
    exit;
}

function SQLquery($query) {
    global $connection;
    return mysqli_query($connection, $query);
}

// Database helper function
function fetchRecords($result) {
    return mysqli_fetch_assoc($result);
}

function isMethod($method=null) {
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}

function isLoggedIn() {
    if (isset($_SESSION['user_role']))
        return true;
    return false;
}

function userLoggedIn_Redirect($uri) {
    if (isLoggedIn()) {
        redirect($uri);
    }
}

function userLoggedIn_GetId() {
    if (isLoggedIn()) {
        $query = "SELECT * FROM users WHERE user_name = '";
        $query.= $_SESSION['user_name'] . "'";

        $result = SQLquery($query);
        confirmQuery($result);

        $user = mysqli_fetch_assoc($result);
        return (mysqli_num_rows($result) >= 1) ? $user['user_id'] : false;
    }
}

function userLikesPost($post_id) {
    $user_id = userLoggedIn_GetId();
    $result = SQLquery("SELECT * FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'");
    confirmQuery($result);
    return (mysqli_num_rows($result) >= 1) ? true : false;
}

function getPostLikes($post_id) {
    $result = SQLquery("SELECT * FROM likes WHERE post_id = '$post_id' ");
    confirmQuery($result);
    return mysqli_num_rows($result);
}


function register_user($user_name, $user_email, $user_password) {
    global $connection;

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array(
        'cost' => 10
    ));

    $query = "INSERT INTO users";
    $query.= "(user_name, user_password, user_email, user_role) ";
    $query.= "VALUES ";
    $query.= "('$user_name', '$user_password', '$user_email', 'Subscriber') ";
    
    $register_user_query = mysqli_query($connection, $query);
    confirmQuery($register_user_query); 

}

function login_user($user_name, $user_password, $AdminURI=null) {
    global $connection;

    $login_name     = trim( mysqli_real_escape_string($connection, $user_name)     );
    $login_password = trim( mysqli_real_escape_string($connection, $user_password) );

    $query = "SELECT * FROM users WHERE user_name = '$login_name'";

    $select_user_query = mysqli_query($connection, $query);
    confirmQuery($select_user_query);

    if (mysqli_num_rows($select_user_query) == 0) {
        if (empty($AdminURI)) 
            redirect('../index.php');
        else 
            redirect('login.php?msg=e');
    }

    while ($user = mysqli_fetch_assoc($select_user_query)) {
        $user_id = $user['user_id'];
        $user_name = $user['user_name'];
        $user_firstname = $user['user_firstname'];
        $user_lastname = $user['user_lastname'];
        $user_password = $user['user_password'];
        $user_role = $user['user_role'];
        // $salt      = $user['randSalt'];
    }

    // $login_password = crypt($login_password, $salt);

    if (password_verify($login_password, $user_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_firstname'] = $user_firstname;
        $_SESSION['user_lastname'] = $user_lastname;
        $_SESSION['user_role'] = $user_role;

        if (empty($AdminURI))
            redirect('../admin/');
        else 
            redirect($AdminURI);
    } else {
        redirect('../index.php');

    }
}


function getUsername() {
    return ( isset( $_SESSION['user_name'] ) ) ? $_SESSION['user_name'] : null;
}

function getUserSpecificPosts() {
    $user_id = userLoggedIn_GetId();
    SQLquery("SELECT * FROM posts WHERE user_id = '$user_id' ");


}

function countRecords($result) {
    return mysqli_num_rows($result);
}

?>