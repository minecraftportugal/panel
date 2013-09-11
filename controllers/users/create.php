<?php

require_once('config.php');
require_once('lib.php');
require_once('i18n.php');

function users_create () {
  global $cfg_enable_registrations;

  $username = s($_POST['username']);
  $email = s($_POST['email']);

  $result = register($username, $email, $email_ip = true);

  if ($result != "0") {
    header("Location: /register?f=$result");
  } else {
    header("Location: /login?f=3");
  }
}

?>
