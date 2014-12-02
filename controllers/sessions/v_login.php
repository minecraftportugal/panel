<?

use lib\session\Session;

function v_login() {
  if (Session::isLoggedIn()) {
    header('Location: /');
    exit();
  }

  require('templates/sessions/v_login.php');
}

?>