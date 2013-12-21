<?
require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function sessions_destroy () {

  // session: admin
  validateSession();
  validateXSRFToken();

  if (isset($_SESSION['id'])) {
    terminatexAuthSession($_SESSION['id']);
  }
  session_destroy();
  
  session_start();
  setFlash('success', 'sessão terminada');
  header('Location: /login');
}

?>
