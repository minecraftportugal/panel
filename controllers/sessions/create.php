<?

require_once('lib/sessions.php');

function sessions_create () {
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  $session = validateLogin($username, $password);
  if ($session == NULL) {
  	setFlash('error', 'username/password inválidos');
    header('Location: /login');
  } else {
    header('Location: /');
  }
}

?>
