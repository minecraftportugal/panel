<?
require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

use helpers\Notice\NoticeHelper;

function sessions_configure () {

  validateSession();
  validateXSRFToken();

  $delete = isset($_POST['delete']) ? $_POST['delete'] : array();

  $status = sessionsConfigure($delete);

  if ($status) {
    NoticeHelper::set('success', 'Sessões apagadas.');
    header("Location: /admin/sessions");
  } else {
  	NoticeHelper::set('error', 'Erro ao apagar sessões.');
    header("Location: /admin/sessions");
  }

}

?>