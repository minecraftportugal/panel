<?

use lib\session\Session;
use lib\template\Template;

function v_maps() {

    Session::validateSession();

    $template = Template::init('maps/v_maps');

    $template->render();

}

?>
