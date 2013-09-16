<?php

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function users_create () {
  
  $username = $_POST['username'];
  $email = $_POST['email'];

  $result = register($username, $email, $email_ip = true);
  
  if (!$result) {
    header('Location: /register');
  } else {
    header('Location: /login');
  }
}

?>
