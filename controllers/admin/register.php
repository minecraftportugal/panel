<?

use lib\session\Session;

function admin_register() {
    
    //session: admin
    Session::validateSession(true);
    Session::validateXSRFToken();
    
    $username = isset($_POST['playername']) ? $_POST['playername'] : NULL;
    $email = isset($_POST['email']) ? $_POST['email'] : NULL;

    $status = AccountModel::register($username, $email, $email_ip = false);
    
    if (!$status) {
        header("Location: /admin");
    } else {
        header("Location: /admin");
    }
}

?>
