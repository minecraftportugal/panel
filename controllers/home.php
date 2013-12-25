<?
require_once('config.php');
require_once('lib/sessions.php');

function home() {
  global $cfg_wp_url;
  global $cfg_dynmap_url;

  validateSession();

  $inquisitor = getInquisitor($_SESSION["username"]);
  $dynmap_url = $cfg_dynmap_url;

  if ($inquisitor != NULL) {
    $world = $inquisitor["world"];
    $dynmap_url .= '?worldname=' . $world;
  }

  require('templates/home.php');
}

?>