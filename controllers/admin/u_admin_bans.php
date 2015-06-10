<?php

use lib\session\Session;
use models\bans\Bans;
use helpers\notice\NoticeHelper;

function u_admin_bans() {

    //session: admin
    Session::validateSession(true);
    Session::validateXSRFToken();

    $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

    $status = Bans::delete($delete);

    if ($status) {
        NoticeHelper::set('success', 'Not Yet Working!');
        header("Location: /admin/bans");
    } else {
        NoticeHelper::set('error', 'Erro ao apagar bans!');
        header("Location: /admin/bans");
    }

}

?>