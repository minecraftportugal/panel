<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');
require_once('helpers/nav.php');

function directory_index() {
  global $cfg_wp_url;

  validateSession();
  $playername = isset($_GET['playername']) && $_GET['playername'] != "" ? $_GET['playername'] : null;
  $staff = isset($_GET['staff']) && $_GET['staff'] == "1" ? $_GET['staff'] : 0;
  $contributor = isset($_GET['contributor']) && $_GET['contributor'] == "1" ? $_GET['contributor'] : 0;
  $donor = isset($_GET['donor']) && $_GET['donor'] == "1" ? $_GET['donor'] : 0;
  $premium = isset($_GET['premium']) && $_GET['premium'] == "1" ? $_GET['premium'] : 0;
  $online = isset($_GET['online']) && $_GET['online'] == "1" ? $_GET['online'] : 0;

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $page = intval($page);
  $per_page = 21;
  $pages = getUserListPaged(($page-1)*$per_page, $per_page, $playername, null,
    null, null, null, null, null,
    0, 0, 0, 0, $contributor, $donor, $premium, $online, $staff);
  $total = $pages['total'];
  $userlist = $pages['pages'];

  $onlinePlayers = getOnlinePlayers();
  $f = function($e) {
    return $e['name'];
  };
  $flatOnlinePlayers = array_map($f, $onlinePlayers);

  $link_after = "";
  $link_after .= $playername != null ? "&playername=$playername" : "";
  $link_after .= $staff != null ? "&staff=$staff" : "";
  $link_after .= $contributor != null ? "&contributor=$contributor" : "";
  $link_after .= $donor != null ? "&donor=$donor" : "";
  $link_after .= $premium != null ? "&premium=$premium" : "";
  $link_after .= $online != null ? "&online=$online" : "";

  $page_navigation = navigation($page, $total, $per_page, "", $link_after);

  require('templates/directory/index.php');
}

?>
