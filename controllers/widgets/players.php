<?

use models\account\AccountModel;

function widgets_players() {
 
  $online_players = AccountModel::get(["per_page" => 100, "online" => 1]);
  $total_online_players = count($online_players);

  require('templates/widgets/players.php');
}

?>
