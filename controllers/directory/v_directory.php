<?

use lib\session\Session;
use lib\template\Template;
use models\accounts\Accounts;
use helpers\arguments\ArgumentsHelper;
use helpers\pagination\PaginationHelper;
use helpers\minotar\MinotarHelper;
use helpers\notice\NoticeHelper;

function v_directory() {

    Session::validateSession();

    $template = Template::init('directory/v_directory');

    $parameters = ArgumentsHelper::process($_GET, [
        'playername' => null,
        'staff' => 0,
        'contributor' => 0,
        'donor' => 0,
        'premium' => 0,
        'online' => 0,
        'page' => 1,
        'per_page' => 30,
        'order_by' => 'registerdate_df',
        'asc_desc' => 'asc'
    ]);

    $action_url = '/directory';

    $total = Accounts::count($parameters);

    $page = Accounts::get($parameters);

    /** Filters: Change and add new data */
    foreach ($page as $k => $v) {

        $badges = Template::init('partials/badges');

        $badges->assign('badges', Accounts::badges($page[$k]['id']));

        $page[$k]['badges'] = $badges;

        $page[$k]['head'] =  MinotarHelper::head($page[$k]['playername'], "64px");

    }

    $link_after = ArgumentsHelper::serialize($parameters);

    $pagination = new PaginationHelper([
        "page" => $parameters['page'],
        "total" => $total,
        "per_page" => $parameters['per_page'],
        "link_before" => $action_url,
        "link_after" => $link_after,
        "show_pages" => 4,
        "expand" => 20
    ]);

    $template->assign('action_url', $action_url);

    $template->assign('parameters', $parameters);

    $template->assign('total', $total);

    $template->assign('page', $page);

    // $template->assign('table', $table);

    $template->assign('pagination', $pagination);

    $template->render();

}



?>
