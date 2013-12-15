<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');


function admin_register() {
  validateSession(true); //validate if admin
  
  $xsrf_token = getXSRFToken();
  if (!validateXSRFToken($xsrf_token)) {
    return;
  }
  
  $username = isset($_POST['playername']) ? $_POST['playername'] : NULL;
  $email = isset($_POST['email']) ? $_POST['email'] : NULL;

  $status = register($username, $email, $email_ip = false);
  
  if (!$status) {
    header("Location: /admin");
  } else {
    header("Location: /admin");
  }
}

?>
