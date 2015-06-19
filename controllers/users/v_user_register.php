<?

use lib\session\Session;
use lib\environment\Environment;
use lib\template\Template;
use helpers\notice\NoticeHelper;

function v_user_register() {

    if (Session::isLoggedIn()) {
        header('Location: /');
        exit();
    }

    if (!Environment::isAjax()) {
        header('Location: /#/register');
        exit();
    }

    $template = Template::init('users/v_user_register');

    $template->assign('icon_path', "/images/icons");

    $template->assign('notices', NoticeHelper::render());

    $template->render();

}

?>
