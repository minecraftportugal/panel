<?php

use models\drop\DropModel;
use helpers\Notice\NoticeHelper;

function admin_delete_drops() {

  //session: admin
  validateSession(true);
  validateXSRFToken();

  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

  $status = DropModel::delete($delete);
  if ($status) {
    NoticeHelper::set('success', 'Item drops apagados.');
    header("Location: /admin/drops");
  } else {
    NoticeHelper::set('error', 'Erro ao apagar item drops!');
    header("Location: /admin/drops");
  }

}

?>