<?

require_once('lib/sessions.php');

use models\fail\FailModel;
use helpers\arguments\ArgumentsHelper;
use helpers\notice\NoticeHelper;
use helpers\pagination\PaginationHelper;
use helpers\table\TableHelper;

function admin_fails() {

    validateSession(true);

    $action_url = '/admin/fails';

    $parameters = [
        "page" => 1,
        "per_page" => 20,
        "accountid" => null,
        "event_type" => null,
        "order_by" => "time",
        "asc_desc" => "desc"
    ];

    $p = ArgumentsHelper::process($_GET, $parameters);

    $total = FailModel::count($p);
    
    $page = FailModel::get($p);

    $link_after = ArgumentsHelper::serialize($p);

    $notices = NoticeHelper::render(['classes' => 'pull-right']);

    $pagination = new PaginationHelper([
      "page" => $p['page'],
      "total" => $total,
      "per_page" => $p['per_page'],
      "link_before" => $action_url,
      "link_after" => $link_after,
      "show_pages" => 4,
      "expand" => 20,
    ]);

    $table = new TableHelper($action_url, $p);

    $table->add_column([
        'width' => '15%',
        'label' => 'Time',
        'order_by' => 'time'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Event Type',
        'order_by' => 'event_type'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'IP Address',
        'order_by' => 'time'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Jogador',
        'order_by' => 'playername'
    ]);

    $table->add_column([
        'width' => '55%',
        'label' => 'Descrição',
        'order_by' => 'comment'
    ]);

    $table->add_column([
        'width' => '18px',
        'alignment' => 'center',
        'label' => '<i class="fa fa-trash-o"></i>',
        'label_title' => 'Apagar'
    ]);

    require('templates/admin/fails.php');
}

?>