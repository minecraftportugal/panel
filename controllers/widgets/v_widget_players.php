<?

use models\account\AccountModel;

function v_widget_players() {
 
  $online_players = AccountModel::get(["per_page" => 100, "online" => 1]);
  $total_online_players = count($online_players);

  require('templates/widgets/v_widget_players.php.php');
}

?>
