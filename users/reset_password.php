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

$reset = isset($_POST['reset']) ? $_POST['reset'] : NULL;
$message = NULL;

$status = resetPassword($reset, $message);

if (!$status) {
  header("Location: /profile/index.php?id=$reset&error=$message");
} else {
  header("Location: /profile/index.php?id=$reset&ok=$message");
}

?>
