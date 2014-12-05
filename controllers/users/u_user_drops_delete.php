<?php

use lib\session\Session;
use models\drop\DropModel;
use helpers\notice\NoticeHelper;

function u_user_drops_delete() {

  //session: admin
  Session::validateSession(true);
  Session::validateXSRFToken();

  $accountid = isset($_POST['accountid']) ? $_POST['accountid'] : null;
  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

  $status = DropModel::delete($delete);

  if ($status) {

    NoticeHelper::set('success', 'Item drops apagados.');
    header("Location: /profile?id=$accountid");

  } else {

    NoticeHelper::set('error', 'Erro ao apagar item drops!');
    header("Location: /profile?id=$accountid");

  }

}

?>