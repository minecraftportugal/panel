<?php

require_once('config.php');
require_once('lib.php');
require_once('i18n.php');

function users_new () {
  global $cfg_enable_registrations;

  if (isLoggedIn()) {
    header('Location: /');
    exit();
  }

  require('templates/users/new.php');
}

?>
