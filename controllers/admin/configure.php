<?

require_once('config.php');
require_once('lib/sessions.php');

use helpers\Notice\NoticeHelper;

function admin_configure() {

  //session: admin
  validateSession(true);

  validateXSRFToken();

  $admin = isset($_POST['admin']) ? $_POST['admin'] : array();
  $active = isset($_POST['active']) ? $_POST['active'] : array();
  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

  $status = usersConfigure($admin, $active, $delete);
  if ($status) {
    NoticeHelper::set('success', 'alterações gravadas');
    header("Location: /admin/accounts");
  } else {
    NoticeHelper::set('error', 'erro ao gravar alterações');
    header("Location: /admin/accounts");
  }
}

?>