<?

use lib\session\Session;
use lib\environment\Environment;
use lib\xauth\xAuth;
use models\log\LogModel;
use helpers\notice\NoticeHelper;

function u_logout() {

    // session: admin
    Session::validateSession();
    Session::validateXSRFToken();

    if (!is_null(Session::get('id'))) {

        LogModel::create('logout', Session::get('id'), Environment::get('REMOTE_ADDR'), "");

        xAuth::terminatexAuthSession($_SESSION['id']);
    }

    session_destroy();
    
    session_start();

    NoticeHelper::set('success', 'sessão terminada');

    header('Location: /login');
}

?>
