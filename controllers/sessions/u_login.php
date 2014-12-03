<?

use lib\session\Session;
use helpers\notice\NoticeHelper;

function u_login() {

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $session = Session::validateLogin($username, $password);

    if (is_null($session)) {

        NoticeHelper::set('error', 'username/password inválidos');

        header('Location: /login');

    } else {

        header('Location: /');

    }
}

?>
