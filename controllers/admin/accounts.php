<?

require_once('lib/sessions.php');

use models\account\AccountModel;
use helpers\request\RequestHelper;
use helpers\pagination\PaginationHelper;

function admin_accounts() {

  validateSession(true);

  $parameters = [
    'page' => 1,
    'per_page' => 20,
    'playername' => null,
    'ipaddress' => null,
    'emailaddress' => null,
    'login_date_begin' => null,
    'login_date_end' => null,
    'register_date_begin' => null,
    'register_date_end' => null,
    'nologin' => 0,
    'yeslogin' => 0,
    'nogame' => 0,
    'yesgame' => 0,
    'inactive' => 0,
    'admin' => 0,
    'operator' => 0,
    'contributor' => 0,
    'donor' => 0,
    'premium' => 0,
    'online' => 0,
  ];

  $p = RequestHelper::process($_GET, $parameters);

  $total = AccountModel::count($p);

  $page = AccountModel::get($p);

  $link_after = PaginationHelper::make_link($p);

  $navigation = PaginationHelper::navigation($p['page'], $total, $p['per_page'], '/admin/accounts', $link_after, 4, true);

  require('templates/admin/accounts.php');
}

?>