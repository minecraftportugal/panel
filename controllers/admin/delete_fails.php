<?php

use models\fail\FailModel;
use helpers\Notice\NoticeHelper;

function admin_delete_fails() {

  //session: admin
  validateSession(true);
  validateXSRFToken();

  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

  $status = FailModel::delete($delete);
  if ($status) {
    NoticeHelper::set('success', 'Logs apagados.');
    header("Location: /admin/fails");
  } else {
    NoticeHelper::set('error', 'Erro ao apagar logs!');
    header("Location: /admin/fails");
  }

}

?>