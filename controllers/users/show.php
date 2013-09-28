<?
require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function users_show () {
  validateSession();

  $profileId = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
  $own  = ($profileId == $_SESSION['id']) ? true : false;
  $admin = ($_SESSION['admin'] == '1') ? true : false;

  $profile = getUserById($profileId);
  $inquisitor = getInquisitor($profile['playername']);
  if ($inquisitor)
    $inventory = json_decode($inquisitor['inventory']);

  $userSkin = "http://s3.amazonaws.com/MinecraftSkins/".$_SESSION['username'].".png";
  $profileSkin = "http://s3.amazonaws.com/MinecraftSkins/".$profile['playername'].".png";

  require('templates/users/show.php');
}

?>
