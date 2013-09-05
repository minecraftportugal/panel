<?php
require('../config.php');
require('../lib.php');
require('../i18n.php');
session_start();

$xsrf_token = getXSRFToken();
if (!validateXSRFToken($xsrf_token)) {
  return;
}

if (isset($_SESSION['id'])) {
  terminatexAuthSession($_SESSION['id']);
}
session_destroy();
header('Location: /login?f=2');
?>
