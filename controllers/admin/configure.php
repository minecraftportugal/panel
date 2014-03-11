<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');


function admin_configure() {

  //session: admin
  validateSession(true);
  validateXSRFToken();

  $admin = isset($_POST['admin']) ? $_POST['admin'] : array();
  $active = isset($_POST['active']) ? $_POST['active'] : array();
  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

  $status = usersConfigure($admin, $active, $delete);
  if (!$status) {
    header("Location: /admin/accounts");
  } else {
    header("Location: /admin/accounts");
  }
}

?>
