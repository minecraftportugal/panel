<?

use lib\session\Session;
use lib\template\Template;
use models\account\AccountModel;
use helpers\minotar\MinotarHelper;

function v_home() {

    Session::validateSession();

    $template = Template::init('v_home');

    $template->assign('user', AccountModel::get(['id' => $_SESSION['id']])[0]);

    $template->assign('background_image', '/images/backgrounds/login/bg7.jpg');

    $template->render();

}

?>
