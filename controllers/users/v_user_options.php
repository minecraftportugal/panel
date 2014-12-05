<?

use lib\session\Session;
use lib\template\Template;
use models\account\AccountModel;
use helpers\notice\NoticeHelper;

function v_user_options() {

    Session::validateSession();

    $template = Template::init('users/v_user_options');

    $player = AccountModel::first(["id" => $_SESSION["id"]]);

    $notices = NoticeHelper::render(['classes' => 'hover-notice']);

    $template->assign('player', $player);

    $template->assign('notices', $notices);
    
    $xsrf_token = Session::getXSRFToken();

    $template->assign('xsrf_token', $xsrf_token);

    $template->render();

}

?>
