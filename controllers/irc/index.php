<?

require_once('config.php');
require_once('lib/sessions.php');

function irc_index() {
  global $cfg_lightirc_path;

  validateSession();

  require('templates/irc/index.php');
}

?>
