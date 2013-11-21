<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');
require_once('lib/nav.php');

function directory_index() {
  global $cfg_wp_url;

  validateSession();
  $playername = isset($_GET['playername']) && $_GET['playername'] != "" ? $_GET['playername'] : null;

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $page = intval($page);
  $per_page = 21;
  $pages = getUserListPaged(($page-1)*$per_page, $per_page, $playername);
  $total = $pages['total'];
  $userlist = $pages['pages'];

  $onlinePlayers = getOnlinePlayers();
  $f = function($e) {
    return $e['name'];
  };
  $flatOnlinePlayers = array_map($f, $onlinePlayers);

  $link_extra = "";
  $link_extra .= $playername != null ? "&playername=$playername" : "";

  $page_navigation = navigation($page, $total, $per_page, $link_extra);

  require('templates/directory/index.php');
}

?>
