<?

require_once('lib/sessions.php');
require_once('lib/i18n.php');

use models\session\SessionModel;
use helpers\request\RequestHelper;
use helpers\pagination\PaginationHelper;

function admin_sessions() {

  validateSession(true);

  $parameters = [
    'page' => 1,
    'length' => 3600,
    'per_page' => 20,
    'playername' => null,
    'ipaddress' => null,
    'date_begin' => null,
    'date_end' => null,
    'valid' => 0,
    'invalid' => 0,
    'online' => 0,
    'web' => 0
  ];

  $p = RequestHelper::process($_GET, $parameters);

  $total = SessionModel::count($p);

  $page = SessionModel::get($p);

  $link_after = PaginationHelper::make_link($p, '#sessions');

  $navigation = PaginationHelper::navigation($p['page'], $total, $p['per_page'], "", $link_after, 4, true);

  require('templates/admin/sessions.php');
}

?>
