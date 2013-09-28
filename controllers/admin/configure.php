<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');


function admin_configure() {
  validateSession(true); //validate if admin
  
  $xsrf_token = getXSRFToken();
  if (!validateXSRFToken($xsrf_token)) {
    return;
  }
  
  $admin = isset($_POST['admin']) ? $_POST['admin'] : array();
  $active = isset($_POST['active']) ? $_POST['active'] : array();
  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();
  
  $status = usersConfigure($admin, $active, $delete);
  
  if (!$status) {
    header("Location: /admin");
  } else {
    header("Location: /admin");
  }
}

?>
