<?

use lib\session\Session;
use lib\template\Template;
use models\session\SessionModel;
use helpers\arguments\ArgumentsHelper;
use helpers\minotar\MinotarHelper;
use helpers\notice\NoticeHelper;
use helpers\pagination\PaginationHelper;
use helpers\table\TableHelper;

function v_admin_sessions() {

    Session::validateSession(true);

    $xsrf_token = Session::getXSRFToken();

    $template = Template::init('admin/v_admin_sessions');

    $parameters = ArgumentsHelper::process($_GET, [
        'page' => 1,
        'length' => 3600,
        'per_page' => 20,
        'playername' => null,
        'ipaddress' => null,
        'date_begin' => null,
        'date_end' => null,
        'login' => 0,
        'logout' => 0,
        'online' => 0,
        'web' => 0,
        'order_by' => 'time',
        'asc_desc' => 'desc'
    ]);

    $action_url = '/admin/sessions';

    $form_url = '/admin/sessions';

    $total = SessionModel::count($parameters);

    $page = SessionModel::get($parameters);

    /** Filters: Change and add new data */
    foreach ($page as $k => $v) {

        $page[$k]['head'] =  MinotarHelper::head($page[$k]['playername'], "24px", "3px");

    }

    $link_after = ArgumentsHelper::serialize($parameters);

    $notices = NoticeHelper::render();

    $pagination = new PaginationHelper([
        "page" => $parameters['page'],
        "total" => $total,
        "per_page" => $parameters['per_page'],
        "link_before" => $action_url,
        "link_after" => $link_after,
        "show_pages" => 4,
        "expand" => 20
    ]);

    $table = new TableHelper($action_url, $parameters);

    $table->add_column([
        'width' => '30px'
    ]);

    $table->add_column([
        'width' => '25%',
        'label' => 'Jogador',
        'order_by' => 'playername'
    ]);

    $table->add_column([
        'width' => '25%',
        'label' => 'IP Sessão',
        'order_by' => 'ipaddress'
    ]);

    $table->add_column([
        'width' => '25%',
        'label' => 'Data',
        'label_title' => 'Timestamp',
        'order_by' => 'time'
    ]);

    $table->add_column([
        'width' => '25%',
        'label' => 'Informação',
        'label_title' => 'Informação',
    ]);

    $template->assign('action_url', $action_url);

    $template->assign('form_url', $form_url);

    $template->assign('parameters', $parameters);

    $template->assign('total', $total);

    $template->assign('page', $page);

    $template->assign('notices', $notices);

    $template->assign('table', $table);

    $template->assign('pagination', $pagination);

    $template->assign('xsrf_token', $xsrf_token);

    $template->render();

}

?>