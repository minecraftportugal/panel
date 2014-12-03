<?

use lib\session\Session;
use helpers\notice\NoticeHelper;

function v_user_register() {

  if (Session::isLoggedIn()) {
    header('Location: /');
    exit();
  }

  $error = NoticeHelper::get('error');

  $success = NoticeHelper::get('success');

  require('templates/users/v_user_register.php');
}

?>
