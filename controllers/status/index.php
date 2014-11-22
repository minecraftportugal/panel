<?
require_once('lib/sessions.php');

use models\account\AccountModel;
use models\drop\DropModel;

function status_index() {

    validateSession();

    $online_players = AccountModel::get(["per_page" => 100, "online" => 1]);

    $new_drops_pages = DropModel::get(["per_page" => 6, "accountid" => $_SESSION["id"]]);

    $top_players = AccountModel::get(["per_page" => 15], "totalTime DESC");
    
    $newest_players = AccountModel::get(["per_page" => 15, "yeslogin" => 1], "a.registerdate DESC");

    require('templates/status/index.php');
}

?>