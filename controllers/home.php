<?
require_once('config.php');
require_once('lib/sessions.php');


function home () {
  global $cfg_wp_url;

  validateSession();

  require('templates/home.php');
}

?>
