<?php

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function users_new () {
  global $cfg_enable_registrations;

  if (isLoggedIn()) {
    header('Location: /');
    exit();
  }

  require('templates/users/new.php');
}

?>
