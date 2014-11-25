<?

require_once('lib/sessions.php');

function maps_index() {

  validateSession();

  require('templates/maps/index.php');

}

?>
