<?php

use lib\session\Session;
use lib\template\Template;
use models\accounts\Accounts;
use helpers\minotar\MinotarHelper;

function v_page_players() {

    Session::refererProtect();

    $template = Template::init('pages/v_players');

    /* scripts */
    $scripts = [

        "lib/jquery/jquery",

        "pages/players"
    ];

    $template->assign('scripts', $scripts);

    $styles = [

        "reset",

        "pages/players"

    ];

    $template->assign('styles', $styles);

    $players = Accounts::get(["per_page" => 100, "online" => 1]);

    /** Filters: Change and add new data */
    foreach ($players as $k => $v) {

        $players[$k]['head'] = MinotarHelper::head($players[$k]['playername'], "32px");

    }

    $total = count($players);

    $template->assign('players', $players);

    $template->assign('total', $total);

    $template->render();

}
?>