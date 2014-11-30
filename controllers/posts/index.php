<?

use lib\session\Session;

function posts_index() {

    Session::validateSession();

    require('templates/posts/index.php');
}

?>