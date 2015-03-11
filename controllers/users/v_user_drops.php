<?

use lib\session\Session;
use lib\template\Template;
use models\accounts\Accounts;
use models\account\drops\AccountDrops;
use helpers\minotar\MinotarHelper;

function v_user_drops() {

    Session::validateSession();

    $template = Template::init('users/v_user_drops');

    $template->assign('drops', AccountDrops::get([
        "accountid" => Session::get("id"),
        "per_page" => 6,
        "undelivered" => 1
    ]));

    $template->assign('title', 'Wow! Free shit!');

    $template->assign('message', 'Encontraste estes itens debaixo da almofada!');

    $template->render();

}

?>