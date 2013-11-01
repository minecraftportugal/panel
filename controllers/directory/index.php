<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');
require_once('lib/nav.php');

function directory_index() {
  global $cfg_wp_url;

  validateSession(true);

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $page = intval($page);
  $per_page = 21;
  $pages = getUserListPaged(($page-1)*$per_page, $per_page);
  $total = $pages['total'];
  $userlist = $pages['pages'];

  $page_navigation = navigation($page, $total, $per_page);

  require('templates/directory/index.php');
}

?>
