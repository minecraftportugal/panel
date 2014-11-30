<?

use lib\session\Session;

function sessions_new () {
  if (Session::isLoggedIn()) {
    header('Location: /');
    exit();
  }

  require('templates/sessions/new.php');
}

?>