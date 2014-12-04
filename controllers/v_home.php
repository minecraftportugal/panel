<?

use lib\session\Session;
use lib\template\Template;
use models\account\AccountModel;
use helpers\minotar\MinotarHelper;

function v_home() {

    Session::validateSession();

    $template = Template::init('v_home');

    $template->assign('xsrf_token', Session::getXSRFToken());

    $user = AccountModel::first(['id' => Session::get('id')]);

    $template->assign('user', $user);

    $background_css = Template::init('partials/background-css');

    $background_css->assign('background_image', '/images/backgrounds/login/bg7.jpg');

    $template->assign('background_css', $background_css);

    $head_url = MinotarHelper::url($user['playername'], 16);

    $taskbar = Template::init('partials/taskbar');

    $taskbar->assign('head_url', $head_url);

    $template->assign('taskbar', $taskbar);

    $menu_home = Template::init('partials/menus/home');

    $menu_home->assign('admin', Session::isAdmin());

    $template->assign('menu_home', $menu_home);

    $menu_user = Template::init('partials/menus/user');

    $menu_user->assign('user', $user);

    $menu_user->assign('head_url', $head_url);

    $template->assign('menu_user', $menu_user);

    $html_templates = Template::init('partials/html-templates');

    $template->assign('html_templates', $html_templates);

    $template->render();

}

?>
