<?

require_once('lib/sessions.php');

use models\account\AccountModel;

use helpers\minotar\MinotarHelper;

function home() {

    validateSession();

    $user = AccountModel::get(['id' => $_SESSION['id']])[0];

    $background_image = '/images/backgrounds/login/bg5.jpg';

    /* 
     * URL do dynmap.
     *    Abrir por defeito o mapa em que o jogador está 
     */
    $dynmap_url = DYNMAP_URL;

    if ($user['world'] != NULL) {
        $dynmap_url .= "?worldname=" . $user['world'];
    }

    require('templates/home.php');
}

?>
