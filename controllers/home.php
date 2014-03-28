<?
require_once('config.php');
require_once('lib/sessions.php');

use models\account\AccountModel;

use helpers\minotar\MinotarHelper;

function home() {
    global $cfg_wp_url;
    global $cfg_dynmap_url;

    validateSession();

    $user = AccountModel::get(['id' => $_SESSION['id']])[0];

    /* 
     * URL do dynmap.
     *    Abrir por defeito o mapa em que o jogador está 
     */
    $dynmap_url = $cfg_dynmap_url;

    if ($user['world'] != NULL) {
        $dynmap_url .= "?worldname=" . $user['world'];
    }

    require('templates/home.php');
}

?>
