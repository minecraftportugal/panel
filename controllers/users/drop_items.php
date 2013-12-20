<?php

require_once('lib/itemdrops.php');

function users_drop_items () {

  //session: admin
  validateSession(true);
  validateXSRFToken();

  $id = isset($_POST['id']) && $_POST['id'] != "" ? $_POST['id'] : null;
  $itemid = isset($_POST['itemid']) && $_POST['itemid'] != "" ? $_POST['itemid'] : null;
  $itemqt = isset($_POST['itemid']) && $_POST['itemqt'] != "" ? $_POST['itemqt'] : null;

  if (($itemid == null) or ($itemqt == null)) {
    setFlash('error', 'Item ID ou quantidade inválida.');
    header("Location: /profile?id=$id#itemdrops");
    return;
  }

  $status = saveDrop($id, $itemid, $itemqt);
  if ($status) {
    setFlash('success', 'Item drop criada.');
    header("Location: /profile?id=$id#itemdrops");
  } else {
    setFlash('error', 'Erro ao criar itemdrop!');
    header("Location: /profile?id=$id#itemdrops");
  }

}

?>