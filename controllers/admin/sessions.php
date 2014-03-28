s<?

require_once('lib/sessions.php');

use models\session\SessionModel;
use helpers\arguments\ArgumentsHelper;
use helpers\pagination\PaginationHelper;
use helpers\table\TableHelper;

function admin_sessions() {

    validateSession(true);

    $action_url = '/admin/sessions';

    $parameters = [
        'page' => 1,
        'length' => 3600,
        'per_page' => 20,
        'playername' => null,
        'ipaddress' => null,
        'date_begin' => null,
        'date_end' => null,
        'valid' => 0,
        'invalid' => 0,
        'online' => 0,
        'web' => 0
    ];

    $p = ArgumentsHelper::process($_GET, $parameters);

    $total = SessionModel::count($p);

    $page = SessionModel::get($p);

    $link_after = ArgumentsHelper::serialize($p);

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
        'label' => 'Nome',
        'label_title' => 'Nome do jogador',
        'order_by' => 'playername'
    ]);

    $table->add_column([
        'width' => '25%',
        'label' => 'IP Sessão',
        'label_title' => 'Endereço IP da sessão',
        'order_by' => 'lastloginip'
    ]);

    $table->add_column([
        'width' => '25%',
        'label' => 'Ultimo login (session)',
        'label_title' => 'Data',
        'order_by' => 'logintime_df'
    ]);

    $table->add_column([
        'width' => '25%',
        'label' => 'Ultimo login (account)',
        'label_title' => 'Data',
        'order_by' => 'lastlogindate_df'
    ]);

    $table->add_column([
        'width' => '18px',
        'alignment' => 'center',
        'label' => '<i class="fa fa-star"></i>',
        'label_title' => 'Tipo Sessão'
    ]);

    $table->add_column([
        'width' => '18px',
        'alignment' => 'center',
        'label' => '<i class="fa fa-trash-o"></i>',
        'label_title' => 'Apagar'
    ]);



    require('templates/admin/sessions.php');
}

?>