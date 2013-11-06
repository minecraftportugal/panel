<?
require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');
require_once('helpers/date.php');

function users_show () {
  validateSession();

  $profileId = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
  $own  = ($profileId == $_SESSION['id']) ? true : false;
  $admin = ($_SESSION['admin'] == '1') ? true : false;

  $profile = getUserById($profileId);
  $inquisitor = getInquisitor($profile['playername']);
  $badges = getUserBadges($profile['id']);

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

    $a = array_slice($playerinv, 0, 9);
    $b = array_slice($playerinv, 9);  
    $playerinv = array_merge($b, $a);

    // 'mapped' data
    $mapped = json_decode($inquisitor['mapped'], true);
    $blocksBroken = $mapped['blocksBroken'];
    $total = array_sum($blocksBroken);
    $diamond = $mapped['blocksBroken']['Diamond Ore'];
    $diamond = $diamond != null ? $diamond : 0;
    $minutes = round($inquisitor['totalTime']/60/60);

  }


  $userSkin = "http://s3.amazonaws.com/MinecraftSkins/".$_SESSION['username'].".png";
  $profileSkin = "http://s3.amazonaws.com/MinecraftSkins/".$profile['playername'].".png";

  require('templates/users/show.php');
}

?>
