<?

use lib\session\Session;
use models\account\AccountModel;
use helpers\minotar\MinotarHelper;

function v_home() {

    Session::validateSession();

    $user = AccountModel::get(['id' => $_SESSION['id']])[0];

    $background_image = '/images/backgrounds/login/bg5.jpg';

    require('templates/v_home.php');
}

?>
