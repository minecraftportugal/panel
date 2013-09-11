<?

require_once('config.php');
require_once('lib.php');

function irc_index() {
  global $cfg_lightirc_path;

  validateSession();

  require('templates/irc/index.php');
}

?>
