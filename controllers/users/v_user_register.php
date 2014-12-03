<?

use lib\session\Session;
use lib\template\Template;
use helpers\notice\NoticeHelper;

function v_user_register() {

    if (Session::isLoggedIn()) {
        header('Location: /');
        exit();
    }

    $template = Template::init('users/v_user_register');

    $error = NoticeHelper::get('error');

    $success = NoticeHelper::get('success');

    $icon_path = "/images/icons";

    $template->assign('error', $error);

    $template->assign('success', $success);

    $template->assign('icon_path', $icon_path);

    $template->render();

}

?>
