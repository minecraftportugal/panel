<?

use lib\session\Session;
use lib\environment\Environment;
use lib\xauth\xAuth;
use models\logs\Logs;
use helpers\notice\NoticeHelper;
use helpers\json\JSONHelper;

function u_logout() {

    // session: admin
    Session::validateSession();
    Session::validateXSRFToken();

    if (!is_null(Session::get('id'))) {

        Logs::create('logout', Session::get('id'), Environment::get('REMOTE_ADDR'), "");

        xAuth::terminatexAuthSession($_SESSION['id']);
    }

    session_destroy();
    
    session_start();

    NoticeHelper::set('success', 'sessão terminada');

    JSONHelper::respond([
        "action" => "logout",
        "status" => "ok",
        "notice" => NoticeHelper::renderObject()
    ]);
}

?>
