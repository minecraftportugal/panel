<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function admin_index() {
  global $cfg_wp_url;

  validateSession(true);
  $playername = isset($_GET['playername']) && $_GET['playername'] != "" ? $_GET['playername'] : null;
  $ipaddress = isset($_GET['ipaddress']) && $_GET['ipaddress'] != "" ? $_GET['ipaddress'] : null;
  $emailaddress = isset($_GET['emailaddress']) && $_GET['emailaddress'] != "" ? $_GET['emailaddress'] : null;
  $login_date_begin = isset($_GET['login_date_begin']) && $_GET['login_date_begin'] != "" ? $_GET['login_date_begin'] : null;
  $login_date_end = isset($_GET['login_date_end']) && $_GET['login_date_end'] != "" ? $_GET['login_date_end'] : null;
  $register_date_begin = isset($_GET['register_date_begin']) && $_GET['register_date_begin'] != "" ? $_GET['register_date_begin'] : null;
  $register_date_end = isset($_GET['register_date_end']) && $_GET['register_date_end'] != "" ? $_GET['register_date_end'] : null;
  $nologin = isset($_GET['nologin']) && $_GET['nologin'] == "1" ? $_GET['nologin'] : 0;
  $inactive = isset($_GET['inactive']) && $_GET['inactive'] == "1" ? $_GET['inactive'] : 0;
  $admin = isset($_GET['admin']) && $_GET['admin'] == "1" ? $_GET['admin'] : 0;
  $operator = isset($_GET['operator']) && $_GET['operator'] == "1" ? $_GET['operator'] : 0;
  $contributor = isset($_GET['contributor']) && $_GET['contributor'] == "1" ? $_GET['contributor'] : 0;
  $donor = isset($_GET['donor']) && $_GET['donor'] == "1" ? $_GET['donor'] : 0;
  $premium = isset($_GET['premium']) && $_GET['premium'] == "1" ? $_GET['premium'] : 0;

  $accounts_per_page = isset($_GET['accounts_per_page']) ? $_GET['accounts_per_page'] : 20;
  $accounts_page = isset($_GET['accounts_page']) ? $_GET['accounts_page'] : 1;
  $accounts_page = intval($accounts_page);
  $accounts_per_page = intval($accounts_per_page);

  $sessions_per_page = isset($_GET['sessions_per_page']) ? $_GET['sessions_per_page'] : 20;
  $sessions_page = isset($_GET['sessions_page']) ? $_GET['sessions_page'] : 1;
  $sessions_page = intval($sessions_page);
  $sessions_per_page = intval($sessions_per_page);

  
  $accounts_pages = getUserListPaged(($accounts_page-1)*$accounts_per_page, $accounts_per_page, $playername, $ipaddress,
    $emailaddress, $login_date_begin, $login_date_end, $register_date_begin, $register_date_end,
    $nologin, $inactive, $admin, $operator, $contributor, $donor, $premium);
  $total_accounts = $accounts_pages['total'];
  $accounts = $accounts_pages['pages'];

  $sessions_pages = getSessionsPaged(($sessions_page-1)*$sessions_per_page, $sessions_per_page);
  $total_sessions = $sessions_pages['total'];
  $sessions = $sessions_pages['pages'];

  $onlinePlayers = getOnlinePlayers();
  $f = function($e) {
    return $e['name'];
  };
  $flatOnlinePlayers = array_map($f, $onlinePlayers);

  $addresses = getPopularAddresses();
  $addresses = $addresses != null ? $addresses : [];

  $link_extra = "";
  $link_extra .= $playername != null ? "&playername=$playername" : "";
  $link_extra .= $ipaddress != null ? "&ipaddress=$ipaddress" : "";
  $link_extra .= $emailaddress != null ? "&emailaddress=$emailaddress" : "";
  $link_extra .= $login_date_begin != null ? "&login_date_begin=$login_date_begin" : "";
  $link_extra .= $login_date_end != null ? "&login_date_end=$login_date_end" : "";
  $link_extra .= $register_date_begin != null ? "&register_date_begin=$register_date_begin" : "";
  $link_extra .= $register_date_end != null ? "&register_date_end=$register_date_end" : "";
  $link_extra .= $nologin != null ? "&nologin=$nologin" : "";
  $link_extra .= $inactive != null ? "&inactive=$inactive" : "";
  $link_extra .= $admin != null ? "&admin=$admin" : "";
  $link_extra .= $operator != null ? "&operator=$operator" : "";
  $link_extra .= $contributor != null ? "&contributor=$contributor" : "";
  $link_extra .= $donor != null ? "&donor=$donor" : "";
  $link_extra .= $premium != null ? "&premium=$premium" : "";

  $accounts_page_navigation = navigation($accounts_page, $total_accounts, $accounts_per_page, $link_extra, 4, true, 'accounts_page', 'accounts_per_page');

  $sessions_page_navigation = navigation($sessions_page, $total_sessions, $sessions_per_page, '#sessions', 4, true, 'sessions_page', 'sessions_per_page');

  require('templates/admin/index.php');
}

?>