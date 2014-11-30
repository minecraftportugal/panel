<?

use lib\session\Session;
use models\account\AccountModel;
use helpers\notice\NoticeHelper;

function users_options_show() {

    Session::validateSession();

    $player = AccountModel::first(["id" => $_SESSION["id"]]);

    $notices = NoticeHelper::render(['classes' => 'hover-notice']);

    require('templates/users/options.php');
}

?>
