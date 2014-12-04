<?

use lib\session\Session;
use lib\template\Template;
use models\account\AccountModel;
use models\drop\DropModel;
use helpers\notice\NoticeHelper;
use helpers\arguments\ArgumentsHelper;
use helpers\pagination\PaginationHelper;
use helpers\dynmap\DynmapHelper;
use helpers\inventory\InventoryHelper;
use helpers\table\TableHelper;
use helpers\datetime\DateTimeHelper;

function v_user () {

    Session::validateSession();

    $template = Template::init('users/v_user');

    $parameters = ArgumentsHelper::process($_GET, [
        "page" => 1,
        "per_page" => 1,
        "id" => null,
        "delivered" => 0,
        "undelivered" => 0,
        "order_by" => "1",
        "asc_desc" => "desc"
    ]);

    assert(!is_null($parameters['id']));

    $action_url = '/profile';

    $player = AccountModel::first($parameters, true); // true : fetch all inquisitor data

    $own = ($parameters['id'] == Session::get('id'));

    $admin = (Session::get('admin') == '1') ? true : false;

    $notices = NoticeHelper::render(['classes' => 'hover-notice']);

    // ja jogou?
    $has_played = !is_null($player['name']);

    /** Skin 3d **/
    $skin3d = Template::init('partials/skin3d');

    $skin3d->assign('player', $player);

    /** Skin 3d **/
    $skin3d = Template::init('partials/skin3d');

    $skin3d->assign('player', $player);

    /** Health / Hunger **/
    $health = Template::init('partials/health');

    $health->assign('level', $player['health']);

    $hunger = Template::init('partials/hunger');

    $hunger->assign('level', $player['foodLevel']);

    /** Badges */
    $badges = Template::init('partials/badges');

    $badges->assign('badges', AccountModel::badges($player['id']));


    /** Mini Map **/
    $dynmap = null;

    if ($has_played) {
        if ($player['online'] == 1) {
            $dynmap = DynmapHelper::map($player['playername']);
        } else {
            if (!is_null($player['coords'])) {
                $coords = explode(',', $player['coords']);
                $dynmap = DynmapHelper::map_position($coords, $player['world']);
            } else {
                $dynmap = DynmapHelper::map();
            }
        }
    } else {
        $dynmap = DynmapHelper::map_offline();
    }


    /** stats and inventory **/
    if ($has_played) {

        $inventory = InventoryHelper::inventory(json_decode($player['inventory']));

        // 'mapped' data
        $mapped = json_decode($player['mapped'], true);
        $blocks_broken = $mapped['blocksBroken'];
        $count_blocks = empty($blocks_broken) ? 0 : array_sum($blocks_broken);
        $count_diamond = array_key_exists('Diamond Ore', $mapped['blocksBroken']) ? $mapped['blocksBroken']['Diamond Ore'] : 0 ;
        $count_diamond = $count_diamond != null ? $count_diamond : 0;
        $count_hours = round($player['totalTime']/60/60);
        $count_hours = $count_hours > 0 ? $count_hours : 1;


    } else {

        $inventory = null;
        $count_blocks = 0;
        $count_diamond = 0;
        $count_hours = 0;

    }

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

    $count_drops = count($drops);

    $table = new TableHelper($action_url, $parameters);

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

    $template->assign('player', $player);

    $template->assign('own', $own);

    $template->assign('admin', $admin);

    $template->assign('notices', $notices);

    $template->assign('has_played', $has_played);

    $template->assign('skin3d', $skin3d);

    $template->assign('health', $health);

    $template->assign('hunger', $hunger);

    $template->assign('badges', $badges);

    $template->assign('dynmap', $dynmap);

    $template->assign('inventory', $inventory);

    $template->assign('table', $table);

    $template->assign('count_blocks', $count_blocks);

    $template->assign('count_diamond', $count_diamond);

    $template->assign('count_hours', $count_hours);

    $template->assign('drops', $drops);

    $template->assign('count_drops', $count_drops);

    $template->render();
}

?>