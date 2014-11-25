<?

require_once('lib/sessions.php');

function sessions_new () {
  if (isLoggedIn()) {
    header('Location: /');
    exit();
  }

  require('templates/sessions/new.php');
}

?>