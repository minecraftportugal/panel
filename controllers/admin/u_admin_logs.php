<?php

use lib\session\Session;
use models\log\LogModel;
use helpers\notice\NoticeHelper;

function u_admin_logs() {

  //session: admin
  Session::validateSession(true);
  Session::validateXSRFToken();

  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

  $status = LogModel::delete($delete);
  if ($status) {
    NoticeHelper::set('success', 'Logs apagados.');
    header("Location: /admin/logs");
  } else {
    NoticeHelper::set('error', 'Erro ao apagar logs!');
    header("Location: /admin/logs");
  }

}

?>