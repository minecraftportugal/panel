<?

use lib\template\Template;
use lib\session\Session;
use lib\environment\Environment;
use helpers\arguments\ArgumentsHelper;


function v_page() {

    $parameters = [
        'page' => null
    ];

    $p = ArgumentsHelper::process($_GET, $parameters);

    $page = $p['page'];

    /* null makes it use the default controller */
    $pages = [
        'players' => 'v_page_players',
        'launcher' => 'v_page_launcher',
        'register' => 'v_page_register',
        'balance' => 'v_page_balance',
        'about' => null,
        'help' => null
    ];

    if (array_key_exists($page, $pages)) {

        $controller = $pages[$page];
        if (!is_null($controller)) {

            require("controllers/pages/$controller.php");
            $controller();

        } else {

            Session::validateSession();

            $template = Template::init("pages/v_$page");
            $template->assign('page', $page);
            $template->render();

        }


    } else {

        $template = Template::init('v_404_not_found');
        $template->assign('self_url', Environment::getSelfURL());
        $template->render(404);

    }



}

?>