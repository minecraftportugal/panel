<?

use lib\session\Session;
use lib\template\Template;
use models\account\AccountModel;
use models\drop\DropModel;

function v_status() {

    Session::validateSession();

    $template = Template::init('status/v_status');

    $players = [];
    $players['online'] = AccountModel::get(["per_page" => 100, "online" => 1]);
    $players['top'] = AccountModel::get(["per_page" => 15], "totalTime DESC");
    $players['new'] = AccountModel::get(["per_page" => 15, "yeslogin" => 1], "a.registerdate DESC");

    $count = array_map(function($array) {
        return count($array);
    }, $players);

    $template->assign('players', $players);

    $template->assign('count', $count);

    $template->render();

}

?>