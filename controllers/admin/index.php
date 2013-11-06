<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function admin_index() {
  global $cfg_wp_url;

  validateSession($admin = true);
  $playername = isset($_GET['playername']) && $_GET['playername'] != "" ? $_GET['playername'] : null;
  $ipaddress = isset($_GET['ipaddress']) && $_GET['ipaddress'] != "" ? $_GET['ipaddress'] : null;
  $emailaddress = isset($_GET['emailaddress']) && $_GET['emailaddress'] != "" ? $_GET['emailaddress'] : null;
  $nologin = isset($_GET['nologin']) && $_GET['nologin'] == "1" ? $_GET['nologin'] : 0;
  $inactive = isset($_GET['inactive']) && $_GET['inactive'] == "1" ? $_GET['inactive'] : 0;

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $page = intval($page);
  $per_page = 20;
  
  $pages = getUserListPaged(($page-1)*$per_page, $per_page, $playername, $ipaddress, $emailaddress, $nologin, $inactive);
  $total = $pages['total'];
  $userlist = $pages['pages'];

  $addresses = getPopularAddresses();
  $addresses = $addresses != null ? $addresses : [];

  $link_extra = "";
  $link_extra .= $playername != null ? "&playername=$playername" : "";
  $link_extra .= $ipaddress != null ? "&ipaddress=$ipaddress" : "";
  $link_extra .= $emailaddress != null ? "&emailaddress=$emailaddress" : "";
  $link_extra .= $nologin != null ? "&nologin=$nologin" : "";
  $link_extra .= $inactive != null ? "&inactive=$inactive" : "";

  $page_navigation = navigation($page, $total, $per_page, $link_extra);

  require('templates/admin/index.php');
}

?>
