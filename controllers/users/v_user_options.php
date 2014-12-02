<?

use lib\session\Session;
use models\account\AccountModel;
use helpers\notice\NoticeHelper;

function v_user_options() {

    Session::validateSession();

    $player = AccountModel::first(["id" => $_SESSION["id"]]);

    $notices = NoticeHelper::render(['classes' => 'hover-notice']);

    require('templates/users/v_user_options.php');
}

?>
