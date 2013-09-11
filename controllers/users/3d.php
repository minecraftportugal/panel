<?

require_once('config.php');
require_once('lib.php');

function users_3d() {
  global $cfg_web_root;

  validateSession();

  require('templates/users/3d.php');
}

?>
