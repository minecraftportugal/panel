<?php

require_once('lib/itemdrops.php');

function admin_delete_drops() {

  //session: admin
  validateSession(true);
  validateXSRFToken();

  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

  $status = dropsConfigure($delete);
  if ($status) {
    setFlash('success', 'Item drops apagados.');
    header("Location: /admin#drops");
  } else {
    setFlash('error', 'Erro ao apagar item drops!');
    header("Location: /admin#drops");
  }

}

?>