<?

require_once('lib/sessions.php');

use models\account\AccountModel;

function launcher_index() {  
  validateSession();
  
  $user = AccountModel::get(['id' => $_SESSION['id']])[0];

  require('templates/launcher/index.php');
}

?>
