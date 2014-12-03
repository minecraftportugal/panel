<?

use lib\template\Template;
use models\account\AccountModel;

function v_widget_players() {

    $template = Template::init('widgets/v_widget_players');

    $players = AccountModel::get(["per_page" => 100, "online" => 1]);

    $total = count($players);

    $template->assign('players', $players);

    $template->assign('total', $total);

    $template->render();

}

?>
