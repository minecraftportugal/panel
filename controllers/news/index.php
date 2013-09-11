<?
require_once('config.php');
require_once('lib.php');
require_once('i18n.php');

function news_index() {
  global $cfg_wp_enabled;

  validateSession();
  refreshxAuthSession($_SESSION['id']);

  require('templates/news/index.php');
}

?>
