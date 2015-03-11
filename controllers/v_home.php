<?

use lib\session\Session;
use lib\template\Template;
use models\accounts\Accounts;
use helpers\minotar\MinotarHelper;

function v_home() {

    Session::validateSession();

    /* home template */
    $template = Template::init('v_home');

    $template->assign('xsrf_token', Session::getXSRFToken());

    $user = Accounts::first(['id' => Session::get('id')]);

    $template->assign('user', $user);

    /* scripts */
    $scripts = [

        "sop",

        "lib/jquery/jquery",

        "lib/jquery/jquery.scrollto",

        "lib/jquery/jqueryui",

        "lib/Three",

        "app",

        "ajax",

        "widget/widget",

        "widget/modal",

        "widget/definition",

        "cookies",

        "iframe",

        "pages/items",

        "pages/skin3d",

        "toaster",

        "sound",

        "unobtrusive",

        "bootstrap",
    ];

    $template->assign('scripts', $scripts);

    $styles = [

        "reset",

        "fonts",

        "desktop",

        "widget",

        "modal",

        "scrollbar",

        "items",

        "font-awesome.min",

        "page-presentation",

        "page-presentation-forms",

        "page-presentation-profile",

        "page-presentation-wp"
    ];

    $template->assign('styles', $styles);

    /* page background */
    $background_css = Template::init('partials/background-css');
    $background_css->assign('background_image', '/images/backgrounds/bg9.jpg');
    $template->assign('background_css', $background_css);

    $desktop_logo =  Template::init('partials/desktop-logo');
    if ($user['donor'] == 1) {
        $desktop_logo->assign('bg_image', '/images/logo_xxs.png');
        $desktop_logo->assign('bg_height', '128px');
        $desktop_logo->assign('logo_action', 'help-about');
    } else {
        $desktop_logo->assign('bg_image', '/images/pls_xxs.png');
        $desktop_logo->assign('bg_height', '147px');
        $desktop_logo->assign('logo_action', 'help-donate');
    }
    $template->assign('desktop_logo', $desktop_logo);

    /* Task bar */
    $taskbar = Template::init('partials/taskbar');
    $head_url = MinotarHelper::url($user['playername'], 16);
    $taskbar->assign('head_url', $head_url);
    $template->assign('taskbar', $taskbar);

    /* Home menu */
    $menu_home = Template::init('partials/menus/home');
    $menu_home->assign('admin', Session::isAdmin());
    $template->assign('menu_home', $menu_home);

    /* User menu */
    $menu_user = Template::init('partials/menus/user');
    $menu_user->assign('user', $user);
    $menu_user->assign('head_url', $head_url);
    $template->assign('menu_user', $menu_user);

    /* Desktop menu */
    $menu_desktop = Template::init('partials/menus/desktop');
    $template->assign('menu_desktop', $menu_desktop);


    /* HTML templates for javascript content*/
    $html_templates = Template::init('partials/html-templates');
    $template->assign('html_templates', $html_templates);

    /* Render */
    $template->render();

}

?>
