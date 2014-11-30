<?

use lib\session\Session;

function users_new () {

  if (Session::isLoggedIn()) {
    header('Location: /');
    exit();
  }

  require('templates/users/new.php');
}

?>
