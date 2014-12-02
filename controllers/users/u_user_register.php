<?php

require_once('lib/sessions.php');

use models\account\AccountModel;

function u_user_register () {
  
  $username = $_POST['username'];
  $email = $_POST['email'];

  $result = AccountModel::register($username, $email, $email_ip = true);
  
  if (!$result) {
    header('Location: /register');
  } else {
    header('Location: /login');
  }
}

?>
