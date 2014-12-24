<?

use lib\session\Session;
use lib\template\Template;
use models\account\AccountModel;

function v_irc() {

    Session::validateSession();

    $template = Template::init('irc/v_irc');

    /* scripts */
    $scripts = [

        "lib/swf/swfobject-2.2",

        "pages/irc",

        "sop",

    ];

    $template->assign('scripts', $scripts);

    /* styles */
    $styles = [

        "irc"

    ];

    $template->assign('styles', $styles);

    assert(!is_null(Session::get('id')));

    $user = AccountModel::first([ "id" => Session::get('id') ], false); // false : don't fetch all inquisitor data

    $template->assign('user', $user);

    $template->render();

}

?>
