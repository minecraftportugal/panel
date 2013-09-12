<?
require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function sessions_create () {
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  $session = validateLogin($username, $password);
  if ($session == NULL) {
    header('Location: /login?f=1');
  } else {
    header('Location: /');
  }
}

?>
