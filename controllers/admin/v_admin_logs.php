<?

use lib\session\Session;
use lib\template\Template;
use models\logs\Logs;
use helpers\arguments\ArgumentsHelper;
use helpers\notice\NoticeHelper;
use helpers\pagination\PaginationHelper;
use helpers\table\TableHelper;

function v_admin_logs() {

    Session::validateSession(true);

    $xsrf_token = Session::getXSRFToken();

    $template = Template::init('admin/v_admin_logs');

    $action_url = '/admin/logs';

    $form_url = '/admin/logs';

    $event_types = Logs::event_types();

    $parameters = ArgumentsHelper::process($_GET, [
        "page" => 1,
        "per_page" => 20,
        "accountid" => null,
        "event_type" => [],
        "order_by" => "time",
        "asc_desc" => "desc"
    ]);


    $total = Logs::count($parameters);

    $page = Logs::get($parameters);

    $link_after = ArgumentsHelper::serialize($parameters);

    $notices = NoticeHelper::render();

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
        'order_by' => 'ipaddress'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Jogador',
        'order_by' => 'accountid'
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

    $template->assign('action_url', $action_url);

    $template->assign('form_url', $form_url);

    $template->assign('parameters', $parameters);

    $template->assign('total', $total);

    $template->assign('page', $page);

    $template->assign('notices', $notices);

    $template->assign('event_types', $event_types);

    $template->assign('table', $table);

    $template->assign('pagination', $pagination);

    $template->assign('xsrf_token', $xsrf_token);

    $template->render();

}

?>