<?

require_once('lib/sessions.php');

use models\account\AccountModel;
use models\drop\DropModel;
use helpers\arguments\ArgumentsHelper;
use helpers\pagination\PaginationHelper;
use helpers\dynmap\DynmapHelper;
use helpers\datetime\DateTimeHelper;

function users_show () {

    validateSession();

    $action_url = '/admin/accounts';

    $parameters = [
        "page" => 1,
        "per_page" => 1,
        "id" => null,
        "delivered" => 0,
        "undelivered" => 0,
        "order_by" => "1",
        "asc_desc" => "desc"
    ];

    $p = ArgumentsHelper::process($_GET, $parameters);
    if (is_null($p['id'])) {
        die("No ID given");
    }

    $player = AccountModel::first($p, true); // true : fetch all inquisitor data
    //$player_mapped = json_decode($player['mapped'], true);
    $drops = DropModel::get([
        "page" => 1,
        "per_page" => 1,
        "accountid" => $player["id"],
        "delivered" => 0,
        "undelivered" => 0,
        "order_by" => "1",
        "asc_desc" => "desc"
    ]);

    $badges = AccountModel::badges($player['id']);

    if ($player['online'] == 1) {
        $v_dynmap_widget = DynmapHelper::map($player['playername']);
    } else {
        if (!is_null($player['coords'])) {
            $coords = explode(',', $player['coords']);
            $v_dynmap_widget = DynmapHelper::map_position($coords, $player['world']);
        } else {
            $v_dynmap_widget = DynmapHelper::map();
        }
    }






    //$own    = ($profileId == $_SESSION['id']) ? true : false;
    //$admin = ($_SESSION['admin'] == '1') ? true : false;
//
//
//    $inquisitor = getInquisitor($profile['playername']);
//
//    // prepare inquisitor data
//    if ($inquisitor) {
//        $inventory = json_decode($inquisitor['inventory']);
//
//        $playerinv = array();
//
//        foreach($inventory as $slot)
//        {
//            if ($slot) {
//                $itemdata = "".$slot->type;
//                $itemdata .= " ".$slot->data;
//                $itemdata .= " ".$slot->amount;
//                $itemdata .= " ".$slot->durability;
//
//                $enchantments = array();
//                foreach($slot->enchantments as $name => $level)
//                {
//                    array_push($enchantments, "$name".":".$level);
//                }
//                $enchantments = implode(" ", $enchantments);
//                array_push($playerinv, array(
//                    "itemdata" => $itemdata,
//                    "enchantments" => $enchantments
//                ));
//            }
//            else
//            {
//                array_push($playerinv, array(
//                    "itemdata" => "",
//                    "enchantments" => ""
//                ));
//            }
//        }
//
//        $a = array_slice($playerinv, 0, 9);
//        $b = array_slice($playerinv, 9);
//        $playerinv = array_merge($b, $a);
//
//        // 'mapped' data
//        $mapped = json_decode($inquisitor['mapped'], true);
//        $blocksBroken = $mapped['blocksBroken'];
//        $total = empty($blocksBroken) ? 0 : array_sum($blocksBroken);
//        $diamond = $mapped['blocksBroken']['Diamond Ore'];
//        $diamond = $diamond != null ? $diamond : 0;
//        $hours = round($inquisitor['totalTime']/60/60);
//        $hours = $hours > 0 ? $hours : 1;
//    }
//
//    // item drops
//    $drops_per_page = isset($_GET['']) ? $_GET['drops_per_page'] : 10;
//    $drops_page = isset($_GET['drops_page']) ? $_GET['drops_page'] : 1;
//    $drops_page = intval($drops_page);
//    $drops_per_page = intval($drops_per_page);
//    $drops_pages = DropModel::get(["accountid" => $profileId, "undelivered" => 0]);
//    $link_after = "";
//    $link_after .= "&id=$profileId";
//    $link_after .= "#itemdrops";
//    $total_drops = $drops_pages["total"];
//    $itemdrops = $drops_pages["pages"];
//
//    $drops_page_navigation = new PaginationHelper([
//        "page" => $p['page'],
//        "total" => $total,
//        "per_page" => $p['per_page'],
//        "link_before" => $action_url,
//        "link_after" => $link_after,
//        "show_pages" => 4,
//        "expand" => 20
//    ]);
//
//    // Item Drops!
//    $new_drops_pages = DropModel::get([
//        "per_page" => 6,
//        "accountid" => $_SESSION["id"],
//        "undelivered" => 1
//    ]); //mostrar até 6 items
//
//    $total_new_drops = $new_drops_pages["total"];
//    $new_drops = $new_drops_pages["pages"];
//    $lootmessage = "WOW";
//    $loottitle = "very items";


    require('templates/users/show.php');
}

?>