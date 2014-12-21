<?

use lib\session\Session;
use lib\template\Template;
use models\drop\DropModel;
use helpers\arguments\ArgumentsHelper;
use helpers\minotar\MinotarHelper;
use helpers\notice\NoticeHelper;
use helpers\pagination\PaginationHelper;
use helpers\table\TableHelper;

function v_admin_drops() {

    Session::validateSession(true);

    $xsrf_token = Session::getXSRFToken();

    $template = Template::init('admin/v_admin_drops');

    $parameters = ArgumentsHelper::process($_GET, [
        "page" => 1,
        "per_page" => 20,
        "accountid" => null,
        "drop_date_begin" => null,
        "drop_date_end" => null,
        "taken_date_begin" => null,
        "taken_date_end" => null,
        "delivered" => 0,
        "undelivered" => 0,
        "order_by" => "dropdate_df",
        "asc_desc" => "desc"
    ]);

    $action_url = '/admin/drops';

    $form_url = '/admin/drops';

    $total = DropModel::count($parameters);

    $page = DropModel::get($parameters);

    /** Filters: Change and add new data */
    foreach ($page as $k => $v) {

        $page[$k]['head'] =  MinotarHelper::head($page[$k]['playername'], "24px", "3px");

    }

    $link_after = ArgumentsHelper::serialize($parameters);

    $notices = NoticeHelper::render(['classes' => 'pull-right']);

    $pagination = new PaginationHelper([
      "page" => $parameters['page'],
      "total" => $total,
      "per_page" => $parameters['per_page'],
      "link_before" => $action_url,
      "link_after" => $link_after,
      "show_pages" => 4,
      "expand" => 20,
    ]);

    $table = new TableHelper($action_url, $parameters);

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
