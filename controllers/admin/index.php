<?

use lib\session\Session;
use models\account\AccountModel;
use helpers\request\RequestHelper;

function admin_index() {

  Session::validateSession(true);

  $addresses = getPopularAddresses();
  $addresses = $addresses != null ? $addresses : [];

  require('templates/admin/index.php');
}

?>
