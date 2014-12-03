<?

use lib\session\Session;
use helpers\notice\NoticeHelper;

function v_login() {

    if (Session::isLoggedIn()) {
        header('Location: /');
        exit();
    }

    $error = NoticeHelper::get('error');

    $success = NoticeHelper::get('success');


    require('templates/sessions/v_login.php');
}

?>