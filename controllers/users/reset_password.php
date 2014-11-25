<?

require_once('lib/sessions.php');

function users_reset_password() {
  
  validateSession();
  validateXSRFToken();

  $id = isset($_POST['id']) ? $_POST['id'] : NULL;
  $reset_pass_check = isset($_POST['reset_pass_check']) ? $_POST['reset_pass_check'] : NULL;
  $admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : NULL;
  
  if ((($admin == "1") or ($_SESSION[id] == $id)) and ($reset_pass_check == "1")) {
    $status = resetPassword($id);
  } else {
    setFlash('error', "Password inalterada");
  }
  
  if (!$status) {
    header("Location: /profile?id=$id#resetpw");
  } else {
    header("Location: /profile?id=$id#resetpw");
  }
}

?>
