<?

use lib\session\Session;
use lib\environment\Environment;
use models\logs\Logs;
use models\accounts\Accounts;


function u_admin_register() {
    
    //session: admin
    Session::validateSession(true);
    Session::validateXSRFToken();
    
    $username = isset($_POST['playername']) ? $_POST['playername'] : NULL;

    $email = isset($_POST['email']) ? $_POST['email'] : NULL;

    $status = Accounts::register($username, $email, $email_ip = false);
    
    if (!$status) {

        $adminame = Session::get('username');
        Logs::create('admin_register', null, Environment::get('REMOTE_ADDR'), "New user registration by $adminname: $username / $email");

        header("Location: /admin/register");

    } else {

        header("Location: /admin/register");

    }
}

?>
