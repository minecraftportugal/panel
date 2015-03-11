<?php

use lib\session\Session;
use lib\environment\Environment;
use models\logs\Logs;
use models\accounts\Accounts;

function u_user_register () {
  
  $username = $_POST['username'];
  $email = $_POST['email'];

  $result = Accounts::register($username, $email, $email_ip = true);
  
  if (!$result) {

    header('Location: /register');

  } else {

    Logs::create('register', null, Environment::get('REMOTE_ADDR'), "New user registration: $username / $email");

    header('Location: /login');

  }
}

?>
