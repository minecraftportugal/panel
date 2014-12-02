<?

use lib\session\Session;
use models\account\AccountModel;
use helpers\arguments\ArgumentsHelper;

function v_irc() {

    Session::validateSession();

    $parameters = [
        "page" => 1,
        "per_page" => 1,
        "id" => $_SESSION['id'],
        "delivered" => 0,
        "undelivered" => 0,
        "order_by" => "1",
        "asc_desc" => "desc"
    ];

    $p = ArgumentsHelper::process($_GET, $parameters);

    if (is_null($_SESSION['id'])) {
        die("No ID given");
    }

    $player = AccountModel::first($p, false); // false : don't fetch all inquisitor data

    require('templates/irc/v_irc.php');
}

?>
