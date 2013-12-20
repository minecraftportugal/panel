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

  $drops_pages = getDrops(0, 1, $_SESSION["id"]);
  $total_drops = $drops_pages["total"];
  $drops = $drops_pages["pages"];

  require('templates/news/index.php');
}

?>