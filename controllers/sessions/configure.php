<?

use lib\session\Session;
use helpers\Notice\NoticeHelper;

function sessions_configure () {

  Session::validateSession();
  Session::validateXSRFToken();

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