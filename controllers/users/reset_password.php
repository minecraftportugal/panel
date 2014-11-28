<?

require_once('lib/sessions.php');

use models\account\AccountModel;
use helpers\notice\NoticeHelper;

function users_reset_password() {
  
  validateSession(true);
  validateXSRFToken();

  $id = isset($_POST['id']) ? $_POST['id'] : NULL;
  $reset_pass_check = isset($_POST['reset_pass_check']) ? $_POST['reset_pass_check'] : NULL;
  $admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : NULL;
  
  if ((($admin == "1") or ($_SESSION[id] == $id)) and ($reset_pass_check == "1")) {
    $status = AccountModel::resetPassword($id);
  } else {
      NoticeHelper::set('error', 'password inalterada');
  }
  
  if (!$status) {
    NoticeHelper::set('error', 'password inalterada');
    header("Location: /profile?id=$id#resetpw");
  } else {
    NoticeHelper::set('success', 'alterações efectuadas');
    header("Location: /profile?id=$id#resetpw");
  }
}

?>
