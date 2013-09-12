<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function users_reset_password() {
  validateSession();
  
  $xsrf_token = getXSRFToken();
  if (!validateXSRFToken($xsrf_token)) {
    return;
  }
  
  $reset = isset($_POST['reset']) ? $_POST['reset'] : NULL;
  $message = NULL;
  
  $status = resetPassword($reset, $message);
  
  if (!$status) {
    header("Location: /profile?id=$reset&error=$message");
  } else {
    header("Location: /profile?id=$reset&ok=$message");
  }
}

?>
