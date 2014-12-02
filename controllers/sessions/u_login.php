<?

use lib\session\Session;

function u_login() {

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $session = Session::validateLogin($username, $password);

    if ($session == NULL) {
    	setFlash('error', 'username/password inválidos');
        header('Location: /login');
    } else {
        header('Location: /');
    }
}

?>
