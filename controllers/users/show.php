<?

require_once('lib/sessions.php');

use models\account\AccountModel;
use models\drop\DropModel;
use helpers\notice\NoticeHelper;
use helpers\arguments\ArgumentsHelper;
use helpers\pagination\PaginationHelper;
use helpers\dynmap\DynmapHelper;
use helpers\table\TableHelper;
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

    $own = ($player['id'] == $_SESSION['id']) ? true : false;

    $admin = ($_SESSION['admin'] == '1') ? true : false;

    $notices = NoticeHelper::render(['classes' => 'hover-notice']);

    $badges = AccountModel::badges($player['id']);

    // ja jogou?
    $has_played = !is_null($player['name']);

    /** Mini Map **/

    if ($has_played) {
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
    } else {
        $v_dynmap_widget = DynmapHelper::map_offline();
    }


    /*
     * stats and inventory
     */

    // prepare inquisitor data
    $inventory = json_decode($player['inventory']);

    $playerinv = array();
    foreach($inventory as $slot) {

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
        } else {
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
    $mapped = json_decode($player['mapped'], true);
    $blocksBroken = $mapped['blocksBroken'];
    $total = empty($blocksBroken) ? 0 : array_sum($blocksBroken);
    $diamond = $mapped['blocksBroken']['Diamond Ore'];
    $diamond = $diamond != null ? $diamond : 0;
    $hours = round($player['totalTime']/60/60);
    $hours = $hours > 0 ? $hours : 1;


    /*
     * ItemDrops Table
     */
    $drops = DropModel::get([
        "page" => 1,
        "per_page" => 10,
        "accountid" => $player["id"],
        "delivered" => 0,
        "undelivered" => 0,
        "order_by" => "1",
        "asc_desc" => "desc"
    ]);

    $table = new TableHelper($action_url, $p);

    $table->add_column([
        'width' => '30px'
    ]);

    $table->add_column([
        'width' => '40%',
        'label' => 'Item',
        'order_by' => 'itemdrop'
    ]);

    $table->add_column([
        'width' => '20%',
        'label' => 'Dropped',
        'order_by' => 'dropdate_df'
    ]);

    $table->add_column([
        'width' => '20%',
        'label' => 'Recebido',
        'order_by' => 'takendate_df'
    ]);


    $table->add_column([
        'width' => '20%',
        'label' => 'Recebido após',
        'order_by' => 'idledroptime'
    ]);

    $table->add_column([
        'width' => '18px',
        'alignment' => 'center',
        'label' => '<i class="fa fa-trash-o"></i>',
        'label_title' => 'Apagar'
    ]);

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

    /*
     * Render Page
     */

    require('templates/users/show.php');
}

?>