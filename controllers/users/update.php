<?

use lib\session\Session;
use \models\account\AccountModel;

function users_update_irc() {

  Session::validateSession();
  Session::validateXSRFToken();
  
  $id = $_SESSION['id'];
  $irc_nickname = isset($_POST['irc_nickname']) ? $_POST['irc_nickname'] : NULL;
  $irc_password = isset($_POST['irc_password']) ? $_POST['irc_password'] : NULL;
  $irc_auto = isset($_POST['irc_auto']) ? $_POST['irc_auto'] : 0;
  
  $status = AccountModel::changeIRC($id, $irc_nickname, $irc_password, $irc_auto);

  if (!$status) {
    header("Location: /options");
  } else {
    header("Location: /options");
  }
}

function users_update_password() {

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
