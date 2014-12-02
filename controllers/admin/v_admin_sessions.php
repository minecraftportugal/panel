<?

use lib\session\Session;
use models\session\SessionModel;
use helpers\arguments\ArgumentsHelper;
use helpers\notice\NoticeHelper;
use helpers\pagination\PaginationHelper;
use helpers\table\TableHelper;

function v_admin_sessions() {

    Session::validateSession(true);

    $action_url = '/admin/sessions';

    $form_url = '/admin/sessions';

    $parameters = [
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
    ];

    $p = ArgumentsHelper::process($_GET, $parameters);

    $total = SessionModel::count($p);

    $page = SessionModel::get($p);

    $link_after = ArgumentsHelper::serialize($p);

    $notices = NoticeHelper::render(['classes' => 'pull-right']);

    $pagination = new PaginationHelper([
        "page" => $p['page'],
        "total" => $total,
        "per_page" => $p['per_page'],
        "link_before" => $action_url,
        "link_after" => $link_after,
        "show_pages" => 4,
        "expand" => 20
    ]);

    $table = new TableHelper($action_url, $p);

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

    require('templates/admin/v_admin_sessions.php');
}

?>