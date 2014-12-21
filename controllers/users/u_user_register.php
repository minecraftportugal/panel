<?php

use lib\session\Session;
use lib\environment\Environment;
use models\log\LogModel;
use models\account\AccountModel;

function u_user_register () {
  
  $username = $_POST['username'];
  $email = $_POST['email'];

  $result = AccountModel::register($username, $email, $email_ip = true);
  
  if (!$result) {

    header('Location: /register');

  } else {

    LogModel::create('register', Environment::get('REMOTE_ADDR'), "New user registration: $username / $email");

    header('Location: /login');

  }
}

?>
