<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function users_show () {
  validateSession();

  $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
  $own  = ($id == $_SESSION['id']) ? true : false;
  $admin = ($_SESSION['admin'] == '1') ? true : false;
  $p = getUserById($id);
  
  $skin_url = "http://s3.amazonaws.com/MinecraftSkins/".$p['playername'].".png";

  require('templates/users/show.php');
}

?>
