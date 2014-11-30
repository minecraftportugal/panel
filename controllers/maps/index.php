<?

use lib\session\Session;

function maps_index() {

  Session::validateSession();

  require('templates/maps/index.php');

}

?>
