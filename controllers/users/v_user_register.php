<?

use lib\session\Session;

function v_user_register() {

  if (Session::isLoggedIn()) {
    header('Location: /');
    exit();
  }

  require('templates/users/v_user_register.php');
}

?>