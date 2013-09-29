<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function admin_index() {
  global $cfg_wp_url;

  validateSession(true);
  
  $userlist = getUserList();
  require('templates/admin/index.php');
}

?>
