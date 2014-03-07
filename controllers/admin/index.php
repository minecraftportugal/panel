<?

require_once('lib/sessions.php');
require_once('lib/i18n.php');

use models\account\AccountModel;
use helpers\request\RequestHelper;

function admin_index() {

  validateSession(true);

  $addresses = getPopularAddresses();
  $addresses = $addresses != null ? $addresses : [];

  require('templates/admin/index.php');
}

?>
