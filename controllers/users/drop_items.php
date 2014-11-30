<?php

use lib\session\Session;
use models\drop\DropModel;
use helpers\notice\NoticeHelper;

function users_drop_items () {

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

  $status = DropModel::create($id, $itemid, $itemqt, $itemaux);
  if ($status) {
    NoticeHelper::set('success', 'Item drop criada.');
    header("Location: /profile?id=$id");
  } else {
    NoticeHelper::set('error', 'Erro ao criar itemdrop!');
    header("Location: /profile?id=$id");
  }

}

function users_delete_drops() {

  //session: admin
  Session::validateSession(true);
  Session::validateXSRFToken();

  $accountid = isset($_POST['id']) ? $_POST['id'] : null;
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