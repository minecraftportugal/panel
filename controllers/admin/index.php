<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function admin_index() {
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
  $online = isset($_GET['online']) && $_GET['online'] == "1" ? $_GET['online'] : 0;

  $accounts_per_page = isset($_GET['accounts_per_page']) ? $_GET['accounts_per_page'] : 20;
  $accounts_page = isset($_GET['accounts_page']) ? $_GET['accounts_page'] : 1;
  $accounts_page = intval($accounts_page);
  $accounts_per_page = intval($accounts_per_page);

  $session_playername = isset($_GET['session_playername']) && $_GET['session_playername'] != "" ? $_GET['session_playername'] : null;
  $session_ipaddress = isset($_GET['session_ipaddress']) && $_GET['session_ipaddress'] != "" ? $_GET['session_ipaddress'] : null;
  $session_date_begin = isset($_GET['session_date_begin']) && $_GET['session_date_begin'] != "" ? $_GET['session_date_begin'] : null;
  $session_date_end = isset($_GET['session_date_end']) && $_GET['session_date_end'] != "" ? $_GET['session_date_end'] : null;
  $session_valid = isset($_GET['session_valid']) && $_GET['session_valid'] != "" ? $_GET['session_valid'] : 0;
  $session_invalid = isset($_GET['session_invalid']) && $_GET['session_invalid'] != "" ? $_GET['session_invalid'] : 0;
  $session_online = isset($_GET['session_online']) && $_GET['session_online'] != "" ? $_GET['session_online'] : 0;
  $session_web = isset($_GET['session_web']) && $_GET['session_web'] != "" ? $_GET['session_web'] : 0;

  $sessions_per_page = isset($_GET['sessions_per_page']) ? $_GET['sessions_per_page'] : 20;
  $sessions_page = isset($_GET['sessions_page']) ? $_GET['sessions_page'] : 1;
  $sessions_page = intval($sessions_page);
  $sessions_per_page = intval($sessions_per_page);

  $drops_undelivered = isset($_GET['drops_undelivered']) && $_GET['drops_undelivered'] != "" ? $_GET['drops_undelivered'] : 0;
  $drops_delivered = isset($_GET['drops_delivered']) && $_GET['drops_delivered'] != "" ? $_GET['drops_delivered'] : 0;

  $drops_per_page = isset($_GET['drops_per_page']) ? $_GET['drops_per_page'] : 20;
  $drops_page = isset($_GET['drops_page']) ? $_GET['drops_page'] : 1;
  $drops_page = intval($drops_page);
  $drops_per_page = intval($drops_per_page);

  
  $accounts_pages = getUserListPaged(($accounts_page-1)*$accounts_per_page, $accounts_per_page, $playername, $ipaddress,
    $emailaddress, $login_date_begin, $login_date_end, $register_date_begin, $register_date_end,
    $nologin, $inactive, $admin, $operator, $contributor, $donor, $premium, $online);
  $total_accounts = $accounts_pages['total'];
  $accounts = $accounts_pages['pages'];

  $sessions_pages = getSessionsPaged(($sessions_page-1)*$sessions_per_page, $sessions_per_page, $session_playername, 
    $session_ipaddress, $session_date_begin, $session_date_end, $session_valid, $session_invalid, $session_online,
    $session_web);
  $total_sessions = $sessions_pages['total'];
  $sessions = $sessions_pages['pages'];

  $drops_pages = getUsersDrops(
    ($drops_page-1)*$drops_per_page, $drops_per_page,
    $drops_undelivered, $drops_delivered);
  $total_drops = $drops_pages["total"];
  $drops = $drops_pages["pages"];

  $onlinePlayers = getOnlinePlayers();
  $f = function($e) {
    return $e['name'];
  };
  $flatOnlinePlayers = array_map($f, $onlinePlayers);

  $addresses = getPopularAddresses();
  $addresses = $addresses != null ? $addresses : [];

  $link_after = "";
  $link_after .= $playername != null ? "&playername=$playername" : "";
  $link_after .= $ipaddress != null ? "&ipaddress=$ipaddress" : "";
  $link_after .= $emailaddress != null ? "&emailaddress=$emailaddress" : "";
  $link_after .= $login_date_begin != null ? "&login_date_begin=$login_date_begin" : "";
  $link_after .= $login_date_end != null ? "&login_date_end=$login_date_end" : "";
  $link_after .= $register_date_begin != null ? "&register_date_begin=$register_date_begin" : "";
  $link_after .= $register_date_end != null ? "&register_date_end=$register_date_end" : "";
  $link_after .= $nologin != null ? "&nologin=$nologin" : "";
  $link_after .= $inactive != null ? "&inactive=$inactive" : "";
  $link_after .= $admin != null ? "&admin=$admin" : "";
  $link_after .= $operator != null ? "&operator=$operator" : "";
  $link_after .= $contributor != null ? "&contributor=$contributor" : "";
  $link_after .= $donor != null ? "&donor=$donor" : "";
  $link_after .= $premium != null ? "&premium=$premium" : "";
  $link_after .= $online != null ? "&online=$online" : "";
  $link_after .= "#accounts";
  $accounts_page_navigation = navigation($accounts_page, $total_accounts, $accounts_per_page, "", $link_after, 4, true, 'accounts_page', 'accounts_per_page');

  $link_after = "";
  $link_after .= $session_playername != null ? "&session_playername=$session_playername" : "";
  $link_after .= $session_ipaddress != null ? "&session_ipaddress=$session_ipaddress" : "";
  $link_after .= $session_date_begin != null ? "&session_date_begin=$session_date_begin" : "";
  $link_after .= $session_date_end != null ? "&session_date_end=$session_date_end" : "";
  $link_after .= $session_valid != null ? "&session_valid=$session_valid" : "";
  $link_after .= $session_invalid != null ? "&session_invalid=$session_invalid" : "";
  $link_after .= $session_online != null ? "&session_online=$session_online" : "";
  $link_after .= "#sessions";
  $sessions_page_navigation = navigation($sessions_page, $total_sessions, $sessions_per_page, "", $link_after, 4, true, 'sessions_page', 'sessions_per_page');

  $link_after = "";
  $link_after .= $drops_undelivered != null ? "&drops_undelivered=$drops_undelivered" : "";
  $link_after .= $drops_delivered != null ? "&drops_delivered=$drops_delivered" : "";
  $link_after .= "#drops";
  $drops_page_navigation = navigation($drops_page, $total_drops, $drops_per_page, "", $link_after, 4, true, 'drops_page', 'drops_per_page');

  require('templates/admin/index.php');
}

?>