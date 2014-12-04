<?

use lib\session\Session;
use lib\template\Template;
use models\account\AccountModel;
use helpers\arguments\ArgumentsHelper;
use helpers\notice\NoticeHelper;
use helpers\pagination\PaginationHelper;
use helpers\table\TableHelper;
use helpers\minotar\MinotarHelper;
use helpers\datetime\DateTimeHelper;

function v_admin_accounts() {

    Session::validateSession(true);

    $template = Template::init('admin/v_admin_accounts');

    $parameters = ArgumentsHelper::process($_GET, [
        'page' => 1,
        'per_page' => 20,
        'playername' => null,
        'ipaddress' => null,
        'emailaddress' => null,
        'login_date_begin' => null,
        'login_date_end' => null,
        'register_date_begin' => null,
        'register_date_end' => null,
        'nologin' => 0,
        'yeslogin' => 0,
        'nogame' => 0,
        'yesgame' => 0,
        'inactive' => 0,
        'admin' => 0,
        'operator' => 0,
        'contributor' => 0,
        'donor' => 0,
        'premium' => 0,
        'online' => 0,
        'order_by' => 'registerdate_df',
        'asc_desc' => 'desc'
    ]);

    $action_url = '/admin/accounts';

    $form_url = '/admin/accounts';

    $total = AccountModel::count($parameters);

    $page = AccountModel::get($parameters);

    /** Filters: Change and add new data */
    foreach ($page as $k => $v) {

        $badges = Template::init('partials/badges');

        $badges->assign('badges', AccountModel::badges($page[$k]['id']));

        $page[$k]['badges'] = $badges;

        $page[$k]['head'] =  MinotarHelper::head($page[$k]['playername'], 24, 3);

        $page[$k]['totalTime'] = DateTimeHelper::stoh($page[$k]["totalTime"]);

        $page[$k]['sessionTime'] = DateTimeHelper::stoh($page[$k]["sessionTime"]);

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
        "expand" => 20
    ]);

    $table = new TableHelper($action_url, $parameters);

    $table->add_column([
        'width' => '30px'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Jogador',
        'order_by' => 'playername'
    ]);

    $table->add_column([
        'width' => '15%'
    ]);

    $table->add_column([
        'width' => '25%',
        'label' => 'Endereço E-mail',
        'order_by' => 'email'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Registo',
        'order_by' => 'registerdate_df'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Ultimo login',
        'order_by' => 'lastlogindate_df'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Ultimo IP',
        'label_title' => 'Ultimo IP (não actualizado se entrar não registado/logado)',
        'order_by' => 'lastloginip'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Tempo total',
        'label_title' => 'Tempo total em jogo',
        'order_by' => 'totalTime'
    ]);

    $table->add_column([
        'width' => '15%',
        'label' => 'Tempo da Sessão',
        'label_title' => 'Tempo da última sessão',
        'order_by' => 'sessionTime'
    ]);

    $table->add_column([
        'width' => '18px',
        'alignment' => 'center',
        'label' => '<i class="fa fa-star-half-empty"></i>',
        'label_title' => 'Operador'
    ]);

    $table->add_column([
        'width' => '18px',
        'alignment' => 'center',
        'label' => '<i class="fa fa-star"></i>',
        'label_title' => 'Administrador'
    ]);

    $table->add_column([
        'width' => '18px',
        'alignment' => 'center',
        'label' => '<i class="fa fa-check"></i>',
        'label_title' => 'Activo'
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

    $template->assign('xsrf_token', Session::getXSRFToken());

    $template->render();

}

?>
