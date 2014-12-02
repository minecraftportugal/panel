<?

use lib\session\Session;

function v_admin_register() {

    Session::validateSession(true);

    require('templates/admin/v_admin_register.php');
}

?>
