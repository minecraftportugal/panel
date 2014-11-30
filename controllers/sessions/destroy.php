<?

use lib\session\Session;
use \lib\xauth\xAuth;

function sessions_destroy () {

    // session: admin
    Session::validateSession();
    Session::validateXSRFToken();

    if (isset($_SESSION['id'])) {
        xAuth::terminatexAuthSession($_SESSION['id']);
    }

    session_destroy();
    
    session_start();
    setFlash('success', 'sessão terminada');
    header('Location: /login');
}

?>
