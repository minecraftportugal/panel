<?

require_once('config.php');
require_once('lib.php');
require_once('i18n.php');

function users_show () {
  validateSession();
  
  $error = isset($_GET['error']) ? $_GET['error'] : NULL;
  $ok = isset($_GET['ok']) ? $_GET['ok'] : NULL;
  
  $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
  $own  = ($id == $_SESSION['id']) ? true : false;
  $admin = ($_SESSION['admin'] == '1') ? true : false;
  $p = getUserById($id);
  
  $skin_url = "http://s3.amazonaws.com/MinecraftSkins/".$p['playername'].".png";

  require('templates/users/show.php');
}

?>
