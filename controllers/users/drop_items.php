<?php

require_once('lib/itemdrops.php');

function users_drop_items () {

  //session: admin
  validateSession(true);
  validateXSRFToken();

  $id = isset($_POST['id']) && $_POST['id'] != "" ? $_POST['id'] : null;
  $itemid = isset($_POST['itemid']) && $_POST['itemid'] != "" ? $_POST['itemid'] : null;
  $itemaux = isset($_POST['itemaux']) && $_POST['itemaux'] != "" ? $_POST['itemaux'] : null;
  $itemqt = isset($_POST['itemid']) && $_POST['itemqt'] != "" ? $_POST['itemqt'] : null;

  if (($itemid == null) or ($itemqt == null)) {
    setFlash('error', 'Item ID ou quantidade inválida.');
    header("Location: /profile?id=$id#itemdrops");
    return;
  }

  $status = saveDrop($id, $itemid, $itemqt, $itemaux);
  if ($status) {
    setFlash('success', 'Item drop criada.');
    header("Location: /profile?id=$id#itemdrops");
  } else {
    setFlash('error', 'Erro ao criar itemdrop!');
    header("Location: /profile?id=$id#itemdrops");
  }

}

function users_delete_drops() {

  //session: admin
  validateSession(true);
  validateXSRFToken();

  $accountid = isset($_POST['id']) ? $_POST['id'] : null;
  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

  $status = dropsConfigure($delete);
  if ($status) {
    setFlash('success', 'Item drops apagados.');
    header("Location: /profile?id=$accountid#itemdrops");
  } else {
    setFlash('error', 'Erro ao apagar item drops!');
    header("Location: /profile?id=$accountid#itemdrops");
  }

}

?>