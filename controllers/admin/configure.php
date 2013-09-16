<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');


function admin_configure() {
  validateSession(true); //validate if admin
  
  $xsrf_token = getXSRFToken();
  if (!validateXSRFToken($xsrf_token)) {
    return;
  }
  
  $admin = isset($_POST['admin']) ? $_POST['admin'] : array();
  $active = isset($_POST['active']) ? $_POST['active'] : array();
  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();
  $username = isset($_POST['playername']) ? $_POST['playername'] : NULL;
  $email = isset($_POST['email']) ? $_POST['email'] : NULL;
  
  // /!\ usersConfigure tem q ser decomposta em funções mais pequenas e colocada seguindo a logica de um model mvc
  // /!\ e posteriormente implementar aqui a logica de negocio do form à conta dessas funçoes
  $status = usersConfigure($admin, $active, $delete, $username, $email);
  
  if (!$status) {
    header("Location: /admin");
  } else {
    header("Location: /admin");
  }
}

?>
