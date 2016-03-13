<?

use lib\session\Session;
use lib\template\Template;
use models\accounts\Accounts;
use helpers\minotar\MinotarHelper;

function v_home() {

    $loggedIn = Session::isLoggedIn();

    /* home template */
    $template = Template::init('v_home');

    $template->assign('loggedIn', $loggedIn);

    /* scripts */
    $template->assign('scripts', [
        "policy/sameorigin",
        "lib/jquery/jquery",
        "lib/jquery/jquery.scrollto",
        "lib/jquery/jqueryui",
        "lib/Three/Three",
        "app",
        "debug",
        "public",
        "ajax",
        "desktop/defaults",
        "desktop/desktop",
        "desktop/widget",
        "forms",
        "cookies",
        "iframe",
        "items",
        "skin3d",
        "toaster",
        "sound",
        "load",
    ]);

    $template->assign('styles', [
        "lib/font-awesome.min",
        "reset",
        "fonts",
        "desktop/desktop",
        "desktop/widget",
        "desktop/modal",
        "scrollbar",
        "items",
        "page-presentation",
        "page-presentation-public",
        "page-presentation-forms",
        "page-presentation-profile",
        "page-presentation-wp",
        "ads"
    ]);

    /* xsrf token */
    $template->assign('xsrf_token', Session::getXSRFToken());

    /* session */
    $user = (!is_null(Session::get('id'))) ? Accounts::first(['id' => Session::get('id')]) : NULL;
    $template->assign('user', $user);

    /* page background */
    $background_css = Template::init('partials/background-css');
    $background_css->assign('background_image', '/images/backgrounds/bg9.jpg');
    $template->assign('background_css', $background_css);

    $desktop_logo = Template::init('partials/desktop-logo');
    $desktop_logo->assign('bg_image', '/images/logo_xxs.png');
    $desktop_logo->assign('bg_height', '128px');
    $desktop_logo->assign('logo_action', 'help-about');

    $template->assign('desktop_logo', $desktop_logo);

    /* Task bar */
    $taskbar = Template::init('partials/taskbar');
    $head_url = MinotarHelper::url($user['playername'], 16);
    $taskbar->assign('head_url', $head_url);
    $template->assign('taskbar', $taskbar);

    /* Home menu */
    $menu_home = Template::init('partials/menus/home');
    $template->assign('menu_home', $menu_home);

    /* Admin menu */
    $admin = Session::isAdmin();
    $template->assign('admin', $admin);
    $taskbar->assign('admin', $admin);

    $menu_admin = Template::init('partials/menus/admin');
    $menu_admin->assign('admin', $admin);
    $template->assign('menu_admin', $menu_admin);

    /* User and desktop menus */
    $menu_user = Template::init('partials/menus/user');
    $menu_user->assign('user', $user);
    $menu_user->assign('head_url', $head_url);
    $template->assign('menu_user', $menu_user);

    $menu_desktop = Template::init('partials/menus/desktop');
    $template->assign('menu_desktop', $menu_desktop);

    /* HTML templates for javascript content*/
    $html_templates = Template::init('partials/html-templates');
    $template->assign('html_templates', $html_templates);

    /* Ads */
    $ad_desktop = Template::init('partials/ads/leaderboard-bottom');
    $template->assign('ad_desktop', $ad_desktop);


    /* Google Analytics */
    $analytics = Template::init('partials/analytics');
    $template->assign('analytics', $analytics);

    /* Render */
    $template->render();

}

?>
