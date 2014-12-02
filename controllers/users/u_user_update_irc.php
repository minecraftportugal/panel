<?

use lib\session\Session;
use \models\account\AccountModel;

function u_user_update_irc() {

    Session::validateSession();
    Session::validateXSRFToken();

    $id = $_SESSION['id'];
    $irc_nickname = isset($_POST['irc_nickname']) ? $_POST['irc_nickname'] : NULL;
    $irc_password = isset($_POST['irc_password']) ? $_POST['irc_password'] : NULL;
    $irc_auto = isset($_POST['irc_auto']) ? $_POST['irc_auto'] : 0;

    $status = AccountModel::changeIRC($id, $irc_nickname, $irc_password, $irc_auto);

    if (!$status) {
        header("Location: /options");
    } else {
        header("Location: /options");
    }
}

?>