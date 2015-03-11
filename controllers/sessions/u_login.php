<?

use lib\session\Session;
use lib\environment\Environment;
use models\logs\Logs;
use helpers\notice\NoticeHelper;

function u_login() {

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $valid = Session::validateLogin($username, $password);

    if ($valid) {

        Logs::create('login', Session::get('id'), Environment::get('REMOTE_ADDR'), "");

        header('Location: /');

    } else {

        Logs::create('failed_login', null, Environment::get('REMOTE_ADDR'), "Username: $username, Password: $password");

        NoticeHelper::set('error', 'username/password inválidos');

        header('Location: /login');


    }
}

?>
