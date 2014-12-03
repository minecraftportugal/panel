<?

use lib\session\Session;
use lib\render\Render;
use models\account\AccountModel;
use helpers\minotar\MinotarHelper;

function v_home() {

    Session::validateSession();

    $user = AccountModel::get(['id' => $_SESSION['id']])[0];

    $background_image = '/images/backgrounds/login/bg7.jpg';

    // Render::template('v_home'); ...

    require_once('templates/v_home.php');


}

?>
