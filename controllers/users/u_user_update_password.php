<?

use lib\session\Session;
use \models\account\AccountModel;

function u_user_update_password() {

  Session::validateSession();
  Session::validateXSRFToken();
  
  $id = $_SESSION['id'];
  $password = isset($_POST['password']) ? $_POST['password'] : NULL;
  $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : NULL;
  $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : NULL;
  
  $status = AccountModel::changePassword($id, $password, $new_password, $confirm_password);

  if (!$status) {
    header("Location: /options");
  } else {
    header("Location: /options");
  }
}

?>
