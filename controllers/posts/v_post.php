<?

use lib\session\Session;

function v_post() {

    Session::validateSession();

    require('templates/posts/v_post.php');

}

?>