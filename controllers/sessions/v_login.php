<?

use lib\session\Session;
use lib\environment\Environment;
use lib\template\Template;
use helpers\notice\NoticeHelper;

function v_login() {

    if (!Environment::isAjax()) {
        header('Location: /');
        exit();
    }

    $template = Template::init('sessions/v_login');

    /* scripts */
    $scripts = [

        "pages/public",

    ];

    $template->assign('scripts', $scripts);

    $notices = NoticeHelper::render();

    $icon_path = "/images/icons";

    $template->assign('notices', $notices);

    $template->assign('icon_path', $icon_path);

    $template->render();

}

?>