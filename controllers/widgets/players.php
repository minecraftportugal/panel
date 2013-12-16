<?
require_once('config.php');
require_once('lib/users.php');

function widgets_players() {
  global $cfg_lightirc_path;
 
  $onlinePlayers = getOnlinePlayers();
  $n = count($onlinePlayers);

  require('templates/widgets/players.php');
}

?>
