<?

use lib\template\Template;
use models\account\AccountModel;
use helpers\minotar\MinotarHelper;

function v_widget_players() {

    $template = Template::init('widgets/v_widget_players');

    $players = AccountModel::get(["per_page" => 100, "online" => 1]);

    /** Filters: Change and add new data */
    foreach ($players as $k => $v) {

        $players[$k]['head'] = MinotarHelper::head($players[$k]['playername'], 32);

    }

    $total = count($players);

    $template->assign('players', $players);

    $template->assign('total', $total);

    $template->render();

}

?>
