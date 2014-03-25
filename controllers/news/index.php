<?
require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');
require_once('lib/users.php');

use models\account\AccountModel;
use models\drop\DropModel;

function news_index() {
    global $cfg_wp_enabled, $cfg_wp_location, $cfg_wp_url;

    validateSession();

    $online_players = AccountModel::get(["per_page" => 100, "online" => 1]);

    $new_drops_pages = DropModel::get(["per_page" => 6, "accountid" => $_SESSION["id"]]);

    $top_players = AccountModel::get(["per_page" => 15], "totalTime DESC");
    
    $newest_players = AccountModel::get(["per_page" => 15, "yeslogin" => 1], "a.registerdate DESC");

    require('templates/news/index.php');
}

?>