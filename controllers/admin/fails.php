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
        'width' => '20%',
        'label' => 'Time',
        'order_by' => 'time'
    ]);

    $table->add_column([
        'width' => '20%',
        'label' => 'Event Type',
        'order_by' => 'event_type'
    ]);

    $table->add_column([
        'width' => '20%',
        'label' => 'IP Address',
        'order_by' => 'time'
    ]);

    $table->add_column([
        'width' => '20%',
        'label' => 'Player',
        'order_by' => 'accountid'
    ]);

    $table->add_column([
        'width' => '20%',
        'label' => 'Comment',
        'order_by' => 'comment'
    ]);

    require('templates/admin/fails.php');
}

?>
