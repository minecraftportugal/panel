<?

use lib\session\Session;

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
