<?

require_once('config.php');
require_once('lib.php');

function admin_index() {
  global $cfg_wp_url;

  validateSession(true);
  
  $error = isset($_GET['error']) ? $_GET['error'] : NULL;
  $ok = isset($_GET['ok']) ? $_GET['ok'] : NULL;

  require('templates/admin/index.php');
}

?>
