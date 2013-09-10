<?
require_once('config.php');
require_once('lib.php');

function home () {
  validateSession();
  require('templates/home.php');
}

?>
