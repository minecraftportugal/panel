<?

use lib\session\Session;
use lib\template\Template;
use models\accounts\Accounts;

function v_page_launcher() {

    Session::validateSession();

    $template = Template::init('pages/v_launcher');

    $user = Accounts::first(['id' => Session::get('id')]);

    $template->assign('user', $user);

    $template->render();

}

?>
