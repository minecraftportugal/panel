<?

use models\account\AccountModel;
use helpers\request\RequestHelper;
use helpers\pagination\PaginationHelper;
use helpers\notice\NoticeHelper;

function directory_index() {

  validateSession();

  $parameters = [
    'playername' => null,
    'staff' => 0,
    'contributor' => 0,
    'donor' => 0,
    'premium' => 0,
    'online' => 0,
    'page' => 1,
    'per_page' => 80
  ];

  $p = RequestHelper::process($_GET, $parameters);

  $total = AccountModel::count($p);

  $pages = AccountModel::get($p);

  $notice = NoticeHelper::get();

  $link_after = PaginationHelper::make_link($p);

  $navigation = PaginationHelper::navigation($p['page'], $total, $p['per_page'], '/directory', $link_after, 4, true);

  require('templates/directory/index.php');
}

?>
