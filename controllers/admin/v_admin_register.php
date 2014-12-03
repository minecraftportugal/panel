<?

use lib\session\Session;
use lib\template\Template;

function v_admin_register() {

    Session::validateSession(true);

    $template = Template::init('admin/v_admin_register');

    $xsrf_token = Session::getXSRFToken();

    $template->assign('xsrf_token', $xsrf_token);

    $template->render();

}

?>