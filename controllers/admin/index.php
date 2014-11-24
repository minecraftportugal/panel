<?

require_once('lib/sessions.php');

use models\account\AccountModel;
use helpers\request\RequestHelper;

function admin_index() {

  validateSession(true);

  $addresses = getPopularAddresses();
  $addresses = $addresses != null ? $addresses : [];

  require('templates/admin/index.php');
}

?>
