<?

use lib\session\Session;
use models\account\drops\AccountDrops;
use helpers\notice\NoticeHelper;

function u_user_drops_drop() {

    //session: admin
    Session::validateSession(true);
    Session::validateXSRFToken();

    $id = isset($_POST['id']) && $_POST['id'] != "" ? $_POST['id'] : null;
    $itemid = isset($_POST['itemid']) && $_POST['itemid'] != "" ? $_POST['itemid'] : null;
    $itemaux = isset($_POST['itemaux']) && $_POST['itemaux'] != "" ? $_POST['itemaux'] : 0;
    $itemqt = isset($_POST['itemid']) && $_POST['itemqt'] != "" ? $_POST['itemqt'] : null;


    if (($itemid == null) or ($itemqt == null)) {
        NoticeHelper::set('error', 'Item ID ou quantidade inválida.');
        header("Location: /profile?id=$id");
        return;
    }

    if (($itemid <= 0) or ($itemaux < 0) or ($itemqt <= 0)) {
        NoticeHelper::set('error', 'Item ID ou quantidade inválida.');
        header("Location: /profile?id=$id");
        return;
    }

    $status = AccountDrops::create($id, $itemid, $itemqt, $itemaux);
    if ($status) {
        NoticeHelper::set('success', 'Item drop criada.');
        header("Location: /profile?id=$id");
    } else {
        NoticeHelper::set('error', 'Erro ao criar itemdrop!');
        header("Location: /profile?id=$id");
    }

}

?>