<?
require_once('config.php');
require_once('lib.php');
require_once('i18n.php');

function sessions_new () {
  if (isLoggedIn()) {
    header('Location: /');
    exit();
  }

  require('templates/sessions/new.php');
}

?>
