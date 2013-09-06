<?
require('../config.php');
require('../lib.php');
require('../i18n.php');
session_start();
validateSession();

$xsrf_token = getXSRFToken();
if (!validateXSRFToken($xsrf_token)) {
  return;
}

$username = $_SESSION['username'];
$password = isset($_POST['password']) ? $_POST['password'] : NULL;
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : NULL;
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : NULL;
$irc_nickname = isset($_POST['irc_nickname']) ? $_POST['irc_nickname'] : NULL;
$irc_password = isset($_POST['irc_password']) ? $_POST['irc_password'] : NULL;
$irc_auto = isset($_POST['irc_auto']) ? $_POST['irc_auto'] : 0;

$message = NULL;

$status = changePassword($username, $password, $new_password, $confirm_password, $irc_nickname, $irc_password, $irc_auto, $message);
if (!$status) {
  header("Location: /profile/index.php?error=$message");
} else {
  header("Location: /profile/index.php?ok=$message");
}

?>
