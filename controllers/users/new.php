<?

require_once('lib/sessions.php');

function users_new () {

  if (isLoggedIn()) {
    header('Location: /');
    exit();
  }

  require('templates/users/new.php');
}

?>
