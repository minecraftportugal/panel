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
  
  $skin_url = "/profile/3d?a=-25&w=35&wt=-45&abg=0&abd=-30&ajg=-25&ajd=30&ratio=10&format=png&displayHairs=true&headOnly=false&login=".$p['playername'];

  require('templates/users/show.php');
}

?>
