<?

use lib\session\Session;
use lib\environment\Environment;
use models\log\LogModel;
use models\account\AccountModel;


function u_admin_register() {
    
    //session: admin
    Session::validateSession(true);
    Session::validateXSRFToken();
    
    $username = isset($_POST['playername']) ? $_POST['playername'] : NULL;

    $email = isset($_POST['email']) ? $_POST['email'] : NULL;

    $status = AccountModel::register($username, $email, $email_ip = false);
    
    if (!$status) {

        $adminame = Session::get('username');
        LogModel::create('admin_register', null, Environment::get('REMOTE_ADDR'), "New user registration by $adminname: $username / $email");

        header("Location: /admin/register");

    } else {

        header("Location: /admin/register");

    }
}

?>
