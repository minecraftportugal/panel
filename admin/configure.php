<?
require('../config.php');
require('../lib.php');
session_start();
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
  header("Location: /admin/index.php?error=$message");
} else {
  header("Location: /admin/index.php?ok=$message");
}

?>
