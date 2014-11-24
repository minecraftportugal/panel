<?

require_once('config.php');
require_once('lib/sessions.php');

function users_update_irc() {

  validateSession();
  validateXSRFToken();
  
  $username = $_SESSION['username'];
  $irc_nickname = isset($_POST['irc_nickname']) ? $_POST['irc_nickname'] : NULL;
  $irc_password = isset($_POST['irc_password']) ? $_POST['irc_password'] : NULL;
  $irc_auto = isset($_POST['irc_auto']) ? $_POST['irc_auto'] : 0;
  
  $status = changeIRC($username, $irc_nickname, $irc_password, $irc_auto);

  if (!$status) {
    header("Location: /profile#irc");
  } else {
    header("Location: /profile#irc");
  }
}

function users_update_password() {

  validateSession();
  validateXSRFToken();
  
  $username = $_SESSION['username'];
  $password = isset($_POST['password']) ? $_POST['password'] : NULL;
  $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : NULL;
  $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : NULL;
  
  $status = changePassword($username, $password, $new_password, $confirm_password);

  if (!$status) {
    header("Location: /profile#changepw");
  } else {
    header("Location: /profile#changepw");
  }
}

?>
