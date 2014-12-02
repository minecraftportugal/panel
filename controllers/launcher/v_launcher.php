<?

use lib\session\Session;
use models\account\AccountModel;

function launcher_index() {  
  Session::validateSession();
  
  $user = AccountModel::get(['id' => $_SESSION['id']])[0];

  require('templates/launcher/v_launcher.php');
}

?>
