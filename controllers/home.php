<?

require_once('lib/sessions.php');

use models\account\AccountModel;
use helpers\minotar\MinotarHelper;

function home() {

    validateSession();

    $user = AccountModel::get(['id' => $_SESSION['id']])[0];

    $background_image = '/images/backgrounds/login/bg5.jpg';

    require('templates/home.php');
}

?>
