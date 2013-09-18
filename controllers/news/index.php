<?
require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');
require_once('lib/users.php');

function news_index() {
  global $cfg_wp_enabled, $cfg_wp_location, $cfg_wp_url;

  validateSession();
  refreshxAuthSession($_SESSION['id']);

  require('templates/news/index.php');
}

?>
