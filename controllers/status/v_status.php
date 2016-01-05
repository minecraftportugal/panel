<?

use lib\session\Session;
use lib\template\Template;
use models\accounts\Accounts;
use models\account\drops\AccountDrops;
use helpers\minotar\MinotarHelper;

function v_status() {

    Session::validateSession();

    $template = Template::init('status/v_status');

    $players = [];
    
    $players['online'] = Accounts::get(["per_page" => 100, "online" => 1]);

    foreach ($players['online'] as $k => $v) {

        $badges = Template::init('partials/badges');

        $badges->assign('badges', Accounts::badges($players['online'][$k]['id']));

        $players['online'][$k]['badges'] = $badges;

        $players['online'][$k]['head'] =  MinotarHelper::head($players['online'][$k]['playername'], "64px");

    }

    $players['top'] = Accounts::get(["per_page" => 15, "yesgame" => 1, "order_by" => "totalTime", "asc_desc" => "DESC"]);

    foreach ($players['top'] as $k => $v) {

        $players['top'][$k]['head'] =  MinotarHelper::head($players['top'][$k]['playername'], "25px");

    }

    $players['new'] = Accounts::get(["per_page" => 15, "yeslogin" => 1, "order_by" => "registerdate_df", "asc_desc" => "DESC"]);

    foreach ($players['new'] as $k => $v) {

        $players['new'][$k]['head'] =  MinotarHelper::head($players['new'][$k]['playername'], "25px");

    }

    $count = array_map(function($array) {
        return count($array);
    }, $players);

    $empty_server = Template::init('partials/empty-server');

    $template->assign('players', $players);

    $template->assign('count', $count);

    $template->assign('empty_server', $empty_server);

    $template->render();

}

?>
