<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');


function admin_configure() {
  validateSession(true);
  
  $xsrf_token = getXSRFToken();
  if (!validateXSRFToken($xsrf_token)) {
    return;
  }
  
  $admin = isset($_POST['admin']) ? $_POST['admin'] : array();
  $active = isset($_POST['active']) ? $_POST['active'] : array();
  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();
  $username = isset($_POST['playername']) ? $_POST['playername'] : NULL;
  $email = isset($_POST['email']) ? $_POST['email'] : NULL;
  
  $status = usersConfigure($admin, $active, $delete, s($username), s($email), $message);
  
  if (!$status) {
    header("Location: /admin?error=$message");
  } else {
    header("Location: /admin?ok=$message");
  }
}

?>
