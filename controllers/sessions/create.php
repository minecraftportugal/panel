<?

use lib\session\Session;

function sessions_create () {

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
