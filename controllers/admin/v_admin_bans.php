<?

use lib\session\Session;
use lib\template\Template;
use models\bans\Bans;
use helpers\arguments\ArgumentsHelper;
use helpers\minotar\MinotarHelper;
use helpers\notice\NoticeHelper;
use helpers\pagination\PaginationHelper;
use helpers\table\TableHelper;
use helpers\form\FormHelper;

function v_admin_bans() {

    Session::validateSession(true);

    $xsrf_token = Session::getXSRFToken();

    $template = Template::init('admin/v_admin_bans');

    $parameters = ArgumentsHelper::process($_GET, [
        "page" => 1,
        "per_page" => 20,
        "subject" => null,
        "banner" => null,
        "bantype" => null,
        "created_date_begin" => null,
        "created_date_end" => null,
        "expires_date_begin" => null,
        "expires_date_end" => null,
        "permanent" => 0,
        "temporary" => 0,
        "expired" => 0,
        "effective" => 0,
        "order_by" => "time_df",
        "asc_desc" => "desc"
    ]);

    $action_url = '/admin/bans';

    $form_url = '/admin/bans';

    $total = Bans::count($parameters);

    $page = Bans::get($parameters);

    /** Filters: Change and add new data */
    foreach ($page as $k => $v) {
        $page[$k]['bannerhead'] =  MinotarHelper::head($page[$k]['banner'], "24px", "3px");
        if ($page[$k]['bantype'] != 'IP') {
            $page[$k]['subjecthead'] =  MinotarHelper::head($page[$k]['subject'], "24px", "3px");
        } else {
            $page[$k]['subjecthead'] =  '';
        }

        $page[$k]['effective'] = (substr($page[$k]["delta_future"], 0, 1) == '-');

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
        "expand" => 20,
    ]);

    $table = new TableHelper($action_url, $parameters);

    $table->add_column([
        'width' => '30px'
    ]);

    $table->add_column([
        'width' => '10%',
        'label' => 'Sujeito',
        'order_by' => 'subject'
    ]);

    $table->add_column([
        'width' => '40%',
        'label' => 'Motivo',
        'order_by' => 'reason'
    ]);

    $table->add_column([
        'width' => '30px'
    ]);

    $table->add_column([
        'width' => '10%',
        'label' => 'Admin',
        'order_by' => 'banner'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Data',
        'order_by' => 'time_df'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Expira',
        'order_by' => 'expires_df'
    ]);

    $table->add_column([
        'width' => '18px',
        'alignment' => 'center',
        'label' => '<i class="fa fa-trash-o"></i>',
        'label_title' => 'Apagar'
    ]);

    $bantype_form_select = FormHelper::select('bantype', [
        [ 'value' => '', 'label' => '&mdash;'],
        [ 'value' => 'NAME', 'label' => 'NAME'],
        [ 'value' => 'IP', 'label' => 'IP'],
        [ 'value' => 'MUTE', 'label' => 'MUTE']
    ], $parameters['bantype']);

    $template->assign('action_url', $action_url);

    $template->assign('form_url', $form_url);

    $template->assign('parameters', $parameters);

    $template->assign('total', $total);

    $template->assign('page', $page);

    $template->assign('notices', $notices);

    $template->assign('table', $table);

    $template->assign('bantype_form_select', $bantype_form_select);

    $template->assign('pagination', $pagination);

    $template->assign('xsrf_token', $xsrf_token);

    $template->render();

}

?>
