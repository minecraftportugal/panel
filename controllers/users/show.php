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

  // prepare inquisitor data
  if ($inquisitor)
  {
    $inventory = json_decode($inquisitor['inventory']);

    $playerinv = array();

    foreach($inventory as $slot)
    { 
      if ($slot) {
        $itemdata = "".$slot->type;
        $itemdata .= " ".$slot->data;
        $itemdata .= " ".$slot->amount;
        $itemdata .= " ".$slot->durability;

        $enchantments = array();
        foreach($slot->enchantments as $name => $level)
        {
          array_push($enchantments, "$name".":".$level);
        }
        $enchantments = implode(" ", $enchantments);
        array_push($playerinv, array(
          "itemdata" => $itemdata,
          "enchantments" => $enchantments
        ));
      }
      else
      {
        array_push($playerinv, array(
          "itemdata" => "",
          "enchantments" => ""
        ));
      }
    }
  }

  $userSkin = "http://s3.amazonaws.com/MinecraftSkins/".$_SESSION['username'].".png";
  $profileSkin = "http://s3.amazonaws.com/MinecraftSkins/".$profile['playername'].".png";

  require('templates/users/show.php');
}

?>
