<?

require_once('lib/sessions.php');

use models\drop\DropModel;
use helpers\request\RequestHelper;
use helpers\pagination\PaginationHelper;

function admin_drops() {

  validateSession(true);

  $parameters = [
    'page' => 1,
    'per_page' => 20,
    'delivered' => 0,
    'undelivered' => 0,
  ];

  $p = RequestHelper::process($_GET, $parameters);

  $total = DropModel::count($p);

  $page = DropModel::get($p);

  $link_after = PaginationHelper::make_link($p, '#drops');

  $navigation = PaginationHelper::navigation($p['page'], $total, $p['per_page'], "", $link_after, 4, true);

  require('templates/admin/drops.php');
}

?>
