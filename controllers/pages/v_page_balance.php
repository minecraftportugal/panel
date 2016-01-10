<?

use lib\template\Template;
use lib\session\Session;

function v_page_balance() {

    Session::refererProtect();

    $template = Template::init('pages/v_balance');

    $template->assign('scripts',[

    ]);

    $template->assign('styles', [

        "reset",

        "pages/balance"

    ]);

    $url = "https://docs.google.com/spreadsheets/u/1/d/1mQxrmVZu3r3xnOXHC9WbMcGLmIYSGQhfFNnCc-MvJjs/pub?gid=1&single=true&output=csv";

    $data = file_get_contents($url);

    $matches = [];

    preg_match_all("/(-?(\d+,?)+\.\d+)/", $data, $matches);

    $template->assign('revenue', $matches[0][0]);

    $template->assign('expenses', $matches[0][1]);

    $template->assign('balance', $matches[0][3]);

    $template->render();

}

?>