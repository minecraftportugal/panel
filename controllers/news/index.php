<?
require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');
require_once('lib/users.php');

function news_index() {
  global $cfg_wp_enabled, $cfg_wp_location, $cfg_wp_url;

  validateSession();

  $onlinePlayers = getOnlinePlayers();
  $f = function($e) {
  	return $e['name'];
  };

  $flatOnlinePlayers = array_map($f, $onlinePlayers);
  $numberOnlinePlayers = $onlinePlayers == null ? 0 : count($onlinePlayers);

  // Item Drops!
  $new_drops_pages = getDrops(0, 6, $_SESSION["id"], 1); //mostrar até 6 itens
  $total_new_drops = $new_drops_pages["total"];
  $new_drops = $new_drops_pages["pages"];
  $lootmessage = getLootMessage();
  $loottitle = getLootTitles();

  require('templates/news/index.php');
}

?>