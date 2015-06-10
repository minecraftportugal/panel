<?

use lib\session\Session;
use lib\template\Template;
use models\account\tickets\AccountTickets;
use models\accounts\Accounts;
use helpers\arguments\ArgumentsHelper;
use helpers\notice\NoticeHelper;
use helpers\dynmap\DynmapHelper;
use helpers\minotar\MinotarHelper;
use helpers\form\FormHelper;

function v_ticket() {

    Session::validateSession();

    $xsrf_token = Session::getXSRFToken();

    $admin = (Session::get('admin') == '1') ? true : false;

    $username = Session::get('username');

    $template = Template::init('tickets/v_ticket');

    $parameters = ArgumentsHelper::process($_GET, [
        'id' => null
    ]);

    $admin_reply_form_url = '/ticket/admin/reply';

    $user_reply_form_url = '/ticket/reply';

    $toggle_ticket_form_url = '/ticket/toggle';

    $assign_ticket_form_url = '/ticket/assign';

    $ticket = AccountTickets::first($parameters);

    $player = Accounts::first(['playername' => $ticket['owner']], true);

    $x = Accounts::get(['staff' => true]);
    $admins_form_select_options = array_merge(
        [['value' => '', 'label' => 'NONE']], array_map(function($item) {
            return [ 'value' => $item['playername'], 'label' => $item['playername']];
        }, $x)
    );
    $admins_form_select = FormHelper::select('admin', $admins_form_select_options, $ticket['admin']);

    $ticket['ownerhead'] =  MinotarHelper::head($ticket['owner'], "48px", "3px");

    $ticket['adminhead'] =  MinotarHelper::head($ticket['admin'], "48px", "3px");

   // var_dump($ticket); die();

    $dynmap_url = DynmapHelper::url_position([$ticket['x'], $ticket['y'], $ticket['z']], $ticket['world']);

    $dynmap = DynmapHelper::map_position([$ticket['x'], $ticket['y'], $ticket['z']], $ticket['world']);

    $notices = NoticeHelper::render();

    $template->assign('admin', $admin);

    $template->assign('username', $username);

    $template->assign('ticket', $ticket);

    $template->assign('player', $player);

    $template->assign('admins_form_select', $admins_form_select);

    $template->assign('dynmap', $dynmap);

    $template->assign('dynmap_url', $dynmap_url);

    $template->assign('admin_reply_form_url', $admin_reply_form_url);

    $template->assign('user_reply_form_url', $user_reply_form_url);

    $template->assign('toggle_ticket_form_url', $toggle_ticket_form_url);

    $template->assign('assign_ticket_form_url', $assign_ticket_form_url);

    $template->assign('parameters', $parameters);

    $template->assign('notices', $notices);

    $template->assign('xsrf_token', $xsrf_token);

    $template->render();

}

?>
