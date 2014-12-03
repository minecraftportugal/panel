<?

use lib\session\Session;
use \lib\xauth\xAuth;
use helpers\notice\NoticeHelper;

function u_logout() {

    // session: admin
    Session::validateSession();
    Session::validateXSRFToken();

    if (isset($_SESSION['id'])) {
        xAuth::terminatexAuthSession($_SESSION['id']);
    }

    session_destroy();
    
    session_start();

    NoticeHelper::set('success', 'sessão terminada');

    header('Location: /login');
}

?>
