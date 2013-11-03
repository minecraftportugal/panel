<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function admin_index() {
  global $cfg_wp_url;

  validateSession($admin = true);
  $playername = isset($_GET['playername']) && $_GET['playername'] != "" ? $_GET['playername'] : null;
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $page = intval($page);
  $per_page = 20;
  
  $pages = getUserListPaged(($page-1)*$per_page, $per_page, $playername);
  $total = $pages['total'];
  $userlist = $pages['pages'] != null ? $pages['pages'] : array();

  $page_navigation = navigation($page, $total, $per_page);

  require('templates/admin/index.php');
}

?>
