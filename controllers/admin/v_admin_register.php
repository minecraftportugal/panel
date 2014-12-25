<?

use lib\session\Session;
use lib\template\Template;
use helpers\notice\NoticeHelper;

function v_admin_register() {

    Session::validateSession(true);

    $template = Template::init('admin/v_admin_register');

    $notices = NoticeHelper::render();

    $xsrf_token = Session::getXSRFToken();

    $template->assign('notices', $notices);

    $template->assign('xsrf_token', $xsrf_token);

    $template->render();

}

?>