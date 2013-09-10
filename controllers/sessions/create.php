<?
require_once('config.php');
require_once('lib.php');
require_once('i18n.php');

function sessions_create () {
  $username = s($_POST['username']);
  $password = s($_POST['password']);
  
  $session = validateLogin($username, $password);
  if ($session == NULL) {
    header('Location: /login?f=1');
  } else {
    header('Location: /');
  }
}

?>
