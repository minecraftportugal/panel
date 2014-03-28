<?

require_once('config.php');
require_once('lib/sessions.php');
require_once('lib/i18n.php');

function maps_index() {

  validateSession();

  require('templates/maps/index.php');
}

?>
