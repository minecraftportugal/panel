<?php
require('../config.php');
require('../lib.php');
require('../i18n.php');
session_start();

$username = s($_POST['username']);
$password = s($_POST['password']);

$session = validateLogin($username, $password);
if ($session == NULL) {
  header('Location: /login?f=1');
} else {
  header('Location: /');
}
?>
