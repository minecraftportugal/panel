<?

use lib\session\Session;
use lib\template\Template;
use lib\environment\Environment;

function v_page() {

    Session::validateSession();

    $page = $_GET['page'];

    $pages = [
        'about',
        'help'
    ];

    if (in_array($page, $pages)) {

        $template = Template::init("pages/v_$page");

        switch ($page) {

            case "about":
                $template->assign('page', $page);
                break;

        }

        $template->render();

    } else {

        $template = Template::init('v_404_not_found');

        $template->assign('self_url', Environment::getSelfURL());

        $template->render(404);

    }



}

?>