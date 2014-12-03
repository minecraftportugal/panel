<?

use lib\session\Session;
use lib\template\Template;
use helpers\notice\NoticeHelper;

function v_login() {

    if (Session::isLoggedIn()) {
        header('Location: /');
        exit();
    }

    $template = Template::init('sessions/v_login');

    $error = NoticeHelper::get('error');

    $success = NoticeHelper::get('success');

    $icon_path = "/images/icons";

    $template->assign('error', $error);

    $template->assign('success', $success);

    $template->assign('icon_path', $icon_path);

    $template->render();

}

?>