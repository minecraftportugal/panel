<?php

use lib\session\Session;
use models\account\drops\AccountDrops;
use helpers\notice\NoticeHelper;

function u_admin_drops() {

  //session: admin
  Session::validateSession(true);
  Session::validateXSRFToken();

  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

  $status = AccountDrops::delete($delete);
  if ($status) {
    NoticeHelper::set('success', 'Item drops apagados.');
    header("Location: /admin/drops");
  } else {
    NoticeHelper::set('error', 'Erro ao apagar item drops!');
    header("Location: /admin/drops");
  }

}

?>