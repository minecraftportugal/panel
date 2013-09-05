<?php
require('../config.php');
require('../lib.php');
require('../i18n.php');
session_start();

$username = s($_POST['username']);
$email = s($_POST['email']);

$result = register($username, $email, $email_ip = true);

if ($result != "0") {
  header("Location: /register?f=$result");
} else {
  header("Location: /login?f=3");
}

?>
