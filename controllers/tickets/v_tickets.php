<?

use lib\session\Session;
use lib\template\Template;
use models\account\tickets\AccountTickets;
use helpers\arguments\ArgumentsHelper;
use helpers\notice\NoticeHelper;
use helpers\pagination\PaginationHelper;
use helpers\table\TableHelper;
use helpers\minotar\MinotarHelper;
use helpers\form\FormHelper;

function v_tickets() {

    Session::validateSession();

    $xsrf_token = Session::getXSRFToken();

    $template = Template::init('tickets/v_tickets');

    $parameters = ArgumentsHelper::process($_GET, [
        'id' => null,
        'ticket_date_begin' => null,
        'ticket_date_end' => null,
        'status' => null,
        'page' => 1,
        'per_page' => 10,
        'order_by' => '1',
        'asc_desc' => 'desc'
    ]);
    $parameters['owner'] = Session::get('username');
    $parameters['admin'] = null;
    $parameters['description'] = null;
    $parameters['expiration_date_begin'] = null;
    $parameters['expiration_date_end'] = null;
    $parameters['adminreply'] = null;
    $parameters['userreply'] = null;

    $action_url = '/tickets';

    $total = AccountTickets::count($parameters);
    $page = AccountTickets::get($parameters);

    /** Filters: Change and add new data */
    $i = 0;
    foreach ($page as $k => $v) {

        $page[$k]['ownerhead'] =  MinotarHelper::head($page[$k]['owner'], "24px", "3px");
        $page[$k]['adminhead'] =  MinotarHelper::head($page[$k]['admin'], "24px", "3px");
        $page[$k]['rowcolor'] = ($i++ % 2 == 0) ? 'dark' : 'light';
        $page[$k]['rowspan'] = 1 +
            ($page[$k]["adminreply"] != 'NONE' ? 1 : 0) +
            ($page[$k]["userreply"] != 'NONE' ? 1 : 0);

    }

    $notices = NoticeHelper::render();

    $link_after = ArgumentsHelper::serialize($parameters);

    $pagination = new PaginationHelper([
        'page' => $parameters['page'],
        'total' => $total,
        'per_page' => $parameters['per_page'],
        'link_before' => $action_url,
        'link_after' => $link_after,
        'show_pages' => 4,
        'expand' => 20
    ]);

    $table = new TableHelper($action_url, $parameters);

    $table->add_column([
        'width' => '20px',
        'label' => '#',
        'order_by' => 'id'
    ]);

    $table->add_column([
        'width' => '20px'
    ]);

    $table->add_column([
        'width' => '12%',
        'label' => 'Dono',
        'order_by' => 'owner'
    ]);

    $table->add_column([
        'width' => '50%',
        'label' => 'Descrição',
        'order_by' => 'description'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Data',
        'order_by' => 'date'
    ]);

    $table->add_column([
        'width' => '70px',
        'label' => 'Status',
        'order_by' => 'status'
    ]);


    $status_form_select = FormHelper::select('status', [
        [ 'value' => '', 'label' => '&mdash;'],
        [ 'value' => 'CLOSED', 'label' => 'CLOSED'],
        [ 'value' => 'OPEN', 'label' => 'OPEN']
    ], $parameters['status']);

    /*<select id="status_sel" name="status">
                        <option value="">&mdash;</option>
                        <option value="CLOSED">CLOSED</option>
                        <option value="OPEN">OPEN</option>
                    </select>;*/

    $template->assign('action_url', $action_url);

    $template->assign('parameters', $parameters);

    $template->assign('total', $total);

    $template->assign('page', $page);

    $template->assign('notices', $notices);

    $template->assign('table', $table);

    $template->assign('pagination', $pagination);

    $template->assign('xsrf_token', $xsrf_token);

    $template->assign('status_form_select', $status_form_select);

    $template->render();

}

?>