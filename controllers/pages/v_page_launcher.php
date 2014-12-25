<?

use lib\session\Session;
use lib\template\Template;
use models\account\AccountModel;

function v_page_launcher() {

    Session::validateSession();

    $template = Template::init('pages/v_launcher');

    $user = AccountModel::first(['id' => Session::get('id')]);

    $template->assign('user', $user);

    $template->render();

}

?>
