<?
require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function sessions_destroy () {
  validateSession();

  $xsrf_token = getXSRFToken();
  if (!validateXSRFToken($xsrf_token)) {
    return;
  }
  
  if (isset($_SESSION['id'])) {
    terminatexAuthSession($_SESSION['id']);
  }
  session_destroy();
  
  session_start();
  setFlash('success', 'sessão terminada');
  header('Location: /login');
}

?>
