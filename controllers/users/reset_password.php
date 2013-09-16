<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function users_reset_password() {
  validateSession();
  
  $xsrf_token = getXSRFToken();
  if (!validateXSRFToken($xsrf_token)) {
    return;
  }
  
  $id = isset($_POST['id']) ? $_POST['id'] : NULL;
  $admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : NULL;
    
  if (($admin == "1") or ($_SESSION[id] == $id)) {
    $status = resetPassword($id);
  } else {
    setFlash('error', "You can't change this password!");
  }
  
  if (!$status) {
    header("Location: /profile?id=$id");
  } else {
    header("Location: /profile?id=$id");
  }
}

?>
