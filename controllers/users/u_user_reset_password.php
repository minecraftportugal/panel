<?

use lib\session\Session;
use models\account\AccountModel;
use helpers\notice\NoticeHelper;

function u_user_reset_password() {
  
  Session::validateSession(true);
  Session::validateXSRFToken();

  $id = isset($_POST['id']) ? $_POST['id'] : NULL;
  $reset_pass_check = isset($_POST['reset_pass_check']) ? $_POST['reset_pass_check'] : NULL;
  $admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : NULL;
  
  if ((($admin == "1") or ($_SESSION[id] == $id)) and ($reset_pass_check == "1")) {
    $status = AccountModel::resetPassword($id);
  } else {
      NoticeHelper::set('error', 'Password inalterada.');
  }
  
  if (!$status) {
    NoticeHelper::set('error', 'Password inalterada.');
    header("Location: /profile?id=$id#resetpw");
  } else {
    NoticeHelper::set('success', 'Nova password enviada por email!');
    header("Location: /profile?id=$id#resetpw");
  }
}

?>
