<?

use lib\session\Session;
use lib\template\Template;
use models\account\AccountModel;
use helpers\arguments\ArgumentsHelper;

function v_irc() {

    Session::validateSession();

    $template = Template::init('irc/v_irc');

    $parameters = ArgumentsHelper::process($_GET, [
        "page" => 1,
        "per_page" => 1,
        "id" => $_SESSION['id'],
        "delivered" => 0,
        "undelivered" => 0,
        "order_by" => "1",
        "asc_desc" => "desc"
    ]);

    assert(!is_null(Session::get('id')));

    $user = AccountModel::first($parameters, false); // false : don't fetch all inquisitor data

    $template->assign('user', $user);

    $template->render();

}

?>
