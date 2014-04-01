<?

require_once('lib/sessions.php');

use models\drop\DropModel;
use helpers\arguments\ArgumentsHelper;
use helpers\notice\NoticeHelper;
use helpers\pagination\PaginationHelper;
use helpers\table\TableHelper;

function admin_drops() {

    validateSession(true);

    $action_url = '/admin/drops';

    $parameters = [
        "page" => 1,
        "per_page" => 20,
        "accountid" => null,
        "delivered" => 0,
        "undelivered" => 0,
        "order_by" => "dropdate_df",
        "asc_desc" => "desc"
    ];

    $p = ArgumentsHelper::process($_GET, $parameters);

    $total = DropModel::count($p);

    $page = DropModel::get($p);

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
        'width' => '30px'
    ]);

    $table->add_column([
        'width' => '20%',
        'label' => 'Item',
        'order_by' => 'itemdrop'
    ]);

    $table->add_column([
        'width' => '30px'
    ]);

    $table->add_column([
        'width' => '20%',
        'label' => 'Jogador',
        'order_by' => 'playername'
    ]);

    $table->add_column([
        'width' => '20%',
        'label' => 'Dropped',
        'order_by' => 'dropdate_df'
    ]);

    $table->add_column([
        'width' => '20%',
        'label' => 'Recebido',
        'order_by' => 'takendate_df'
    ]);


    $table->add_column([
        'width' => '20%',
        'label' => 'Recebido após',
        'order_by' => 'idledroptime'
    ]);

    $table->add_column([
        'width' => '18px',
        'alignment' => 'center',
        'label' => '<i class="fa fa-trash-o"></i>',
        'label_title' => 'Apagar'
    ]);

    require('templates/admin/drops.php');
}

?>
